<?php

declare(strict_types=1);

namespace Castlegate\AlcoholicsAnonymous;

use WP_Post;
use WP_Query;
use WP_Role;
use WP_Screen;
use WP_User;

use function Castlegate\ErsatzFunctions\WordPress\labels;

abstract class AbstractRegionPostType
{
    /**
     * Post type name
     *
     * @var string|null
     */
    public const NAME = null;

    /**
     * Post type slug
     *
     * @var string|null
     */
    public const SLUG = null;

    /**
     * Post type icon
     *
     * @var string|null
     */
    public const ICON = 'dashicons-location';

    /**
     * Label (single)
     *
     * @var string|null
     */
    public const LABEL_SINGLE = null;

    /**
     * Label (plural)
     *
     * @var string|null
     */
    public const LABEL_PLURAL = null;

    /**
     * Overrides for specific labels
     *
     * @var array|null
     */
    public const LABEL_OVERRIDES = null;

    /**
     * Post type has archive?
     *
     * @var bool
     */
    public const HAS_ARCHIVE = true;

    /**
     * Capability type
     *
     * @var array|null
     */
    public const CAPABILITY_TYPE = null;

    /**
     * Maximum number of child pages
     *
     * @var int
     */
    public const MAX_PAGES = 10;

    /**
     * Author instructions added?
     *
     * @var bool
     */
    private static $addAuthorDropdownInstructionsDone = false;

    /**
     * Author sanitization in progress?
     *
     * @var bool
     */
    private static $sanitizeAuthorInProgress = false;

    /**
     * Construct
     *
     * @return void
     */
    final public function __construct()
    {
        $required_constants = ['NAME', 'LABEL_SINGLE', 'LABEL_PLURAL'];
        $missing_constants = [];

        foreach ($required_constants as $constant) {
            if (is_null(constant(static::class . '::' . $constant))) {
                $missing_constants[] = $constant;
            }
        }

        if ($missing_constants) {
            trigger_error('Missing required constant(s) ' . implode(', ', $missing_constants), E_USER_ERROR);
        }
    }

    /**
     * Initialization
     *
     * @return void
     */
    public static function init(): void
    {
        $instance = new static();

        add_action('init', [$instance, 'registerPostType']);
        add_action('pre_get_posts', [$instance, 'setQueryArgs']);
        add_action('after_switch_theme', [$instance, 'setUserCapabilities'], 20);
        add_action('save_post_' . static::NAME, [$instance, 'sanitizeAuthor'], 10, 3);
        add_action('save_post_' . static::NAME, [$instance, 'notify'], 20, 3);

        add_filter('page_attributes_dropdown_pages_args', [$instance, 'setParentArgs']);
        add_filter('quick_edit_dropdown_pages_args', [$instance, 'setParentArgs']);
        add_filter('user_has_cap', [$instance, 'setUserEditPost'], 20, 4);
        add_filter('wp_dropdown_pages', [$instance, 'setQuickEditParentReadOnly'], 20, 3);
        add_filter('wp_dropdown_users', [$instance, 'addAuthorDropdownInstructions']);
        add_filter('wp_insert_post_data', [$instance, 'setPostData']);
        add_filter('wp_insert_post_data', [$instance, 'validatePostData'], 20, 2);

        add_action('wp_insert_post_data', [$instance, 'validateMaxPages'], 10, 4);
        add_action('admin_notices', [$instance, 'addMaxPagesAdminNotice']);
        add_filter('manage_' . static::NAME . '_posts_columns', [$instance, 'addPageCountTableColumn'], 30);
        add_action('manage_' . static::NAME . '_posts_custom_column', [$instance, 'populatePageCountTableColumn'], 30, 2);

        add_filter('manage_' . static::NAME . '_posts_columns', [$instance, 'maybeRemoveTableColumns'], 20);
        add_filter('views_edit-' . static::NAME, [$instance, 'maybeRemoveTableViews'], 20);
        add_filter('wpseo_accessible_post_types', [$instance, 'maybeRemoveYoastPostTypes'], 20);
    }

    /**
     * Register post type
     *
     * @return void
     */
    public function registerPostType(): void
    {
        register_post_type(static::NAME, $this->getPostTypeArgs());
    }

    /**
     * Return post type parameters for registration
     *
     * @return array
     */
    protected function getPostTypeArgs(): array
    {
        $args = [
            'labels' => labels(static::LABEL_SINGLE, static::LABEL_PLURAL),
            'public' => true,
            'has_archive' => static::HAS_ARCHIVE,
            'hierarchical' => true,
            'supports' => [
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'revisions',
                'author',
                'page-attributes',
            ],
        ];

        if (is_array(static::LABEL_OVERRIDES)) {
            $overrides = array_intersect_key(static::LABEL_OVERRIDES, $args['labels']);
            $overrides = array_filter($overrides, 'is_string');

            $args['labels'] = array_merge($args['labels'], $overrides);
        }

        if (!is_null(static::SLUG)) {
            $args['rewrite'] = [
                'slug' => static::SLUG,
            ];
        }

        if (!is_null(static::ICON)) {
            $args['menu_icon'] = static::ICON;
        }

        if (!is_null(static::CAPABILITY_TYPE)) {
            $args['capability_type'] = static::CAPABILITY_TYPE;
        }

        return $args;
    }

    /**
     * Set main query parameters
     *
     * @param WP_Query $wp_query
     * @return void
     */
    public function setQueryArgs(WP_Query $wp_query): void
    {
        if (
            $wp_query->is_admin ||
            !$wp_query->is_main_query() ||
            !$wp_query->is_post_type_archive(static::NAME)
        ) {
            return;
        }

        $wp_query->set('orderby', 'title');
        $wp_query->set('order', 'ASC');
        $wp_query->set('posts_per_page', -1);
        $wp_query->set('post_parent', 0);
    }

    /**
     * Set wp_dropdown_pages parameters
     *
     * Restrict parent region options to top level regions in the region
     * attributes meta box and in the quick edit form.
     *
     * @param array $args
     * @return array
     */
    public function setParentArgs(array $args): array
    {
        $post_type = $args['post_type'] ?? null;

        if ($post_type !== static::NAME) {
            return $args;
        }

        // Restrict parent options to top level regions
        $args['depth'] = 1;

        // Additional region manager restrictions
        if (current_user_can('region_manager')) {
            $user = wp_get_current_user();
            $screen = get_current_screen();
            $selected = $args['selected'] ?? null;

            // Restrict parents to regions belonging to the same author
            $args['authors'] = $user->ID;

            // Remove the "no parent" option for new posts or existing second
            // level posts.
            if ($screen->base === 'post' && ($screen->action === 'add' || $selected)) {
                $args['show_option_none'] = false;
            }
        }

        return $args;
    }

    /**
     * Set quick edit parent field read only
     *
     * We cannot set the "no parent" option in the quick edit form because we do
     * not have access to the current post ID or the current post parent. For
     * this reason, the parent can only be selected on the edit post screen.
     *
     * @param string $output
     * @param array $args
     * @param array $pages
     * @return string
     */
    public function setQuickEditParentReadOnly(string $output, array $args = [], array $pages = []): string
    {
        if (!function_exists('get_current_screen')) {
            return $output;
        }

        $screen = get_current_screen();

        if ($screen instanceof WP_Screen && $screen->base === 'edit' && $screen->post_type === 'region') {
            $output = str_replace('<select', '<select disabled', $output);
        }

        return $output;
    }

    /**
     * Set region manager edit_{post_type} capability
     *
     * @param array $allcaps
     * @param array $caps
     * @param array $args
     * @param WP_User $user
     * @return array
     */
    public function setUserEditPost(array $allcaps, array $caps, array $args, WP_User $user): array
    {
        // Check user role
        if (!in_array('region_manager', $user->roles)) {
            return $allcaps;
        }

        // Check requested capability
        $requested = $args[0] ?? null;
        $post_id = $args[2] ?? null;

        if ($requested !== 'edit_post' || !is_int($post_id)) {
            return $allcaps;
        }

        // Check post type
        $post = get_post($post_id);

        if ($post->post_type !== static::NAME) {
            return $allcaps;
        }

        // Check author
        $author_id = (int) $post->post_author;
        $user_id = (int) $user->ID;

        if ($author_id === $user_id) {
            return $allcaps;
        }

        // Remove edit_{post_type} capability
        $allcaps['edit_' . static::NAME] = false;

        return $allcaps;
    }

    /**
     * Append instructions to author field
     *
     * @param string $output
     * @return string
     */
    public function addAuthorDropdownInstructions(string $output): string
    {
        // Have the instructions already been added?
        if (static::$addAuthorDropdownInstructionsDone) {
            return $output;
        }

        // Is this the right dropdown?
        if (
            strpos($output, 'name="post_author_override"') === false &&
            strpos($output, 'name=\'post_author_override\'') === false
        ) {
            return $output;
        }

        // Prevent instructions being added more than once
        static::$addAuthorDropdownInstructionsDone = true;

        // Append instructions
        ob_start();
        get_template_part('parts/admin/author-dropdown-instructions');

        $instructions = ob_get_clean();

        return $output . $instructions;
    }

    /**
     * Sanitize region author
     *
     * If this is a parent region, make sure that all child regions have the
     * same author. If this is a child region, make sure its parent and all its
     * siblings have the same author.
     *
     * @param int $post_id
     * @param WP_Post $post
     * @param bool $update
     * @return void
     */
    public function sanitizeAuthor(int $post_id, WP_Post $post, bool $update): void
    {
        if (static::$sanitizeAuthorInProgress) {
            return;
        }

        // Skip the action to prevent an infinite loop
        static::$sanitizeAuthorInProgress = true;

        // Identify top level region and post author ID
        $parent_id = wp_get_post_parent_id($post_id);
        $author_id = (int) $post->post_author;

        if (!$parent_id) {
            $parent_id = $post_id;
        }

        // Identify all second level regions
        $region_ids = get_posts([
            'post_type' => 'region',
            'posts_per_page' => -1,
            'post_parent' => $parent_id,
            'fields' => 'ids',
        ]);

        // Assemble a list of regions to be updated
        $region_ids[] = $parent_id;
        $region_ids = array_diff($region_ids, (array) $post_id);

        // Update the author for each region
        foreach ($region_ids as $region_id) {
            wp_update_post([
                'ID' => $region_id,
                'post_author' => $author_id,
            ]);
        }

        // Stop skipping the action
        static::$sanitizeAuthorInProgress = false;
    }

    /**
     * Send edit notification email
     *
     * @param int $post_id
     * @param WP_Post $post
     * @param bool $update
     * @return void
     */
    public function notify(int $post_id, WP_Post $post, bool $update): void
    {
        $email = get_field('microsite_edit_email', 'options');

        if (!$email) {
            return;
        }

        $type = get_post_type_object($post->post_type);
        $subject = $type->labels->singular_name . ' updated';

        ob_start();
        get_template_part('parts/email/microsite-edit', null, compact('post', 'type'));

        $content = trim(ob_get_clean());

        wp_mail($email, $subject, $content);
    }

    /**
     * Set post data before saving
     *
     * Prevent non-top level regions being set as region parents when the post
     * data is saved to the database.
     *
     * @param array $data
     * @return array
     */
    public function setPostData(array $data): array
    {
        $post_type = $data['post_type'] ?? null;
        $parent_id = $data['post_parent'] ?? 0;

        if ($post_type !== static::NAME || $parent_id === 0) {
            return $data;
        }

        $prev_parent_id = $parent_id;

        while ($parent_id) {
            $prev_parent_id = $parent_id;
            $parent_id = get_post_parent($parent_id)->ID ?? null;
        }

        $data['post_parent'] = $prev_parent_id;

        return $data;
    }

    /**
     * Validate post data before saving
     *
     * If the region has child regions and a parent region has been selected,
     * trigger an error to avoid creating a third level in the region hierarchy.
     *
     * @param array $data
     * @return array
     */
    public function validatePostData(array $data, array $post_array): array
    {
        $post_type = $data['post_type'] ?? null;
        $parent_id = $data['post_parent'] ?? 0;
        $post_id = $post_array['ID'] ?? null;

        if ($post_type !== static::NAME || $parent_id === 0 || !$post_id) {
            return $data;
        }

        $children = get_posts([
            'post_parent' => $parent_id,
            'fields' => 'ids',
        ]);

        if ($children) {
            wp_die('Secondary ' . static::LABEL_PLURAL . ' cannot have child pages.');
        }

        return $data;
    }

    /**
     * Validate post parent when saving post status to restrict each "microsite"
     * to 10 pages
     *
     * @param array $data
     * @param array $post_array
     * @param array $unsanitized_post_array
     * @param bool $update
     * @return array
     */
    public function validateMaxPages(array $data, array $post_array, array $unsanitized_post_array, bool $update): array
    {
        $post_type = $data['post_type'] ?? null;
        $status = $data['post_status'] ?? null;
        $parent_id = $data['post_parent'] ?? null;

        // Skip other post types, non-publish saves, and posts without parents
        if ($post_type !== static::NAME || $status !== 'publish' || !$parent_id) {
            return $data;
        }

        // Skip posts with fewer than 10 siblings
        $sibling_ids = get_posts([
            'post_type' => static::NAME,
            'post_parent' => $parent_id,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
        ]);

        if (!is_array($sibling_ids) || count($sibling_ids) < static::MAX_PAGES) {
            return $data;
        }

        // Prevent publishing
        $data['post_status'] = 'draft';

        // Add an error message
        add_filter('redirect_post_location', [$this, 'setMaxPagesRedirectPostLocation'], 99);
        set_transient($this->getMaxPagesTransientKey(), sprintf('This %s has reached its limit of %s pages. This page has been saved as a draft and cannot be published until another page in this %s has been removed.', static::NAME, static::MAX_PAGES, static::NAME));

        return $data;
    }

    /**
     * Replace "published" success message on the edit post screen
     *
     * @param string $location
     * @return string
     */
    public function setMaxPagesRedirectPostLocation(string $location): string
    {
        remove_filter('redirect_post_location', __FUNCTION__, 99);

        return add_query_arg('message', 0, $location);
    }

    /**
     * Add page limit error message to edit post screen
     *
     * @return void
     */
    public function addMaxPagesAdminNotice(): void
    {
        $message = get_transient($this->getMaxPagesTransientKey());

        if (!$message) {
            return;
        }

        delete_transient($this->getMaxPagesTransientKey());
        echo '<div class="notice error"><p><b>Error:</b> ' . $message . '</p></div>';
    }

    /**
     * Return transient key for page limit error message
     *
     * @return string
     */
    private function getMaxPagesTransientKey(): string
    {
        return get_current_user_id() . '_max_pages';
    }

    /**
     * Add page count posts table column
     *
     * @param array $columns
     * @return array
     */
    public function addPageCountTableColumn(array $columns): array
    {
        if (static::MAX_PAGES < 1) {
            return $columns;
        }

        $offset = array_search('author', array_keys($columns));

        return array_slice($columns, 0, $offset, true) + ['page_count' => 'Page Count'] + array_slice($columns, $offset, null, true);
    }

    /**
     * Populate page count posts table column
     *
     * @param string $column
     * @param int $post_id
     * @return void
     */
    public function populatePageCountTableColumn(string $column, int $post_id): void
    {
        if (static::MAX_PAGES < 1) {
            return;
        }

        $parent_id = wp_get_post_parent_id($post_id);

        if ($parent_id) {
            return;
        }

        $post_ids = get_posts([
            'post_type' => static::NAME,
            'post_parent' => $post_id,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
        ]);

        echo count($post_ids) . '/' . static::MAX_PAGES;
    }

    /**
     * Set user capabilities
     *
     * @return void
     */
    public function setUserCapabilities(): void
    {
        $single = static::CAPABILITY_TYPE[0] ?? null;
        $plural = static::CAPABILITY_TYPE[1] ?? null;

        if (!$single || !$plural) {
            return;
        }

        $region_role_names = ['region_manager'];
        $admin_role_names = ['administrator', 'editor', 'cgit_site_manager'];

        $region_caps = [
            "edit_{$single}",
            "read_{$single}",
            "delete_{$single}",
            "edit_{$plural}",
            "delete_{$plural}",
            "publish_{$plural}",
            "read_private_{$plural}",
        ];

        $admin_caps = array_merge($region_caps, [
            "edit_others_$plural",
        ]);

        foreach ($region_role_names as $name) {
            $role = get_role($name);

            if ($role instanceof WP_Role) {
                foreach ($region_caps as $cap) {
                    $role->add_cap($cap);
                }
            }
        }

        foreach ($admin_role_names as $name) {
            $role = get_role($name);

            if ($role instanceof WP_Role) {
                foreach ($admin_caps as $cap) {
                    $role->add_cap($cap);
                }
            }
        }
    }

    /**
     * Remove posts table columns (if necessary)
     *
     * @param array $columns
     * @return array
     */
    public function maybeRemoveTableColumns(array $columns): array
    {
        // Remove columns for region manager users
        if (current_user_can('region_manager')) {
            // Default columns
            unset($columns['author']);

            // Remove Yoast columns
            unset($columns['wpseo-score']);
            unset($columns['wpseo-score-readability']);
            unset($columns['wpseo-title']);
            unset($columns['wpseo-metadesc']);
            unset($columns['wpseo-focuskw']);
            unset($columns['wpseo-links']);
            unset($columns['wpseo-linked']);
            unset($columns['wpseo-cornerstone']);
        }

        return $columns;
    }

    /**
     * Remove view options from posts table
     *
     * @param array $views
     * @return array
     */
    public function maybeRemoveTableViews(array $views): array
    {
        // Remove views for region manager users
        if (current_user_can('region_manager')) {
            // Remove Yoast views
            unset($views['yoast_cornerstone']);
            unset($views['yoast_orphaned']);
            unset($views['yoast_stale-cornerstone-content']);
        }

        return $views;
    }

    /**
     * Remove Yoast bulk actions from posts table by limiting Yoast's access to
     * this post type
     *
     * @param array $views
     * @return array
     */
    public function maybeRemoveYoastPostTypes(array $post_types): array
    {
        // Remove support for region manager users
        if (current_user_can('region_manager')) {
            return [];
        }

        return $post_types;
    }
}

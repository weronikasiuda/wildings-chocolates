<?php

use WS\WS\MeetingFinder;

use function WS\WS\getArchiveRedirectPageId;
use function WS\WS\getTaxonomyPostType;

// Register navigation menu(s).
register_nav_menus([
    'main-nav' => 'Main Navigation',
    'footer-links' => 'Footer Links',
    'shop-admin-links' => 'Shop Links'
]);

// Sanitize navigation menu parameters.
add_filter('wp_nav_menu_args', function ($args) {
    $location = $args['theme_location'] ?? null;

    $location_args = [
        'main-nav' => [
            'depth' => 2,
            'container' => false,
            'menu_class' => 'header-nav__list',
            'fallback_cb' => false,
        ],
    ];

    if ($location && array_key_exists($location, $location_args)) {
        $args = array_merge($args, $location_args[$location]);
    }

    return $args;
});

// Sanitize navigation menu item class names.
add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
    $location = $args->theme_location ?? null;

    $location_classes = [
        'main-nav' => [
            'item' => 'header-nav__item',
            'sub_item' => 'header-nav__sub-item',
        ],
    ];

    if ($location && array_key_exists($location, $location_classes)) {
        $class = $location_classes[$location]['item'];

        if ($depth !== 0) {
            $class = $location_classes[$location]['sub_item'];
        }

        $classes = (array) $class;
    }

    return $classes;
}, 10, 4);

// Sanitize navigation menu second level list class name.
add_filter('nav_menu_submenu_css_class', function ($classes, $args, $depth) {
    $location = $args->theme_location ?? null;

    $location_classes = [
        'main-nav' => 'header-nav__sub-list',
    ];

    if ($location && array_key_exists($location, $location_classes)) {
        $classes = (array) $location_classes[$location];
    }

    return $classes;
}, 10, 3);

// Sanitize navigation menu link class names and set active state(s).
add_filter('nav_menu_link_attributes', function ($attributes, $item, $args, $depth) {
    $location = $args->theme_location ?? null;

    $location_classes = [
        'main-nav' => [
            'item' => 'header-nav__link',
            'sub_item' => 'header-nav__sub-link',
        ],
    ];

    $active_modifiers = [
        'main-nav' => [
            'item' => 'active',
            'sub_item' => 'active',
        ],
    ];

    $default_active_classes = [
        'current-menu-item',
        'current-menu-parent',
        'current-menu-ancestor',
        'current-page-item',
        'current-page-parent',
        'current-page-ancestor',
        'current_page_item',
        'current_page_parent',
        'current_page_ancestor',
    ];

    if ($location && array_key_exists($location, $location_classes)) {
        $key = $depth === 0 ? 'item' : 'sub_item';
        $class = $location_classes[$location][$key];
        $classes = (array) $class;

        $item_url = $item->url;
        $item_classes = $item->classes;
        $item_path = parse_url($item_url, PHP_URL_PATH);

        $object = $item->object;
        $object_id = (int) $item->object_id;

        $post_page_id = null;
        $post_page_url = home_url('/');

        // Get post index URL if home page displays a static page.
        if (get_option('show_on_front') === 'page') {
            $post_page_id = (int) get_option('page_for_posts');
            $post_page_url = get_permalink($post_page_id);
        }

        // Show active state if current view is a page, the nav menu item is a
        // link to a page, and the nav menu item has a default active class.
        $is_active_page = is_page() &&
            $object === 'page' &&
            array_intersect($item_classes, $default_active_classes);

        // Show active state if current view is a post or list of posts and the
        // nav menu item URL is the posts page URL or the nav menu item object
        // ID is the posts page ID.
        $is_active_post = $post_page_url &&
            (is_home() ||
                is_singular('post') ||
                is_category() ||
                is_tag() ||
                (is_date() && !is_post_type_archive('event')) ||
                is_author()) &&
            ($item_url === $post_page_url ||
                ($object === 'page' && $object_id === $post_page_id));

        // Nav menu item is an active link to a custom post type archive or an
        // active link to a redirect page destination?
        $is_active_type = false;
        $is_active_redirect = false;

        // If the nav menu item is not an active link to a page, post, or list
        // of posts, check for links to custom post types, custom post type
        // archives, and custom taxonomies.
        if (!$is_active_page && !$is_active_post) {
            $types = get_post_types([
                'public' => true,
            ]);

            foreach ($types as $type) {
                $type_url = get_post_type_archive_link($type);
                $type_path = parse_url($type_url, PHP_URL_PATH);

                // Show active state if current view is a custom post type or a
                // custom post type archive and the current URL path matches the
                // URL path of the corresponding custom post type archive.
                if (is_post_type_archive($type) || is_singular($type)) {
                    if ($item_path === $type_path) {
                        $is_active_type = true;

                        break;
                    }
                }

                // Show active state if current view is a custom taxonomy and
                // the item URL path matches the URL path of the custom post
                // type to which the custom taxonomy belongs.
                if (is_tax()) {
                    $term = get_queried_object();
                    $taxonomy = get_taxonomy($term->taxonomy);

                    if (
                        $item_path === $type_path &&
                        in_array($type, $taxonomy->object_type)
                    ) {
                        $is_active_type = true;

                        break;
                    }
                }
            }
        }

        // If the nav menu item is a link to a redirect page, check whether the
        // current page is the redirect destination.
        if (get_page_template_slug($object_id) === 'templates/redirect.php') {
            switch (get_field('redirect_type', $object_id)) {
                case 'single':
                    $destination_post_id = get_field('redirect_post_id', $object_id);
                    $is_active_redirect = is_page($destination_post_id) || is_single($destination_post_id);
                    break;

                case 'archive':
                    $destination_post_type = get_field('redirect_post_type', $object_id);

                    if ($destination_post_type === 'post') {
                        $is_active_redirect = is_home() || is_singular('post');
                    } else {
                        $is_active_redirect = is_post_type_archive($destination_post_type) ||
                            is_singular($destination_post_type);


                        // Check for taxonomy term associated with post type.
                        if (!$is_active_redirect && is_tax()) {
                            $taxonomy_post_type = getTaxonomyPostType($term->taxonomy);

                            if ($destination_post_type === $taxonomy_post_type) {
                                $is_active_redirect = true;
                            }
                        }
                    }

                    break;

                case 'taxonomy':
                    $destination_term_id = get_field('redirect_term_id', $object_id);
                    $destination_term = get_term($destination_term_id);

                    $is_active_redirect = is_category($destination_term_id) ||
                        is_tag($destination_term_id) ||
                        is_tax($destination_term->taxonomy, $destination_term_id);

                    break;
            }
        }

        // If the nav menu item is a page ancestor of a redirect page that
        // points to a post type archive, check if the current view is that
        // custom post type archive or a single post of that type.
        if ($object_id) {
            $is_post_type_archive = is_post_type_archive();
            $is_singular = is_singular();

            if ($is_post_type_archive || $is_singular) {
                $type = null;
                $object = get_queried_object();

                if ($is_post_type_archive) {
                    $type = $object->name;
                } elseif ($is_singular) {
                    $type = $object->post_type;
                }

                $redirect_page_id = getArchiveRedirectPageId($type);
                $page_ids = get_ancestors($redirect_page_id, 'page');
                $page_ids[] = $redirect_page_id;

                if (in_array($object_id, $page_ids)) {
                    $is_active_page = true;
                }
            }
        }


        // If any of the active state conditions have been met, add the active
        // modifier class to the list of classes.
        if ($is_active_page || $is_active_post || $is_active_type || $is_active_redirect) {
            $modifier = $active_modifiers[$location][$key] ?? 'active';
            $classes[] = "$class--$modifier";
        }

        $attributes['class'] = implode(' ', $classes);
    }

    return $attributes;
}, 10, 4);

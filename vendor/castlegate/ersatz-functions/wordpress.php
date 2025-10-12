<?php

declare(strict_types=1);

namespace Castlegate\ErsatzFunctions\WordPress;

/**
 * Return array of pages by template
 *
 * This function returns an array of pages that use a particular template, or
 * null of none can be found. The second parameter can be used to pass
 * additional options to the get_posts function. By default, the array of pages
 * is sorted by the menu_order property.
 *
 * @param string $template
 * @param array $args
 * @return array|null
 */
function templatePageList(string $template, array $args = []): ?array
{
    $args = array_merge([
        'post_type' => 'page',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_query' => [
            [
                'key' => '_wp_page_template',
                'value' => $template,
            ],
        ],
    ], $args);

    $pages = get_posts($args);

    if (!$pages) {
        return null;
    }

    return $pages;
}

/**
 * Return page by template
 *
 * This function returns the first page, sorted by menu_order, that uses a
 * particular template, or null if none can be found. The second parameter can
 * be used to pass additional options to the get_posts function, which might
 * affect the sort order of the pages returned and, therefore, which page is
 * returned by this function.
 *
 * @param string $template
 * @param array $args
 * @return object|null
 */
function templatePage(string $template, array $args = []): ?object
{
    $pages = templatePageList($template, $args);

    if (!$pages) {
        return null;
    }

    return array_shift($pages);
}

/**
 * Trigger 403 "forbidden" error
 *
 * @return void
 */
function trigger403(
    string $message = null,
    string $title = null,
    array $args = []
): void {
    if (is_null($message)) {
        $message = 'Forbidden';
    }

    if (is_null($title)) {
        $title = 'Forbidden';
    }

    $args = array_merge([
        'response' => 403,
    ], $args);

    wp_die($message, $title, $args);
}

/**
 * Trigger 404 "not found" error
 *
 * @return void
 */
function trigger404(): void
{
    global $wp_query;

    $wp_query->set_404();

    status_header(404);

    $template = get_404_template();

    if ($template) {
        include $template;
    }

    exit;
}

/**
 * Return post type or taxonomy labels
 *
 * This function creates an array of labels that can be used with the
 * register_post_type and register_taxonomy functions. The first parameter is
 * the singular name of the post type or taxonomy. The second parameter is the
 * plural name. If no plural name is provided, the plural will be created by
 * appending "s" to the singular name.
 *
 * @param string $item
 * @param string|null $items
 * @return array
 */
function labels(string $item, string $items = null): array
{
    if (is_null($items)) {
        $items = $item . 's';
    }

    return [
        'name' => $items,
        'singular_name' => $item,
        'add_new' => 'Add New',
        'add_new_item' => "Add New $item",
        'add_or_remove_items' => "Add or remove $items",
        'all_items' => "All $items",
        'archives' => "$item Archives",
        'attributes' => "$item Attributes",
        'choose_from_most_used' => "Choose from the most used $items",
        'edit_item' => "Edit $item",
        'insert_into_item' => "Insert into $item",
        'menu_name' => $items,
        'new_item' => "New $item",
        'new_item_name' => "New $item Name",
        'not_found' => "No $items found",
        'not_found_in_trash' => "No $items found in Trash",
        'parent_item' => "Parent $item",
        'parent_item_colon' => "Parent $item:",
        'popular_items' => "Popular $items",
        'search_items' => "Search $items",
        'separate_items_with_commas' => "Separate $items with commas",
        'update_item' => "Update $item",
        'uploaded_to_this_item' => "Uploaded to this $item",
        'view_item' => "View $item",
        'view_items' => "View $items",
    ];
}

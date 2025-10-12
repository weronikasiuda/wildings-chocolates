<?php

use function WS\WS\getArchiveRedirectPageId;

$current_page_id = (int) ($args['page_id'] ?? 0);

if (!$current_page_id) {
    if (is_page()) {
        $current_page_id = get_the_ID();
    } else {
        $current_page_id = getArchiveRedirectPageId();
    }
}

// Magazine article publication redirect page
$publication_id = null;

if (is_tax('article-publication')) {
    $publication_id = get_queried_object()->term_id;
} elseif (is_tax('article-edition')) {
    $edition_id = get_queried_object()->term_id;
    $publication_id = get_field('article_edition_publication', 'term_' . $edition_id);
} elseif (is_singular('article')) {
    $publications = get_the_terms(get_the_ID(), 'article-publication');

    if ($publications) {
        $publication = array_shift($publications);
        $publication_id = $publication->term_id;
    }
}

if ($publication_id) {
    $redirect_page_id = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT templates.post_id
            FROM %i AS templates
            JOIN %i AS redirect_types
                ON templates.post_id = redirect_types.post_id
            JOIN %i AS post_types
                ON templates.post_id = post_types.post_id
            WHERE templates.meta_key = '_wp_page_template'
                AND templates.meta_value = 'templates/redirect.php'
                AND redirect_types.meta_key = 'redirect_type'
                AND redirect_types.meta_value = 'taxonomy'
                AND post_types.meta_key = 'redirect_term_id'
                AND post_types.meta_value = %s
            LIMIT 1",
        $wpdb->postmeta,
        $wpdb->postmeta,
        $wpdb->postmeta,
        $publication_id
    ));

    if ($redirect_page_id) {
        $current_page_id = $redirect_page_id;
    }
}

if (!$current_page_id) {
    return;
}

$first_ancestor_id = $current_page_id;
$ancestor_ids = get_post_ancestors($first_ancestor_id);

if ($ancestor_ids) {
    $first_ancestor_id = $ancestor_ids[array_key_last($ancestor_ids)];
}

$args = [
    'child_of' => $first_ancestor_id,
    'parent' => $first_ancestor_id,
    'sort_column' => 'menu_order',
    'sort_order' => 'ASC',
];

$pages = get_pages($args);

if (!$pages) {
    return;
}

// Generate items and sub-items for output.
$items = [];

foreach ($pages as $page) {
    $sub_pages = get_pages(array_merge($args, [
        'child_of' => $page->ID,
        'parent' => $page->ID,
    ]));

    $sub_items = [];

    if ($sub_pages) {
        foreach ($sub_pages as $sub_page) {
            $sub_sub_pages = get_pages(array_merge($args, [
                'child_of' => $sub_page->ID,
                'parent' => $sub_page->ID,
            ]));

            $sub_sub_items = [];

            if ($sub_sub_pages) {
                foreach ($sub_sub_pages as $sub_sub_page) {
                    $sub_sub_items[] = [
                        'title' => get_the_title($sub_sub_page->ID),
                        'url' => get_permalink($sub_sub_page->ID),
                        'active' => is_page($sub_sub_page->ID) ||
                            in_array($sub_sub_page->ID, $ancestor_ids) ||
                            in_array($current_page_id, $ancestor_ids),
                    ];
                }
            }

            $sub_items[] = [
                'title' => get_the_title($sub_page->ID),
                'url' => get_permalink($sub_page->ID),
                'active' => is_page($sub_page->ID) ||
                    $sub_page->ID === $current_page_id ||
                    in_array($sub_page->ID, $ancestor_ids) ||
                    in_array($current_page_id, $ancestor_ids),
                'sub_sub_items' => $sub_sub_items,
            ];
        }
    }

    $items[] = [
        'title' => get_the_title($page->ID),
        'url' => get_permalink($page->ID),
        'active' => is_page($page->ID) ||
            $page->ID === $current_page_id ||
            in_array($page->ID, $ancestor_ids) ||
            in_array($current_page_id, $ancestor_ids),
        'sub_items' => $sub_items,
    ];
}

?>

<div class="section">
    <?php

    get_template_part('parts/subnav', null, [
        'heading' => get_the_title($first_ancestor_id),
        'items' => $items,
    ]);

    ?>
</div>

<?php

$taxonomy_name = $args['taxonomy'] ?? null;
$taxonomy_args = $args['args'] ?? null;

if (!$taxonomy_name || !taxonomy_exists($taxonomy_name)) {
    $taxonomy_name = 'category';
}

if (!is_array($taxonomy_args)) {
    $taxonomy_args = [];
}

$taxonomy_args = array_merge([
    'taxonomy' => $taxonomy_name,
    'child_of' => 0,
    'parent' => 0,
    'orderby' => 'name',
    'order' => 'ASC',
], $taxonomy_args);

$cats = get_categories($taxonomy_args);

if (!$cats) {
    return;
}

$current_cat = null;
$current_ancestors = [];

if (is_tax($taxonomy_name)) {
    $current_cat = get_queried_object();
    $current_ancestors = get_ancestors($current_cat->term_id, $taxonomy_name);
}

$taxonomy = get_taxonomy($taxonomy_name);

// Generate items and sub-items for output.
$items = [];

foreach ($cats as $cat) {
    $sub_cats = get_categories(array_merge($taxonomy_args, [
        'child_of' => $cat->term_id,
        'parent' => $cat->term_id,
    ]));

    $sub_items = [];

    if ($sub_cats) {
        foreach ($sub_cats as $sub_cat) {
            $sub_sub_cats = get_categories(array_merge($taxonomy_args, [
                'child_of' => $sub_cat->term_id,
                'parent' => $sub_cat->term_id,
            ]));

            $sub_sub_items = [];

            if ($sub_sub_cats) {
                foreach ($sub_sub_cats as $sub_sub_cat) {
                    $sub_sub_items[] = [
                        'title' => $sub_sub_cat->name,
                        'url' => get_term_link($sub_sub_cat),
                        'active' => is_tax($taxonomy_name, $sub_sub_cat->term_id),
                    ];
                }
            }

            $sub_items[] = [
                'title' => $sub_cat->name,
                'url' => get_term_link($sub_cat),
                'active' => is_tax($taxonomy_name, $sub_cat->term_id) || in_array($sub_cat->term_id, $current_ancestors),
                'sub_sub_items' => $sub_sub_items,
            ];
        }
    }

    $items[] = [
        'title' => $cat->name,
        'url' => get_term_link($cat),
        'active' => is_tax($taxonomy_name, $cat->term_id) || in_array($cat->term_id, $current_ancestors),
        'sub_items' => $sub_items,
    ];
}

// Prepend and append items?
$items_before = $args['items_before'] ?? null;
$items_after = $args['items_after'] ?? null;

if (is_array($items_before) && $items_before) {
    $items = array_merge($items_before, $items);
}

if (is_array($items_after) && $items_after) {
    $items = array_merge($items, $items_after);
}

?>

<div class="section">
    <?php

    get_template_part('parts/subnav', null, [
        'heading' => $taxonomy->label,
        'items' => $items,
    ]);

    ?>
</div>

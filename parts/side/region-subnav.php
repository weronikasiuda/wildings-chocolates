<?php

if (!is_singular('region')) {
    return;
}

// Identify top level region
$current = get_post();
$parent = $current;
$next = get_post_parent($current);

while ($next) {
    $parent = $next;
    $next = get_post_parent($next);
}

// Set heading
$heading = get_the_title($parent);

// Create array of items
$items = [
    [
        'title' => __('Region Home'),
        'url' => get_permalink($parent),
        'active' => is_single($parent->ID),
    ],
];

$sub_page_ids = get_posts([
    'post_type' => 'region',
    'post_parent' => $parent->ID,
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'fields' => 'ids',
]);

if ($sub_page_ids) {
    foreach ($sub_page_ids as $sub_page_id) {
        $items[] = [
            'title' => get_the_title($sub_page_id),
            'url' => get_permalink($sub_page_id),
            'active' => is_single($sub_page_id)
        ];
    }
}

?>

<div class="section">
    <?php

    get_template_part('parts/subnav', null, [
        'heading' => $heading,
        'items' => $items,
        'modifiers' => 'region',
    ]);

    ?>
</div>

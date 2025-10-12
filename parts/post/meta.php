<?php

if (!is_singular('post')) {
    return;
}

$items = [];
$sep = ', ';

$cats = get_the_category_list($sep);
$tags = get_the_tag_list(null, $sep);

if ($cats) {
    $cat_taxonomy = get_taxonomy('category');
    $cat_label = $cat_taxonomy->label;

    $items[] = esc_html($cat_label) . ': ' . $cats;
}

if ($tags) {
    $tag_taxonomy = get_taxonomy('post_tag');
    $tag_label = $tag_taxonomy->label;

    $items[] = esc_html($tag_label) . ': ' . $tags;
}

if (!$items) {
    return;
}

?>

<div class="post-meta">
    <?= implode(THEME_TEXT_SEPARATOR, $items) ?>
</div>

<?php


use function WS\WS\getTaxonomyPostType;

global $wp_query;

$heading = get_bloginfo('name');

$document_page_id = (int) get_option('dlp_document_page');
$document_search_page_id = (int) get_option('dlp_search_page');

if (function_exists('is_woocommerce') && is_woocommerce()) {
    $heading = get_the_title(wc_get_page_id('shop'));
} elseif (is_page([$document_page_id, $document_search_page_id])) {
    $document_post_type = get_post_type_object('dlp_document');
    $heading = 'Document Library';
} elseif (is_page()) {
    $heading = get_the_title();
} elseif (
    is_home() ||
    is_singular('post') ||
    is_category() ||
    is_tag() ||
    (is_date() && !is_post_type_archive('event')) ||
    is_author()
) {
    $type = get_post_type_object('post');
    $heading = $type->label;

    if (get_option('show_on_front') === 'page') {
        $heading = get_the_title(get_option('page_for_posts'));
    }
} elseif (is_search()) {
    $heading = __('Search');
} elseif (is_singular(['intergroup', 'region'])) {
    $heading = get_the_title();

    if ($parent_id = get_post_parent()) {
        $heading = get_the_title($parent_id);
    }
} elseif (is_post_type_archive() || is_single()) {
    $type_name = $wp_query->query['post_type'] ?? null;

    if ($type_name) {
        $type = get_post_type_object($type_name);
        $heading = $type->label;
    }
} elseif (is_tax()) {
    $term = get_queried_object();
    $type = getTaxonomyPostType($term->taxonomy);

    if ($type) {
        $type = get_post_type_object($type);
        $heading = $type->label;
    }
}

$class = 'banner';
$classes = (array) $class;
$modifiers = (array) ($args['modifiers'] ?? []);

foreach ($modifiers as $modifier) {
    $classes[] = "$class--$modifier";
}

?>

<div class="<?= esc_attr(implode(' ', $classes)) ?>" style="background-image:url(/wp-content/themes/wildings-chocolates/images/wildings-chocolates-banner.webp)">
    <div class="banner__wrap">
        <h1 class="banner__heading"><?= esc_html($heading) ?></h1>
    </div>
</div>

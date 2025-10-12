<?php

// WP_Post instance from template part parameters or global object.
$post_object = $args['post_object'] ?? get_post();

if (!($post_object) instanceof WP_Post) {
    return;
}

// Post image?
$image_src = path_join(THEME_URL, 'images/default/large.webp');
$image_alt = '';

$image_id = get_post_thumbnail_id($post_object);

if ($image_id) {
    $image_src = wp_get_attachment_image_src($image_id, 'large')[0] ?? $image_src;
    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
}

// Meta?
$meta = null;

if ($post_object->post_type === 'post') {
    $meta = get_the_date(null, $post_object);
}

// Load card box template part.
get_template_part('parts/card-box', null, [
    'heading' => get_the_title($post_object),
    'excerpt' => apply_filters('the_excerpt', get_the_excerpt($post_object)),
    'meta' => $meta,
    'url' => get_permalink($post_object),
    'button_text' => get_field('read_more_text', $post_object->ID) ?: null,
    'image_src' => $image_src,
    'image_alt' => $image_alt,
]);

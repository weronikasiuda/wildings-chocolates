<?php

// WP_Post instance from template part parameters or global object.
$post_object = $args['post_object'] ?? get_post();

if (!($post_object) instanceof WP_Post) {
    return;
}

// Event date(s)
$meta = null;

if (function_exists('cgit_wp_events_get_event_date_range')) {
    $meta = cgit_wp_events_get_event_date_range($post_object->ID);
}

// Load card box template part.
get_template_part('parts/card-box', null, [
    'heading' => get_the_title($post_object),
    'excerpt' => apply_filters('the_excerpt', get_the_excerpt($post_object)),
    'meta' => $meta,
    'url' => get_permalink($post_object),
]);

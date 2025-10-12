<?php

// Move ACF fields below WooCommerce product fields
add_action('add_meta_boxes', function ($post_type, $post_object) {
    global $wp_meta_boxes;

    if (
        $post_type !== 'product' ||
        !isset($wp_meta_boxes[$post_type]['normal']['high']) ||
        !is_array($wp_meta_boxes[$post_type]['normal']['high'])
    ) {
        return;
    }

    foreach ($wp_meta_boxes[$post_type]['normal']['high'] as $key => $box) {
        if (substr($key, 0, 4) !== 'acf-') {
            continue;
        }

        unset($wp_meta_boxes[$post_type]['normal']['high'][$key]);

        if (!isset($wp_meta_boxes[$post_type]['normal']['default'])) {
            $wp_meta_boxes[$post_type]['normal']['default'] = [];
        }

        $wp_meta_boxes[$post_type]['normal']['default'][$key] = $box;
    }
}, 999, 2);

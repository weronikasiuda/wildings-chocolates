<?php

// Template part arguments
$template_args = [
    'taxonomy' => 'product_cat',
    'args' => [
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_key' => 'order',
    ],
];

// "View All" link?
$shop_url = null;
$is_shop = false;

if (function_exists('wc_get_page_id')) {
    $shop_url = get_permalink(wc_get_page_id('shop'));
}

if (function_exists('is_shop') && is_shop()) {
    $is_shop = true;
}

if ($shop_url) {
    $template_args['items_before'] = [
        [
            'title' => 'View All',
            'url' => $shop_url,
            'active' => $is_shop,
        ],
    ];
}

// Load template part
get_template_part('parts/side/categories', null, $template_args);

<?php

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'Product selection',
        'key' => 'product_selection__product_selection',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/home.php',
                ],
            ],
        ],
        'menu_order' => 20,
        'fields' => [
            [
                'label' => 'Heading',
                'key' => 'product_selection__product_selection__product_selection_heading',
                'name' => 'product_selection_heading',
                'type' => 'text',
            ],
            [
                'label' => 'Select Products',
                'key' => 'product_selection__product_selection__product_selection_select_products',
                'name' => 'product_selection_select_products',
                'type' => 'relationship',
                'post_type' => ['product'],
                'return_format' => 'object',
                'filters' => ['search'], // Only show search box, no taxonomy filters
            ],
        ],
    ]);
});

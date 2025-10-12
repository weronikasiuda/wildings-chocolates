<?php

add_action('acf/init', function () {

    // Get a list of all product taxonomies to use for the dropdown choices
    $product_taxonomies = get_object_taxonomies('product', 'objects');
    $taxonomy_choices = [];

    foreach ($product_taxonomies as $taxonomy) {
        // Exclude built-in taxonomies and the brand taxonomy
        // Add or remove any other taxonomy slugs you want to exclude
        if (!in_array($taxonomy->name, ['product_cat', 'product_tag', 'product_shipping_class', 'product_brand'])) {
            $taxonomy_choices[$taxonomy->name] = $taxonomy->labels->singular_name;
        }
    }

    acf_add_local_field_group([
        'title' => 'Shop by sliders',
        'key' => 'product_taxonomy_sliders__product_taxonomy_sliders',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/home.php',
                ],
            ],
        ],
        'menu_order' => 40,
        'fields' => [
            [
                'label' => 'Taxonomy Sliders',
                'key' => 'product_taxonomy_sliders__product_taxonomy_sliders__taxonomy_sliders',
                'name' => 'taxonomy_sliders',
                'type' => 'repeater',
                'sub_fields' => [
                    [
                        'label' => 'Heading',
                        'key' => 'product_taxonomy_sliders__product_taxonomy_sliders__taxonomy_sliders__slider_heading',
                        'name' => 'slider_heading',
                        'type' => 'text',
                    ],
                    [
                        'label' => 'Select Taxonomy',
                        'key' => 'product_taxonomy_sliders__product_taxonomy_sliders__taxonomy_sliders__select_taxonomy',
                        'name' => 'select_taxonomy',
                        'type' => 'select', // Changed to select
                        'choices' => $taxonomy_choices, // Dynamically generated choices
                        'default_value' => '',
                        'allow_null' => 1,
                        'multiple' => 0,
                        'ui' => 1,
                        'return_format' => 'value', // Returns the taxonomy slug
                    ],
                ],
                'layout' => 'block',
                'button_label' => 'Add Slider',
            ],
        ],
    ]);
});
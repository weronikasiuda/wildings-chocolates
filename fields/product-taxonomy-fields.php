<?php

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'Taxonomy Images',
        'key' => 'taxonomy_images_group',
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'diet',
                ],
            ],
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'occasion',
                ],
            ],
        ],
        'fields' => [
            [
                'label' => 'Taxonomy Image',
                'key' => 'field_taxonomy_image',
                'name' => 'taxonomy_image',
                'type' => 'image_aspect_ratio_crop',
                'crop_type' => 'aspect_ratio',
                'aspect_ratio_width' => 4,
                'aspect_ratio_height' => 5,
            ],
        ],
    ]);
});
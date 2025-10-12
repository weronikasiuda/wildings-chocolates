<?php

use function WS\WS\getButtonStyleChoices;
use function WS\WS\getIconChoices;

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'Banner',
        'key' => 'home_banner__home_banner',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/home.php',
                ],
            ],
        ],
        'menu_order' => 10,
        'fields' => [
            [
                'label' => 'Image',
                'key' => 'home_banner__home_banner__home_banner_image',
                'name' => 'home_banner_image',
                'crop_type' => 'aspect_ratio',
                'type' => 'image_aspect_ratio_crop',
				'aspect_ratio_width' => 21,
				'aspect_ratio_height' => 9,
                'wrapper' => [
                    'width' => 100,
                ],
            ],

            [
                'label' => 'Heading',
                'key' => 'home_banner__home_banner__home_banner_heading',
                'name' => 'home_banner_heading',
                'type' => 'text',
                'wrapper' => [
                    'width' => 100,
                ],
            ],
            [
                'label' => 'Subheading',
                'key' => 'home_banner__home_banner__home_banner_subheading',
                'name' => 'home_banner_subheading',
                'type' => 'text',
                'wrapper' => [
                    'width' => 100,
                ],
            ],
            [
                'label' => 'Content',
                'key' => 'home_banner__home_banner__home_banner_content',
                'name' => 'home_banner_content',
                'type' => 'textarea',
                'rows' => 8,
                'wrapper' => [
                    'width' => 100,
                ],
            ],
            [
                'label' => 'Links',
                'key' => 'home_banner__home_banner__home_banner_links',
                'name' => 'home_banner_links',
                'type' => 'repeater',
                'max' => 3,
                'button_label' => 'Add Link',
                'sub_fields' => [
                    [
                        'label' => 'Link',
                        'key' => 'home_banner__home_banner__home_banner_links__link',
                        'name' => 'link',
                        'type' => 'link',
                        'wrapper' => [
                            'width' => 66,
                        ],
                    ],
                    [
                        'label' => 'Style',
                        'key' => 'home_banner__home_banner__home_banner_sections__style',
                        'name' => 'style',
                        'type' => 'select',
                        'choices' => [
                            'secondary' => 'Secondary',
                            'outline' => 'Outline',
                        ],
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                ],
            ],
        ],
    ]);
});

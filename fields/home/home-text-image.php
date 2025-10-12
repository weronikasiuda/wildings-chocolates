<?php

use function WS\WS\getButtonStyleChoices;
use function WS\WS\getIconChoices;

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'Text and image sections',
        'key' => 'home_text_image__home_text_image',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/home.php',
                ],
            ],
        ],
        'menu_order' => 30,
        'fields' => [
            [
                'label' => 'Sections',
                'key' => 'home_text_image__home_text_image__home_text_image_sections',
                'name' => 'home_text_image_sections',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Section',
                'collapsed' => 'home_text_image__home_text_image__home_text_image_sections__title',
                'sub_fields' => [
                    [
                        'label' => 'Title',
                        'key' => 'home_text_image__home_text_image__home_text_image_sections__title',
                        'name' => 'title',
                        'type' => 'text',
                    ],

                    [
                        'label' => 'Heading',
                        'key' => 'home_text_image__home_text_image__home_text_image_sections__heading',
                        'name' => 'heading',
                        'type' => 'text',
                    ],
                    [
                        'label' => 'Image (Mobile)',
                        'key' => 'home_text_image__home_text_image__home_text_image_sections__image_mobile',
                        'name' => 'image_mobile',
                        'type' => 'image_aspect_ratio_crop',
                        'crop_type' => 'aspect_ratio',
                        'aspect_ratio_width' => 5,
                        'aspect_ratio_height' => 4,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
            
                    [
                        'label' => 'Image (Desktop)',
                        'key' => 'home_text_image__home_text_image__home_text_image_sections__image_desktop',
                        'name' => 'image_desktop',
                        'type' => 'image_aspect_ratio_crop',
                        'crop_type' => 'aspect_ratio',
                        'aspect_ratio_width' => 4,
                        'aspect_ratio_height' => 5,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],

                    [
                        'label' => 'Text',
                        'key' => 'home_text_image__home_text_image__home_text_image_sections__content',
                        'name' => 'content',
                        'type' => 'wysiwyg',
                        'toolbar' => 'basic',
                        'media_upload' => false,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],

                    [
                        'label' => 'Layout',
                        'key' => 'home_text_image__home_text_image__home_text_image_sections__section_layout',
                        'name' => 'section_layout',
                        'type' => 'radio',
                        'default_value' => 'default',
                        'choices' => [
                            'default' => 'Image left and text right',
                            'alt' => 'Text left and image right',
                        ],
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                    [
                        'label' => 'Links',
                        'key' => 'home_text_image__home_text_image__home_text_image_sections__links',
                        'name' => 'links',
                        'type' => 'repeater',
                        'button_label' => 'Add Link',
                        'sub_fields' => [
                            [
                                'label' => 'Link',
                                'key' => 'home_text_image__home_text_image__home_text_image_sections__link',
                                'name' => 'link',
                                'type' => 'link',
                                'wrapper' => [
                                    'width' => 33,
                                ],
                            ],
            
                            [
                                'label' => 'Style',
                                'key' => 'home_text_image__home_text_image__home_text_image_sections__style',
                                'name' => 'style',
                                'type' => 'select',
                                'choices' => getButtonStyleChoices(),
                                'wrapper' => [
                                    'width' => 33,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);
});

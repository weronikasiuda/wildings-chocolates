<?php

use function WS\WS\getButtonStyleChoices;
use function WS\WS\getIconChoices;

return [
    'label' => 'Text with image',
    'key' => 'flex__flex__flex_sections__text_image',
    'name' => 'text_image',
    'sub_fields' => [
        [
            'label' => 'Section ID',
            'key' => 'flex__flex__flex_sections__text_image__section_idt',
            'name' => 'section_id',
            'type' => 'text',
            'instructions' => 'Adding a descriptive ID to a section allows you to create a unique HTML anchor for that specific part of your webpage. Use one word or multiple words separated by hyphens.',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => 'Title',
            'key' => 'flex__flex__flex_sections__text_image__title',
            'name' => 'title',
            'type' => 'text',
        ],

        [
            'label' => 'Heading',
            'key' => 'flex__flex__flex_sections__text_image__heading',
            'name' => 'heading',
            'type' => 'text',
        ],

        [
            'label' => 'Image (Mobile)',
            'key' => 'flex__flex__flex_sections__text_image____image_mobile',
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
            'key' => 'flex__flex__flex_sections__text_image____image_desktop',
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
            'key' => 'flex__flex__flex_sections__text_image__content',
            'name' => 'content',
             'toolbar' => 'basic',
            'type' => 'wysiwyg',
            'toolbar' => 'basic',
            'media_upload' => false,
            'wrapper' => [
                'width' => 50,
            ],
        ],


        [
            'label' => 'Layout',
            'key' => 'flex__flex__flex_sections__text_image__layout',
            'name' => 'layout',
            'type' => 'radio',
            'choices' => [
                'default' => 'Image left and text right',
                'alt' => 'Text left and image right',
            ],
            'wrapper' => [
                'width' => 50,
            ],
        ],

        [
            'label' => 'Links',
            'key' => 'flex__flex__flex_sections__text_image__links',
            'name' => 'links',
            'type' => 'repeater',
            'button_label' => 'Add Link',
            'sub_fields' => [
                [
                    'label' => 'Link',
                    'key' => 'flex__flex__flex_sections__text_image__links__link',
                    'name' => 'link',
                    'type' => 'link',
                    'wrapper' => [
                        'width' => 25,
                    ],
                ],

                [
                    'label' => 'Style',
                    'key' => 'flex__flex__flex_sections__text_image__links__style',
                    'name' => 'style',
                    'type' => 'select',
                    'choices' => getButtonStyleChoices(),
                    'wrapper' => [
                        'width' => 25,
                    ],
                ],
            ],
        ],
    ],
];

<?php

use function WS\WS\getButtonStyleChoices;
use function WS\WS\getIconChoices;

return [
    'label' => 'Accordion',
    'key' => 'flex__flex__flex_sections__accordion',
    'name' => 'accordion',
    'sub_fields' => [
        [
            'label' => 'Accordion',
            'key' => 'flex__flex__flex_sections__accordion__accordion_items',
            'name' => 'accordion_items',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Item',
            'collapsed' => 'flex__flex__flex_sections__accordion__accordion_items__heading',
            'sub_fields' => [
                [
                    'label' => 'Heading',
                    'key' => 'flex__flex__flex_sections__accordion__accordion_items__heading',
                    'name' => 'heading',
                    'type' => 'text',
                    'required' => true,
                ],

                [
                    'label' => 'Text',
                    'key' => 'flex__flex__flex_sections__accordion__accordion_items__content',
                    'name' => 'content',
                    'type' => 'wysiwyg',
                    'media_upload' => false,
                    'toolbar' => 'basic',
                ],

                [
                    'label' => 'Links',
                    'key' => 'flex__flex__flex_sections__accordion__accordion_items__links',
                    'name' => 'links',
                    'type' => 'repeater',
                    'button_label' => 'Add Link',
                    'sub_fields' => [
                        [
                            'label' => 'Link',
                            'key' => 'flex__flex__flex_sections__accordion__accordion_items__links__link',
                            'name' => 'link',
                            'type' => 'link',
                            'wrapper' => [
                                'width' => 33,
                            ],
                        ],

                        [
                            'label' => 'Style',
                            'key' => 'flex__flex__flex_sections__accordion__accordion_items__links__style',
                            'name' => 'style',
                            'type' => 'select',
                            'choices' => getButtonStyleChoices(),
                            'wrapper' => [
                                'width' => 33,
                            ],
                        ],

                        [
                            'label' => 'Icon',
                            'key' => 'flex__flex__flex_sections__accordion__accordion_items__links__icon',
                            'name' => 'icon',
                            'type' => 'select',
                            'choices' => getIconChoices(),
                            'allow_null' => true,
                            'wrapper' => [
                                'width' => 33,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];

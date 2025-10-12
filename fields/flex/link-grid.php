<?php

use function WS\WS\getButtonStyleChoices;
use function WS\WS\getIconChoices;

return [
    'label' => 'Link grid',
    'key' => 'flex__flex__flex_sections__link_grid',
    'name' => 'link_grid',
    'sub_fields' => [
        [
            'label' => 'Links',
            'key' => 'flex__flex__flex_sections__link_grid__links',
            'name' => 'links',
            'type' => 'repeater',
            'button_label' => 'Add Link',
            'sub_fields' => [
                [
                    'label' => 'Link',
                    'key' => 'flex__flex__flex_sections__link_grid__links__link',
                    'name' => 'link',
                    'type' => 'link',
                    'wrapper' => [
                        'width' => 50,
                    ],
                ],

                [
                    'label' => 'Style',
                    'key' => 'flex__flex__flex_sections__link_grid__links__style',
                    'name' => 'style',
                    'type' => 'select',
                    'choices' => getButtonStyleChoices(),
                    'allow_null' => false,
                    'wrapper' => [
                        'width' => 50,
                    ],
                ],

                // [
                //     'label' => 'Icon',
                //     'key' => 'flex__flex__flex_sections__link_grid__links__icon',
                //     'name' => 'icon',
                //     'type' => 'select',
                //     'choices' => getIconChoices(),
                //     'allow_null' => true,
                //     'wrapper' => [
                //         'width' => 33,
                //     ],
                // ],
            ],
        ],
    ],
];

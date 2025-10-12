<?php

return [
    'label' => 'Resource',
    'key' => 'flex__flex__flex_sections__resource',
    'name' => 'resource',
    'sub_fields' => [
        [
            'label' => 'Heading',
            'key' => 'flex__flex__flex_sections__resource__heading',
            'name' => 'heading',
            'type' => 'text',
        ],

        [
            'label' => 'Description',
            'key' => 'flex__flex__flex_sections__resource__text',
            'name' => 'text',
            'type' => 'textarea',
            'rows' => 4,
        ],

        [
            'label' => 'Resource type',
            'key' => 'flex__flex__flex_sections__resource__type',
            'name' => 'type',
            'type' => 'radio',
            'layout' => 'horizontal',
            'choices' => [
                'file' => 'File',
                'link' => 'Link',
            ],
        ],

        [
            'label' => 'File',
            'key' => 'flex__flex__flex_sections__resource__file',
            'name' => 'file',
            'type' => 'file',
            'conditional_logic' => [
                [
                    [
                        'field' => 'flex__flex__flex_sections__resource__type',
                        'operator' => '==',
                        'value' => 'file',
                    ],
                ],
            ],
        ],

        [
            'label' => 'Link',
            'key' => 'flex__flex__flex_sections__resource__link',
            'name' => 'link',
            'type' => 'link',
            'conditional_logic' => [
                [
                    [
                        'field' => 'flex__flex__flex_sections__resource__type',
                        'operator' => '==',
                        'value' => 'link',
                    ],
                ],
            ],
        ],
    ],
];

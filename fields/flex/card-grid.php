<?php

return [
    'label' => 'Card grid',
    'key' => 'flex__flex__flex_sections__card_grid',
    'name' => 'card_grid',
    'sub_fields' => [
        [
            'label' => 'Layout',
            'key' => 'flex__flex__flex_sections__card_grid__layout',
            'name' => 'layout',
            'type' => 'radio',
            'choices' => [
                '4-col-layout' => '4 column layout',
                '3-col-layout' => '3 column layout',
            ],
        ],
        [
            'label' => 'Cards',
            'key' => 'flex__flex__flex_sections__card_grid__cards',
            'name' => 'cards',
            'type' => 'repeater',
            'button_label' => 'Add Card',
            'layout' => 'block',
            'collapsed' => 'flex__flex__flex_sections__card_grid__cards__heading',
            'sub_fields' => [
                [
                    'label' => 'Image',
                    'key' => 'flex__flex__flex_sections__card_grid__cards__image',
                    'name' => 'image',
                    'type' => 'image_aspect_ratio_crop',
                    'crop_type' => 'aspect_ratio',
                    'aspect_ratio_width' => 5,
                    'aspect_ratio_height' => 4,
                    'wrapper' => [
                        'width' => 50,
                    ],
                ],
                [
                    'label' => 'Heading',
                    'key' => 'flex__flex__flex_sections__card_grid__cards__heading',
                    'name' => 'heading',
                    'type' => 'text',
                    'required' => true,
                ],

                [
                    'label' => 'Text',
                    'key' => 'flex__flex__flex_sections__card_grid__cards__text',
                    'name' => 'text',
                    'type' => 'textarea',
                    'rows' => 8,
                ],

                [
                    'label' => 'Link',
                    'key' => 'flex__flex__flex_sections__card_grid__cards__link',
                    'name' => 'link',
                    'type' => 'link',
                ],
            ],
        ],
    ],
];

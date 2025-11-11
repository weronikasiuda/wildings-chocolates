<?php

return [
    'label' => 'Image grid',
    'key' => 'flex__flex__flex_sections__image_grid',
    'name' => 'image_grid',
    'sub_fields' => [
        [
            'label' => 'Section ID',
            'key' => 'flex__flex__flex_sections__image_grid__section_id',
            'name' => 'section_id',
            'type' => 'text',
            'instructions' => 'Adding a descriptive ID to a section allows you to create a unique HTML anchor for that specific part of your webpage. Use one word or multiple words separated by hyphens.',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => 'Images',
            'key' => 'flex__flex__flex_sections__image_grid__images',
            'name' => 'images',
            'type' => 'gallery',
        ],
    ],
];

<?php

return [
    'label' => 'Map',
    'key' => 'flex__flex__flex_sections__google_map',
    'name' => 'google_map',
    'sub_fields' => [
        [
            'label' => 'Section ID',
            'key' => 'flex__flex__flex_sections__text__section_id',
            'name' => 'section_id',
            'type' => 'text',
            'instructions' => 'Adding a descriptive ID to a section allows you to create a unique HTML anchor for that specific part of your webpage. Use one word or multiple words separated by hyphens.',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => 'Location',
            'key' => 'flex__flex__flex_sections__text__google_map',
            'name' => 'google_map',
            'type' => 'google_map',
        ],
    ],
];

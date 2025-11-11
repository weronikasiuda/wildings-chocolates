<?php

return [
    'label' => 'Video',
    'key' => 'flex__flex__flex_sections__video',
    'name' => 'video',
    'sub_fields' => [
        [
            'label' => 'Section ID',
            'key' => 'flex__flex__flex_sections__video__section_id',
            'name' => 'section_id',
            'type' => 'text',
            'instructions' => 'Adding a descriptive ID to a section allows you to create a unique HTML anchor for that specific part of your webpage. Use one word or multiple words separated by hyphens.',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => 'Video',
            'key' => 'flex__flex__flex_sections__video__video_embed',
            'name' => 'video_embed',
            'type' => 'oembed',
        ],
    ],
];

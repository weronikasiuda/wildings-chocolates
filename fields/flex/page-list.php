<?php

return [
    'label' => 'List of sub-pages',
    'key' => 'flex__flex__flex_sections__page_list',
    'name' => 'page_list',
    'sub_fields' => [
        [
            'label' => 'Section ID',
            'key' => 'flex__flex__flex_sections__page_list__section_id',
            'name' => 'section_id',
            'type' => 'text',
            'instructions' => 'Adding a descriptive ID to a section allows you to create a unique HTML anchor for that specific part of your webpage. Use one word or multiple words separated by hyphens.',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => '',
            'key' => 'flex__flex__flex_sections__page_list__message',
            'name' => 'message',
            'type' => 'message',
            'message' => 'List of sub-pages displayed as cards. If there are no sub-pages, this section will not be shown.'
        ],
    ],
];

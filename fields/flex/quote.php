<?php

return [
    'label' => 'Quote',
    'key' => 'flex__flex__flex_sections__quote',
    'name' => 'quote',
    'sub_fields' => [
        [
            'label' => 'Section ID',
            'key' => 'flex__flex__flex_sections__quote__section_id',
            'name' => 'section_id',
            'type' => 'text',
            'instructions' => 'Adding a descriptive ID to a section allows you to create a unique HTML anchor for that specific part of your webpage. Use one word or multiple words separated by hyphens.',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => 'Quote',
            'key' => 'flex__flex__flex_sections__quote__quote_content',
            'name' => 'quote_content',
            'type' => 'wysiwyg',
            'media_upload' => false,
            'toolbar' => 'basic',
        ],

        [
            'label' => 'Caption',
            'key' => 'flex__flex__flex_sections__quote__quote_caption',
            'name' => 'quote_caption',
            'type' => 'textarea',
            'rows' => 2,
        ],
    ],
];

<?php

return [
    'label' => 'Embed code',
    'key' => 'flex__flex__flex_sections__embed_code',
    'name' => 'embed_code',
    'sub_fields' => [
        [
            'label' => 'Section ID',
            'key' => 'flex__flex__flex_sections__embed_code__section_id',
            'name' => 'section_id',
            'type' => 'text',
            'instructions' => 'Adding a descriptive ID to a section allows you to create a unique HTML anchor for that specific part of your webpage. Use one word or multiple words separated by hyphens.',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => 'Embed code',
            'key' => 'flex__flex__flex_sections__embed_code__embed_code',
            'name' => 'embed_code',
            'type' => 'textarea',
            'instructions' => 'The code entered in this field will be output as is, without being escaped. Please be careful.',
        ],
    ],
];

<?php

return [
    'label' => 'Quote',
    'key' => 'flex__flex__flex_sections__quote',
    'name' => 'quote',
    'sub_fields' => [
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

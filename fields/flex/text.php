<?php

return [
    'label' => 'Text',
    'key' => 'flex__flex__flex_sections__text',
    'name' => 'text',
    'sub_fields' => [
        [
            'label' => 'Full size',
            'key' => 'flex__flex__flex_sections__text__full_size',
            'name' => 'full_size',
            'type' => 'true_false',
            'ui' => true,
            'default_value' => 1, // '1' sets the checkbox to be selected by default
            'ui_on_text' => 'Yes',
            'ui_off_text' => 'No',
        ],
        [
            'label' => 'Heading',
            'key' => 'flex__flex__flex_sections__text__heading',
            'name' => 'heading',
            'type' => 'text',
        ],

        [
            'label' => 'Text',
            'key' => 'flex__flex__flex_sections__text__content',
            'name' => 'content',
            'type' => 'wysiwyg',
            'media_upload' => false,
        ],
    ],
];
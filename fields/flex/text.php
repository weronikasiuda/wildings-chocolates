<?php

return [
    'label' => 'Text',
    'key' => 'flex__flex__flex_sections__text',
    'name' => 'text',
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
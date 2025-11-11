<?php

return [
    'label' => 'Profile',
    'key' => 'flex__flex__flex_sections__profile',
    'name' => 'profile',
    'sub_fields' => [
        [
            'label' => 'Section ID',
            'key' => 'flex__flex__flex_sections__profile__section_id',
            'name' => 'section_id',
            'type' => 'text',
            'instructions' => 'Adding a descriptive ID to a section allows you to create a unique HTML anchor for that specific part of your webpage. Use one word or multiple words separated by hyphens.',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => 'Heading',
            'key' => 'flex__flex__flex_sections__profile__heading',
            'name' => 'heading',
            'type' => 'text',
            'required' => true,
        ],

        [
            'label' => 'Image',
            'key' => 'flex__flex__flex_sections__profile__image',
            'name' => 'image',
            'type' => 'image',
            'wrapper' => [
                'width' => 50,
            ],
        ],

        [
            'label' => 'Introduction',
            'key' => 'flex__flex__flex_sections__profile__excerpt',
            'name' => 'excerpt',
            'type' => 'textarea',
            'rows' => 4,
            'wrapper' => [
                'width' => 50,
            ],
        ],

        [
            'label' => 'Text',
            'key' => 'flex__flex__flex_sections__profile__content',
            'name' => 'content',
            'type' => 'wysiwyg',
            'media_upload' => false,
            'toolbar' => 'basic',
        ],
    ],
];

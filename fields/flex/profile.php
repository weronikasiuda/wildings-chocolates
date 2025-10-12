<?php

return [
    'label' => 'Profile',
    'key' => 'flex__flex__flex_sections__profile',
    'name' => 'profile',
    'sub_fields' => [
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

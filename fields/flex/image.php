<?php

return [
    'label' => 'Image',
    'key' => 'flex__flex__flex_sections__image',
    'name' => 'image',
    'sub_fields' => [
        [
            'label' => 'Image',
            'key' => 'flex__flex__flex_sections__image__image',
            'name' => 'image',
            'type' => 'image_aspect_ratio_crop',
            'crop_type' => 'aspect_ratio',
            'aspect_ratio_width' => 4,
            'aspect_ratio_height' => 3,
        ],

        [
            'label' => 'Caption',
            'key' => 'flex__flex__flex_sections__image__caption',
            'name' => 'caption',
            'type' => 'textarea',
            'rows' => 4,
        ],
    ],
];

<?php

$filters = [
    'mce_buttons',
    'mce_buttons_2',
    'teeny_mce_buttons',
];

// Remove presentational TinyMCE controls.
foreach ($filters as $filter) {
    add_filter($filter, function ($buttons) {
        return array_diff($buttons, [
            'aligncenter',
            'alignfull',
            'alignleft',
            'alignright',
            'forecolor',
            'indent',
            'outdent',
            'strikethrough',
            'underline',
            'wp_more'
        ]);
    });
}

// Restrict TinyMCE block formats.
add_filter('tiny_mce_before_init', function ($init, $editor_id) {
    // Default editor allows h2 headings.
    $formats = [
        'Paragraph=p',
        'Heading 2=h2',
        'Heading 3=h3',
        'Heading 4=h4',
        'Heading 5=h5',
        'Heading 6=h6',
        'Preformatted=pre',
    ];

    // ACF editor allows h2 headings.
    if ($editor_id === 'acf_content') {
        $formats = [
            'Paragraph=p',
            'Heading 3=h3',
            'Heading 4=h4',
            'Heading 5=h5',
            'Heading 6=h6',
            'Preformatted=pre',
        ];
    }

    $init['block_formats'] = implode(';', $formats);

    return $init;
}, 10, 2);

// Remove TinyMCE media buttons.
// add_action('admin_head', function () {
//     remove_action('media_buttons', 'media_buttons');
// });

<?php

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'Read more text',
        'key' => 'read_more_text__read_more_text',
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ],
            ],
        ],
        'position' => 'side',
        'fields' => [
            [
                'label' => 'Read more text',
                'key' => 'read_more_text__read_more_text__read_more_text',
                'name' => 'read_more_text',
                'type' => 'text',
                'instructions' => 'Card links to this page will use this text instead of the default &ldquo;Read more&rdquo;.',
            ],
        ],
    ]);
});

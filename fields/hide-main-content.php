<?php

add_action('acf/init', function () {
    acf_add_local_field_group([
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/home.php',
                ],
            ],
        ],
        'key' => 'hide_main_content__hide_main_content',
        'menu_order' => -1,
        'style' => 'seamless',
        'hide_on_screen' => ['the_content'],
    ]);
});

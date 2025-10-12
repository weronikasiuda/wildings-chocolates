<?php

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'News section',
        'key' => 'home_news_section',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/home.php',
                ],
            ],
        ],
        'menu_order' => 60,
        'fields' => [
            [
                'label' => '',
                'key' => 'home_news_section__message',
                'name' => 'message',
                'type' => 'message',
                'message' => 'This section will display latest news.'
            ],
        ],
    ]);
});

<?php

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'Instagram section',
        'key' => 'home_shortcode',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/home.php',
                ],
            ],
        ],
        'menu_order' => 50,
        'fields' => [

            [
                'label' => 'Heading',
                'key' => 'home_shortcode__heading',
                'name' => 'home_shortcode_heading',
                'type' => 'text',
            ],
            [
                'label' => 'Text content',
                'key' => 'home_shortcode__text_content',
                'name' => 'home_shortcode_text_content',
                'type' => 'wysiwyg',
            ],
        ],
    ]);
});

<?php

use function WS\WS\getButtonStyleChoices;
use function WS\WS\getIconChoices;

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'Links',
        'key' => 'list_links__list_links',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/list.php',
                ],
            ],
        ],
        'menu_order' => 10,
        'fields' => [
            [
                'label' => 'Links',
                'key' => 'list_links__list_links__list_links',
                'name' => 'list_links',
                'type' => 'repeater',
                'button_label' => 'Add Link',
                'sub_fields' => [
                    [
                        'label' => 'Link',
                        'key' => 'list_links__list_links__list_links__link',
                        'name' => 'link',
                        'type' => 'link',
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],

                    [
                        'label' => 'Style',
                        'key' => 'list_links__list_links__list_links__style',
                        'name' => 'style',
                        'type' => 'select',
                        'choices' => getButtonStyleChoices(),
                        'allow_null' => false,
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],

                    [
                        'label' => 'Icon',
                        'key' => 'list_links__list_links__list_links__icon',
                        'name' => 'icon',
                        'type' => 'select',
                        'choices' => getIconChoices(),
                        'allow_null' => true,
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                ],
            ],
        ],
    ]);
});

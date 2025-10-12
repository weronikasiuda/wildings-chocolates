<?php

use Castlegate\AlcoholicsAnonymous\Api\ApiRequest;

add_action('acf/init', function () {
    $location = [
        [
            [
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'options',
            ],
        ],
    ];

    acf_add_options_page([
        'page_title' => 'Options',
        'menu_slug' => 'options',
        'capability' => 'edit_others_posts',
        'autoload' => true,
        'redirect' => false,
    ]);

    acf_add_local_field_group([
        'title' => 'Contact details',
        'key' => 'options__contact',
        'location' => $location,
        'menu_order' => 10,
        'fields' => [
            [
                'label' => 'Address',
                'key' => 'options__contact__contact_address',
                'name' => 'contact_address',
                'type' => 'textarea',
                'wrapper' => [
                    'width' => 50,
                ],
            ],

            [
                'label' => 'Location',
                'key' => 'options__contact__contact_location',
                'name' => 'contact_location',
                'type' => 'google_map',
                'wrapper' => [
                    'width' => 50,
                ],
            ],

            [
                'label' => 'Email address',
                'key' => 'options__contact__contact_email',
                'name' => 'contact_email',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],

            [
                'label' => 'Telephone number',
                'key' => 'options__contact__contact_tel',
                'name' => 'contact_tel',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
        ],
    ]);


    acf_add_local_field_group([
        'title' => 'Top Tagline Information',
        'key' => 'options__top_tagline',
        'location' => $location,
        'menu_order' => 30,
        'fields' => [
            [
                'label' => 'Information displayed in the top bar above the header',
                'key' => 'options__top_tagline__text',
                'name' => 'top_tagline_text',
                'type' => 'text',
                'wrapper' => [
                    'width' => 100,
                ],
            ],
        ],
    ]);

    acf_add_local_field_group([
        'title' => 'Bottom Tagline Information',
        'key' => 'options__bottom_tagline',
        'location' => $location,
        'menu_order' => 40,
        'fields' => [
            [
                'label' => 'Information displayed in the bottom bar below the header',
                'key' => 'options__bottom_tagline__text',
                'name' => 'bottom_tagline_text',
                'type' => 'text',
                'wrapper' => [
                    'width' => 100,
                ],
            ],
        ],
    ]);

    // acf_add_local_field_group([
    //     'title' => 'Links',
    //     'key' => 'options__links',
    //     'location' => $location,
    //     'menu_order' => 50,
    //     'fields' => [
    //         [
    //             'label' => 'Cookie policy',
    //             'key' => 'options__links__cookie_policy_link',
    //             'name' => 'cookie_policy_link',
    //             'type' => 'link',
    //             'wrapper' => [
    //                 'width' => 50,
    //             ],
    //         ],

    //         [
    //             'label' => 'Privacy policy',
    //             'key' => 'options__links__privacy_policy_link',
    //             'name' => 'privacy_policy_link',
    //             'type' => 'link',
    //             'wrapper' => [
    //                 'width' => 50,
    //             ],
    //         ],
    //     ],
    // ]);

});

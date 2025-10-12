<?php

// Create an options page that can be used to define widgets.
add_action('acf/init', function () {
    acf_add_options_sub_page([
        'page_title' => 'Widgets',
        'menu_title' => 'Widgets',
        'menu_slug' => 'widget-options',
        'parent_slug' => 'options',
        'capability' => 'edit_others_posts',
        'autoload' => true,
    ]);

    acf_add_local_field_group([
        'title' => 'Widgets',
        'key' => 'widget_options__widgets',
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'widget-options',
                ],
            ],
        ],
        'menu_order' => 10,
        'fields' => [
            [
                'label' => 'Widgets',
                'key' => 'widget_options__widgets__widgets',
                'name' => 'widgets',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Widget',
                'collapsed' => 'widget_options__widgets__widgets__heading',
                'sub_fields' => [
                    [
                        'label' => 'Heading',
                        'key' => 'widget_options__widgets__widgets__heading',
                        'name' => 'heading',
                        'type' => 'text',
                        'required' => true,
                    ],

                    [
                        'label' => 'Text',
                        'key' => 'widget_options__widgets__widgets__text',
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 4,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],

                    [
                        'label' => 'Image',
                        'key' => 'widget_options__widgets__widgets__image',
                        'name' => 'image',
                        'type' => 'image',
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],

                    [
                        'label' => 'Link',
                        'key' => 'widget_options__widgets__widgets__link',
                        'name' => 'link',
                        'type' => 'link',
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],

                    [
                        'label' => 'Colour',
                        'key' => 'widget_options__widgets__widgets__color',
                        'name' => 'color',
                        'type' => 'select',
                        'choices' => [
                            'primary' => 'Dark Blue',
                            'secondary' => 'Peach',
                            'tertiary' => 'Light Blue',
                            'light' => 'Light',
                        ],
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],

                    [
                        'label' => 'ID',
                        'key' => 'widget_options__widgets__widgets__id',
                        'name' => 'id',
                        'type' => 'text',
                        'readonly' => true,
                    ],
                ],
            ],
        ],
    ]);
});

// When the options page is updated, add a unique value to the read-only widget
// ID field so each widget can be identified.
add_filter('acf/update_value', function ($value, $post_id, $field, $original) {
    $key = $field['key'] ?? null;

    if ($key !== 'widget_options__widgets__widgets__id' || $value) {
        return $value;
    }

    return substr(bin2hex(random_bytes(32)), 0, 32);
}, 10, 4);

// Hide the read-only widget ID field on the options page.
add_action('admin_head', function () {
    ?>
    <style>
        .acf-field-widget-options--widgets--widgets--id {
            display: none;
        }
    </style>
    <?php
});

// Create a custom field so widgets can be selected for display on each page.
add_action('acf/init', function () {
    $widgets = (array) get_field('widgets', 'options');
    $options = [];

    foreach ($widgets as $widget) {
        $id = $widget['id'] ?? null;
        $heading = $widget['heading'] ?? null;

        if (!$id || !$heading) {
            continue;
        }

        $options[$id] = $heading;
    }

    if (!$options) {
        return;
    }

    acf_add_local_field_group([
        'title' => 'Widgets',
        'key' => 'widget_fields__widgets',
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'default',
                ],
            ],

            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/contact.php',
                ],
            ],

            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/flex.php',
                ],
            ],
        ],
        'menu_order' => 100,
        'fields' => [
            [
                'label' => 'Widgets',
                'key' => 'widget_fields__widgets__widgets',
                'name' => 'widgets',
                'type' => 'select',
                'allow_null' => true,
                'multiple' => true,
                'ui' => true,
                'choices' => $options,
            ],
        ],
    ]);
});

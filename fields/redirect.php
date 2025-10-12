<?php

add_action('acf/init', function () {
    add_action('init', function () {
        $exclude_post_types = [
            'attachment',
            'nav_menu_item',
            'revision',
        ];

        $exclude_taxonomies = [
            'link_category',
            'nav_menu',
            'post_format',
            'wp_template_part_area',
            'wp_theme',
        ];

        // Post single redirects
        $single_names = array_diff_key(get_post_types([
            'public' => true,
        ], 'names'), array_flip($exclude_post_types));

        $single_choices = array_values($single_names);

        // Post archive redirects
        $archive_objects = array_diff_key(get_post_types([
            'public' => true,
            'has_archive' => true,
        ], 'objects'), array_flip($exclude_post_types));

        $archive_choices = [];

        foreach ($archive_objects as $archive_object) {
            $archive_choices[$archive_object->name] = $archive_object->labels->singular_name;
        }

        asort($archive_choices);

        $post_post_type = get_post_type_object('post');

        $archive_choices = array_merge([
            'post' => $post_post_type->labels->singular_name,
        ], $archive_choices);

        // Taxonomy term redirects
        $taxonomies = get_taxonomies([
            'public' => true,
        ], 'objects');

        $taxonomies = array_diff_key($taxonomies, array_flip($exclude_taxonomies));
        $term_choices = [];

        foreach ($taxonomies as $taxonomy_name => $taxonomy_object) {
            $terms = get_terms([
                'taxonomy' => $taxonomy_name,
                'orderby' => 'name',
                'order' => 'ASC',
            ]);

            if ($terms) {
                $taxonomy_key = $taxonomy_object->label;
                $term_choices[$taxonomy_key] = [];

                foreach ($terms as $term) {
                    $term_choices[$taxonomy_key][$term->term_id] = $term->name;
                }
            }
        }

        ksort($term_choices);

        acf_add_local_field_group([
            'title' => 'Redirect',
            'key' => 'redirect__redirect',
            'location' => [
                [
                    [
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'templates/redirect.php',
                    ],
                ],
            ],
            'hide_on_screen' => [
                'the_content',
            ],
            'fields' => [
                [
                    'label' => 'Redirect type',
                    'key' => 'redirect__redirect__redirect_type',
                    'name' => 'redirect_type',
                    'type' => 'radio',
                    'choices' => [
                        'url' => 'URL',
                        'single' => 'Single post or page',
                        'archive' => 'Post type archive',
                        'taxonomy' => 'Taxonomy term archive',
                    ],
                ],

                [
                    'label' => 'URL',
                    'key' => 'redirect__redirect__redirect_url',
                    'name' => 'redirect_url',
                    'type' => 'text',
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'redirect__redirect__redirect_type',
                                'operator' => '==',
                                'value' => 'url',
                            ],
                        ],
                    ],
                ],

                [
                    'label' => 'Post or page',
                    'key' => 'redirect__redirect__redirect_post_id',
                    'name' => 'redirect_post_id',
                    'type' => 'post_object',
                    'post_type' => $single_choices,
                    'allow_null' => true,
                    'return_format' => 'id',
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'redirect__redirect__redirect_type',
                                'operator' => '==',
                                'value' => 'single',
                            ],
                        ],
                    ],
                ],

                [
                    'label' => 'Post type',
                    'key' => 'redirect__redirect__redirect_post_type',
                    'name' => 'redirect_post_type',
                    'type' => 'select',
                    'choices' => $archive_choices,
                    'allow_null' => true,
                    'ui' => true,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'redirect__redirect__redirect_type',
                                'operator' => '==',
                                'value' => 'archive',
                            ],
                        ],
                    ],
                ],

                [
                    'label' => 'Term',
                    'key' => 'redirect__redirect__redirect_term_id',
                    'name' => 'redirect_term_id',
                    'type' => 'select',
                    'choices' => $term_choices,
                    'allow_null' => true,
                    'ui' => true,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'redirect__redirect__redirect_type',
                                'operator' => '==',
                                'value' => 'taxonomy',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }, 999);
});

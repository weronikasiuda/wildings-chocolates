<?php

add_action('acf/init', function () {
    acf_add_local_field_group([
        'title' => 'Edition details',
        'key' => 'article_edition__article_edition',
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'article-edition',
                ],
            ],
        ],
        'fields' => [
            [
                'label' => 'Publication',
                'key' => 'article_edition__article_edition__article_edition_publication',
                'name' => 'article_edition_publication',
                'type' => 'taxonomy',
                'taxonomy' => 'article-publication',
                'return_format' => 'id',
                'field_type' => 'radio',
                'add_term' => false,
                'multiple' => false,
            ],

            [
                'label' => 'Date',
                'key' => 'article_edition__article_edition__article_edition_date',
                'name' => 'article_edition_date',
                'type' => 'date_picker',
                'return_format' => 'Y-m-d',
            ],

            [
                'label' => 'Excerpt',
                'key' => 'article_edition__article_edition__article_edition_excerpt',
                'name' => 'article_edition_excerpt',
                'type' => 'textarea',
            ],

            [
                'label' => 'Payment link embed code',
                'key' => 'article_edition__article_edition__article_edition_payment_embed',
                'name' => 'article_edition_payment_embed',
                'type' => 'textarea',
                'instructions' => 'The code entered in this field will be output as is, without being escaped. Please be careful.',
            ],
        ],
    ]);
});

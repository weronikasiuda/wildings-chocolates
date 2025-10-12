<!DOCTYPE html>
<html <?php language_attributes() ?>>
    <head>
        <!-- Website by The Web Brigade <https://thewebbrigade.com> -->

        <meta charset="<?= esc_attr(get_bloginfo('charset')) ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head() ?>
    </head>

    <body <?php body_class() ?>>
        <?php

        wp_body_open();

        get_template_part('parts/top-tagline');
        get_template_part('parts/header');

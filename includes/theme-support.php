<?php

add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');
add_theme_support('title-tag');

add_theme_support('html5', [
    'caption',
    'comment-form',
    'comment-list',
    'gallery',
    'script',
    'search-form',
    'style',
]);

add_post_type_support('page', 'excerpt');

<?php

/** Template Name: Home Page */

get_header();

the_post();

get_template_part('parts/bottom-tagline');
get_template_part('parts/home/home-banner');
get_template_part('parts/home/product-selection');
get_template_part('parts/home/home-text-image');
get_template_part('parts/home/home-shop-by-slider');
get_template_part('parts/home/home-shortcode');
get_template_part('parts/home/home-news-section');

get_footer();

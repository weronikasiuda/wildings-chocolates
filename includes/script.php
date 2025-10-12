<?php
// Enqueue Scripts only (styles are handled elsewhere)
add_action('wp_enqueue_scripts', function () {

    // All scripts that interact with the DOM should be in the footer.
    // The fifth parameter is set to true to ensure this.
    wp_enqueue_script(
        'twb-bootstrap',
        path_join(THEME_URL, 'dist/js/lib/bootstrap.bundle.min.js'),
        ['jquery'],
        null,
        true
    );
    wp_enqueue_script(
        'twb-aos',
        path_join(THEME_URL, 'dist/js/lib/aos.js'),
        ['jquery'],
        null,
        true
    );
    wp_enqueue_script(
        'twb-magnific-popup',
        path_join(THEME_URL, 'dist/js/lib/jquery.magnific-popup.min.js'),
        ['jquery'],
        null,
        true
    );

    // This is the Swiper library itself.
    wp_enqueue_script(
        'twb-swiper',
        path_join(THEME_URL, 'dist/js/lib/swiper-bundle.min.js'),
        [], // No direct dependencies needed for the bundle.
        null,
        true
    );

    // This is your main script, which contains the initialization code.
    // It must load AFTER Swiper, so Swiper is listed as a dependency.
    wp_enqueue_script(
        'twb-main',
        path_join(THEME_URL, 'dist/js/main.min.js'),
        ['twb-swiper', 'twb-magnific-popup'], // It depends on Swiper and other scripts.
        null,
        true
    );

}, 20);
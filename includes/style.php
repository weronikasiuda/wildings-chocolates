<?php

add_action('wp_enqueue_scripts', function () {
    $styles = [
        'twb-magnific-popup' => 'dist/css/lib/magnific-popup.css',
        'twb-aos' => 'dist/css/lib/aos.css',
        'twb-swiper' => 'dist/css/lib/swiper-bundle.min.css',
        'twb-style' => 'dist/css/style.min.css',
    ];

    if (defined('WP_DEBUG') && WP_DEBUG) {
        $styles['twb-debug'] = 'dist/css/debug.min.css';
    }

    $deps = [];

    foreach ($styles as $key => $src) {
        $url = path_join(THEME_URL, $src);
        $file = path_join(THEME_DIR, $src);
        $version = null;

        if (is_file($file)) {
            $version = md5_file($file);
        }

        wp_enqueue_style($key, $url, $deps, $version);

        $deps[] = $key;
    }
});

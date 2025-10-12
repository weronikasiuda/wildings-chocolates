<?php

add_action('admin_enqueue_scripts', function () {
    $src = 'dist/js/admin.min.js';

    $url = path_join(THEME_URL, $src);
    $file = path_join(THEME_DIR, $src);

    $deps = [
        'acf-input',
    ];

    $version = null;

    if (is_file($file)) {
        $version = md5_file($file);
    }

    wp_enqueue_script('twb-admin', $url, $deps, $version);
});

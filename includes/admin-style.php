<?php

add_action('admin_enqueue_scripts', function () {
    $styles = [
        'twb-admin' => 'dist/css/admin.min.css',
    ];

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

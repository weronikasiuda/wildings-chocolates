<?php

// Enqueue TinyMCE CSS with cache-busting query parameter.
add_action('init', function () {
    $path = 'dist/css/editor-style.min.css';
    $file = path_join(THEME_DIR, $path);
    $url = path_join(THEME_URL, $path);

    if (!is_file($file)) {
        return;
    }

    add_editor_style(add_query_arg('m', md5_file($file), $url));
});

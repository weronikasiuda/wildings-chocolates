<?php

// Sort ACF options pages alphabetically.
add_action('admin_init', function () {
    global $submenu;

    if (!isset($submenu['options']) || !is_array($submenu['options'])) {
        return;
    }

    usort($submenu['options'], function ($a, $b) {
        // The primary options page always comes first.
        if (($a[2] ?? null) === 'options') {
            return -1;
        }

        // The remaining pages are sorted alphabetically by title.
        return ($a[0] ?? null) <=> ($b[0] ?? null);
    });
}, 999);

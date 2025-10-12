<?php

// Add "Reactivate Theme" link to "Tools" menu.
add_action('admin_menu', function () {
    global $submenu;

    if (
        !current_user_can('install_plugins') ||
        !isset($submenu['tools.php'])
    ) {
        return;
    }

    $nonce = wp_create_nonce('reactivate_theme_nonce');

    $submenu['tools.php'][] = [
        'Reactivate Theme',
        'install_plugins',
        add_query_arg('reactivate_theme', $nonce),
    ];
});

// Run "activate theme" actions in response to request.
add_action('init', function () {
    $nonce = $_GET['reactivate_theme'] ?? null;

    if (
        !current_user_can('install_plugins') ||
        !wp_verify_nonce($nonce, 'reactivate_theme_nonce')
    ) {
        return;
    }

    do_action('after_switch_theme');
    flush_rewrite_rules();

    add_action('admin_notices', function () {
        echo '<div class="notice updated"><p>Theme reactivated.</p></div>';
    });
});

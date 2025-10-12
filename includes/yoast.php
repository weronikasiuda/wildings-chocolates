<?php

// Remove Yoast comments from front end HTML
add_filter('wpseo_debug_markers', '__return_false');

// Remove items from admin menu
add_action('admin_menu', function () {
    if (current_user_can('activate_plugins')) {
        return;
    }

    remove_menu_page('wpseo_dashboard');
    remove_menu_page('wpseo_workouts');
}, 20);

// Remove items from admin bar
add_action('admin_bar_menu', function ($admin_bar) {
    if (current_user_can('activate_plugins')) {
        return;
    }

    $admin_bar->remove_node('wpseo-menu');
}, 99);

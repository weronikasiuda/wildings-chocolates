<?php

add_filter('user_has_cap', function ($all_caps, $caps, $args, $user) {
    $roles = $user->roles ?? [];

    // User is not a site manager? Do not modify capabilities.
    if (!is_array($roles) || !in_array('cgit_site_manager', $roles)) {
        return $all_caps;
    }

    // Grant access to WooCommerce post types
    $woocommerce_post_types = [
        'product',
        'shop_order',
        'shop_coupon'
    ];

    foreach ($woocommerce_post_types as $type) {
        $all_caps["edit_{$type}"] = true;
        $all_caps["read_{$type}"] = true;
        $all_caps["delete_{$type}"] = true;
        $all_caps["edit_{$type}s"] = true;
        $all_caps["edit_others_{$type}s"] = true;
        $all_caps["publish_{$type}s"] = true;
        $all_caps["read_private_{$type}s"] = true;
        $all_caps["delete_{$type}s"] = true;
        $all_caps["delete_private_{$type}s"] = true;
        $all_caps["delete_published_{$type}s"] = true;
        $all_caps["delete_others_{$type}s"] = true;
        $all_caps["edit_private_{$type}s"] = true;
        $all_caps["edit_published_{$type}s"] = true;
        $all_caps["manage_{$type}_terms"] = true;
        $all_caps["edit_{$type}_terms"] = true;
        $all_caps["delete_{$type}_terms"] = true;
        $all_caps["assign_{$type}_terms"] = true;
    }

    // Grant access to WooCommerce configuration
    $all_caps['manage_woocommerce'] = true;
    $all_caps['view_woocommerce_reports'] = true;

    // Grant access to Gravity Forms
    // https://docs.gravityforms.com/role-management-guide/
    $all_caps['gravityforms_create_form'] = true;
    $all_caps['gravityforms_delete_forms'] = true;
    $all_caps['gravityforms_edit_forms'] = true;
    $all_caps['gravityforms_preview_forms'] = true;
    $all_caps['gravityforms_view_entries'] = true;
    $all_caps['gravityforms_edit_entries'] = true;
    $all_caps['gravityforms_delete_entries'] = true;
    $all_caps['gravityforms_view_entry_notes'] = true;
    $all_caps['gravityforms_edit_entry_notes'] = true;
    $all_caps['gravityforms_export_entries'] = true;
    // $all_caps['gravityforms_view_settings'] = true;
    // $all_caps['gravityforms_edit_settings'] = true;
    // $all_caps['gravityforms_view_updates'] = true;
    // $all_caps['gravityforms_view_addons'] = true;
    // $all_caps['gravityforms_system_status'] = true;
    // $all_caps['gravityforms_uninstall'] = true;
    // $all_caps['gravityforms_logging'] = true;
    // $all_caps['gravityforms_api_settings'] = true;

    return $all_caps;
}, 10, 4);

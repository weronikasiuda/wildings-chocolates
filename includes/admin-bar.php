<?php
add_action('admin_bar_menu', function ($admin_bar) {
    // Remove unnecessary nodes
    $admin_bar->remove_node('wp-logo');
    $admin_bar->remove_node('comments');
    
    // Remove "Howdy" from account link
    $account_node = $admin_bar->get_node('my-account');
    
    if ($account_node && isset($account_node->title)) { // Enhanced check to ensure node exists AND has a title property
        $howdy_components = array_filter(explode('%s', __('Howdy, %s')));
        $account_node->title = str_replace($howdy_components, '', $account_node->title);
        $admin_bar->remove_node('my-account');
        $admin_bar->add_node($account_node);
    }
}, 99);
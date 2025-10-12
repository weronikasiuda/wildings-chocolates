<?php


function register_product_taxonomies() {
    // Labels for the 'Diet' taxonomy
    $diet_labels = array(
        'name'              => _x( 'Diets', 'taxonomy general name', 'the-web-brigade' ),
        'singular_name'     => _x( 'Diet', 'taxonomy singular name', 'the-web-brigade' ),
        'search_items'      => __( 'Search Diets', 'the-web-brigade' ),
        'all_items'         => __( 'All Diets', 'the-web-brigade' ),
        'parent_item'       => __( 'Parent Diet', 'the-web-brigade' ),
        'parent_item_colon' => __( 'Parent Diet:', 'the-web-brigade' ),
        'edit_item'         => __( 'Edit Diet', 'the-web-brigade' ),
        'update_item'       => __( 'Update Diet', 'the-web-brigade' ),
        'add_new_item'      => __( 'Add New Diet', 'the-web-brigade' ),
        'new_item_name'     => __( 'New Diet Name', 'the-web-brigade' ),
        'menu_name'         => __( 'Diets', 'the-web-brigade' ),
    );

    // Arguments for the 'Diet' taxonomy
    $diet_args = array(
        'hierarchical'      => true,
        'labels'            => $diet_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'diet' ),
    );

    // Register the 'Diet' taxonomy
    register_taxonomy( 'diet', array( 'product' ), $diet_args );

    // Labels for the 'Occasion' taxonomy
    $occasion_labels = array(
        'name'              => _x( 'Occasions', 'taxonomy general name', 'the-web-brigade' ),
        'singular_name'     => _x( 'Occasion', 'taxonomy singular name', 'the-web-brigade' ),
        'search_items'      => __( 'Search Occasions', 'the-web-brigade' ),
        'all_items'         => __( 'All Occasions', 'the-web-brigade' ),
        'parent_item'       => __( 'Parent Occasion', 'the-web-brigade' ),
        'parent_item_colon' => __( 'Parent Occasion:', 'the-web-brigade' ),
        'edit_item'         => __( 'Edit Occasion', 'the-web-brigade' ),
        'update_item'       => __( 'Update Occasion', 'the-web-brigade' ),
        'add_new_item'      => __( 'Add New Occasion', 'the-web-brigade' ),
        'new_item_name'     => __( 'New Occasion Name', 'the-web-brigade' ),
        'menu_name'         => __( 'Occasions', 'the-web-brigade' ),
    );

    // Arguments for the 'Occasion' taxonomy
    $occasion_args = array(
        'hierarchical'      => true,
        'labels'            => $occasion_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'occasion' ),
    );

    // Register the 'Occasion' taxonomy
    register_taxonomy( 'occasion', array( 'product' ), $occasion_args );

    // Labels for the 'Chocolate type' taxonomy
    $chocolate_type_labels = array(
        'name'              => _x( 'Chocolate types', 'taxonomy general name', 'the-web-brigade' ),
        'singular_name'     => _x( 'Chocolate type', 'taxonomy singular name', 'the-web-brigade' ),
        'search_items'      => __( 'Search Chocolate types', 'the-web-brigade' ),
        'all_items'         => __( 'All Chocolate types', 'the-web-brigade' ),
        'parent_item'       => __( 'Parent Chocolate type', 'the-web-brigade' ),
        'parent_item_colon' => __( 'Parent Chocolate type:', 'the-web-brigade' ),
        'edit_item'         => __( 'Edit Chocolate type', 'the-web-brigade' ),
        'update_item'       => __( 'Update Chocolate type', 'the-web-brigade' ),
        'add_new_item'      => __( 'Add New Chocolate type', 'the-web-brigade' ),
        'new_item_name'     => __( 'New Chocolate type Name', 'the-web-brigade' ),
        'menu_name'         => __( 'Chocolate types', 'the-web-brigade' ),
    );

    // Arguments for the 'Chocolate type' taxonomy
    $chocolate_type_args = array(
        'hierarchical'      => true,
        'labels'            => $chocolate_type_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'chocolate-type' ),
    );

    // Register the 'Chocolate type' taxonomy
    register_taxonomy( 'chocolate_type', array( 'product' ), $chocolate_type_args );

}
add_action( 'init', 'register_product_taxonomies', 0 );
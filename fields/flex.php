<?php
add_action('acf/init', function () {
    // Flexible content layouts
    $layouts = [
        'accordion',
        'card-grid',
        'carousel',
        'divider',
        'google-map',
        'image-grid',
        'image',
        'link-grid',
        'quote',
        'resource',
        'text-image',
        'text',
        // 'video',
    ];

    // Flexible content layouts for privileged users
    if (current_user_can('edit_others_posts')) {
        $layouts[] = 'embed-code';
        $layouts[] = 'page-list';
    }
    sort($layouts);

    // Flexible content fields with ACFE modal settings
    $fields = [
        [
            'label' => 'Flexible content',
            'key' => 'flex__flex__flex_sections',
            'name' => 'flex_sections',
            'type' => 'flexible_content',
            'button_label' => 'Add Section',

            // ACFE Modal Settings - these are the key additions
            'acfe_flexible_modal' => [
                'acfe_flexible_modal_enabled' => '1',
                'acfe_flexible_modal_title' => '',
                'acfe_flexible_modal_size' => 'full',
                'acfe_flexible_modal_col' => '6',
                'acfe_flexible_modal_categories' => '0',
            ],

            // ACFE Modal Edit Settings
            'acfe_flexible_modal_edit' => [
                'acfe_flexible_modal_edit_enabled' => '1',
                'acfe_flexible_modal_edit_size' => 'large',
            ],

            // Additional ACFE settings
            'acfe_flexible_advanced' => 1,
            'acfe_flexible_stylised_button' => 0,
            'acfe_flexible_hide_empty_message' => 0,
            'acfe_flexible_empty_message' => '',
            'acfe_flexible_layouts_templates' => 0,
            'acfe_flexible_layouts_placeholder' => 0,
            'acfe_flexible_layouts_thumbnails' => 1,
            'acfe_flexible_layouts_settings' => 0,
            'acfe_flexible_layouts_locations' => 0,
            'acfe_flexible_async' => [],
            'acfe_flexible_add_actions' => [
                'title',
                'toggle',
                'copy',
                'close',
            ],
            'acfe_flexible_remove_button' => [],

            // Grid settings (optional)
            'acfe_flexible_grid' => [
                'acfe_flexible_grid_enabled' => '0',
                'acfe_flexible_grid_align' => 'center',
                'acfe_flexible_grid_valign' => 'stretch',
                'acfe_flexible_grid_wrap' => false,
            ],

            'layouts' => array_map(function ($layout) {
                $layout_config = include __DIR__ . '/flex/' . $layout . '.php';

                // Add modal settings to each layout if not already present
                if (!isset($layout_config['acfe_flexible_modal_edit_size'])) {
                    $layout_config['acfe_flexible_modal_edit_size'] = 'xlarge';
                }

                return $layout_config;
            }, $layouts),
        ],
    ];

    // --- START: Banner Field Definitions ---
    // --- START: Banner Field Definitions (as a Group Field) ---
    $banner_fields = [
        [
            'label' => 'Inner Flex Banner',
            'key' => 'flex_inner_banner__group', // Unique key for the Group field
            'name' => 'inner_flex_banner',      // Main name for the Group (used in get_field('inner_flex_banner'))
            'type' => 'group',
            'layout' => 'block', // 'block' stacks fields; 'row' or 'table' are other options
            'sub_fields' => [
                // Banner Image (Subfield 1)
                [
                    'label' => 'Banner Image',
                    'key' => 'flex_inner_banner__banner_image',
                    'name' => 'banner_image',
                    'crop_type' => 'aspect_ratio',
                    'type' => 'image_aspect_ratio_crop',
                    'aspect_ratio_width' => 21,
                    'aspect_ratio_height' => 9,
                    'wrapper' => [
                        'width' => 100,
                    ],
                ],
    
                // Banner Heading (Subfield 2)
                [
                    'label' => 'Banner Heading',
                    'key' => 'flex_inner_banner__banner_heading',
                    'name' => 'banner_heading',
                    'type' => 'text',
                    'wrapper' => [
                        'width' => 100,
                    ],
                ],
    
                // Banner Subheading (Subfield 3)
                [
                    'label' => 'Banner Subheading',
                    'key' => 'flex_inner_banner__banner_subheading',
                    'name' => 'banner_subheading',
                    'type' => 'text',
                    'wrapper' => [
                        'width' => 100,
                    ],
                ],
    
                // Banner Content (Subfield 4)
                [
                    'label' => 'Banner Content',
                    'key' => 'flex_inner_banner__banner_content',
                    'name' => 'banner_content',
                    'type' => 'textarea',
                    'rows' => 4,
                    'wrapper' => [
                        'width' => 100,
                    ],
                ],
                
                // Note: The Links Repeater would be added here if you still wanted it
                /* [
                    'label' => 'Links',
                    'key' => 'flex_inner_banner__banner_links', 
                    'name' => 'banner_links', 
                    'type' => 'repeater',
                    // ... repeater settings
                ],
                */
            ],
        ],
    ];
    // --- END: Banner Field Definitions (as a Group Field) ---
    // --- END: Banner Field Definitions ---


    // Additional fields for posts with optional main content
    // We merge the $banner_fields array first to ensure it appears above 
    // the Page heading/content toggles.
    $fields_with_content = array_merge(
        $banner_fields, // <-- Banner fields injected first
        [
            [
                'label' => 'Page heading',
                'key' => 'flex__flex__show_heading',
                'name' => 'show_heading',
                'type' => 'true_false',
                'message' => 'Show page heading above flexible content sections',
                'default_value' => true,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => 'Page content',
                'key' => 'flex__flex__show_content',
                'name' => 'show_content',
                'type' => 'true_false',
                'message' => 'Show page content above flexible content sections',
                'default_value' => true,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
        ],
        $fields // <-- The Flexible Content block and other fields come last
    );

    // Common field group parameters
    $args = [
        'title' => 'Flexible content',
        'key' => 'flex__flex',
        'menu_order' => 10,
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',

        // ACFE settings for the field group
        'acfe_autosync' => '',
        'acfe_form' => 1,
        'acfe_display_title' => '',
        'acfe_permissions' => '',
        'acfe_meta' => '',
        'acfe_note' => '',
    ];

    // Basic flexible content
    acf_add_local_field_group(array_merge($args, [
        'key' => 'flex_basic__flex',
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ],
            ],
        ],
        'fields' => $fields,
    ]));

    // Flexible content with optional main content
    acf_add_local_field_group(array_merge($args, [
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'templates/flex.php',
                ],
            ],
        ],
        'fields' => $fields_with_content,
    ]));
});

// Ensure ACF Extended scripts are loaded (if needed)
add_action('acf/input/admin_enqueue_scripts', function() {
    // This ensures ACFE modal scripts are loaded
    if (class_exists('ACFE')) {
        // ACFE will handle this automatically
        return;
    }

    // If ACFE is not available, you might need to enqueue custom modal scripts
    // or consider installing ACF Extended plugin
});
?>
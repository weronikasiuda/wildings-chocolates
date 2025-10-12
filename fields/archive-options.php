<?php

use function WS\WS\getButtonStyleChoices;
use function WS\WS\getIconChoices;

// add_action('acf/init', function () {
//     acf_add_options_sub_page([
//         'page_title' => 'Archives',
//         'menu_title' => 'Archives',
//         'menu_slug' => 'archive-options',
//         'parent_slug' => 'options',
//         'capability' => 'edit_others_posts',
//     ]);

//     // Post types
//     $types = [
//         'event' => [
//             'title' => 'Events',
//             'widgets' => false,
//         ],

//         'article' => [
//             'title' => 'Magazine Articles',
//             'widgets' => false,
//         ],

//         'member-story' => [
//             'title' => 'Member Stories',
//             'widgets' => true,
//         ],

//         'region' => [
//             'title' => 'Regions',
//             'widgets' => true,
//         ],
//     ];

//     // Available widgets as ACF select options
//     $widgets = (array) get_field('widgets', 'options');
//     $widgets_options = [];

//     foreach ($widgets as $widget) {
//         $id = $widget['id'] ?? null;
//         $heading = $widget['heading'] ?? null;

//         if (!$id || !$heading) {
//             continue;
//         }

//         $widgets_options[$id] = $heading;
//     }

//     // Custom fields
//     $fields = [];

//     foreach ($types as $key => $type) {
//         $title = $type['title'] ?? $key;
//         $has_widgets = $type['widgets'] ?? false;

//         $fields[] = [
//             'label' => $title,
//             'key' => "archive_options__archive_options__{$key}_archive_tab",
//             'name' => "{$key}_archive_tab",
//             'type' => 'tab',
//         ];

//         $fields[] = [
//             'label' => 'Introduction',
//             'key' => "archive_options__archive_options__{$key}_archive_content",
//             'name' => "{$key}_archive_content",
//             'type' => 'wysiwyg',
//             'media_upload' => false,
//         ];

//         $fields[] = [
//             'label' => 'Links',
//             'key' => "archive_options__archive_options__{$key}_archive_links",
//             'name' => "{$key}_archive_links",
//             'type' => 'repeater',
//             'sub_fields' => [
//                 [
//                     'label' => 'Link',
//                     'key' => "archive_options__archive_options__{$key}_archive_links__link",
//                     'name' => 'link',
//                     'type' => 'link',
//                     'wrapper' => [
//                         'width' => 33,
//                     ],
//                 ],

//                 [
//                     'label' => 'Style',
//                     'key' => "archive_options__archive_options__{$key}_archive_links__style",
//                     'name' => 'style',
//                     'type' => 'select',
//                     'choices' => getButtonStyleChoices(),
//                     'allow_null' => false,
//                     'wrapper' => [
//                         'width' => 33,
//                     ],
//                 ],

//                 [
//                     'label' => 'Icon',
//                     'key' => "archive_options__archive_options__{$key}_archive_links__icon",
//                     'name' => 'icon',
//                     'type' => 'select',
//                     'choices' => getIconChoices(),
//                     'allow_null' => true,
//                     'wrapper' => [
//                         'width' => 33,
//                     ],
//                 ],
//             ],
//         ];

//         if ($widgets_options && $has_widgets) {
//             $fields[] = [
//                 'label' => 'Widgets',
//                 'key' => "archive_options__archive_options__{$key}_archive_widgets",
//                 'name' => "{$key}_archive_widgets",
//                 'type' => 'select',
//                 'allow_null' => true,
//                 'multiple' => true,
//                 'ui' => true,
//                 'choices' => $widgets_options,
//             ];
//         }
//     }

//     acf_add_local_field_group([
//         'title' => 'Archives',
//         'key' => 'archive_options__archive_options',
//         'location' => [
//             [
//                 [
//                     'param' => 'options_page',
//                     'operator' => '==',
//                     'value' => 'archive-options',
//                 ],
//             ],
//         ],
//         'style' => 'seamless',
//         'menu_order' => 20,
//         'fields' => $fields,
//     ]);
// }, 20);

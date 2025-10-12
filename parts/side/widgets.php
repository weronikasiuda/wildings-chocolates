<?php

if (!function_exists('get_field')) {
    return;
}

// Assemble list of active widget IDs.
$active_widget_ids = (array) get_field('widgets');

if (is_post_type_archive()) {
    $type = get_queried_object();
    $name = $type->name ?? null;

    if ($name) {
        $active_widget_ids = (array) get_field($name . '_archive_widgets', 'options');
    }
}

if (!$active_widget_ids) {
    return;
}

// Assemble list of valid widgets.
$unprocessed_widgets = (array) get_field('widgets', 'options');
$valid_widgets = [];

foreach ($unprocessed_widgets as $widget) {
    $widget_id = $widget['id'] ?? null;

    if (!$widget_id) {
        continue;
    }

    $valid_widgets[$widget_id] = $widget;
}

if (!$valid_widgets) {
    return;
}

// Assemble final list of active widgets.
$widgets = [];

foreach ($active_widget_ids as $widget_id) {
    $widget = $valid_widgets[$widget_id] ?? null;

    if (!$widget) {
        continue;
    }

    $widgets[$widget_id] = $widget;
}

if (!$widgets) {
    return;
}

foreach ($widgets as $key => $widget) {
    $heading = $widget['heading'] ?? null;
    $excerpt = $widget['text'] ?? null;
    $color = $widget['color'] ?? null;

    $image_src = $widget['image']['sizes']['medium'] ?? '';
    $image_alt = $widget['image']['alt'] ?? '';

    if (!$image_src) {
        $image_src = path_join(THEME_URL, 'images/default/medium.webp');
    }

    $link_url = $widget['link']['url'] ?? null;
    $link_title = $widget['link']['title'] ?? null;

    ?>

    <div class="section">
        <?php

        get_template_part('parts/widget-box', null, [
            'heading' => $heading,
            'excerpt' => $excerpt,
            'color' => $color,
            'url' => $link_url,
            'image_src' => $image_src,
            'image_alt' => $image_alt,
            'button_text' => $link_title,
        ]);

        ?>
    </div>

    <?php
}

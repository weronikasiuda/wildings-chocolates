<?php

if (!function_exists('get_field')) {
    return;
}

$sections = (array) get_field('flex_sections');

if (!$sections) {
    return;
}

foreach ($sections as $section) {
    $layout = $section['acf_fc_layout'] ?? null;

    if (!$layout) {
        continue;
    }

    $part = 'parts/flex/' . str_replace('_', '-', $layout);

    get_template_part($part, null, $section);
}

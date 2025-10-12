<?php

// Edit CSS properties permitted by wp_kses
add_filter('safe_style_css', function ($attributes) {
    $attributes[] = 'aspect-ratio';
    $attributes[] = 'object-fit';

    return $attributes;
});

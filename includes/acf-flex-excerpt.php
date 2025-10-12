<?php

// Generate excerpts from ACF flexible content text layouts if an excerpt has
// not been entered manually and cannot be generated from the post content.
add_filter('get_the_excerpt', function ($excerpt, $post_object) {
    // Post already has an excerpt?
    if ($excerpt) {
        return $excerpt;
    }

    // ACF flexible content sections
    $sections = array_filter((array) get_field('flex_sections', $post_object->ID));

    if (!$sections) {
        return $excerpt;
    }

    // Attempt to assemble an excerpt from flexible content sections
    $contents = [];

    foreach ($sections as $section) {
        $layout = $section['acf_fc_layout'] ?? null;
        $content = $section['content'] ?? null;

        if ($layout === 'text' && $content) {
            $contents[] = strip_tags($content);
        }
    }

    $contents = array_map('strip_tags', $contents);
    $contents = array_map('trim', $contents);
    $contents = array_filter($contents);

    if (!$contents) {
        return $excerpt;
    }

    // Apply standard filters to generated excerpt
    $length = (int) apply_filters('excerpt_length', 55);
    $more = apply_filters('excerpt_more', ' [&hellip;]');

    return wp_trim_words(implode(' ', $contents), $length, $more);
}, 20, 2);

<?php
/**
 * Parent Template: Home Page Shop By Slider Logic
 * Description: Retrieves data from the ACF repeater and passes it to a reusable template.
 */

// Exit if the repeater field has no rows
if (!have_rows('taxonomy_sliders')) {
    return;
}

while (have_rows('taxonomy_sliders')) : the_row();
    $row_index = get_row_index();
    $section_heading = get_sub_field('slider_heading');
    $taxonomy_slug = get_sub_field('select_taxonomy');

    // Get all terms from the selected taxonomy
    $terms = get_terms([
        'taxonomy' => $taxonomy_slug,
        'hide_empty' => false,
    ]);

    // Check if there are errors with terms
    if ( is_wp_error($terms)) {
        continue;
    }
    
    // Create an array of data to pass to the reusable part
    $slider_data = [
        'row_index' => $row_index,
        'section_heading' => $section_heading,
        'terms' => $terms,
    ];

    // Call the reusable template part and pass the data as arguments
    get_template_part('parts/taxonomy-slider', null, $slider_data);

endwhile;
<?php

// 1. Define the arguments for the new query to get the latest three posts.
$args = array(
    'post_type'      => 'post',        // Only pull standard blog posts
    'posts_per_page' => 4,             // Limit to the latest three
    'post_status'    => 'publish',     // Only published posts
    'orderby'        => 'date',        // Order by date
    'order'          => 'DESC',        // Latest first
);

// 2. Create a new WP_Query instance.
$latest_posts = new WP_Query($args);

// 3. Check if any posts were found. If not, exit early.
if ( ! $latest_posts->have_posts() ) {
    return;
}

?>
<div class="card-grid">
    <div class="card-grid__wrap card-grid__wrap--narrow">
        <div class="card-grid__row">
            <div class="card-grid__heading-container">
                <h2 class="card-grid__heading" data-aos="fade-up" data-aos-duration="1000">Latest news</h2>
            </div>
        </div>
        <div class="card-grid__row card-grid__row--cards">
                <?php
                // 4. Start the WordPress loop to iterate over the posts.
                while ( $latest_posts->have_posts() ) {
                    $latest_posts->the_post(); // Sets up the current post data.

                    $heading    = get_the_title(); // Post title
                    $link_url   = get_the_permalink(); // Post URL
                    $link_title = 'Read more'; // Static text for the button/link title
                    $meta = get_the_date(); 

                    // --- Featured Image URL Logic ---
                    $image_src = path_join(THEME_URL, 'images/default/large.webp');
                    $image_alt = '';
                    // 1. Get the ID of the featured image attachment for the current post.
                    $image_id = get_post_thumbnail_id( get_the_ID() );

                    if ($image_id) {
                    // 2. Get the image data array [URL, width, height] for the 'xxl' size.
                    $image_data = wp_get_attachment_image_src( $image_id, 'xxl' );

                    // 3. Extract the URL (index 0) and use an empty string as a fallback if no image exists.
                    $image_src = $image_data[0] ?? ''; // FIX: Removed the extra '$'

                    // 4. Get the Alt Text for accessibility.
                    $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true ); // FIX: Changed variable name to 'image_alt' to match 'card-box.php'
                    }
                    ?>
                <div class="card-grid__column card-grid__column--4 ">
                    <?php
                    // You'll need to pass the featured image to your template part.
                    get_template_part('parts/card-box', null, [
                        'heading'     => $heading,
                        'meta'        => $meta,
                        'url'         => $link_url,
                        'button_text' => $link_title,
                        'image_src'   => $image_src, // FIX: Removed the '$' from the key
                        'image_alt'   => $image_alt, // PASS the image alt text
                    ]);
                    ?>
                </div>
                <?php
                }

                // 6. Reset post data to ensure the rest of the page works correctly.
                wp_reset_postdata(); 
                ?>
        </div>
    </div>
</div>
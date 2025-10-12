<?php

if (get_post_parent()) {
    return;
}

// Get the URL for the main blog posts index page
$blog_archive_url = get_permalink( get_option( 'page_for_posts' ) );

// Check if a URL was successfully found before outputting the link
if (!$blog_archive_url) {
    // If no specific blog page is set, fall back to home_url() 
    // or return if you prefer no button.
    $blog_archive_url = home_url('/'); 
}

?>

<div class="section">
    <?php

    get_template_part('parts/button-link', null, [
        'title' => 'Back to news', // Keep or change the title as desired
        'url' => $blog_archive_url,
        'icon' => 'chevron-left.svg',
        'reversed' => true,
    ]);

    ?>
</div>
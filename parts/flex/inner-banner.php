<?php
/**
 * Template part for displaying the inner flex banner (Group Field).
 */

// 1. Get the entire 'inner_flex_banner' Group field array.
// The name of the Group field is 'inner_flex_banner'.
$banner_group = get_field('inner_flex_banner');

// Check if the group field actually returned data before proceeding
if (!$banner_group) {
    return;
}

// 2. Extract subfields from the group array
// Subfields are accessed using their field names (e.g., 'banner_image').
$image      = $banner_group['banner_image'] ?? null;
$heading    = $banner_group['banner_heading'] ?? null;
$subheading = $banner_group['banner_subheading'] ?? null;
$content    = $banner_group['banner_content'] ?? null;

// Fallback checks for image data (only needed if you keep the original image processing logic)
$image_src  = $image['sizes']['xxxl'] ?? null; // Removed, as it's not used below
$image_alt  = $image['alt'] ?? null;


// 3. Final check to return if no content exists (using original logic)
if (!$image && !$heading && !$subheading && !$content) {
    return;
}

// Set a fallback for the image src for the mobile image tag
$mobile_image_src = $image['sizes']['medium'] ?? $image['url'] ?? '';

?>

<div class="inner-banner">
  <div class="inner-banner__container">
        
        <?php if ($image) : ?>
        <picture>
          <source srcset="<?= esc_url($image['url'] ?? '') ?>" media="(min-width: 1441px)">
          <source srcset="<?= esc_url($image['sizes']['xxl'] ?? $image['url'] ?? '') ?>" media="(max-width: 1440px)">
          <source srcset="<?= esc_url($image['sizes']['xxl'] ?? $image['url'] ?? '') ?>" media="(max-width: 1200px)">
          <source srcset="<?= esc_url($image['sizes']['medium'] ?? $image['url'] ?? '') ?>" media="(max-width: 1024px)">
          
          <img 
            src="<?= esc_url($mobile_image_src) ?>" 
            alt="<?= esc_attr($image_alt) ?>" 
            class="inner-banner__image"
          >
        </picture>
        <?php endif; ?>

        <?php
                    if ($heading || $subheading || $content) { ?>
        <div class="inner-banner__text-section" data-aos="fade-up" data-aos-duration="1000">
        <?php
                    if ($heading) {
                        ?>
                        <h1 class="inner-banner__heading" data-aos="fade-up" data-aos-duration="1000"><?= esc_html($heading) ?></h1>
                        <?php
                    }
                    if ($subheading) {
                        ?>
                        <h2 class="inner-banner__subheading" data-aos="fade-up" data-aos-duration="1000"><?= esc_html($subheading) ?></h2>
                        <?php
                    }
                    if ($content) {
                        // Assuming this content can contain paragraphs/basic HTML from a textarea, 
                        // wp_kses_post is safer than esc_html for a content area.
                        ?>
                        <div class="inner-banner__content" data-aos="fade-up" data-aos-duration="1000"><?= wp_kses_post($content) ?></div>
                        <?php
                    }
                    // Note: Changed the <h3> to a <div> for semantic correctness when wrapping $content.
                    ?>
                    <?php
                }
                ?> 
        </div>
  </div>
</div>
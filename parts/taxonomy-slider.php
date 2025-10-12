<?php
/**
 * Reusable Template: Taxonomy Slider 
 * Description: Renders a slider based on the data passed to it.
 */

// Get required arguments
$row_index = $args['row_index'] ?? 0;
$section_heading = $args['section_heading'] ?? '';
$section_heading_modifier = $args['section_heading_modifier'] ?? '';
$terms = $args['terms'] ?? [];

// Exit if no terms
if (empty($terms)) {
    return;
}
?>

<div class="image-card-grid">
    <div class="image-card-grid__wrap">
        <?php if ($section_heading) : ?>
            <div class="image-card-grid__row">
                <div class="image-card-grid__heading-container image-card-grid__heading-container--with-slider-nav">
                    <h2 class="image-card-grid__heading image-card-grid__heading--left-aligned image-card-grid__heading<?php echo $section_heading_modifier; ?>"><?php echo esc_html($section_heading); ?></h2>
                </div>
                <div class="image-card-grid__slider-nav">
                    <div class="image-card-grid__slider-nav-buttons">
                        <div class="swiper-button-next swiper-button-next-<?php echo $row_index; ?>"></div>
                        <div class="swiper-button-prev swiper-button-prev-<?php echo $row_index; ?>"></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="image-card-grid__row">
            <div class="swiper mySwiper-<?php echo $row_index; ?>">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($terms as $term) :
                        $image_src = path_join(THEME_URL, 'images/default/large.webp');
                        $image_alt = '';
                        $term_link = get_term_link($term);

                        // --- NEW LOGIC TO GET IMAGE BASED ON TAXONOMY ---
                        if (isset($term->taxonomy) && $term->taxonomy === 'product_cat') {
                            // Get WooCommerce category thumbnail
                            $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                            if ($thumbnail_id) {
                                $image_data = wp_get_attachment_image_src($thumbnail_id, 'medium_large');
                                $image_src = $image_data[0] ?? '';
                                $image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: $term->name;
                            }
                        } else {
                            // Fallback to ACF for custom taxonomies
                            $image_object = get_field('taxonomy_image', $term);
                            if ($image_object) {
                                $image_src = $image_object['url'];
                                $image_alt = $image_object['alt'];
                            }
                        }

                        if ($image_src) : // Only display if an image was found
                    ?>
                        <div class="swiper-slide">
                            <a href="<?php echo esc_url($term_link); ?>" class="image-card-grid__card">
                                <img class="image-card-grid__card-image"
                                    src="<?php echo esc_url($image_src); ?>"
                                    alt="<?php echo esc_attr($image_alt); ?>">
                                <div class="image-card-grid__card-text">
                                    <h3 class="image-card-grid__card-title">
                                        <?php echo esc_html($term->name); ?>
                                    </h3>
                                </div>
                            </a>
                        </div>
                    <?php endif; // End if image_src exists
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
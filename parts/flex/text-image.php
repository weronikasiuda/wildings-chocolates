<?php
/**
 * Text Image template part
 */

// *************************************************************************
// * NEW VARIABLES for data passed from single.php *
// *************************************************************************
$post_date = $args['post_date'] ?? null;
$post_title = $args['post_title'] ?? null;
$post_image = $args['post_image'] ?? null;


// *************************************************************************
// * ORIGINAL VARIABLES for Flexible Content / ACF use *
// *************************************************************************
$section_title = $args['title'] ?? null;
$section_heading = $args['heading'] ?? null;
$section_content = $args['content'] ?? null;
$image_mobile = $args['image_mobile'] ?? null; // NEW: Mobile image field
$image_desktop = $args['image_desktop'] ?? null; // NEW: Desktop image field
$layout = $args['layout'] ?? null;
$link_items = (array) ($args['links'] ?? []);
$links = [];


// Assemble list of valid links with URLs and titles. (NO CHANGE)
foreach ($link_items as $item) {
    $title = $item['link']['title'] ?? null;
    $url = $item['link']['url'] ?? null;
    if (!$url || !$title) { // Changed conditional from !$section_title to !$title
        continue;
    }
    $target = $item['link']['target'] ?? null;
    $icon = $item['icon'] ?? null;
    $style = $item['style'] ?? null;
    $links[] = compact('title', 'url', 'target', 'icon', 'style');
}


// *************************************************************************
// * Image Source Logic - Prioritizes the simple post data *
// *************************************************************************

$is_post_image = false; // Flag to track if the image is from a single post
$image_desktop_src = null; // New variable for desktop source
$image_mobile_src = null; // New variable for mobile source
$image_alt = '';

// 1. Check for simple post image data (from single.php)
if (isset($post_image['url'])) {
    $image_src = $post_image['url']; // Simple src for post image
    $image_alt = $post_image['alt'] ?? '';
    $is_post_image = true; // Set the flag

// 2. Check for complex ACF image data (from Flexible Content)
} elseif (!empty($image_desktop) && !empty($image_mobile)) {
    // Both images exist, so use both for the <picture> element
    $image_desktop_src = $image_desktop['sizes']['large'] ?? null;
    $image_mobile_src = $image_mobile['sizes']['large'] ?? null;

    // Use alt from the desktop image as the primary alt text
    $image_alt = $image_desktop['alt'] ?? ($image_mobile['alt'] ?? '');

    // Set a fallback src for the <img> tag within <picture> (default to desktop)
    $image_src = $image_desktop_src ?? $image_mobile_src ?? null;
} elseif (!empty($image_desktop)) {
    // Only desktop image exists, use it as the main source
    $image_src = $image_desktop['sizes']['large'] ?? null;
    $image_alt = $image_desktop['alt'] ?? '';
} elseif (!empty($image_mobile)) {
    // Only mobile image exists, use it as the main source
    $image_src = $image_mobile['sizes']['large'] ?? null;
    $image_alt = $image_mobile['alt'] ?? '';
}


// 3. Fallback to default image
if (empty($image_src) && empty($image_desktop_src) && empty($image_mobile_src)) {
    $image_src = path_join(THEME_URL, 'images/default/large.webp');
    $image_alt = '';
}


// *************************************************************************
// * Content and Exit Logic - Now includes post data *
// *************************************************************************

// No meaningful content? No output.
if (!$post_title && !$post_date && !$section_title && !$section_heading && !$section_content && !$image_src && empty($links) && !$image_desktop_src && !$image_mobile_src) {
    return;
}

// Feature-grid classes (NO CHANGE)
$class = 'feature-grid';
$classes = (array) $class;

// Add layout modifier if specified (NO CHANGE)
if ($layout === 'alt') {
    $classes[] = "$class--alt";
}

// Image class
$image_class = 'feature-grid__image';
$image_classes = (array) $image_class;

// *************************************************************************
// * NEW LOGIC: Add --landscape modifier if it's the post image *
// *************************************************************************
if ($is_post_image) {
    $image_classes[] = "$image_class--landscape";
}
// *************************************************************************

// Image format (NO CHANGE)
$image_format = $args['image_format'] ?? null;
if ($image_format === 'resize') {
    $image_classes[] = "$image_class--resized";
}
?>
<div class="section section--flex">
    <div class="<?= esc_attr(implode(' ', $classes)) ?>">
        <div class="feature-grid__wrap">
            <div class="feature-grid__grid">
                <div class="feature-grid__image-section" data-aos="fade-up" data-aos-duration="1000">
                    <?php if ($image_desktop_src && $image_mobile_src) :
                        // Use <picture> for responsive images if both ACF fields are present
                    ?>
                        <picture>
                            <source media="(min-width: 768px)" srcset="<?= esc_url($image_desktop_src) ?>">
                            <img src="<?= esc_url($image_mobile_src) ?>" alt="<?= esc_attr($image_alt) ?>" loading="lazy" class="<?= esc_attr(implode(' ', $image_classes)) ?>">
                        </picture>
                    <?php else:
                        // Fallback to a single <img> tag for post image or if only one ACF field is present
                    ?>
                        <img src="<?= esc_url($image_src) ?>" alt="<?= esc_attr($image_alt) ?>" loading="lazy" class="<?= esc_attr(implode(' ', $image_classes)) ?>">
                    <?php endif; ?>
                </div>
                <div class="feature-grid__text-section">
                        <?php
                            // New logic: Check for post_date first (from single.php header)
                            if ($post_date) {
                        ?>
                            <p class="feature-grid__date" data-aos="fade-up" data-aos-duration="1000">Published on <?= esc_html($post_date) ?></p>
                        <?php
                            // Fallback to original ACF title logic (from Flexible Content)
                            } elseif ($section_title) {
                        ?>
                            <h2 class="feature-grid__title" data-aos="fade-up" data-aos-duration="1000"><?= esc_html($section_title) ?></h2>
                        <?php
                        }

                        // New logic: Check for post_title (from single.php header)
                        if ($post_title) {
                        ?>
                        <h2 class="feature-grid__heading feature-grid__heading--standalone" data-aos="fade-up" data-aos-duration="1000"><?= esc_html($post_title) ?></h2>
                        <?php
                        // Fallback to original ACF heading logic (from Flexible Content)
                        } elseif ($section_heading) {
                        ?>
                        <h3 class="feature-grid__heading" data-aos="fade-up" data-aos-duration="1000"><?= esc_html($section_heading) ?></h3>
                        <?php
                        }
                        
                        // Original ACF content logic (NO CHANGE)
                        if ($section_content) {
                        ?>
                        <div class="feature-grid__text" data-aos="fade-up" data-aos-duration="1000">
                            <div class="text-content">
                                <?= wp_kses_post($section_content) ?>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if ($links): ?>
                    <div class="feature-grid__more" data-aos="fade-up" data-aos-duration="1000">
                        <?php get_template_part('parts/button-link-grid', null, compact('links')); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
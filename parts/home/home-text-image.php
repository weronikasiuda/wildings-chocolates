<?php
/**
 * Home Text Image section
 * * This template processes ACF fields and passes them as arguments
 * to the text-image template part
 */

// Get ACF sections data
$sections = get_field('home_text_image_sections');
if (!$sections) {
    return;
}

// Process each section
foreach ($sections as $section) {
    // Extract ACF field values
    $title = $section['title'] ?? null;
    $heading = $section['heading'] ?? null;
    
    // START AMENDMENT: Extract the new image fields
    $image_mobile = $section['image_mobile'] ?? null;
    $image_desktop = $section['image_desktop'] ?? null;
    
    // NOTE: The original $image variable is no longer needed but kept for context if it was used elsewhere.
    // Since your text-image.php only uses $image_mobile and $image_desktop for Flexible Content, 
    // it's safe to remove the original $image extraction if it was based on an old ACF field.
    // $image = $section['image'] ?? null; // Removed or commented out
    
    $content = $section['content'] ?? null;
    $section_layout = $section['section_layout'] ?? 'default';

    
    // Handle links
    $links = [];
    
    // Check if there's a links array (new format from ACF)
    if (isset($section['links']) && is_array($section['links'])) {
        foreach ($section['links'] as $item) {
            // Process each link item
            if (isset($item['link']) && !empty($item['link']['url'])) {
                $links[] = [
                    'link' => $item['link'],
                    'style' => $item['style'] ?? null,
                    'icon' => $item['icon'] ?? null
                ];
            }
        }
    }
    // Backward compatibility - if there's a single link field
    elseif (isset($section['link']) && !empty($section['link']['url'])) {
        $links[] = [
            'link' => $section['link'],
            'style' => $section['style'] ?? null,
            'icon' => $section['icon'] ?? null
        ];
    }
    
    // Prepare the arguments for the text-image template part
    $args = [
        'title' => $title,
        'heading' => $heading,
        'content' => $content,
        // START AMENDMENT: Pass the new image fields to the template part
        'image_mobile' => $image_mobile,
        'image_desktop' => $image_desktop,
        // 'image' => $image, // Removed/commented out as it's not used by the receiving template
        // END AMENDMENT
        'layout' => $section_layout === 'alt' ? 'alt' : 'default',
        'links' => $links
    ];
    ?>
    <div class="home-text-image">
        <div class="home-text-image__wrap">
            <div class="home-text-image__grid">
                <?php
                // Call the text-image template part with our arguments
                get_template_part('parts/flex/text-image', null, $args);
                ?>
            </div>
        </div>
    </div>
    <?php
} 
?>
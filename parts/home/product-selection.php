<?php
// Get ACF fields
$section_title = get_field('product_selection_heading');
$products = get_field('product_selection_select_products');
$layout = get_field('product_selection_layout');

// Format items for the grid template
$grid_items = [];
if (!empty($products)) {
    foreach ($products as $product_post) {
        // Get WooCommerce product object
        $product = wc_get_product($product_post->ID);
        
        // Get featured image
        $image_src = path_join(THEME_URL, 'images/default/large.webp');
        $image_alt = '';

        $image_id = get_post_thumbnail_id($product_post->ID);

        if ($image_id) {
        $image_src = wp_get_attachment_image_url($image_id, 'medium_large');
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        }
        
        // Get product data
        $title = $product->get_name();
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        $price_html = $product->get_price_html();
        $link_url = $product->get_permalink();
        
        $grid_items[] = [
            'title' => $title,
            'link_url' => $link_url,
            'image_src' => $image_src ?: '',
            'image_alt' => $image_alt ?: $title,
            'regular_price' => $regular_price,
            'sale_price' => $sale_price,
            'price_html' => $price_html,
        ];
    }
}

// Use the grid template with ACF data
get_template_part('parts/product-slider', null, [
    'section_title' => $section_title,
    'items' => $grid_items,
    'layout' => $layout,
]);
?>
<?php

if (!class_exists('\\WooCommerce')) {
    return;
}

// Add support for WooCommerce to the theme
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});

// Hide the product tag taxonomy
add_action('init', function () {
    register_taxonomy('product_tag', 'product', [
        'public' => false,
    ]);
});

add_filter('manage_product_posts_columns', function ($columns) {
    return array_diff_key($columns, ['product_tag' => null]);
}, 20);

// Replace default page template for WooCommerce pages
add_filter('template_include', function ($template) {
    $replacements = [
        'is_cart' => 'cart',
        'is_checkout' => 'checkout',
        'is_account_page' => 'account',
    ];

    foreach ($replacements as $function => $page) {
        $file = path_join(THEME_DIR, "parts/shop/pages/$page.php");

        if (function_exists($function) && $function() && is_file($file)) {
            return $file;
        }
    }

    return $template;
});

// Remove WooCommerce breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Show/hide WooCommerce page title
add_filter('woocommerce_show_page_title', function ($show) {
    if (is_product_category()) {
        return true;
    }

    return false;
});

// Set number of posts per page on the shop page(s)
add_action('pre_get_posts', function ($wp_query) {
    global $wpdb;

    if ($wp_query->is_admin || !$wp_query->is_main_query()) {
        return;
    }

    if ($wp_query->is_post_type_archive('product') || $wp_query->is_tax('product_cat')) {
        $wp_query->set('posts_per_page', 12);

        // Assemble a complete list of products sorted by (i) featured, (ii)
        // menu order, and (iii) post title. Use this list to sort the results
        // of the main product query.
        $product_ids = $wpdb->get_col('SELECT ID
            FROM wp_posts AS posts
            WHERE posts.post_type = "product"
            AND posts.post_status = "publish"
            ORDER BY
                IF((SELECT object_id FROM wp_term_relationships AS term_rel
                    WHERE posts.ID = term_rel.object_id
                    AND term_rel.term_taxonomy_id = (SELECT terms.term_id
                        FROM wp_terms AS terms
                        JOIN wp_term_taxonomy AS term_tax ON terms.term_id = term_tax.term_id
                        WHERE terms.slug = "featured"
                        AND term_tax.taxonomy = "product_visibility"
                        LIMIT 1)), 0, 1),
                menu_order,
                post_title
            ASC');

        if (is_array($product_ids) && $product_ids) {
            $product_ids = array_map('intval', $product_ids);

            $wp_query->set('post__in', $product_ids);
            $wp_query->set('orderby', 'post__in');
        }
    }
});

// Remove count and sorting options from archive
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// Wrap products in loop in elements to allow flexbox alignment
add_action('woocommerce_before_shop_loop_item', function () {
    echo '<div class="product-link-main">';
}, 5);

add_action('woocommerce_after_shop_loop_item_title', function () {
    echo '</div> <div class="product-link-cart">';
}, 20);

add_action('woocommerce_after_shop_loop_item', function () {
    echo '</div>';
}, 20);

// Add "featured" indicator
add_action('woocommerce_before_shop_loop_item_title', function () {
    global $product;

    if ($product->is_featured()) {
        get_template_part('parts/shop/featured');
    }
}, 5);

// Set image placeholder
add_filter('woocommerce_placeholder_img_src', function ($src) {
    return path_join(THEME_URL, 'images/default/product.webp');
});

// Prevent image placeholder being overwritten by option value
add_filter('option_woocommerce_placeholder_image', function ($value, $option) {
    return null;
}, 10, 2);

// Add grid HTML to single product image and text content
add_action('woocommerce_before_single_product_summary', function () {
    global $product;
    $img_cols = 'col-md-4'; // Default for non-composite

    // // Check if the product object exists and is a composite product
    // if ( is_a( $product, 'WC_Product' ) && $product->is_type( 'composite' ) ) {
    //     $img_cols = 'col-md-4'; // Change to col-md-4 for composite
    // }

    ?>
    <div class="section">
        <div class="row">
            <div class="<?php echo $img_cols; ?>">
    <?php
}, 1);

add_action('woocommerce_before_single_product_summary', function () {
    global $product;
    $text_cols = 'col-md-6 offset-md-1'; // Default for non-composite (5 + 1 + 6 = 12)

    // Check if the product object exists and is a composite product
    if ( is_a( $product, 'WC_Product' ) && $product->is_type( 'composite' ) ) {
        $text_cols = 'col-12'; 
    }

    ?>
            </div>
            <div class="<?php echo $text_cols; ?>">
    <?php
}, 999);

add_action('woocommerce_after_single_product_summary', function () {
    ?>
            </div>
        </div>
    </div>
    <?php
}, 1);

// Add section HTML to upsells ("You may also like")
add_action('woocommerce_before_template_part', function ($template, $path, $located, $args) {
    if ($template === 'single-product/up-sells.php' && ($args['upsells'] ?? null)) {
        ?>
        <div class="section">
            <hr>
        </div>

        <div class="section">
        <?php
    }
}, 10, 4);

add_action('woocommerce_after_template_part', function ($template, $path, $located, $args) {
    if ($template === 'single-product/up-sells.php' && ($args['upsells'] ?? null)) {
        ?>
        </div>
        <?php
    }
}, 10, 4);

// Add section HTML to related products
add_action('woocommerce_before_template_part', function ($template, $path, $located, $args) {
    if ($template === 'single-product/related.php' && ($args['related_products'] ?? null)) {
        ?>
        <div class="section">
            <hr>
        </div>

        <div class="section">
        <?php
    }
}, 10, 4);

add_action('woocommerce_after_template_part', function ($template, $path, $located, $args) {
    if ($template === 'single-product/related.php' && ($args['related_products'] ?? null)) {
        ?>
        </div>
        <?php
    }
}, 10, 4);

// Set "Sale!" text
add_filter('woocommerce_sale_flash', function ($content, $post, $product) {
    return '<span class="onsale">' . esc_html__('Sale', 'woocommerce') . '</span>';
}, 10, 3);

// Add grid HTML to login, lost password, and reset password forms
$forms = [
    'customer_login_form',
    'lost_password_form',
    'reset_password_form',
];

foreach ($forms as $form) {
    add_action("woocommerce_before_$form", function () {
        echo '<div class="row"><div class="col-lg-8 offset-lg-2">';
    });

    add_action("woocommerce_after_$form", function () {
        echo '</div></div>';
    });
}

// Change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_add_to_cart_button_text_single' );
function woocommerce_add_to_cart_button_text_single() {
    return __( 'Add to basket', 'woocommerce' );
}

// Change add to cart text on product archives page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_add_to_cart_button_text_archives' );
function woocommerce_add_to_cart_button_text_archives() {
    return __( 'Add to basket', 'woocommerce' );
}

// Change "cart" to "basket" in "added to cart" notification
add_filter('ngettext', function ($translation, $single, $plural, $number, $domain) {
    if ($single !== '%s has been added to your basket.') {
        return $translation;
    }

    if ($number === 1) {
        return '%s has been added to your basket.';
    }

    return '%s have been added to your basket.';
}, 10, 5);

// Change WooCommerce Cart Updated Text
add_filter( 'gettext', function( $new_text ) {
    if ( 'Cart updated.' === $new_text ) {
        $new_text = 'Basket updated.';
    }
    return $new_text;
} );

add_filter( 'gettext', function( $new_text ) {
    if ( 'Your cart is currently empty.' === $new_text ) {
        $new_text = 'Your basket is currently empty.';
    }
    return $new_text;
} );

// Change WooCommerce Update Cart Text
add_filter( 'gettext', function( $new_text ) {
    if ( 'Update cart' === $new_text ) {
        $new_text = 'Update basket';
    }
    return $new_text;
} );

// Change WooCommerce View Cart Text
add_filter( 'gettext', function( $new_text ) {
    if ( 'View cart' === $new_text ) {
        $new_text = 'View basket';
    }
    return $new_text;
} );

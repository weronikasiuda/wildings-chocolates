<?php

/**
 * Single product title
 *
 * @package WooCommerce\Templates
 * @version 1.6.4
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) {
    ?>
    <div class="product_meta">
        <span class="sku_wrapper"><?php esc_html_e('Product code:', 'woocommerce') ?> <span class="sku"><?= ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce') ?></span></span>
    </div>
    <?php
}

the_title('<h1 class="product_title entry-title">', '</h1>');

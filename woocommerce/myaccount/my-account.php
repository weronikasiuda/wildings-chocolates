<?php

/**
 * Account
 *
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="aa-wc-account-grid">
    <?php do_action('woocommerce_account_navigation') ?>

    <div class="woocommerce-MyAccount-content">
        <?php do_action('woocommerce_account_content') ?>
    </div>
</div>

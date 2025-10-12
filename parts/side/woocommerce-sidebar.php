<?php

// Default WooCommerce sidebar, which is blank by default, for compatibility
// with WooCommerce code and plugins.
ob_start();
do_action('woocommerce_sidebar');

$content = ob_get_clean();

if (!$content) {
    return;
}

?>

<div class="section">
    <?= $content ?>
</div>

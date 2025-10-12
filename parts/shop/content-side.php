<?php

ob_start();

// get_template_part('parts/side/product-categories');
get_template_part('parts/side/woocommerce-sidebar');

$content = trim(ob_get_clean());

if (!$content) {
    return;
}

?>

<div class="content__side">
    <?= $content ?>
</div>

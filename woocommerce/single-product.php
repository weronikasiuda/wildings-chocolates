<?php

/**
 * Product single
 *
 * @package WooCommerce\Templates
 * @version 1.6.4
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header('shop');

get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

?>

<div class="content">
    <div class="content__wrap">
        <?php

        do_action('woocommerce_before_main_content');

        while (have_posts()) {
            the_post();
            wc_get_template_part('content', 'single-product');
        }

        do_action('woocommerce_after_main_content');

        ?>
    </div>
</div>

<?php

get_footer('shop');

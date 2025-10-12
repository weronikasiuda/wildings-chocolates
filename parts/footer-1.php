<?php
use function WS\WS\getSanitizedSvgIcon;
use function WS\WS\getSanitizedSocialSvgIcon;
use function Castlegate\ErsatzFunctions\emailLink;
use function Castlegate\ErsatzFunctions\telLink;

// Contact details
$email = get_field('contact_email', 'options');
$tel = get_field('contact_tel', 'options');

// Shop admin links
$admin_links = [];
$admin_links_html = [];
$locations = get_nav_menu_locations();
$admin_menu_id = $locations['shop-admin-links'] ?? null;
if ($admin_menu_id) {
    $admin_links = (array) wp_get_nav_menu_items($admin_menu_id);
    $admin_links = array_filter($admin_links, function ($item) {
        return ((int) $item->menu_item_parent) === 0;
    });
    foreach ($admin_links as $item) {
        $admin_links_html[] = '<li class="footer-1__nav-item"><a href="' . esc_url($item->url) . '" class="footer-1__nav-link">' . esc_html($item->title) . '</a></li>';
    }
}

// Shop
$current_url = add_query_arg([]);
$shop_login_url = wp_login_url($current_url);
$shop_login_text = 'Log in';
if (function_exists('wc_get_page_permalink')) {
    $shop_login_url = wc_get_page_permalink('myaccount');
}
if (is_user_logged_in()) {
    $shop_login_url = wp_logout_url($current_url);
    $shop_login_text = 'Log out';
}
$shop_cart_url = null;
if (function_exists('wc_get_cart_url')) {
    $shop_cart_url = wc_get_cart_url();
}
?>
<div class="footer-1">
    <div class="footer-1__wrap">
        <div class="footer-1__grid">
            <div class="footer-1__item">
                <h3 class="footer-1__heading">Useful links</h3>
                <?php if ($admin_links) : ?>
                <ul class="footer-1__nav-list">
                    <?= implode(' ', $admin_links_html) ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php
            if ($email || $tel) {
            ?>
            <div class="footer-1__item">
                <h3 class="footer-1__heading">Contact us</h3>
                <div class="footer-1__text">
                    <?php
                    if ($tel) {
                    ?>
                    <p class="footer-1__text-line">
                        <?= getSanitizedSocialSvgIcon('phone.svg') ?>
                        <?= telLink($tel, null, ['class' => 'footer-big-link']) ?></p>
                    <?php
                    }
                    if ($email) {
                    ?>
                    <p class="footer-1__text-line">
                        <?= getSanitizedSocialSvgIcon('email.svg') ?>
                        <?= emailLink($email, null, ['class' => 'footer-big-link']) ?></p>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            }
            if ($shop_login_url && $shop_cart_url) {
            ?>
            <div class="footer-1__item">
                <h3 class="footer-1__heading">Login or update your basket</h3>
                <div class="row gy-3">
                    <div class="col-12 col-sm-6 col-md-4 offset-lg5-0 col-lg3-12 col-xl1-6">
                        <a href="<?= $shop_login_url ?>" class="btn btn-outline-primary d-block">
                            <span class="btn-icon" aria-hidden="true"><?= getSanitizedSvgIcon('account.svg') ?></span>
                            <span class="btn-text"><?= $shop_login_text ?></span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 offset-md-1 offset-lg3-0 col-lg3-12 col-xl1-6">
                        <a href="<?= $shop_cart_url ?>" class="btn btn-outline-primary d-block">
                            <span class="btn-icon" aria-hidden="true"><?= getSanitizedSvgIcon('cart.svg') ?></span>
                            <span class="btn-text">View basket</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php

use function WS\WS\getSanitizedSvgIcon;

// Site title
if (function_exists('cgit_seo_heading')) {
    $title = cgit_seo_heading();
} else {
    $title = trim(wp_title('', false));
}

if (!$title) {
    $title = get_bloginfo('name');
}


// Log in/out link
$current_url = add_query_arg([]);
$login_url = wp_login_url($current_url);

if (function_exists('wc_get_page_permalink')) {
    $login_url = wc_get_page_permalink('myaccount');
}

if (is_user_logged_in()) {
    if (function_exists('wc_get_page_permalink')) {
        $login_url = wc_get_page_permalink('myaccount');
    } else {
        $login_url = wp_logout_url($current_url);
    }
}

// Cart link
$cart_url = null;
$cart_mod = 'cart-empty';
$cart_has_contents = false;

if (function_exists('WC') && WC()->cart->get_cart_contents_count()) {
    $cart_has_contents = true;
}

if ($cart_has_contents) {
    $cart_mod = 'cart-has-contents';
}

if (function_exists('wc_get_cart_url')) {
    $cart_url = wc_get_cart_url();
}

?>

<div class="header">
    <div class="header__wrap">
        <div class="header__row">
            <h1 class="header__title">
                <a href="<?= esc_url(home_url('/')) ?>" class="header__title-link">
                    <img src="<?= esc_url(THEME_URL . '/images/' . LOGO) ?>" alt="<?= esc_attr(get_bloginfo('name')) ?>" class="header__title-logo">
                </a>
            </h1>

            <div class="header__nav">
                <div class="header-nav">
                    <?php

                    wp_nav_menu([
                        'theme_location' => 'main-nav',
                    ]);

                    ?>
                </div>
            </div>

            <div class="header__mobile-nav">
                <span class="header__mobile-nav-button">
                    <a href="#" class="header__mobile-nav-link">
                        <span class="header__mobile-nav-icon hamburger" aria-hidden="true">
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                        </span>
                    </a>
                </span>
            </div>



            <div class="header__actions">
                <div class="header__actions-grid">

                    <span class="header__actions-item header__actions-item--login">
                        <a href="<?= esc_url($login_url) ?>" class="header__actions-link">
                            <span class="header__actions-icon" aria-hidden="true"><?= getSanitizedSvgIcon('account.svg') ?></span>
                        </a>
                    </span>


                    <?php

                    if ($cart_url) {
                        ?>
                        <span class="header__actions-item header__actions-item--cart">
                            <a href="<?= esc_url($cart_url) ?>" class="<?= esc_attr('header__actions-link header__actions-link--' . $cart_mod) ?>">
                                <span class="header__actions-icon" aria-hidden="true"><?= getSanitizedSvgIcon('cart.svg') ?></span>
                            </a>
                        </span>
                        <?php
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

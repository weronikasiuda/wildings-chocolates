<?php

// Load classes and functions

require_once __DIR__ . '/vendor/autoload.php';

// Theme constants and functions
require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/functions.php';

// Theme CSS and JavaScript
require_once __DIR__ . '/includes/style.php';
require_once __DIR__ . '/includes/editor-style.php';
require_once __DIR__ . '/includes/script.php';

// Theme features
require_once __DIR__ . '/includes/acf-flex-excerpt.php';
require_once __DIR__ . '/includes/acf-google-maps.php';
require_once __DIR__ . '/includes/acf-options-sort.php';
require_once __DIR__ . '/includes/acf-video-embed.php';
require_once __DIR__ . '/includes/acf-woocommerce.php';
require_once __DIR__ . '/includes/acf-yoast.php';
require_once __DIR__ . '/includes/admin-bar.php';
require_once __DIR__ . '/includes/admin-menus.php';
require_once __DIR__ . '/includes/admin-script.php';
require_once __DIR__ . '/includes/admin-style.php';
require_once __DIR__ . '/includes/date-format.php';
require_once __DIR__ . '/includes/editor-toolbar.php';
require_once __DIR__ . '/includes/emoji.php';
require_once __DIR__ . '/includes/generator.php';
require_once __DIR__ . '/includes/google-analytics.php';
require_once __DIR__ . '/includes/gutenberg.php';
require_once __DIR__ . '/includes/icons.php';
require_once __DIR__ . '/includes/image-sizes.php';
require_once __DIR__ . '/includes/nav-menus.php';
require_once __DIR__ . '/includes/prevent-menu-flash.php';
require_once __DIR__ . '/includes/post-submitbox-misc-actions.php';
require_once __DIR__ . '/includes/post-taxonomies.php';
require_once __DIR__ . '/includes/posts-per-page.php';
require_once __DIR__ . '/includes/reactivate-theme.php';
require_once __DIR__ . '/includes/reenable-paypal-standard.php';
require_once __DIR__ . '/includes/safe-style-css.php';
require_once __DIR__ . '/includes/site-manager-user-role.php';
require_once __DIR__ . '/includes/theme-support.php';
require_once __DIR__ . '/includes/upload-mimes.php';
require_once __DIR__ . '/includes/upload-size-limit.php';
require_once __DIR__ . '/includes/woocommerce.php';
require_once __DIR__ . '/includes/woocommerce-product-taxonomies.php';
require_once __DIR__ . '/includes/woocommerce_no_shipping_available.php';
require_once __DIR__ . '/includes/wp-mail-headers.php';
require_once __DIR__ . '/includes/yoast.php';

// Theme fields
require_once __DIR__ . '/fields/archive-options.php';
require_once __DIR__ . '/fields/article-edition.php';
require_once __DIR__ . '/fields/flex.php';
require_once __DIR__ . '/fields/hide-main-content.php';
require_once __DIR__ . '/fields/list-links.php';
require_once __DIR__ . '/fields/options.php';
require_once __DIR__ . '/fields/product-taxonomy-fields.php';
require_once __DIR__ . '/fields/read-more-text.php';
require_once __DIR__ . '/fields/redirect.php';
require_once __DIR__ . '/fields/widgets.php';

require_once __DIR__ . '/fields/home/home-banner.php';
require_once __DIR__ . '/fields/home/product-selection.php';
require_once __DIR__ . '/fields/home/home-text-image.php';
require_once __DIR__ . '/fields/home/home-product-taxonomy-sliders.php';
require_once __DIR__ . '/fields/home/home-shortcode.php';
require_once __DIR__ . '/fields/home/home-news-section.php';

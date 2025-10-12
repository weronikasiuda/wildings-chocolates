<?php

/**
 * Breadcrumb
 *
 * Requires Castlegate Breadcrumb plugin.
 *
 * @see https://github.com/castlegateit/cgit-wp-breadcrumb
 */


use Cgit\Breadcrumb;

use function WS\WS\getArchiveRedirectPageId;
use function WS\WS\getTaxonomyPostType;

if (!class_exists('\\Cgit\\Breadcrumb')) {
    return;
}

$breadcrumb = new Breadcrumb();
$items = $breadcrumb->getItems();

// Splice in post types with corresponding redirect pages
$type = null;
$offset = -1;
$object = get_queried_object();

if (is_post_type_archive() && $object instanceof WP_Post_Type) {
    $type = $object->name;
} elseif (is_singular() && !is_singular('post') && $object instanceof WP_Post) {
    $type = $object->post_type;
    $offset = -2;
} elseif (is_tax()) {
    $term = get_queried_object();
    $type = getTaxonomyPostType($term->taxonomy);
    $offset = -2;
}


if ($type) {
    $redirect_page_id = getArchiveRedirectPageId($type);

    if ($redirect_page_id) {
        $parent_object = get_post_parent($redirect_page_id);
        $parent_items = [];

        while ($parent_object) {
            $parent_items[] = [
                'text' => get_the_title($parent_object),
                'url' => get_permalink($parent_object),
            ];

            $parent_object = get_post_parent($parent_object);
        }

        if (is_tax()) {
            array_unshift($parent_items, [
                'text' => get_the_title($redirect_page_id),
                'url' => get_permalink($redirect_page_id),
            ]);
        }

        if ($parent_items) {
            array_splice($items, $offset, 0, array_reverse($parent_items));
        }
    }
}



// Fix event date archives
if (is_post_type_archive('event') && is_date()) {
    $redirect_page_id = getArchiveRedirectPageId('event');
    $post_type_object = get_post_type_object('event');
    $items = array_slice($items, 0, 1);

    if ($redirect_page_id) {
        $parent_object = get_post_parent($redirect_page_id);
        $parent_items = [];

        while ($parent_object) {
            $parent_items[] = [
                'text' => get_the_title($parent_object),
                'url' => get_permalink($parent_object),
            ];

            $parent_object = get_post_parent($parent_object);
        }

        if ($parent_items) {
            $items = array_merge($items, array_reverse($parent_items));
        }

        $items[] = [
            'text' => $post_type_object->labels->name,
            'url' => get_permalink($redirect_page_id),
        ];
    }

    $year = get_query_var('year');
    $month = get_query_var('monthnum');
    $day = get_query_var('day');

    $output = 'Archives';

    if ($day && $month && $year) {
        $date = DateTime::createFromFormat('Y-m-d', "$year-$month-$day");

        if ($date) {
            $output = $date->format('j F Y');
        }
    } elseif ($month && $year) {
        $date = DateTime::createFromFormat('Y-m', "$year-$month");

        if ($date) {
            $output = $date->format('F Y');
        }
    } elseif ($year) {
        $output = (string) $year;
    }

    if ($output) {
        $items[] = [
            'text' => $output,
        ];
    }
}

// Add WooCommerce items
if (class_exists('\\WooCommerce')) {
    $shop_page_id = wc_get_page_id('shop');

    // Shop page
    $shop_items = [
        [
            'text' => get_the_title($shop_page_id),
            'url' => wc_get_page_permalink('shop'),
        ],
    ];

    // Shop page parents
    if ($shop_page_id) {
        $shop_parent = get_post_parent($shop_page_id);

        while ($shop_parent) {
            $shop_items[] = [
                'text' => get_the_title($shop_parent),
                'url' => get_permalink($shop_parent),
            ];

            $shop_parent = get_post_parent($shop_parent);
        }
    }

    $shop_items = array_reverse($shop_items);

    // Categories, single products, cart, checkout, account page
    if (is_product_category()) {
        array_splice($items, 1, 0, $shop_items);
    } elseif (is_product()) {
        array_splice($items, -2, 1, $shop_items);
    } elseif (is_cart() || is_checkout() || is_account_page()) {
        array_splice($items, -1, 0, $shop_items);
    }

    // Account sub-pages
    $account_endpoints = [
        'orders',
        'downloads',
        'edit-account',
        'edit-address',
    ];

    foreach ($account_endpoints as $endpoint) {
        if (is_wc_endpoint_url($endpoint)) {
            // Add URL to account item
            $items[array_key_last($items)]['url'] = wc_get_page_permalink('myaccount');

            // Append sub-page item
            $items[] = [
                'text' => WC()->query->get_endpoint_title($endpoint),
                'url' => null,
            ];

            break;
        }
    }
}

// Document Library Pro
$document_page_id = (int) get_option('dlp_document_page');
$document_search_page_id = (int) get_option('dlp_search_page');

if (
    $document_page_id &&
    (
        is_singular('dlp_document') ||
        is_tax('doc_categories') ||
        is_tax('doc_tags') ||
        ($document_search_page_id && is_page($document_search_page_id))
    )
) {
    $document_items = [
        [
            'text' => get_the_title($document_page_id),
            'url' => get_permalink($document_page_id),
        ],
    ];

    $document_page_parent_id = get_post_parent($document_page_id);

    while ($document_page_parent_id) {
        $document_items[] = [
            'text' => get_the_title($document_page_parent_id),
            'url' => get_permalink($document_page_parent_id),
        ];

        $document_page_parent_id = get_post_parent($document_page_parent_id);
    }

    $document_items = array_reverse($document_items);

    $offset = 1;
    $length = 1;

    if (is_tax() || is_page()) {
        $length = 0;
    }

    array_splice($items, $offset, $length, $document_items);
}


// Convert items to HTML Links
$links = [];

foreach ($items as $item) {
    $text = $item['text'] ?? null;
    $url = $item['url'] ?? null;

    if (!$text) {
        continue;
    }

    if (!$url) {
        $links[] = '<span class="breadcrumb-nav__text">' . esc_html($text) . '</span>';
        continue;
    }

    $links[] = '<a href="' . esc_url($url) . '" class="breadcrumb-nav__link">' . esc_html($text) . '</a>';
}

if (!$links) {
    return;
}

?>

<div class="breadcrumb-nav">
    <div class="breadcrumb-nav__wrap">
        <?= implode(' <span class="breadcrumb-nav__sep" aria-hidden="true">//</span> ', $links) ?>
    </div>
</div>

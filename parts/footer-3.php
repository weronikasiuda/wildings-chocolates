<?php

// Links
$nav_items = [];
$nav_links = [];
$locations = get_nav_menu_locations();
$id = $locations['footer-links'] ?? null;

if ($id) {
    $nav_items = (array) wp_get_nav_menu_items($id);

    $nav_items = array_filter($nav_items, function ($item) {
        return ((int) $item->menu_item_parent) === 0;
    });

    foreach ($nav_items as $item) {
        $nav_links[] = '<a href="' . esc_url($item->url) . '" class="footer-3__nav-link">' . esc_html($item->title) . '</a>';
    }
}

// Legal information
$copyright_name = get_field('copyright_name', 'options');
$copyright_text = get_field('copyright_text', 'options');

if (!$copyright_name) {
    $copyright_name = get_bloginfo('name');
}

$copyright = trim('Copyright &copy; ' . date('Y') . ' ' . $copyright_name . '. All rights reserved. ' . $copyright_text);

?>

<div class="footer-3">
    <div class="footer-3__wrap">
        <?php

        if ($nav_items) {
            ?>
            <div class="footer-3__nav">
                <?= implode(' <span class="footer-3__nav-sep">|</span> ', $nav_links) ?>
            </div>
            <?php
        }

        if ($copyright) {
            ?>
            <div class="footer-3__copyright">
                <div class="text-content">
                    <p><?= esc_html($copyright) ?></p>
                </div>
            </div>
            <?php
        }

        ?>
    </div>
</div>

<?php
$nav_items = [];
$locations = get_nav_menu_locations();
$id = $locations['main-nav'] ?? null;
if ($id) {
    // Get all menu items without filtering
    $all_nav_items = (array) wp_get_nav_menu_items($id);
    
    // Get parent menu items
    $parent_nav_items = array_filter($all_nav_items, function ($item) {
        return ((int) $item->menu_item_parent) === 0;
    });
    
    // Create a function to get child items
    function get_child_menu_items($parent_id, $all_nav_items) {
        return array_filter($all_nav_items, function($item) use ($parent_id) {
            return ((int) $item->menu_item_parent) === $parent_id;
        });
    }
}
?>
<div class="footer-2">
<div class="footer-2__wrap">
<div class="footer-2__row">
    <div class="footer-2__logo-column">
        <h2 class="footer-2__logo-heading">
            <a href="<?= esc_url(home_url('/')) ?>" class="footer-2__logo-link">
                <img src="<?= esc_url(THEME_URL . '/images/' . LOGO) ?>" alt="<?= esc_attr(get_bloginfo('name')) ?>" class="footer-2__logo-image">
            </a>
        </h2>
    </div>
    <div class="footer-2__nav-column">
        <?php if ($parent_nav_items) { ?>
        <ul class="footer-2__nav-list">
            <?php foreach ($parent_nav_items as $parent_item) { 
                $child_items = get_child_menu_items($parent_item->ID, $all_nav_items);
                $has_children = !empty($child_items);
            ?>
            <li class="footer-2__nav-item <?= $has_children ? 'has-children' : '' ?>">
                <a href="<?= esc_url($parent_item->url) ?>" class="footer-2__nav-link"><?= esc_html($parent_item->title) ?></a>
                
                <?php if ($has_children) { ?>
                <ul class="footer-2__subnav-list">
                    <?php foreach ($child_items as $child_item) { ?>
                    <li class="footer-2__subnav-item">
                        <a href="<?= esc_url($child_item->url) ?>" class="footer-2__subnav-link"><?= esc_html($child_item->title) ?></a>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
                
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>
</div>
</div>
</div>
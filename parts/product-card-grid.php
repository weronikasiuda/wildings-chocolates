<?php
/**
 * Reusable Grid Template
 */

// Get required arguments
$section_title = $args['section_title'] ?? '';
$items = $args['items'] ?? [];
$layout = $args['layout']  ?? '';


// Exit if no items
if (empty($items)) {
    return;
}
?>
<div class="card-grid">
    <div class="card-grid__wrap">
        <?php if ($section_title) : ?>
        <div class="card-grid__section-title-wrap">
            <h2 class="card-grid__section-title"><?php echo esc_html($section_title); ?></h2>
        </div>
        <?php endif; ?>
        <div class="card-grid__row">
            <?php foreach ($items as $item) : ?>
            <div class="card-grid__column">
                <div class="card-grid__card">
                    <?php if (!empty($item['image_src'])) : ?>
                    <img class="card-grid__card-image"
                         src="<?php echo esc_url($item['image_src']); ?>"
                         alt="<?php echo esc_attr($item['image_alt'] ?? $item['title']); ?>">
                    <?php endif; ?>
                    <div class="card-grid__card-text">
                        <h3 class="card-grid__card-title">
                            <?php echo esc_html($item['title']); ?>
                        </h3>
                        <div class="card-grid__card-price">
                            <?php if (!empty($item['sale_price'])) : ?>
                                <span class="card-grid__price-text card-grid__price-text--sale">£<?php echo esc_html($item['sale_price']); ?></span>
                                <span class="card-grid__price-text card-grid__price-text--regular"><s>£<?php echo esc_html($item['regular_price']); ?></s></span>
                            <?php else : ?>
                                <span class="card-grid__price-text">£<?php echo esc_html($item['regular_price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo esc_url($item['link_url']); ?>" class="card-grid__card-button">
                            <?php echo isset($item['button_text']) ? esc_html($item['button_text']) : 'Add to cart'; ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
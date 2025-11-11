<?php
/**
 * Reusable Product Slider
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

<!-- Swiper -->
<div class="card-grid">
    <div class="card-grid__wrap">
    <?php if ($section_title) : ?>
        <div class="card-grid__row">
            <div class="card-grid__heading-container card-grid__heading-container--with-slider-nav">
                <h2 class="card-grid__heading card-grid__heading--left-aligned"><?php echo esc_html($section_title); ?></h2>
            </div>
                <div class="card-grid__slider-nav">
                    <div class="card-grid__slider-nav-buttons">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
        </div>
        <?php endif; ?>
        <div class="card-grid__row">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                <?php foreach ($items as $item) : ?>
                            <div class="swiper-slide">
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
                                         <!-- CHECK: Only display the price container if a price exists -->
                                       <?php if (!empty($item['sale_price']) || !empty($item['regular_price'])) : 
                                        ?>
                                            <div class="card-grid__card-price">
                                                <?php if (!empty($item['sale_price'])) : ?>
                                                    <span class="card-grid__price-text card-grid__price-text--sale">£<?php echo esc_html($item['sale_price']); ?></span>
                                                    <span class="card-grid__price-text card-grid__price-text--regular"><s>£<?php echo esc_html($item['regular_price']); ?></s></span>
                                                <?php elseif (!empty($item['regular_price'])) : ?>
                                                    <span class="card-grid__price-text">£<?php echo esc_html($item['regular_price']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; // End price container check ?>
                                        <a href="<?php echo esc_url($item['link_url']); ?>" class="card-grid__card-button">
                                            <?php echo isset($item['button_text']) ? esc_html($item['button_text']) : 'View product'; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                </div>
            </div>
        </div>
   </div>
</div>

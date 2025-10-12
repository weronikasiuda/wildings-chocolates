<?php

// Component class and modifiers
$class = 'widget-box';
$classes = (array) $class;
$color = $args['color'] ?? null;

if ($color) {
    $classes[] = $class . '--' . str_replace('_', '-', $color);
}

// Link URL
$url = $args['url'] ?? null;

// Text content
$heading = $args['heading'] ?? null;
$excerpt = $args['excerpt'] ?? null;

// Image
$image_src = $args['image_src'] ?? null;
$image_alt = $args['image_alt'] ?? '';

// Button text
$button_text = $args['button_text'] ?? null;

if (!$button_text) {
    $button_text = __('Read more');
}

// Component output
$component_class = implode(' ', $classes);

if ($url) {
    echo '<a href="' . esc_url($url) . '" class="' . esc_attr($component_class) . '" aria-label="' . esc_attr($heading) . '">';
} else {
    echo '<div class="' . esc_attr($component_class) . '">';
}

if ($image_src) {
    ?>
    <div class="widget-box__image-section">
        <img src="<?= esc_url($image_src) ?>" alt="<?= esc_attr($image_alt) ?>" class="card-box__image" loading="lazy">
    </div>
    <?php
}

?>

<div class="widget-box__text-section">
    <div class="widget-box__main">
        <?php

        if ($heading) {
            ?>
            <h3 class="screen-reader-text"><?= esc_html($heading) ?></h3>
            <?php
        }

        if ($excerpt) {
            ?>
            <div class="widget-box__excerpt">
                <div class="text-content">
                    <?= wp_kses_post($excerpt) ?>
                </div>
            </div>
            <?php
        }

        ?>
    </div>

    <?php

    if ($url) {
        ?>
        <div class="widget-box__more">
            <span class="card-more">
                <span class="card-more__text"><?= esc_html($button_text) ?></span>
            </span>
        </div>
        <?php
    }

    ?>
</div>

<?php

if ($url) {
    echo '</a>';
} else {
    echo '</div>';
}

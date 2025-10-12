<?php

// Component class and modifiers
$class = 'card-box';
$classes = (array) $class;
$modifiers = (array) ($args['modifiers'] ?? []);

foreach ($modifiers as $modifier) {
    $classes[] = "$class--$modifier";
}

//Featured image
$image_src = $args['image_src'] ?? null; // Changed to 'image_src'
$image_alt = $args['image_alt'] ?? ''; // Added to get the alt text

// Link URL
$url = $args['url'] ?? null;

// Text content
$meta = $args['meta'] ?? null;
$heading = $args['heading'] ?? null;
$excerpt = $args['excerpt'] ?? null;

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

?>
<div class="card-box__image-section">
    <img class="card-box__image" src="<?= esc_url($image_src) ?>" alt="<?= esc_attr($image_alt) ?>">
</div>
<div class="card-box__text-section">
    <div class="card-box__main">
        <?php

        if ($meta) {
            ?>
            <div class="card-box__meta"><?= esc_html($meta) ?></div>
            <?php
        }

        if ($heading) {
            ?>
            <h3 class="card-heading"><?= esc_html($heading) ?></h3>
            <?php
        }

        if ($excerpt) {
            ?>
            <div class="card-box__excerpt">
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
        <div class="card-box__more">
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
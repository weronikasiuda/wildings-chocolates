<?php

// Profile with Bootstrap 5 collapse effect (initialized with JavaScript)

$heading = $args['heading'] ?? null;
$excerpt = $args['excerpt'] ?? null;
$content = $args['content'] ?? null;

$image_src = $args['image']['sizes']['medium'] ?? null;
$image_alt = $args['image']['alt'] ?? '';

if (!$image_src) {
    $image_src = path_join(THEME_URL, 'images/default/medium.webp');
}

$show_text = __('Show details');
$hide_text = __('Hide details');

?>

<div class="section section--flex">
    <div class="profile" data-show-text="<?= esc_attr($show_text) ?>" data-hide-text="<?= esc_attr($hide_text) ?>">
        <div class="profile__image-section">
            <img src="<?= esc_url($image_src) ?>" alt="<?= esc_attr($image_alt) ?>" class="profile__image" loading="lazy">
        </div>

        <div class="profile__text-section">
            <?php

            if ($heading) {
                ?>
                <h2 class="profile__heading">
                    <?= esc_html($heading) ?>
                </h2>
                <?php
            }

            if ($excerpt) {
                ?>
                <div class="profile__excerpt">
                    <div class="text-content">
                        <?= wpautop(esc_html(strip_tags($excerpt))) ?>
                    </div>
                </div>
                <?php
            }

            if ($content) {
                ?>
                <div class="profile__content">
                    <div class="text-content">
                        <?= wp_kses_post($content) ?>
                    </div>
                </div>
                <?php
            }

            ?>
        </div>
    </div>
</div>

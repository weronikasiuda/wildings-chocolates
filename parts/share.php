<?php

use Cgit\Socialize;

use function WS\WS\getSanitizedSvgIcon;

if (!class_exists('\Cgit\Socialize')) {
    return;
}

$heading = $args['heading'] ?? null;
$socialize = new Socialize();

$items = $socialize->getNetworks([
    'linkedin',
    'facebook',
    'twitter',
    'whatsapp',
    'email',
]);

if (!$heading) {
    $heading = 'Share';
}

$class = 'share';
$classes = (array) $class;
$modifiers = array_filter((array) ($args['modifiers'] ?? null));

foreach ($modifiers as $modifier) {
    $classes[] = "$class--$modifier";
}

?>

<div class="<?= implode(' ', $classes) ?>">
    <h3 class="share__heading"><?= esc_html($heading) ?></h3>

    <ul class="share__list">
        <?php

        foreach ($items as $key => $item) {
            ?>

            <li class="share__item">
                <a href="<?= esc_url($item['url']) ?>" class="<?= esc_attr("share__link share__link--$key") ?>">
                    <span aria-hidden="true"><?= getSanitizedSvgIcon("$key.svg") ?></span>
                    <span class="screen-reader-text"><?= $item['name'] ?></span>
                </a>
            </li>

            <?php
        }

        ?>
    </ul>
</div>

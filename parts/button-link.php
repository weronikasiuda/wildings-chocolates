<?php

use function WS\WS\getSanitizedSvgIcon;

$title = $args['title'] ?? null;
$url = $args['url'] ?? null;

if (!$title || !$url) {
    return;
}

$target = $args['target'] ?? null;
$icon = $args['icon'] ?? null;
$style = $args['style'] ?? null;
$reversed = $args['reversed'] ?? null;

$sanitized_icon_svg = null;
$sanitized_icon_html = '';
$sanitized_target_attribute = '';

if ($icon) {
    $sanitized_icon_svg = getSanitizedSvgIcon($icon);

    if ($sanitized_icon_svg) {
        $sanitized_icon_html = '<span class="btn-icon" aria-hidden="true">' . $sanitized_icon_svg . '</span>';
    }
}

if ($target) {
    $sanitized_target_attribute = 'target="' . esc_attr($target) . '"';
}

$classes = ['button-grid__item-link btn'];

switch ($style) {
    case 'primary':
        $classes[] = 'btn-primary';
        break;

    case 'secondary':
        $classes[] = 'btn-secondary';
        break;

    case 'outline':
        $classes[] = 'btn-outline-primary';
        break;

    default:
        $classes[] = 'btn-primary';
        break;
}

?>

<a href="<?= esc_url($url) ?>" class="<?= implode(' ', $classes) ?>" <?= $sanitized_target_attribute ?>>
    <?php

    if ($reversed) {
        echo $sanitized_icon_html;
    }

    echo '<span>' . esc_html($title) . '</span>';

    if (!$reversed) {
        echo $sanitized_icon_html;
    }

    ?>
</a>

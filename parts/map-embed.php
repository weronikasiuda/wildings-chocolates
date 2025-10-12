<?php

use function WS\WS\getMapTileUrl;

$lat = $args['lat'] ?? null;
$lng = $args['lng'] ?? null;

if (is_null($lat) || is_null($lng)) {
    return;
}

$title = $args['title'] ?? null;
$icon = $args['icon'] ?? null;
$zoom = $args['zoom'] ?? null;

if (!$icon) {
    $icon = THEME_URL . '/images/map-marker.svg';
}

$class = 'map-embed';
$classes = (array) $class;
$modifiers = (array) ($args['modifiers'] ?? []);

foreach ($modifiers as $modifier) {
    $classes[] = "$class--$modifier";
}

?>

<div class="<?= esc_attr(implode(' ', $classes)) ?>" data-lat="<?= esc_attr($lat) ?>" data-lng="<?= esc_attr($lng) ?>" data-title="<?= esc_attr($title) ?>" data-icon="<?= esc_attr($icon) ?>" data-zoom="<?= esc_attr($zoom) ?>" data-tile-url="<?= esc_attr(getMapTileUrl()) ?>">
    <div class="map-embed__fallback">
        <a href="<?= esc_url("https://maps.google.com/?ll=$lat,$lng&z=$zoom") ?>" class="btn btn-outline-secondary btn-sm">View on Google Maps</a>
    </div>
</div>

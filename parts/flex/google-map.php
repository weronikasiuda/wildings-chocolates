<?php

$lat = $args['google_map']['lat'] ?? null;
$lng = $args['google_map']['lng'] ?? null;

if (is_null($lat) || is_null($lng)) {
    return;
}

$name = $args['google_map']['name'] ?? null;
$zoom = $args['google_map']['zoom'] ?? null;

ob_start();
get_template_part('parts/map-embed', null, $args['google_map'] ?? null);

$embed = ob_get_clean();

if (!$embed) {
    return;
}

?>

<div class="section section--flex">
    <?= $embed ?>
</div>

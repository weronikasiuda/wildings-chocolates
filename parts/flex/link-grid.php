<?php

$items = (array) ($args['links'] ?? []);
$links = [];

foreach ($items as $item) {
    $title = $item['link']['title'] ?? null;
    $url = $item['link']['url'] ?? null;

    if (!$url || !$title) {
        continue;
    }

    $target = $item['link']['target'] ?? null;
    $icon = $item['icon'] ?? null;
    $style = $item['style'] ?? null;

    $links[] = compact('title', 'url', 'target', 'icon', 'style');
}

if (!$links) {
    return;
}

?>

<div class="section section--flex">
    <div class="link-grid">
        <div class="link-grid__wrap">
            <div class="link-grid__row">
                <div class="link__column">
                    <?php get_template_part('parts/button-link-grid', null, compact('links')) ?>
                </div>
            </div>
        </div>
    </div>
</div>

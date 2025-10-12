<?php

$items = get_field('list_links');

if (!is_array($items)) {
    return;
}

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

<div class="section">
    <?php get_template_part('parts/button-link-grid', null, compact('links')) ?>
</div>

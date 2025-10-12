<?php

$post_type = $args['post_type'] ?? null;

if (!$post_type || !post_type_exists($post_type)) {
    return;
}

$content = get_field($post_type . '_archive_content', 'options');
$items = get_field($post_type . '_archive_links', 'options');

$links = [];

if (is_array($items) && $items) {
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
}

if (!$content && !$links) {
    return;
}

?>

<div class="section">
    <?php

    if ($content) {
        ?>
        <div class="subsection">
            <div class="text-content">
                <?= wp_kses_post($content) ?>
            </div>
        </div>
        <?php
    }

    if ($links) {
        ?>
        <div class="subsection">
            <?php get_template_part('parts/button-link-grid', null, compact('links')) ?>
        </div>
        <?php
    }

    ?>
</div>

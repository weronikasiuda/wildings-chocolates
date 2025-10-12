<?php

$links = (array) ($args['links'] ?? []);

$links = array_filter($links, function ($link) {
    $url = $link['url'] ?? null;
    $title = $link['title'] ?? null;

    return $url && $title;
});

if (!$links) {
    return;
}

?>

<div class="button-grid">
    <?php

    foreach ($links as $link) {
        ?>
        <span class="button-grid__item">
            <?php get_template_part('parts/button-link', null, $link) ?>
        </span>
        <?php
    }

    ?>
</div>

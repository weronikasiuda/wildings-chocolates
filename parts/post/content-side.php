<?php

if (!(is_home() || is_singular('post') || is_category() || is_tag() || is_date() || is_author())) {
    return;
}

ob_start();

get_template_part('parts/side/categories');
get_template_part('parts/side/archives');

$content = trim(ob_get_clean());

if (!$content) {
    return;
}

?>

<div class="content__side">
    <?= $content ?>
</div>

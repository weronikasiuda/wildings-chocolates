<?php

if (!is_page()) {
    return;
}

ob_start();

get_template_part('parts/side/subnav');
get_template_part('parts/side/widgets');

$content = trim(ob_get_clean());

if (!$content) {
    return;
}

?>

<div class="content__side">
    <?= $content ?>
</div>

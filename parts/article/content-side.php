<?php

ob_start();

get_template_part('parts/side/subnav');

$content = trim(ob_get_clean());

if (!$content) {
    return;
}

?>

<div class="content__side">
    <?= $content ?>
</div>

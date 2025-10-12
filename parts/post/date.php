<?php

if (!is_singular('post')) {
    return;
}

?>

<div class="post-date">
    <?php the_date() ?>
</div>

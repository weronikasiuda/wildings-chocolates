<?php

if (!have_posts()) {
    return get_template_part('parts/article/archive/none');
}

?>

<div class="post-grid">
    <?php

    while (have_posts()) {
        the_post();

        ?>
        <div class="post-grid__item">
            <?php

            get_template_part('parts/post-card');

            ?>
        </div>
        <?php
    }

    ?>
</div>

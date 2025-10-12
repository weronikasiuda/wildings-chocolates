<?php

if (!have_posts()) {
    return get_template_part('parts/post/archive/none');
}

?>

<div class="post-grid">
    <div class="post-grid__wrap">
        <div class="post-grid__row">
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
        </div>
</div>

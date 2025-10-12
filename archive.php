<?php

get_header();
get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

?>

<div class="content">
    <div class="content__wrap">
        <div class="content__row">
            <div class="content__main">

                <div class="section">
                    <?php get_template_part('parts/post/archive/loop') ?>
                </div>

                <?php get_template_part('parts/pagination') ?>
            </div>

            <?php get_template_part('parts/post/content-side') ?>
        </div>
    </div>
</div>

<?php

get_footer();

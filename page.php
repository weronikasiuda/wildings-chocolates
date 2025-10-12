<?php

get_header();

the_post();

get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

?>

<div class="content">
    <div class="content__wrap">
        <div class="content__grid">
            <div class="content__main">
                <?php get_template_part('parts/page/content-main-section') ?>
            </div>

            <?php get_template_part('parts/page/content-side') ?>
        </div>
    </div>
</div>

<?php

get_footer();

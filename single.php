<?php

get_header();

the_post();

get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

?>

<div class="content">
    <div class="content__wrap">
        <div class="content__row">
            <div class="content__main">

            <div class="section">
                <?php get_template_part('parts/back-to-blog-button'); ?>
            </div>
                
                <div class="section">
                    <?php get_template_part('parts/post/date') ?>
                </div>

                <div class="section">
                    <h1 class="post-title"><?= esc_html(get_the_title()) ?></h1>
                </div>

                <?php
                get_template_part('parts/flex-sections');
                ?>

                <div class="section">
                    <?php get_template_part('parts/post/meta') ?>
                </div>
                
            </div> <?php get_template_part('parts/post/content-side') ?>
            
        </div> </div> </div> <?php

get_footer();
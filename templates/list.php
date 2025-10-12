<?php

/** Template Name: List Page */

get_header();

the_post();

get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

ob_start();

get_template_part('parts/page/content-main-section');
get_template_part('parts/list-links-section');

$main = ob_get_clean();



if ($main) {
    ?>

    <div class="content">
        <div class="content__wrap">
            <div class="content__row">
                <div class="content__main">
                    <?= $main ?>
                </div>
            </div>
        </div>
    </div>

    <?php
}

get_template_part('parts/page-list-wide');
get_footer();

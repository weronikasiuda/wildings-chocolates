<?php

/** Template Name: Flexible Content Page */

get_header();

the_post();

get_template_part('parts/flex/inner-banner');
// get_template_part('parts/breadcrumb-nav');

?>

<div class="content">
    <div class="content__wrap">
        <div class="content__row">

            <!-- <?php get_template_part('parts/page/content-side'); ?> -->
            
            <div class="content__main content__main--full">
                <?php

                get_template_part('parts/flex-content');
                get_template_part('parts/flex-sections');

                ?>
            </div>
        </div>
    </div>
</div>

<?php

get_footer();

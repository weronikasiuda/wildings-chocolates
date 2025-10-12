<?php

get_header();
get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

$type = get_post_type_object('post');
$title = $type->label;

if (get_option('show_on_front') === 'page') {
    $title = get_the_title(get_option('page_for_posts'));
}

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

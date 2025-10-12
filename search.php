<?php

get_header();
get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

?>

<div class="content">
    <div class="content__wrap">
        <div class="content__grid">
            <div class="content__main">
                <div class="section">
                    <h1 class="page-title"><?= esc_html(sprintf(__('Search: %s'), get_search_query())) ?></h1>
                </div>

                <div class="section">
                    <?php get_template_part('parts/search/loop') ?>
                </div>

                <?php get_template_part('parts/pagination') ?>
            </div>
        </div>
    </div>
</div>

<?php

get_footer();

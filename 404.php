<?php

get_header();
get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

?>

<div class="content">
    <div class="content__wrap">
        <div class="content__grid">
            <div class="content__main">
                <h1 class="content__title"><?= esc_html__('Page not found') ?></h1>

                <div class="text-content">
                    <p><?= esc_html__('The page you were looking for could not be found.') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

get_footer();

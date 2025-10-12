<?php

get_header();

the_post();

get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');

?>

<div class="content">
    <div class="content__wrap">
        <?php the_content() ?>
    </div>
</div>

<?php

get_footer();

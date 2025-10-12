<?php

if (!have_posts()) {
    return get_template_part('parts/search/none');
}

while (have_posts()) {
    the_post();

    ?>
    <div class="search-result">
        <h2>
            <a href="<?= esc_url(get_permalink()) ?>">
                <?= esc_html(get_the_title()) ?>
            </a>
        </h2>

        <div class="text-content">
            <?php the_excerpt() ?>
        </div>
    </div>
    <?php
}

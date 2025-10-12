<?php

$publication = get_queried_object();

// Find all editions
$editions = get_terms([
    'taxonomy' => 'article-edition',
    'orderby' => 'meta_value_num',
    'meta_key' => 'article_edition_date',
    'order' => 'DESC',
]);

// Remove editions with no articles in this publication
foreach ($editions as $key => $edition) {
    $articles = get_posts([
        'post_type' => 'article',
        'fields' => 'ids',
        'tax_query' => [
            'relation' => 'AND',
            [
                'taxonomy' => 'article-edition',
                'terms' => $edition->term_id,
            ],
            [
                'taxonomy' => 'article-publication',
                'terms' => $publication->term_id,
            ],
        ],
    ]);

    if (!$articles) {
        unset($editions[$key]);
    }
}

if (!$editions) {
    return;
}

$max_words = apply_filters('excerpt_length', 55);

?>

<div class="post-grid">
    <?php

    foreach ($editions as $edition) {
        ?>
        <div class="post-grid__item">
            <?php

            get_template_part('parts/card-box', null, [
                'heading' => $edition->name,
                'url' => get_term_link($edition),
                'excerpt' => wp_trim_words($edition->description, $max_words),
            ]);

            ?>
        </div>
        <?php
    }

    ?>
</div>

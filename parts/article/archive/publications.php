<?php

$taxonomy_args = [
    'taxonomy' => 'article-publication',
    'child_of' => 0,
    'parent' => 0,
    'orderby' => 'name',
    'order' => 'ASC',
];

$terms = get_categories($taxonomy_args);

if (!$terms) {
    return get_template_part('parts/article/archive/none');
}

?>

<div class="section">
    <div class="post-grid">
        <?php

        foreach ($terms as $term) {
            $excerpt = get_field('article_publication_excerpt', 'term_' . $term->term_id);

            if (!$excerpt) {
                $excerpt_length = (int) apply_filters('excerpt_length', 55);
                $excerpt_more = apply_filters('excerpt_more', ' [&hellip;]');

                $excerpt = trim(strip_tags($term->description));
                $excerpt = wp_trim_words($excerpt, $excerpt_length, $excerpt_more);
            }

            ?>

            <div class="post-grid__item">
                <a href="<?= esc_url(get_term_link($term)) ?>" class="card-box" aria-label="<?= esc_attr($term->name) ?>">
                    <div class="card-box__text-section">
                        <div class="card-box__main">
                            <h3 class="card-heading"><?= esc_html($term->name) ?></h3>

                            <div class="card-box__excerpt">
                                <div class="text-content">
                                    <p><?= esc_html($excerpt) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="card-box__more">
                            <span class="card-more">
                                <span class="card-more__text">View articles</span>
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <?php
        }

        ?>
    </div>
</div>

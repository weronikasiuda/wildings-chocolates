<?php

$items = [];

// Publication(s)
$terms = get_the_terms(get_the_ID(), 'article-publication');
$links = [];

if ($terms) {
    foreach ($terms as $term) {
        $links[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
    }
}

if ($links) {
    $items[] = implode(', ', $links);
}

// Edition(s)
$terms = get_the_terms(get_the_ID(), 'article-edition');
$links = [];

if ($terms) {
    foreach ($terms as $term) {
        $links[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
    }
}

if ($links) {
    $items[] = implode(', ', $links);
}

// Date
// ob_start();
// the_date();

// $date = ob_get_clean();

// if ($date) {
//     $items[] = esc_html($date);
// }

if (!$items) {
    return;
}

?>

<div class="post-date">
    <?= implode(THEME_TEXT_SEPARATOR, $items) ?>
</div>

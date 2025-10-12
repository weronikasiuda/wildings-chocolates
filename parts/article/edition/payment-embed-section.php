<?php

// Show content on first page only
if (is_paged()) {
    return;
}

$term = get_queried_object();
$code = get_field('article_edition_payment_embed', 'term_' . $term->term_id);

if (!$code) {
    return;
}

// Payment embed code is deliberately output without escaping

?>

<div class="section">
    <?= $code ?>
</div>

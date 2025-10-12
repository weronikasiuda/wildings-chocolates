<?php

// Show content on first page only
if (is_paged()) {
    return;
}

$term = get_queried_object();
$heading = $term->name;
$content = $term->description;

?>

<div class="section">
    <h1 class="page-title"><?= esc_html($heading) ?></h1>

    <?php

    if ($content) {
        ?>
        <div class="text-content">
            <?= wp_kses_post(wpautop($content)) ?>
        </div>
        <?php
    }

    ?>
</div>

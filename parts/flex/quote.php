<?php

$content = $args['quote_content'] ?? null;
$caption = $args['quote_caption'] ?? null;

$section_id = $args['section_id'] ?? null; // Section ID

if (!$content) {
    return;
}

// Prepare ID attribute
// NEW LOGIC: Conditionally set the ID attribute string
$id_attr = '';
if (!empty($section_id)) {
    $id_attr = ' id="' . esc_attr($section_id) . '"';
}

?>

<div class="section section--flex">
    <div class="quote"<?= $id_attr ?>>
        <div class="quote__wrap">
            <div class="quote__row">
                <div class="quote__column">
                    <figure>
                        <blockquote class="blockquote">
                            <?= wp_kses_post(wpautop($content)) ?>
                        </blockquote>

                        <figcaption class="blockquote-footer"><?= nl2br(esc_html($caption)) ?></figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>
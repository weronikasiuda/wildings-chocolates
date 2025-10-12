<?php

$content = $args['quote_content'] ?? null;
$caption = $args['quote_caption'] ?? null;

if (!$content) {
    return;
}

?>

<div class="section section--flex">
    <div class="quote">
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

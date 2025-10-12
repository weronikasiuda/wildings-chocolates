<?php

$image_src = $args['image']['sizes']['large'] ?? null;
$image_alt = $args['image']['alt'] ?? null;
$caption = $args['caption'] ?? null;

if (!$image_src) {
    return;
}

?>

<div class="section section--flex">
    <div class="image">
        <div class="image__wrap">
            <div class="image__row">
                <div class="image__column">
                    <div class="figure">
                        <img src="<?= esc_url($image_src) ?>" alt="<?= esc_attr($image_alt) ?>" class="figure__image" loading="lazy">

                            <?php

                            if ($caption) {
                            ?>
                            <div class="figure__caption">
                                <?= esc_html($caption) ?>
                            </div>
                            <?php
                            }

                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$images = $args['images'] ?? null;

if (!$images) {
    return;
}

?>

<div class="section section--flex">
    <div class="image-grid">
        <div class="image-grid__wrap">
            <div class="image-grid__row">

          
                <?php

                foreach ($images as $image) {
                    $url = $image['sizes']['large'];
                    $src = $image['sizes']['large'];
                    $alt = $image['alt'];
                    $title = $image['title'];

                    ?>
                    <div class="image-grid__item">
                        <a href="<?= esc_url($url) ?>" class="image-grid__link" title="<?= esc_attr($title) ?>">
                            <img src="<?= esc_url($src) ?>" alt="<?= esc_attr($alt) ?>" class="image-grid__image">
                        </a>
                    </div>
                    <?php
                }

                ?>
            </div>
        </div>
     </div>
</div>

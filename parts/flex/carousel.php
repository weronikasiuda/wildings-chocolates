<?php

// Bootstrap 5 carousel (initialized with JavaScript)

$images = (array) ($args['images'] ?? []);
$items = [];

foreach ($images as $image) {
    $url = $image['url'] ?? null;
    $src = $image['sizes']['xxxl'] ?? null;
    $alt = $image['alt'] ?? null;
    $title = $image['title'] ?? null;


    if (!$url || !$src) {
        continue;
    }

    $items[] = compact('url', 'alt', 'src', 'title');
}

if (!$items) {
    return;
}

?>

<div class="section section--flex">
    <div class="carousel-section">
        <div class="carousel-section__wrap">
            <div class="carousel-section__row">
                <div class="carousel-section__column">
                    <div class="carousel">
                        <div class="carousel-inner">
                            <?php

                            $count = 0;

                            foreach ($items as $key => $item) {
                                $classes = [
                                    'carousel-item',
                                ];

                                if ($count === 0) {
                                    $classes[] = 'active';
                                }

                                ?>
                                <div class="<?= esc_attr(implode(' ', $classes)) ?>">
                                    <a href="<?= esc_url($item['url']) ?>">
                                        <img src="<?= esc_url($item['url']) ?>" alt="<?= esc_attr($item['alt']) ?>" class="carousel-image" loading="lazy">
                                    </a>
                                </div>
                                <?php

                                $count++;
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

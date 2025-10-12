<?php

$image = get_field('home_banner_image');
$image_src = $image['sizes']['xxxl'] ?? null;
// $image_src = $image['url'] ?? null;
$image_alt = $image['alt'] ?? null;

$heading = get_field('home_banner_heading');
$subheading = get_field('home_banner_subheading');
$content = get_field('home_banner_content');
$link_items = get_field('home_banner_links');
$links = [];

// if (is_array($links)) {
//     $links = array_column($links, 'link');
// }
// Assemble list of valid links with URLs and titles.
if($link_items) {
    foreach ($link_items as $item) {
        $title = $item['link']['title'] ?? null;
        $url = $item['link']['url'] ?? null;
        if (!$url || !$title) {
            continue;
        }
        $target = $item['link']['target'] ?? null;
        $style = $item['style'] ?? null;
        $links[] = compact('title', 'url', 'target', 'style');
    }
}

if (!$image && !$heading && !$subheading && !$content && !$links) {
    return;
}

?>

<div class="home-banner">
  <div class="home-banner__container">
        <picture>
          <!-- XXL screen image -->
          <source srcset="<?= $image['url'] ?>" media="(min-width: 1441px)">
        <!-- XL screen image -->
        <source srcset="<?= $image['sizes']['xxl'] ?>" media="(max-width: 1440px)">
          <!-- LG screen image -->
        <source srcset="<?= $image['sizes']['xxl'] ?>" media="(max-width: 1200px)">
        <!-- MED screen image -->
        <source srcset="<?= $image['sizes']['medium'] ?>" media="(max-width: 1024px)">
          <!-- Small screen image (for mobile devices) -->
          <img src="<?= $image['sizes']['medium'] ?>" alt="<?= $image['alt'] ?>" class="home-banner__image">
        </picture>

        <div class="home-banner__text-section" data-aos="fade-up" data-aos-duration="1000">
        <?php
                    if ($heading) {
                        ?>
                        <h1 class="home-banner__heading" data-aos="fade-up" data-aos-duration="1000"><?= esc_html($heading) ?></h1>
                        <?php
                    }
                    if ($subheading) {
                        ?>
                        <h2 class="home-banner__subheading" data-aos="fade-up" data-aos-duration="1000"><?= esc_html($subheading) ?></h2>
                        <?php
                    }
                    if ($content) {
                        ?>
                        <h3 class="home-banner__content" data-aos="fade-up" data-aos-duration="1000"><?= esc_html($content) ?></h3>
                        <?php
                    }
                    
                     if ($links) {
                        ?>
                        <div class="home-banner__more" data-aos="fade-up" data-aos-duration="1000">
                            <?php get_template_part('parts/button-link-grid', null, compact('links')); ?>
                        </div>
                        <?php
                    }

                    ?>
        </div>
  </div>
</div>
<?php

use function WS\WS\getSanitizedSvgIcon;
use function Castlegate\ErsatzFunctions\url;

$heading = $args['heading'] ?? null;
$text = $args['text'] ?? null;
$type = $args['type'] ?? null;

$link_url = null;
$link_title = null;
$icon = null;

$class = 'resource';
$classes = (array) $class;

$meta = [];

switch ($type) {
    case 'file':
        $link_url = $args['file']['url'] ?? null;
        $link_title = $args['file']['title'] ?? null;
        $icon = 'download.svg';
        $classes[] = "$class--file";

        if (!$link_title) {
            $link_title = $args['file']['filename'] ?? null;
        }

        // Add file extension to meta
        $name = $args['file']['filename'] ?? null;

        if ($name) {
            $extension = pathinfo($name, PATHINFO_EXTENSION);

            if ($extension) {
                $meta[] = sprintf(__('File type: %s'), strtoupper($extension));
            }
        }

        // Add file size to meta
        $size = $args['file']['filesize'] ?? null;

        if ($size) {
            $bytes = (int) $size;
            $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

            for ($i = 0; $bytes > 1024; $i++) {
                $bytes /= 1024;
            }

            $meta[] = sprintf(__('File size: %s'), round($bytes, 2) . ' ' . $units[$i]);
        }

        break;

    case 'link':
        $link_url = $args['link']['url'] ?? null;
        $link_title = $args['link']['title'] ?? null;
        $icon = 'open-in-new.svg';
        $classes[] = "$class--link";

        if (is_string($link_url)) {
            $meta[] = 'URL: ' . url($link_url, true);
        }

        if (!$link_title && $link_url) {
            $link_title = url($link_url, true);
        }

        break;
}

if (!$link_url || !$link_title) {
    return;
}

if (!$heading) {
    $heading = $link_title;
}

// SVG icon (escaped)
$sanitized_icon_svg = null;

if ($icon) {
    $sanitized_icon_svg = getSanitizedSvgIcon($icon);
}

?>

<div class="section section--flex">
    <a href="<?= esc_url($link_url) ?>" class="<?= implode(' ', $classes) ?>" aria-label="<?= esc_attr($heading) ?>">
        <h3 class="card-heading"><?= esc_html($heading) ?></h3>

        <div class="resource__excerpt">
            <div class="text-content">
                <?= wpautop(esc_html(strip_tags($text))) ?>
            </div>
        </div>

        <?php

        if ($meta) {
            ?>
            <div class="resource__meta">
                <?php

                foreach ($meta as $meta_item) {
                    ?>
                    <div class="resource__meta-item">
                        <?= esc_html($meta_item) ?>
                    </div>
                    <?php
                }

                ?>
            </div>
            <?php
        }

        ?>

        <div class="resource__more">
            <span class="card-more">
                <?php

                if ($sanitized_icon_svg) {
                    ?>
                    <span class="card-more__icon" aria-hidden="true"><?= $sanitized_icon_svg ?></span>
                    <?php
                }

                ?>
                <span class="card-more__file-name">
                    <?= esc_html($link_title) ?>
                </span>
            </span>
        </div>
    </a>
</div>

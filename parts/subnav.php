<?php

$heading = $args['heading'] ?? null;
$items = $args['items'] ?? null;
$modifiers = (array) ($args['modifiers'] ?? []);

if (!is_array($items) || !$items) {
    return;
}

$class = 'subnav';
$classes = (array) $class;

foreach ($modifiers as $modifier) {
    $classes[] = "$class--$modifier";
}

?>

<div class="<?= esc_attr(implode(' ', $classes)) ?>">
    <?php

    if ($heading) {
        ?>
        <h3 class="subnav__heading"><?= esc_html($heading) ?></h3>
        <?php
    }

    ?>

    <ul class="subnav__list">
        <?php

        foreach ($items as $item) {
            $title = $item['title'] ?? null;
            $url = $item['url'] ?? null;
            $active = $item['active'] ?? false;
            $sub_items = $item['sub_items'] ?? [];

            $item_class = 'subnav__item';
            $item_classes = (array) $item_class;

            if ($active) {
                $item_classes[] = "$item_class--active";
            }

            ?>

            <li class="<?= esc_attr(implode(' ', $item_classes)) ?>">
                <a href="<?= esc_url($url) ?>" class="subnav__link">
                    <?= esc_html($title) ?>
                </a>
                <?php

                if ($sub_items) {
                    ?>
                    <ul class="subnav__sub-list">
                        <?php

                        foreach ($sub_items as $sub_item) {
                            $sub_title = $sub_item['title'] ?? null;
                            $sub_url = $sub_item['url'] ?? null;
                            $sub_active = $sub_item['active'] ?? false;
                            $sub_sub_items = $sub_item['sub_sub_items'] ?? [];

                            $sub_item_class = 'subnav__sub-item';
                            $sub_item_classes = (array) $sub_item_class;

                            if ($sub_active) {
                                $sub_item_classes[] = "$sub_item_class--active";
                            }

                            ?>
                            <li class="<?= esc_attr(implode(' ', $sub_item_classes)) ?>">
                                <a href="<?= esc_url($sub_url) ?>" class="subnav__sub-link">
                                    <?= esc_html($sub_title) ?>
                                </a>
                                <?php

                                if ($sub_sub_items) {
                                    ?>
                                    <ul class="subnav__sub-sub-list">
                                        <?php

                                        foreach ($sub_sub_items as $sub_sub_item) {
                                            $sub_sub_title = $sub_sub_item['title'] ?? null;
                                            $sub_sub_url = $sub_sub_item['url'] ?? null;
                                            $sub_sub_active = $sub_sub_item['active'] ?? false;

                                            $sub_sub_item_class = 'subnav__sub-sub-item';
                                            $sub_sub_item_classes = (array) $sub_sub_item_class;

                                            if ($sub_sub_active) {
                                                $sub_sub_item_classes[] = "$sub_sub_item_class--active";
                                            }

                                            ?>
                                            <li class="<?= esc_attr(implode(' ', $sub_sub_item_classes)) ?>">
                                                <a href="<?= esc_url($sub_sub_url) ?>" class="subnav__sub-sub-link">
                                                    <?= esc_html($sub_sub_title) ?>
                                                </a>
                                            </li>
                                            <?php
                                        }

                                        ?>
                                    </ul>
                                    <?php
                                }

                                ?>
                            </li>
                            <?php
                        }

                        ?>
                    </ul>
                    <?php
                }

                ?>
            </li>

            <?php
        }

        ?>
    </ul>
</div>

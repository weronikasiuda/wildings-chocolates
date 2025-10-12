<?php

// Bootstrap 5 accordion (initialized with JavaScript)

$items = (array) ($args['accordion_items'] ?? []);

// Remove invalid items from list of accordion sections.
foreach ($items as $key => $item) {
    $heading = $item['heading'] ?? null;
    $content = $item['content'] ?? null;

    if (!$heading || !$content) {
        unset($items[$key]);
    }
}

if (!$items) {
    return;
}

?>

<div class="section section--flex">
    <div class="accordion">
        <div class="accordion__wrap">
            <div class="accordion__grid">
                <div class="accordion__column">
                    <div class="accordion__element">
                        <?php

                        foreach ($items as $item) {
                            $heading = $item['heading'] ?? null;
                            $content = $item['content'] ?? null;

                            $link_items = (array) ($item['links'] ?? []);
                            $links = [];

                            // Assemble list of valid links with URLs and titles.
                            foreach ($link_items as $item) {
                                $title = $item['link']['title'] ?? null;
                                $url = $item['link']['url'] ?? null;

                                if (!$url || !$title) {
                                    continue;
                                }

                                $target = $item['link']['target'] ?? null;
                                $icon = $item['icon'] ?? null;
                                $style = $item['style'] ?? null;

                                $links[] = compact('title', 'url', 'target', 'icon', 'style');
                            }

                            ?>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button type="button" class="accordion-button">
                                        <?= esc_html($heading) ?>
                                    </button>
                                </h3>

                                <div class="accordion-collapse">
                                    <div class="accordion-body">
                                        <div class="text-content">
                                            <?= wp_kses_post($content) ?>
                                        </div>

                                        <?php

                                        if ($links) {
                                            ?>
                                            <div class="mt-3">
                                                <?php get_template_part('parts/button-link-grid', null, compact('links')) ?>
                                            </div>
                                            <?php
                                        }

                                        ?>
                                    </div>

                                </div>
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

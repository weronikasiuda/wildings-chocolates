<?php

$full_size = $args['full_size'] ?? null;
$heading = $args['heading'] ?? null;
$content = $args['content'] ?? null;

if (!$heading && !$content) {
    return;
}

// 1. Calculate the modifier class
$modifier = '';
if ($full_size) { // Checks if $full_size is set to 1 (true)
    $modifier = ' --full-size';
} else {
    $modifier = ' --half-size';
}

?>

<div class="section section--flex">
    <div class="text-banner__wrap">
        <div class="text-banner__grid">
            
            <div class="text-banner__column text-banner__column<?= esc_attr($modifier) ?>">
                <div class="text-content">
                    <?php

                    if ($heading) {
                        ?>
                        <h2><?= esc_html($heading) ?></h2>
                        <?php
                    }

                    echo $content;

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
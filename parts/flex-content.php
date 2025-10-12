<?php

$show_heading = true;
$show_content = true;

if (function_exists('get_field')) {
    $show_heading = get_field('show_heading') !== false;
    $show_content = get_field('show_content') !== false;
}

if (!$show_heading && !$show_content) {
    return;
}

?>
<div class="section">
    <div class="intro">
        <div class="intro__wrap">
            <div class="intro__row">
                <div class="intro__column">
                    <?php

                    if ($show_heading) {
                        ?>
                        <h1 class="page-title"><?= esc_html(get_the_title()) ?></h1>
                        <?php
                    }

                    if ($show_content) {
                        ?>
                        <div class="text-content">
                            <?php the_content() ?>
                        </div>
                        <?php
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

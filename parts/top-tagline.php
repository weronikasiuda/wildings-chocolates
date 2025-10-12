<?php

$text = get_field('top_tagline_text', 'options');

if (!$text) {
    return;
}

?>
<div class="tagline tagline--secondary">
    <div class="tagline__wrap">
        <div class="tagline__row">
            <?php

            if ($text) {
                ?>
                <div class="tagline__column">
                        <span class="tagline__text"><?= $text ?></span>
                </div>
                <?php
            }

            ?>
        </div>
    </div>
</div>

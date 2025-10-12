<?php

// Embed code is deliberately output without escaping
$embed = $args['embed_code'] ?? null;

if (!$embed) {
    return;
}

?>

<div class="section section--flex">
    <div class="embed-code">
        <div class="embed-code__wrap">
            <div class="embed-code__row">
                <div class="embed-code__column">
                    <?= $embed ?>
                </div>
            </div>
        </div>
    </div>
</div>

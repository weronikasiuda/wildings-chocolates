<?php

// Video embed code is sanitized in includes/acf-video-embed.php
$video_embed = $args['video_embed'] ?? null;

if (!$video_embed) {
    return;
}

?>

<div class="section section--flex">
    <div class="content__wrap">
        <div class="content__grid">
            <div class="content__section content__section--full">
                <?= $video_embed ?>
            </div>
        </div>
    </div>
</div>

<?php

$title = $args['audio_file']['title'] ?? null;
$url = $args['audio_file']['url'] ?? null;

if (!$url) {
    return;
}

if (!$title) {
    $title = pathinfo($url, PATHINFO_BASENAME);
}

?>

<div class="section section--flex">
    <audio src="<?= esc_url($url) ?>" controls class="audio-embed">
        <a href="<?= esc_url($url) ?>">Download audio file: <?= esc_html($title) ?></a>
    </audio>
</div>

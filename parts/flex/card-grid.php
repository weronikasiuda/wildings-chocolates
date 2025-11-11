<?php
$layout = $args['layout'] ?? [];
$cards = (array) ($args['cards'] ?? []);

foreach ($cards as $key => $card) {
    $heading = $card['heading'] ?? null;
    if (!$heading) {
        unset($cards[$key]);
    }
}


$modifier = null;

if($layout == '4-col-layout') {
    $modifier = '--4';  
} else {
    $modifier = '--3'; 
}

if (!$cards) {
    return;
}

$section_id = $args['section_id'] ?? null; // Section ID
// Prepare ID attribute
// NEW LOGIC: Conditionally set the ID attribute string
$id_attr = '';
if (!empty($section_id)) {
    $id_attr = ' id="' . esc_attr($section_id) . '"';
}

?>
<div class="section section--flex">
    <div class="card-grid" <?= $id_attr ?>>
        <div class="card-grid__wrap">
            <div class="card-grid__row card-grid__row--cards">
                <?php
                foreach ($cards as $card) {
                    $heading = $card['heading'] ?? null;
                    $excerpt = $card['text'] ?? null;
                    $link_url = $card['link']['url'] ?? null;
                    $link_title = $card['link']['title'] ?? null;
                    $image_src = $card['image']['url'] ?? null; // Renamed variable for clarity
                    $image_alt = $card['image']['alt'] ?? ''; // Added to get the alt text
                ?>
                <div class="card-grid__column <?= "card-grid__column" . $modifier ?>">
                    <?php
                    get_template_part('parts/card-box', null, [
                        'heading'     => $heading,
                        'excerpt'     => $excerpt,
                        'url'         => $link_url,
                        'button_text' => $link_title,
                        'image_src'   => $image_src, // FIX: Changed key from 'featured_image_url' to 'image_src'
                        'image_alt'   => $image_alt, // FIX: Added image alt text
                    ]);
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
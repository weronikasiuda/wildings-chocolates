<?php

$heading = get_field('home_shortcode_heading');
$shortcode = get_field('home_shortcode_text_content');

?>

<div class="shortcode">
    <div class="shortcode__container">
        <div class="shortcode__row">
            <div class="shortcode__text-col">
				<?php if ($heading): ?>
                <div class="shortcode__heading-container">
					<h2 class="shortcode__heading" data-aos="fade-up" data-aos-duration="1000"><?= $heading ?></h2>
				</div>
				<?php endif; ?>
            </div>
            <div class="shortcode__shortcode-col">
            <?php if ($shortcode): ?>
                <div class="shortcode__text-container" data-aos="fade-up" data-aos-duration="1000">
					<?= $shortcode ?>
				</div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
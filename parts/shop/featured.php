<?php

use function WS\WS\getSanitizedSvgIcon;

?>

<span class="featured-product-badge" title="Featured Product">
    <span aria-hidden="true"><?= getSanitizedSvgIcon('star.svg') ?></span>
    <span class="screen-reader-text">Featured</span>
</span>

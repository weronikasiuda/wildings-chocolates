<?php

ob_start();
the_content();

$content = ob_get_clean();

if (!$content) {
    return;
}

?>

<div class="section">
    <?php

    if ($content) {
        ?>
        <div class="text-content">
            <?= $content ?>
        </div>
        <?php
    }

    ?>
</div>

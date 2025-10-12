<?php

$pagination = paginate_links([
    'prev_text' => '&lt;&lt; <span class="screen-reader-text">Previous</span>',
    'next_text' => '<span class="screen-reader-text">Next</span> &gt;&gt;',
]);

if (!$pagination) {
    return;
}

?>

<div class="section">
    <div class="wp-pagination">
        <?= $pagination ?>
    </div>
</div>

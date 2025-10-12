<?php

if (!is_page()) {
    return;
}

$parent_id = get_the_ID();

$pages = get_pages([
    'parent' => $parent_id,
    'child_of' => $parent_id,
    'number' => 0,
    'sort_column' => 'menu_order',
    'sort_order' => 'ASC',
]);

if (!$pages) {
    return;
}

?>

<div class="content">
    <div class="content__wrap">
        <div class="wide-grid">
            <?php

            foreach ($pages as $page) {
                ?>
                <div class="wide-grid__item">
                    <?php

                    get_template_part('parts/post-card', null, [
                        'post_object' => $page,
                    ]);

                    ?>
                </div>
                <?php
            }

            ?>
        </div>
    </div>
</div>

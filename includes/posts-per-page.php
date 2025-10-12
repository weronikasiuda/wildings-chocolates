<?php

add_action('pre_get_posts', function ($query) {
    if (
        !$query->is_main_query() ||
        $query->is_admin ||
        $query->is_post_type_archive
    ) {
        return;
    }

    $query->set('posts_per_page', 6);
});

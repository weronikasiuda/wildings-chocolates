<?php

// Show last modified date, time, and user in WP admin.
add_action('post_submitbox_misc_actions', function ($post) {
    $items = [];

    if ($post instanceof WP_Post && $post->ID) {
        $modified = DateTime::createFromFormat('Y-m-d H:i:s', $post->post_modified);

        if ($modified) {
            $date_string = __('%1$s at %2$s');
            $date_format = _x('M j, Y', 'publish box date format');
            $time_format = _x('H:i', 'publish box time format');

            $date = date_i18n($date_format, strtotime($post->post_modified));
            $time = date_i18n($time_format, strtotime($post->post_modified));

            $items[] = 'Modified on: <b>' . esc_html(sprintf($date_string, $date, $time)) . '</b>';
        }
    }

    if ($post->ID) {
        $user_id = (int) get_post_meta(get_post()->ID, '_edit_last', true);

        if ($user_id) {
            $user = get_user_by('id', $user_id);

            if ($user && $user->exists()) {
                $items[] = 'Modified by: <b><a href="' . esc_url(get_edit_user_link($user_id)) . '">' . esc_html($user->display_name) . '</a></b>';
            }
        }
    }

    if ($items) {
        foreach ($items as $item) {
            echo '<div class="misc-pub-section">' . $item . '</div>';
        }
    }
});

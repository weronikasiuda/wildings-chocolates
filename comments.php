<?php

add_action('comment_form_before', function () {
    echo '<div class="section">';
});

add_action('comment_form_after', function () {
    echo '</div>';
});

?>

<div class="section" id="comments">
    <div class="wp-comments">
        <?php

        if (have_comments()) {
            echo '<div class="section">';
            echo '<h2>' . esc_html__('Comments') . '</h2>';
            echo '<ol class="comment-list">';

            wp_list_comments([
                'style' => 'ol',
            ]);

            echo '</ol>';

            if (get_comment_pages_count() > 1 && get_option('page_comments')) {
                echo previous_comments_link(esc_html__('Previous comments'));
                echo next_comments_link(esc_html__('Next comments'));
            }

            if (!comments_open() && get_comments_number()) {
                echo '<p>' . esc_html__('Comments are closed.') . '</p>';
            }

            echo '</div>';
        }

        comment_form();

        ?>
    </div>
</div>

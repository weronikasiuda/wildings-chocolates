<?php

function prevent_header_flash() {
    ?>
    <script>
    // Add class immediately when DOM is ready (before full page load)
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('page-loaded');
        
        <?php if (is_user_logged_in()) : ?>
        document.body.classList.add('user-logged-in');
        <?php else : ?>
        document.body.classList.add('user-not-logged-in');
        <?php endif; ?>
    });
    </script>
    <?php
}
add_action('wp_footer', 'prevent_header_flash');
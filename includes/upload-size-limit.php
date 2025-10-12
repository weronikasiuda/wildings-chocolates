<?php

// Restrict size of files that can be uploaded to the media library
add_filter('upload_size_limit', function ($bytes) {
    // Admin and site manager use the default (server) size limit
    if (current_user_can('edit_theme_options')) {
        return $bytes;
    }

    // All other users are limited to 2MB
    return 2 * pow(1024, 2);
});

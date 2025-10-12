<?php

// Restrict file types that can be uploaded to the media library
add_filter('upload_mimes', function ($mimes, $user = null) {
    // Get current user object
    if (is_int($user)) {
        $user = new WP_User($user);
    } elseif (is_null($user)) {
        $user = wp_get_current_user();
    }

    // User does not exist? User cannot upload any mime type.
    if (!$user->exists()) {
        return [];
    }

    // Administrator or site manager? Set full list of mime types.
    if ($user->has_cap('edit_theme_options')) {
        return [
            // Text
            'csv' => 'text/csv',
            'tsv' => 'text/tab-separated-values',
            'txt' => 'text/plain',

            // Image
            'gif' => 'image/gif',
            'jpg|jpeg|jpe' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',

            // Audio
            'aac' => 'audio/aac',
            'mp3|m4a|m4b' => 'audio/mpeg',
            'ogg|oga' => 'audio/ogg',

            // Video
            'ogv' => 'video/ogg',
            'webm' => 'video/webm',

            // Archive
            'zip' => 'application/zip',

            // Document
            'pdf' => 'application/pdf',

            // OpenDocument
            'odb' => 'application/vnd.oasis.opendocument.database',
            'odc' => 'application/vnd.oasis.opendocument.chart',
            'odf' => 'application/vnd.oasis.opendocument.formula',
            'odg' => 'application/vnd.oasis.opendocument.graphics',
            'odp' => 'application/vnd.oasis.opendocument.presentation',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            'odt' => 'application/vnd.oasis.opendocument.text',

            // Microsoft
            'doc' => 'application/msword',
            'mdb' => 'application/vnd.ms-access',
            'mpp' => 'application/vnd.ms-project',
            'pot|pps|ppt' => 'application/vnd.ms-powerpoint',
            'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'rtf' => 'application/rtf',

            // Apple
            'key' => 'application/vnd.apple.keynote',
            'numbers' => 'application/vnd.apple.numbers',
            'pages' => 'application/vnd.apple.pages',
        ];
    }

    // All other user roles can upload a restricted set of mime types.
    return [
        // Text
        'txt' => 'text/plain',

        // Image
        'gif' => 'image/gif',
        'jpg|jpeg|jpe' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',

        // Document
        'pdf' => 'application/pdf',

        // OpenDocument
        'odg' => 'application/vnd.oasis.opendocument.graphics',
        'odp' => 'application/vnd.oasis.opendocument.presentation',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'odt' => 'application/vnd.oasis.opendocument.text',

        // Microsoft
        'doc' => 'application/msword',
        'pot|pps|ppt' => 'application/vnd.ms-powerpoint',
        'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'rtf' => 'application/rtf',
    ];
}, 10, 2);

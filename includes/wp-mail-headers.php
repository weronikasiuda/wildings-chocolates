<?php

// Set the "From" and "Reply-To" email headers based on constants
add_filter('wp_mail', function ($args) {
    if (
        !defined('CGIT_MAIL_FROM_NAME') ||
        !defined('CGIT_MAIL_FROM_ADDRESS') ||
        !defined('CGIT_MAIL_REPLY_TO_NAME') ||
        !defined('CGIT_MAIL_REPLY_TO_ADDRESS')
    ) {
        return $args;
    }

    // Sanitize headers
    $headers = $args['headers'] ?? [];

    if (is_string($headers)) {
        $headers = preg_split('/\s*[\n\r]+\s*/', trim($headers));
    }

    if (!is_array($headers)) {
        $headers = [];
    }

    $has_reply_to = false;

    foreach ($headers as $key => $content) {
        $name = strtolower(substr($content, 0, strpos($content, ':')));

        switch ($name) {
            // Set "From"
            case 'from':
                $headers[$key] = sprintf('From: %s <%s>', CGIT_MAIL_FROM_NAME, CGIT_MAIL_FROM_ADDRESS);
                break;

            // "Reply-To" has already been set?
            case 'reply-to':
                $has_reply_to = true;
                break;
        }
    }

    // Set the "Reply-To" header if it has not already been set
    if (!$has_reply_to) {
        $headers[] = sprintf('Reply-To: %s <%s>', CGIT_MAIL_REPLY_TO_NAME, CGIT_MAIL_REPLY_TO_ADDRESS);
    }

    // Restore headers to parameters
    $args['headers'] = $headers;

    return $args;
}, 1);

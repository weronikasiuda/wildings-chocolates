<?php

/** Template Name: Redirect Page */

if (!function_exists('get_field')) {
    return get_template_part('page');
}

// Attempt to identify destination URL.
$url = null;

switch (get_field('redirect_type')) {
    case 'url':
        $url = get_field('redirect_url');
        break;

    case 'single':
        $url = get_permalink(get_field('redirect_post_id'));
        break;

    case 'archive':
        $url = get_post_type_archive_link(get_field('redirect_post_type'));
        break;

    case 'taxonomy':
        $url = get_term_link((int) get_field('redirect_term_id'));
        break;
}

// Redirect to URL.
if ($url) {
    wp_redirect($url);
    exit;
}

// URL does not exist? Send 404 instead.
$wp_query->set_404();
status_header(404);

if ($template_404 = get_404_template()) {
    include $template_404;
}

<?php

$post = $args['post'] ?? null;
$type = $args['type'] ?? null;

if (!($post instanceof WP_Post) || !($type instanceof WP_Post_Type)) {
    return;
}

$date = DateTime::createFromFormat('Y-m-d H:i:s', $post->post_modified);
$user = get_user_by('id', $post->post_author);

$type_label = $type->labels->singular_name;
$post_label = '"' . get_the_title($post) . '"';

if ($post->post_parent) {
    $post_label .= ' in "' . get_the_title($post->post_parent) . '"';
}

$date_formatted = $date->format('j F Y \a\t H:i');
$user_name = $user->display_name . ' <' . $user->user_email . '>';
$url = get_permalink($post);

?>

<?= $type_label ?> <?= $post_label ?> was updated by <?= $user_name ?> on <?= $date_formatted ?>.

View page: <<?= $url ?>>

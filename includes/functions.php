<?php

declare(strict_types=1);

namespace WS\WS;

use DOMDocument;
use DOMElement;
use Embed\Embed;
use WP_Post_Type;
use WP_Post;
use WP_Taxonomy;
use WP_Term;

/**
 * Return a list of SVG icons as ACF choices
 *
 * @return array
 */
function getIconChoices(): array
{
    $icons = scandir(THEME_CLIENT_ICON_DIR);
    $icons = array_diff($icons, ['.', '..']);

    return array_combine($icons, $icons);
}

function getSocialIconChoices(): array
{
    $icons = scandir(THEME_SOCIAL_ICON_DIR);
    $icons = array_diff($icons, ['.', '..']);

    return array_combine($icons, $icons);
}

/**
 * Return sanitized SVG icon
 *
 * @param string $icon
 * @return string|null
 */
function getSanitizedSvgIcon(string $icon): ?string
{
    return getSanitizedSvg(path_join(THEME_ICON_DIR, $icon));
}

/**
 * Return sanitized SVG icon selected in the backend
 *
 * @param string $icon
 * @return string|null
 */
function getSanitizedSocialSvgIcon(string $icon): ?string
{
    return getSanitizedSvg(path_join(THEME_SOCIAL_ICON_DIR, $icon));
}

/**
 * Return sanitized content of SVG file
 *
 * @param string $path
 * @return string|null
 */
function getSanitizedSvg(string $path): ?string
{
    $path = wp_normalize_path($path);
    $path = wp_kses_no_null($path);
    $path = realpath($path);

    if (!$path) {
        return null;
    }

    $svg = file_get_contents($path);

    if (!$svg) {
        return null;
    }

    return sanitizeSvg($svg);
}

/**
 * Sanitize SVG
 *
 * @param string
 * @return string
 */
function sanitizeSvg(string $svg): string
{
    $standard_attributes = [
        'style' => [],

        'alignment-baseline' => [],
        'baseline-shift' => [],
        'clip' => [],
        'clip-path' => [],
        'clip-rule' => [],
        'color' => [],
        'color-interpolation' => [],
        'color-interpolation-filters' => [],
        'color-profile' => [],
        'color-rendering' => [],
        'cursor' => [],
        'direction' => [],
        'display' => [],
        'dominant-baseline' => [],
        'enable-background' => [],
        'fill' => [],
        'fill-opacity' => [],
        'fill-rule' => [],
        'filter' => [],
        'flood-color' => [],
        'flood-opacity' => [],
        'font-family' => [],
        'font-size' => [],
        'font-size-adjust' => [],
        'font-stretch' => [],
        'font-style' => [],
        'font-variant' => [],
        'font-weight' => [],
        'glyph-orientation-horizontal' => [],
        'glyph-orientation-vertical' => [],
        'image-rendering' => [],
        'kerning' => [],
        'letter-spacing' => [],
        'lighting-color' => [],
        'marker-end' => [],
        'marker-mid' => [],
        'marker-start' => [],
        'mask' => [],
        'opacity' => [],
        'overflow' => [],
        'pointer-events' => [],
        'shape-rendering' => [],
        'solid-color' => [],
        'solid-opacity' => [],
        'stop-color' => [],
        'stop-opacity' => [],
        'stroke' => [],
        'stroke-dasharray' => [],
        'stroke-dashoffset' => [],
        'stroke-linecap' => [],
        'stroke-linejoin' => [],
        'stroke-miterlimit' => [],
        'stroke-opacity' => [],
        'stroke-width' => [],
        'text-anchor' => [],
        'text-decoration' => [],
        'text-rendering' => [],
        'transform' => [],
        'unicode-bidi' => [],
        'vector-effect' => [],
        'visibility' => [],
        'word-spacing' => [],
        'writing-mode' => [],
    ];

    return wp_kses($svg, [
        'svg' => [
            'xmlns' => [],
            'version' => [],
            'viewbox' => [],
            'width' => [],
            'height' => [],
        ],

        'g' => $standard_attributes,

        'circle' => array_merge($standard_attributes, [
            'cx' => [],
            'cy' => [],
            'r' => [],
            'fill' => [],
        ]),

        'rect' => array_merge($standard_attributes, [
            'x' => [],
            'y' => [],
            'rx' => [],
            'ry' => [],
            'width' => [],
            'height' => [],
            'fill' => [],
        ]),

        'path' => array_merge($standard_attributes, [
            'd' => [],
            'fill' => [],
        ]),

        'line' => array_merge($standard_attributes, [
            'x1' => [],
            'x2' => [],
            'y1' => [],
            'y2' => [],
        ]),
    ]);
}

/**
 * Sanitize video embed
 *
 * @param string $embed
 * @return string|null
 */
function sanitizeVideoEmbed(?string $embed): ?string
{
    // Check if the embed string is empty or null
    if (empty($embed)) {
        return null;
    }
    
    $document = new DOMDocument();
    // Add error suppression to prevent warnings about malformed HTML
    @$document->loadHTML($embed);
    
    $iframe = $document->getElementsByTagName('iframe')->item(0);
    if (!($iframe instanceof DOMElement)) {
        return null;
    }
    
    $width = (int) $iframe->getAttribute('width');
    $height = (int) $iframe->getAttribute('height');
    $style = 'height: auto; width: 100%;';
    
    if ($width && $height) {
        $style = "aspect-ratio: $width / $height; $style";
    }
    
    $iframe->setAttribute('style', $style);
    $video = $document->saveHTML($iframe);
    
    return wp_kses($video, [
        'iframe' => [
            'allow' => [],
            'allowfullscreen' => [],
            'height' => [],
            'src' => [],
            'style' => [],
            'title' => [],
            'width' => [],
        ],
    ]);
}

/**
 * Return post types associated with taxonomy
 *
 * @param string $name
 * @return array|null
 */
function getTaxonomyPostTypeList(string $name): ?array
{
    $taxonomy = get_taxonomy($name);

    if ($taxonomy instanceof WP_Taxonomy && is_array($taxonomy->object_type)) {
        return $taxonomy->object_type;
    }

    return null;
}

/**
 * Return single post type associated with taxonomy
 *
 * @param string $name
 * @return string|null
 */
function getTaxonomyPostType(string $name): ?string
{
    $types = getTaxonomyPostTypeList($name);

    if (is_array($types)) {
        return array_shift($types);
    }

    return null;
}

/**
 * Return redirect page ID from destination archive post type
 *
 * @param string|null $type
 * @return int|null
 */
function getArchiveRedirectPageId(string $type = null): ?int
{
    global $wpdb;

    if (is_null($type)) {
        $object = get_queried_object();

        if (is_post_type_archive() && $object instanceof WP_Post_Type) {
            $type = $object->name;
        } elseif (is_singular() && !is_singular('post') && $object instanceof WP_Post) {
            $type = $object->post_type;
        } elseif (is_tax() && $object instanceof WP_Term) {
            $type = getTaxonomyPostType($object->taxonomy);
        }
    }

    if (is_null($type)) {
        return null;
    }

    $page_id = (int) $wpdb->get_var($wpdb->prepare("SELECT templates.post_id
        FROM `{$wpdb->postmeta}` AS templates
        JOIN `{$wpdb->postmeta}` AS redirect_types
            ON templates.post_id = redirect_types.post_id
        JOIN `{$wpdb->postmeta}` AS post_types
            ON templates.post_id = post_types.post_id
        WHERE templates.meta_key = '_wp_page_template'
            AND templates.meta_value = 'templates/redirect.php'
            AND redirect_types.meta_key = 'redirect_type'
            AND redirect_types.meta_value = 'archive'
            AND post_types.meta_key = 'redirect_post_type'
            AND post_types.meta_value = %s
        LIMIT 1", $type));

    if ($page_id) {
        return $page_id;
    }

    return null;
}

/**
 * Return a list of button styles as ACF choices
 *
 * @return array
 */
function getButtonStyleChoices(): array
{
    return [
        'primary' => 'Primary',
        'secondary' => 'Secondary',
        'outline' => 'Outline',
    ];
}

/**
 * Return cached video image URL
 *
 * @param string $video_url
 * @return string|null
 */
function getVideoImageUrl(string $video_url): ?string
{
    $extensions = ['jpg', 'jpeg', 'png', 'webp'];
    $hash = md5($video_url);

    $uploads = wp_get_upload_dir();
    $cache = 'cgit-video-cache';

    $dir = path_join($uploads['basedir'], $cache);
    $url = path_join($uploads['baseurl'], $cache);

    // Does the file already exist in the cache with any valid extension?
    foreach ($extensions as $extension) {
        if (is_file(path_join($dir, "$hash.$extension"))) {
            return path_join($url, "$hash.$extension");
        }
    }

    // Does the cache directory exist? Can we create it?
    if (!is_dir($dir) && !wp_mkdir_p($dir)) {
        return null;
    }

    $embed = Embed::create($video_url);
    $image_url = $embed->image;

    // Does a preview image exist?
    if (!$image_url) {
        return null;
    }

    $extension = pathinfo($image_url, PATHINFO_EXTENSION);

    // Save the preview image to the cache.
    $fh = fopen(path_join($dir, "$hash.$extension"), 'w');
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $image_url);
    curl_setopt($ch, CURLOPT_FILE, $fh);

    $result = curl_exec($ch);
    curl_close($ch);

    // Success? Return cached image URL.
    if ($result) {
        return path_join($url, "$hash.$extension");
    }

    // Failure? Return null.
    return null;
}

/**
 * Return OpenStreetMap/Leaflet tile URL
 *
 * @return string|null
 */
function getMapTileUrl(): ?string
{
    // Thunderforest Map Tiles API
    // https://www.thunderforest.com/docs/map-tiles-api/
    if (defined('THUNDERFOREST_MAPS_API_KEY') && THUNDERFOREST_MAPS_API_KEY) {
        return vsprintf('https://%s.tile.thunderforest.com/%s/{z}/{x}/{y}%s.%s?apikey=%s', [
            'server' => 'a',
            'style' => 'atlas',
            'scale' => '',
            'format' => 'png',
            'key' => THUNDERFOREST_MAPS_API_KEY,
        ]);
    }

    return null;
}

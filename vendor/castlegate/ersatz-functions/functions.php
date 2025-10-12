<?php

declare(strict_types=1);

namespace Castlegate\ErsatzFunctions;

/**
 * Return nested object or array value
 *
 * This function attempts to return a nested object or array value. If any of
 * the nested properties or keys do not exist, the function will return null. No
 * distinction is made between a property that exists with a null value and a
 * property that does not exist.
 *
 * @param mixed $object
 * @param mixed $keys,...
 * @return mixed
 */
function nested($object, ...$keys)
{
    if (!$keys) {
        return $object;
    }

    if (!is_object($object) && !is_array($object)) {
        return null;
    }

    $object = (object) $object;
    $key = (string) array_shift($keys);
    $function = __FUNCTION__;

    if (!property_exists($object, $key)) {
        return null;
    }

    return $function($object->$key, ...$keys);
}

/**
 * Return HTML element
 *
 * This function returns an HTML element with attributes, if the content is not
 * empty and all its required attributes have values. If the element is a void
 * element, the parameters are passed to the nonContentElement function. If the
 * element is not a void element, the parameters are passed to the
 * contentElement function.
 *
 * @param string $element
 * @param mixed $args,...
 * @return string|null
 */
function element(string $element, ...$args): ?string
{
    $non_content_elements = [
        'area',
        'base',
        'br',
        'col',
        'command',
        'embed',
        'hr',
        'img',
        'input',
        'keygen',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
    ];

    if (in_array($element, $non_content_elements)) {
        return nonContentElement($element, ...$args);
    }

    return contentElement($element, ...$args);
}

/**
 * Return HTML element with content
 *
 * If provided with non-empty content and, optionally, all required attributes,
 * this function will return an HTML element. If not, it will return null. The
 * first parameter is the element name. The second parameter is the content,
 * which must be non-empty to return the element. The third parameter is an
 * associative array of attributes.
 *
 * The fourth parameter is an array of required attributes. If specified, each
 * of these attributes must exist in the array of attributes and they must have
 * non-empty values.
 *
 * @param string $element
 * @param string $content
 * @param array $attributes
 * @param array $required_attributes
 * @return string|null
 */
function contentElement(
    string $element,
    string $content,
    array $attributes = [],
    array $required_attributes = []
): ?string {
    // No element? No content? Required attributes empty? Return null.
    if (
        !$element ||
        !$content ||
        !hasRequiredAttributes($attributes, $required_attributes)
    ) {
        return null;
    }

    $start = "<$element>";
    $end = "</$element>";

    // Attributes provided? Append attributes to start tag.
    if ($attributes) {
        $formatted_attributes = attributes($attributes);
        $start = "<$element $formatted_attributes>";
    }

    // Return content wrapped in start and end tags (or null).
    return wrap($content, $start, $end);
}

/**
 * Return HTML void element
 *
 * If provided with all the required attributes, this function will return an
 * HTML void element. If not, it will return null. The first parameter is the
 * element name. The second parameter is an associative array of attributes.
 *
 * The third parameter is an array of required attributes. If specified, each of
 * these attributes must exist in the array of attributes and they must have
 * non-empty values.
 *
 * @param string $element
 * @param array $attributes
 * @param array $required_attributes
 * @return string|null
 */
function nonContentElement(
    string $element,
    array $attributes = [],
    array $required_attributes = []
): ?string {
    // No element? Required attributes empty? Return null.
    if (
        !$element ||
        !hasRequiredAttributes($attributes, $required_attributes)
    ) {
        return null;
    }

    // Attributes provided? Append attributes to tag.
    if ($attributes) {
        $formatted_attributes = attributes($attributes);

        return "<$element $formatted_attributes>";
    }

    return "<$element>";
}

/**
 * Required attributes set and non-empty?
 *
 * Check whether an associative array has all its required keys and that those
 * keys have non-empty values.
 *
 * @param array $attributes
 * @param array $required
 * @return boolean
 */
function hasRequiredAttributes(array $attributes, array $required): bool
{
    $populated = array_keys(array_filter($attributes));
    $empty = array_diff($required, $populated);

    if ($empty) {
        return false;
    }

    return true;
}

/**
 * Return HTML attributes as string
 *
 * This function converts an associative array of HTML attributes into a
 * correctly formatted string of HTML attributes. Object and array values are
 * converted into space-separated string values.
 *
 * @param array $attributes
 * @return string|null
 */
function attributes(array $attributes): ?string
{
    if (!$attributes) {
        return null;
    }

    $attributes = array_map(function ($key, $value) {
        // Convert objects and arrays to space-separated lists of values
        if (is_object($value) || is_array($value)) {
            $value = implode(' ', (array) $value);
        }

        return ((string) $key) . '="' . ((string) $value) . '"';
    }, array_keys($attributes), $attributes);

    return implode(' ', $attributes);
}

/**
 * Return wrapped content
 *
 * If the content is not empty, this will return the content wrapped in the
 * strings provided in the second and third parameters. If the content is empty,
 * the other parameters are ignored and the function returns null.
 *
 * @param string $content
 * @param string $before
 * @param string $after
 * @return string|null
 */
function wrap(string $content, string $before = '', string $after = ''): ?string
{
    if (!$content) {
        return null;
    }

    return $before . $content . $after;
}

/**
 * Randomly encode a character or sequence of characters
 *
 * This function randomly encodes each character in a string as a character, a
 * decimal HTML entity, or a hexadecimal HTML entity.
 *
 * @param string $str
 * @return string
 */
function obfuscate(string $str): string
{
    $characters = array_map(function ($character) {
        switch (rand(0, 2)) {
            case 1:
                return entity($character);

            case 2:
                return entity($character, true);
        }

        return $character;
    }, characters($str));

    return implode($characters);
}

/**
 * Split a string into an array of characters
 *
 * This function splits a string into an array of characters. Unlike str_split,
 * it is safe to use on multibyte strings. Note that mb_str_split is available
 * from PHP 7.4.
 *
 * @param string $str
 * @return array
 */
function characters(string $str): array
{
    if (function_exists('mb_str_split')) {
        return mb_str_split($str);
    }

    $characters = [];

    while (mb_strlen($str)) {
        $characters[] = mb_substr($str, 0, 1);
        $str = mb_substr($str, 1);
    }

    return $characters;
}

/**
 * Encode the characters in a string as HTML entities
 *
 * @param string $str
 * @param bool $hex
 * @return string
 */
function entity(string $str, bool $hex = false): string
{
    return mb_encode_numericentity($str, [0x00, 0xff, 0, 0xff], 'utf-8', $hex);
}

/**
 * Return formatted URL
 *
 * This function returns a valid URL or, if the second parameter is true, a
 * human-readable URL. If the URL cannot be parsed by parse_url, this function
 * returns null.
 *
 * @param string $url
 * @param bool $human
 * @return string|null
 */
function url(string $url, bool $human = false): ?string
{
    if (strpos($url, '//') === false) {
        $url = "//$url";
    }

    if (parse_url($url) === false) {
        return null;
    }

    if ($human) {
        return rtrim(substr($url, strpos($url, '//') + 2), '/');
    }

    return $url;
}

/**
 * Return formatted telephone number
 *
 * This function attempts to create a machine-readable telephone number that can
 * be used in a "tel:" link by stripping invalid characters and bracketed
 * segments of a telephone number string. If the second parameter is true, it
 * returns the string unmodified as a human-readable telephone number.
 *
 * @param string $tel
 * @param bool $human
 * @return string|null
 */
function tel(string $tel, bool $human = false): ?string
{
    if ($human) {
        return $tel;
    }

    $pattern = '/\([^\(\)]*\)/';

    // Assume segments in parentheses are optional and remove them
    while (preg_match($pattern, $tel)) {
        $tel = preg_replace($pattern, '', $tel);
    }

    // Remove invalid telephone number link characters
    return preg_replace('/[^0-9\+\-]/', '', $tel);
}

/**
 * Return formatted HTML URL link
 *
 * The first parameter is the URL, the second is the content, and the third is
 * an array of attributes. If the second parameter is not provided, a
 * human-readable version of the URL will be used instead.
 *
 * @param string $url
 * @param string|null $content
 * @param array $attributes
 * @return string|null
 */
function urlLink(
    string $url,
    string $content = null,
    array $attributes = []
): ?string {
    if (!$content) {
        $content = url($url, true);
    }

    $href_attributes = [
        'href' => url($url),
    ];

    $attributes = array_merge($href_attributes, $attributes, $href_attributes);

    return element('a', $content, $attributes);
}

/**
 * Return formatted HTML email link
 *
 * The first parameter is the email address, the second is the content, and the
 * third is an array of attributes. The email address will be obfuscated. If the
 * second parameter is not provided, the email address will be used instead.
 *
 * @param string $email
 * @param string|null $content
 * @param array $attributes
 * @return string|null
 */
function emailLink(
    string $email,
    string $content = null,
    array $attributes = []
): ?string {
    if (!$content) {
        $content = obfuscate($email);
    }

    $href_attributes = [
        'href' => obfuscate("mailto:$email"),
    ];

    $attributes = array_merge($href_attributes, $attributes, $href_attributes);

    return element('a', $content, $attributes);
}

/**
 * Return formatted HTML telephone link
 *
 * The first parameter is the telephone number as a human-readable string, the
 * second is the content, and the third is an array of attributes. The telephone
 * number will be parsed to strip optional and invalid components. If the second
 * parameter is not provided, the original, unmodified telephone number will be
 * used instead.
 *
 * @param string $tel
 * @param string|null $content
 * @param array $attributes
 * @return string|null
 */
function telLink(
    string $tel,
    string $content = null,
    array $attributes = []
): ?string {
    if (!$content) {
        $content = tel($tel, true);
    }

    $href_attributes = [
        'href' => 'tel:' . tel($tel),
    ];

    $attributes = array_merge($href_attributes, $attributes, $href_attributes);

    return element('a', $content, $attributes);
}

/**
 * Return date range
 *
 * This function returns a string representation of a date range, from the first
 * parameter DateTime instance to the second parameter DateTime instance. The
 * third parameter is an optional associative array of date formats for
 * comparison (keys) and output (values).
 *
 * If the year, month, and day are the same, the first format is used. If the
 * year and month are the same, the second pair of formats are used. If the year
 * is the same, the third pair of formats are used. If no parts of the two dates
 * are the same, the first format is used for both dates.
 *
 * The fourth parameter is the string used to separate the start and end dates,
 * by default an en dash.
 *
 * @param DateTime $start
 * @param DateTime $end
 * @param array|null $formats
 * @param string|null $dash
 * @return string
 */
function dateRange(
    DateTime $start,
    DateTime $end,
    array $formats = null,
    string $dash = null
): string {
    // Assemble and sort array of dates
    $dates = [$start, $end];

    sort($dates);

    // Set default return formats for each comparison format
    $default_formats = [
        'Ymd' => ['j F Y'],
        'Ym' => ['j', 'j F Y'],
        'Y' => ['j F', 'j F Y'],
    ];

    // Set custom return formats, which must use the same comparison formats (as
    // array keys) as the default formats, must include return formats as
    // arrays, and must not include any additional array keys.
    $formats = $formats ?? $default_formats;
    $formats = array_intersect_key($formats, $default_formats);
    $formats = array_filter(array_filter($formats), 'is_array');
    $formats = array_merge($default_formats, $formats);

    // Set default string to put between the output start and end dates
    if (is_null($dash)) {
        $dash = "\u{2013}"; // en dash
    }

    // Set the default return formats
    $return_formats = $formats['Ymd'];

    // Perform each comparison and set the return formats if a match is found
    foreach ($formats as $k => $v) {
        if ($dates[0]->format($k) === $dates[1]->format($k)) {
            $return_formats = $v;

            break;
        }
    }

    // Pad the return formats to the same length as the array of dates
    $return_formats = array_values($return_formats);
    $return_formats = array_pad($return_formats, 2, $return_formats[0]);

    // Assemble an array of formatted dates
    $return_dates = array_map(function ($date, $format) {
        return $date->format($format);
    }, $dates, $return_formats);

    // Return unique formatted dates with separator
    return implode($dash, array_unique($return_dates));
}

/**
 * Return time range
 *
 * This function returns a string representation of a time range, from the first
 * parameter DateTime instance to the second parameter DateTime instance. The
 * third parameter is a time format used for both comparison and output, by
 * default "G:i". The fourth parameter is the string used to separate the start
 * and end dates, by default an en dash.
 *
 * @param DateTime $start
 * @param DateTime $end
 * @param string $format
 * @param string|null $dash
 * @return string
 */
function timeRange(
    DateTime $start,
    DateTime $end,
    string $format = 'G:i',
    string $dash = null
): string {
    // Assemble and sort array of times
    $times = [$start, $end];

    sort($times);

    // Set default string to put between the output start and end times
    if (is_null($dash)) {
        $dash = "\u{2013}"; // en dash
    }

    // Assemble an array of formatted times
    $return_times = array_map(function ($time) use ($format) {
        return $time->format($format);
    }, $times);

    // Return unique formatted times with separator
    return implode($dash, array_unique($return_times));
}

/**
 * Return human-readable representation of a number of bytes
 *
 * Convert a number of bytes into a more human-readable string with the correct
 * SI unit. The second parameter sets the number of decimal points. The default
 * number of decimal points is 2. If the third parameter is true, 1 kilobyte is
 * assumed to be 1024 bytes, instead of the default 1000 bytes. The fourth
 * parameter sets the character used to separate the value from the unit. The
 * default separator is a non-breaking space.
 *
 * @param int $bytes
 * @param int $points
 * @param bool $binary
 * @param string $space
 * @return string
 */
function bytes(
    int $bytes,
    int $points = null,
    bool $binary = false,
    string $space = null
): string {
    $points = $points ?? 2;
    $space = $space ?? "\u{00a0}";

    $base = 1000;
    $units = explode(',', 'B,KB,MB,GB,TB,PB,EB,ZB,YB');

    if ($binary) {
        $base = 1024;
        $units = explode(',', 'B,KiB,MiB,GiB,TiB,PiB,EiB,ZiB,YiB');
    }

    $max = count($units) - 1;
    $exponent = (int) min($max, floor((strlen((string) $bytes) - 1) / 3));
    $size = $bytes / pow($base, $exponent);

    return number_format($size, $points) . $space . $units[$exponent];
}

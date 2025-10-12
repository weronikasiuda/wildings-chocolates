# Ersatz Functions

Basic PHP and WordPress functions. Install with Composer:

    composer require Castlegate/ersatz-functions

## Functions

### Core

Core functions use the `Castlegate\ErsatzFunctions` namespace.

#### nested

Return nested object or array value.

    function nested($object, ...$keys)

This function attempts to return a nested object or array value. If any of the nested properties or keys do not exist, the function will return `null`. No distinction is made between a property that exists with a null value and a property that does not exist.

#### element

Return HTML element.

    function element(string $element, ...$args): ?string

This function returns an HTML element with attributes, if the content is not empty and all its required attributes have values. If the element is a void element, the parameters are passed to the `nonContentElement` function. If the element is not a void element, the parameters are passed to the `contentElement` function.

#### contentElement

Return HTML element with content.

    function contentElement(
        string $element,
        string $content,
        array $attributes = [],
        array $required_attributes = []
    ): ?string

If provided with non-empty content and, optionally, all required attributes, this function will return an HTML element. If not, it will return `null`. The first parameter is the element name. The second parameter is the content, which must be non-empty to return the element. The third parameter is an associative array of attributes.

The fourth parameter is an array of required attributes. If specified, each of these attributes must exist in the array of attributes and they must have non-empty values.

#### nonContentElement

Return HTML void element.

    function nonContentElement(
        string $element,
        array $attributes = [],
        array $required_attributes = []
    ): ?string

If provided with all the required attributes, this function will return an HTML void element. If not, it will return `null`. The first parameter is the element name. The second parameter is an associative array of attributes.

The third parameter is an array of required attributes. If specified, each of these attributes must exist in the array of attributes and they must have non-empty values.

#### hasRequiredAttributes

Required attributes set and non-empty?

    function hasRequiredAttributes(
        array $attributes,
        array $required
    ): bool

Check whether an associative array has all its required keys and that those keys have non-empty values.

#### attributes

Return HTML attributes as string.

    function attributes(array $attributes): ?string

This function converts an associative array of HTML attributes into a correctly formatted string of HTML attributes. Object and array values are converted into space-separated string values.

#### wrap

Return wrapped content.

    function wrap(
        string $content,
        string $before = '',
        string $after = ''
    ): ?string

If the content is not empty, this will return the content wrapped in the strings provided in the second and third parameters. If the content is empty, the other parameters are ignored and the function returns null.

#### obfuscate

Randomly encode a character or sequence of characters.

    function obfuscate(string $str): string

This function randomly encodes each character in a string as a character, a decimal HTML entity, or a hexadecimal HTML entity.

#### characters

Split a string into an array of characters.

    function characters(string $str): array

This function splits a string into an array of characters. Unlike `str_split`, it is safe to use on multibyte strings. Note that `mb_str_split` is available from PHP 7.4.

#### entity

Encode the characters in a string as HTML entities.

    function entity(string $str, bool $hex = false): string

#### url

Return formatted URL.

    function url(string $url, bool $human = false): ?string

This function returns a valid URL or, if the second parameter is true, a human-readable URL. If the URL cannot be parsed by `parse_url`, this function returns `null`.

#### tel

Return formatted telephone number.

    function tel(string $tel, bool $human = false): ?string

This function attempts to create a machine-readable telephone number that can be used in a `tel:` link by stripping invalid characters and bracketed segments of a telephone number string. If the second parameter is `true`, it returns the string unmodified as a human-readable telephone number.

#### urlLink

Return formatted HTML URL link.

    function urlLink(
        string $url,
        string $content = null,
        array $attributes = []
    ): ?string

The first parameter is the URL, the second is the content, and the third is an array of attributes. If the second parameter is not provided, a human-readable version of the URL will be used instead.

#### emailLink

Return formatted HTML email link.

    function emailLink(
        string $email,
        string $content = null,
        array $attributes = []
    ): ?string

The first parameter is the email address, the second is the content, and the third is an array of attributes. The email address will be obfuscated. If the second parameter is not provided, the email address will be used instead.

#### telLink

Return formatted HTML telephone link.

    function telLink(
        string $tel,
        string $content = null,
        array $attributes = []
    ): ?string

The first parameter is the telephone number as a human-readable string, the second is the content, and the third is an array of attributes. The telephone number will be parsed to strip optional and invalid components. If the second parameter is not provided, the original, unmodified telephone number will be used instead.

#### dateRange

Return date range.

    function dateRange(
        DateTime $start,
        DateTime $end,
        array $formats = null,
        string $dash = null
    ): string

This function returns a string representation of a date range, from the first parameter `DateTime` instance to the second parameter `DateTime` instance. The third parameter is an optional associative array of date formats for comparison (keys) and output (values). Example:

~~~ php
$formats = [
    // Year, month, and day match
    'Ymd' => [
        'j F Y', // output format
    ],

    // Year and month match
    'Ym' => [
        'j', // start date output format
        'j F Y', // end date output format
    ],

    // Year matches
    'Y' => [
        'j F', // start date output format
        'j F Y', // end date output format
    ],
];
~~~

If the year, month, and day are the same, the first format is used. If the year and month are the same, the second pair of formats are used. If the year is the same, the third pair of formats are used. If no parts of the two dates are the same, the first format (with the `Ymd` key) is used for both dates.

The fourth parameter is the string used to separate the start and end dates, by default an en dash.

#### timeRange

Return time range.

    function timeRange(
        DateTime $start,
        DateTime $end,
        string $format = 'G:i',
        string $dash = null
    ): string

This function returns a string representation of a time range, from the first parameter `DateTime` instance to the second parameter `DateTime` instance. The third parameter is a time format used for both comparison and output, by default `G:i`. The fourth parameter is the string used to separate the start and end dates, by default an en dash.

#### bytes

Return human-readable representation of a number of bytes.

    function bytes(
        int $bytes,
        int $points = null,
        bool $binary = false,
        string $space = null
    ): string

Convert a number of bytes into a more human-readable string with the correct SI unit. The second parameter sets the number of decimal points. The default number of decimal points is 2. If the third parameter is true, 1 kilobyte is assumed to be 1024 bytes, instead of the default 1000 bytes. The fourth parameter sets the character used to separate the value from the unit. The default separator is a non-breaking space.

### WordPress

WordPress functions use the `Castlegate\ErsatzFunctions\WordPress` namespace.

#### templatePageList

Return array of pages by template.

    function templatePageList(string $template, array $args = []): ?array

This function returns an array of pages that use a particular template, or null of none can be found. The second parameter can be used to pass additional options to the get_posts function. By default, the array of pages is sorted by the menu_order property.

#### templatePage

Return page by template.

    function templatePage(string $template, array $args = []): ?object

This function returns the first page, sorted by menu_order, that uses a particular template, or null if none can be found. The second parameter can be used to pass additional options to the get_posts function, which might affect the sort order of the pages returned and, therefore, which page is returned by this function.

#### trigger403

Trigger 403 "forbidden" error.

    function trigger403(
        string $message = null,
        string $title = null,
        array $args = []
    ): void {

This function is a wrapper around `wp_die` with the message and title set to `Forbidden` and the response code set to `403`.

#### trigger404

Trigger 404 "not found" error.

    function trigger404(): void

This function triggers a 404 "not found" error and displays the 404 template, if it is a available.

#### labels

Return post type or taxonomy labels.

    function labels(string $item, string $items = null): array

This function creates an array of labels that can be used with the `register_post_type` and `register_taxonomy` functions. The first parameter is the singular name of the post type or taxonomy. The second parameter is the plural name. If no plural name is provided, the plural will be created by appending "s" to the singular name.

## License

Released under the [MIT License](https://opensource.org/licenses/MIT).

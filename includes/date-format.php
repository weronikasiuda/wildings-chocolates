<?php

add_filter('option_date_format', function ($format) {
    return THEME_DATE_FORMAT;
});

add_filter('default_option_date_format', function ($format) {
    return THEME_DATE_FORMAT;
});

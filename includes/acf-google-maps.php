<?php

add_filter('acf/fields/google_map/api', function ($api) {
    if (defined('GOOGLE_MAPS_API_KEY') && GOOGLE_MAPS_API_KEY) {
        $api['key'] = GOOGLE_MAPS_API_KEY;
    }

    return $api;
});

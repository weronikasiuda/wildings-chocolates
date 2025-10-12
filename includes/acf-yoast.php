<?php

// Move Yoast fields below ACF fields
add_filter('wpseo_metabox_prio', function () {
    return 'low';
});

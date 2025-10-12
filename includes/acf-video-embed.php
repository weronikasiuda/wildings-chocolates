<?php

// Sanitize ACF flexible content video embed output
add_filter('acf/format_value/name=video_embed', '\\Castlegate\\AlcoholicsAnonymous\\sanitizeVideoEmbed');

<?php

global $wp_query;
global $wpdb;

$dates = $wpdb->get_results("
    SELECT
        YEAR(post_date) as year,
        MONTH(post_date) as month
    FROM
        $wpdb->posts
    WHERE
        post_type = 'post'
    AND
        post_status = 'publish'
    GROUP BY
        YEAR(post_date),
        MONTH(post_date)
    ORDER BY
        post_date DESC
");

if (!$dates) {
    return;
}

// Group months by year
$archives = [];

foreach ($dates as $date) {
    $archives[(int) $date->year][] = (int) $date->month;
}

// Map month numbers to month names
$month_numbers = range(1, 12);
$month_names = [];

foreach ($month_numbers as $month_number) {
    $month_names[$month_number] = (DateTime::createFromFormat('!m', $month_number))->format('F');
}

// Current year and month
$current_year = (int) get_query_var('year');
$current_month = (int) get_query_var('monthnum');

// Generate items and sub-items for output.
$items = [];

foreach ($archives as $year => $months) {
    $sub_items = [];

    if ($months) {
        foreach ($months as $month) {
            $sub_items[] = [
                'title' => $month_names[$month],
                'url' => get_month_link($year, $month),
                'active' => is_month() && $year === $current_year && $month === $current_month,
            ];
        }
    }

    $items[] = [
        'title' => $year,
        'url' => get_year_link($year),
        'active' => (is_year() || is_month()) && $year === $current_year,
        'sub_items' => $sub_items,
    ];
}

?>

<div class="section">
    <?php

    get_template_part('parts/subnav', null, [
        'heading' => __('Archives'),
        'items' => $items,
    ]);

    ?>
</div>

<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');

// Load custom template parts for banner and breadcrumb
get_template_part('parts/banner');
get_template_part('parts/breadcrumb-nav');
?>

<div class="content">
    <div class="content__wrap">
        <div class="content__grid">
                <?php
                /**
                 * Hook: woocommerce_before_main_content.
                 *
                 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                 * @hooked woocommerce_breadcrumb - 20
                 * @hooked WC_Structured_Data::generate_website_data() - 30
                 */
                do_action('woocommerce_before_main_content');

                // Only show page title and description on main shop page, not category pages
                if (!is_product_category() && !is_product_tag()) {
                    // Page title and introductory content for main shop page only
                    ob_start();
                    if (apply_filters('woocommerce_show_page_title', true)) {
                        echo '<h1 class="page-title">' . woocommerce_page_title(false) . '</h1>';
                    }
                    /**
                     * Hook: woocommerce_archive_description.
                     *
                     * @hooked woocommerce_taxonomy_archive_description - 10
                     * @hooked woocommerce_product_archive_description - 10
                     */
                    do_action('woocommerce_archive_description');
                    $content = ob_get_clean();

                    if ($content) {
                    ?>
                    <div class="section">
                        <div class="text-content">
                            <?php echo wp_kses_post($content); ?>
                        </div>
                    </div>
                    <?php
                    }
                    
                    // The main shop page now outputs taxonomy sliders
                    $taxonomies_to_include = [
                        'product_cat',
                        'diet',
                        'occasion',
                    ];

                    $row_index = 0;
                    foreach ($taxonomies_to_include as $taxonomy_slug) {
                        $row_index++;
                        $taxonomy_object = get_taxonomy($taxonomy_slug);

                        if (!$taxonomy_object || !$taxonomy_object->public) {
                            continue;
                        }
                        
                        if ($taxonomy_slug === 'product_cat') {
                            $section_heading = 'Shop by category';
                        } elseif ($taxonomy_slug === 'diet') {
                            $section_heading = 'Shop by diet';
                        } elseif ($taxonomy_slug === 'occasion') {
                            $section_heading = 'Shop by occasion';
                        } else {
                            $section_heading = $taxonomy_object->label;
                        }
                        
                        // This query is more robust for WooCommerce categories
                        if ($taxonomy_slug === 'product_cat') {
                            $terms = get_terms([
                                'taxonomy'   => $taxonomy_slug,
                                'hide_empty' => false,
                                'order'      => 'ASC',
                                'orderby' => 'meta_value_num',
                                'meta_key' => 'order',
                            ]);
                        } else {
                            // This query for custom taxonomies is working correctly
                            $terms = get_terms([
                                'taxonomy'   => $taxonomy_slug,
                                'hide_empty' => false,
                                'orderby'    => 'name',
                                'order'      => 'ASC'
                            ]);
                        }
                        
                        if (is_wp_error($terms)) {
                            continue;
                        }
                        
                        $slider_data = [
                            'row_index' => $row_index,
                            'section_heading' => $section_heading,
                            'terms' => $terms,
                            'section_heading_modifier' => '--sm'
                        ];
                        
                        get_template_part('parts/taxonomy-slider', null, $slider_data);
                    }
                } else {
                    // If we're on a category page, show the products
                    if (woocommerce_product_loop()) {
                        /**
                         * Hook: woocommerce_shop_loop_header.
                         * This will output the category title and description automatically
                         *
                         * @since 8.6.0
                         *
                         * @hooked woocommerce_product_taxonomy_archive_header - 10
                         */
                        do_action('woocommerce_shop_loop_header');
                        
                        /**
                         * Hook: woocommerce_before_shop_loop.
                         *
                         * @hooked woocommerce_output_all_notices - 10
                         * @hooked woocommerce_result_count - 20
                         * @hooked woocommerce_catalog_ordering - 30
                         */
                        do_action('woocommerce_before_shop_loop');
                        
                        woocommerce_product_loop_start();
                        
                        if (wc_get_loop_prop('total')) {
                            while (have_posts()) {
                                the_post();
                                
                                /**
                                 * Hook: woocommerce_shop_loop.
                                 */
                                do_action('woocommerce_shop_loop');
                                
                                wc_get_template_part('content', 'product');
                            }
                        }
                        
                        woocommerce_product_loop_end();
                        
                        /**
                         * Hook: woocommerce_after_shop_loop.
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                        do_action('woocommerce_after_shop_loop');
                    } else {
                        /**
                         * Hook: woocommerce_no_products_found.
                         *
                         * @hooked wc_no_products_found - 10
                         */
                        do_action('woocommerce_no_products_found');
                    }
                }
                ?>

                <?php
                /**
                 * Hook: woocommerce_after_main_content.
                 *
                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
                do_action('woocommerce_after_main_content');
                ?>
            </div>
            
            <?php
            // Sidebar template part - Preserving your custom sidebar
            get_template_part('parts/shop/content-side');
            ?>
            
        </div>
    </div>
</div>

<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
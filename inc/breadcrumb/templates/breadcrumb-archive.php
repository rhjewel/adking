<?php

use Egns\Inc\Header_Helper;
use Egns\Helper\Egns_Helper;

$enable_breadcrumb_by_theme = Egns_Helper::egns_get_theme_option('breadcrumb_enable');
$breadcrumb_enable_by_page  = Egns_Helper::egns_page_option_value('breadcrumb_enable_page');

// Default heading 
$breadcrumb_heading         = Egns_Helper::egns_get_theme_option('breadcrumb_heading') ?? '';
$breadcrumb_page_heading    = Egns_Helper::egns_page_option_value('breadcrumb_page_heading') ?? '';

// Final default values
$breadcrumb_display_heading = $breadcrumb_page_heading !== '' ? $breadcrumb_page_heading : $breadcrumb_heading;

// Custom Post Type Headings
$breadcrumb_cpt_pt_heading = Egns_Helper::egns_get_theme_option('breadcrumb_cpt_people_heading') ?? '';
$breadcrumb_cpt_cr_heading = Egns_Helper::egns_get_theme_option('breadcrumb_cpt_creer_heading') ?? '';
$breadcrumb_cpt_cs_heading = Egns_Helper::egns_get_theme_option('breadcrumb_cpt_case_heading') ?? '';

$is_woocommerce_archive  = function_exists('is_shop') && (is_shop() || is_post_type_archive('product'));
$is_woocommerce_taxonomy = function_exists('is_product_taxonomy') && is_product_taxonomy();


/**
 * -------------------------------------------------------
 * Custom Post Type Archive + Taxonomy Override Logic
 * -------------------------------------------------------
 */


if (is_post_type_archive('career') || (is_tax(['career-category', 'career-tag']))) {
    $breadcrumb_display_heading = $breadcrumb_cpt_cr_heading ?: 'Career';
}

if (is_post_type_archive('people') || (is_tax(['people-category', 'people-tag']))) {
    $breadcrumb_display_heading = $breadcrumb_cpt_pt_heading ?: 'People';
}

if (is_post_type_archive('case-study') || (is_tax(['case-study-category', 'case-study-tag']))) {
    $breadcrumb_display_heading = $breadcrumb_cpt_cs_heading ?: 'Case Study';
}

if ($is_woocommerce_archive && function_exists('woocommerce_page_title')) {
    $breadcrumb_display_heading = woocommerce_page_title(false);
}

?>

<?php if (Egns\Helper\Egns_Helper::is_enabled($enable_breadcrumb_by_theme, $breadcrumb_enable_by_page)): ?>
    <div class="breadcrumb-section">
        <div class="container one">
            <div class="row">
                <div class="col-lg-10">
                    <div class="banner-content">
                        <h1>
                            <?php

                            $term = get_queried_object();

                            if ($is_woocommerce_taxonomy && $term instanceof WP_Term) {
                                if (is_tax('product_cat')) {
                                    echo esc_html__('Category: ', 'adking') . esc_html($term->name);
                                } elseif (is_tax('product_tag')) {
                                    echo esc_html__('Tag: ', 'adking') . esc_html($term->name);
                                } else {
                                    $taxonomy = get_taxonomy($term->taxonomy);
                                    $taxonomy_label = $taxonomy && !empty($taxonomy->labels->singular_name) ? $taxonomy->labels->singular_name : $term->taxonomy;

                                    echo esc_html($taxonomy_label . ': ') . esc_html($term->name);
                                }
                            } elseif (is_tax() && $term) {
                                if (strpos($term->taxonomy, 'category') !== false) {
                                    echo esc_html__('Category: ', 'adking') . esc_html($term->name);
                                } elseif (strpos($term->taxonomy, 'tag') !== false) {
                                    echo esc_html__('Tag: ', 'adking') . esc_html($term->name);
                                }
                            } else {

                                // ----- CPT or Page Heading -----
                                if (!empty($breadcrumb_display_heading)) {
                                    echo wp_kses_post($breadcrumb_display_heading);
                                } else {
                                    // fallback: default WP logic
                                    if (is_category()) {
                                        echo esc_html__('Category: ', 'adking');
                                        single_cat_title();
                                    } elseif (is_tag()) {
                                        echo esc_html__('Tag: ', 'adking');
                                        single_tag_title();
                                    } elseif (is_author()) {
                                        echo esc_html__('Author: ', 'adking');
                                        the_author();
                                    } elseif (is_date()) {
                                        echo esc_html__('Date: ', 'adking');
                                        if (is_day()) echo get_the_time('F j, Y');
                                        elseif (is_month()) echo get_the_time('F, Y');
                                        elseif (is_year()) echo get_the_time('Y');
                                    } elseif (is_home()) {
                                        Egns\Helper\Egns_Helper::egns_translate('Blog');
                                    } else {
                                        the_title();
                                    }
                                }
                            }

                            ?>
                        </h1>
                        <?php echo egns_breadcrumb(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
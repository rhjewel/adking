<?php

use Egns\Inc\Header_Helper;
use Egns\Helper\Egns_Helper;

$enable_breadcrumb_by_theme = Egns_Helper::egns_get_theme_option('breadcrumb_enable');
$breadcrumb_enable_by_page  = Egns_Helper::egns_page_option_value('breadcrumb_enable_page');

// Heading and short description: page value has priority over theme option
$breadcrumb_heading         = Egns_Helper::egns_get_theme_option('breadcrumb_heading') ?? '';
$breadcrumb_page_heading    = Egns_Helper::egns_page_option_value('breadcrumb_page_heading') ?? '';

// Determine final values: page option first, then theme option
$breadcrumb_display_heading = $breadcrumb_page_heading !== '' ? $breadcrumb_page_heading : $breadcrumb_heading;

?>
<?php if (Egns\Helper\Egns_Helper::is_enabled($enable_breadcrumb_by_theme, $breadcrumb_enable_by_page)): ?>
    <div class="breadcrumb-section">
        <div class="container one">
            <div class="row">
                <div class="col-lg-10">
                    <div class="banner-content">
                        <h1>
                            <?php
                            // page-level heading overrides theme heading; if set
                            // use that, otherwise fall back to the original title logic
                            if (! empty($breadcrumb_display_heading)) {
                                echo wp_kses_post($breadcrumb_display_heading);
                            } else {
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
                                    if (is_day()) {
                                        echo get_the_time('F j, Y');
                                    } elseif (is_month()) {
                                        echo get_the_time('F, Y');
                                    } elseif (is_year()) {
                                        echo get_the_time('Y');
                                    }
                                } elseif (is_home()) {
                                    Egns\Helper\Egns_Helper::egns_translate('Blog');
                                } else {
                                    the_title();
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
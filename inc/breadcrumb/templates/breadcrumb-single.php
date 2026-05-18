<?php

use Egns\Inc\Header_Helper;
use Egns\Helper\Egns_Helper;

$enable_breadcrumb_by_theme = Egns_Helper::egns_get_theme_option('breadcrumb_enable');
$breadcrumb_enable_by_page  = Egns_Helper::egns_page_option_value('breadcrumb_enable_page');

// Heading override logic
$breadcrumb_heading         = Egns_Helper::egns_get_theme_option('breadcrumb_heading') ?? '';
$breadcrumb_page_heading    = Egns_Helper::egns_page_option_value('breadcrumb_page_heading') ?? '';

// final values (page override > theme)
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
                            // Priority: 1) the_title() 2) custom heading fallback
                            if (! empty(get_the_title())) {
                                the_title();
                            } elseif (! empty($breadcrumb_display_heading)) {
                                echo wp_kses_post($breadcrumb_display_heading);
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
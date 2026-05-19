<?php

get_header();

if (!is_front_page()) {
    // Include breadcrumb template
    Egns\Helper\Egns_Helper::egns_template_part('breadcrumb', 'templates/breadcrumb-single');
}

?>

<div class="case-study-details-section mt-120 mb-120">
    <?php
    while (have_posts()) {
        the_post();
        the_content();
    }
    ?>
</div>

<?php
get_footer();

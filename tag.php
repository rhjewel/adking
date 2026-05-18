<?php

/**
 * The template for displaying tag archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package adking
 */

get_header();

if (!is_front_page()) {
    // Include breadcrumb template
    Egns\Helper\Egns_Helper::egns_template_part('breadcrumb', 'templates/breadcrumb-archive');
}

?>
<div class="home1-blog-section mt-140 mb-140">
    <div class="container">
        <div class="row gy-5">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();

                    if (Egns\Helper\Egns_Helper::egns_check_template_part('blog', 'templates/single/post/post', get_post_format())) {

                        echo apply_filters('egns_filter_blog_single_template', Egns\Helper\Egns_Helper::egns_get_template_part('blog', 'templates/grid/post/post', get_post_format() ? get_post_format() : 'default'));
                    } else {

                        echo apply_filters('egns_filter_blog_single_template', Egns\Helper\Egns_Helper::egns_get_template_part('blog', 'templates/grid/post/post', 'default'));
                    }
                }; // End of the loop.

            } else {
                // Include global posts not found
                Egns\Helper\Egns_Helper::egns_template_part('content', 'templates/posts-not-found');
            }
            ?>
        </div>
        <?php
        // Get the total number of pages.
        $total_pages = Egns\Inc\Blog_Helper::get_total_pages();
        // Only paginate if there are multiple pages.
        if ($total_pages > 1) {
            $current_page = max(1, get_query_var('paged'));
        ?>
            <div class="row justify-content-center mt-70">
                <div class="col-lg-8">
                    <div class="pagination-area">
                        <?php if ($current_page > 1): ?>
                            <div class="paginations-button">
                                <a href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>">
                                    <svg width="7" height="14" viewBox="0 0 7 14"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 7.00008L7 0L2.54545 7.00008L7 14L0 7.00008Z" />
                                    </svg>
                                    <?php echo esc_html__('Prev', 'adking') ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php
                        // Pagination
                         Egns\Inc\Blog_Helper::egns_pagination();
                        ?>
                        <?php if ($current_page < $total_pages): ?>
                            <div class="paginations-button">
                                <a href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>">
                                    <?php echo esc_html__('Next', 'adking') ?>
                                    <svg width="7" height="14" viewBox="0 0 7 14"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 7.00008L0 0L4.45455 7.00008L0 14L7 7.00008Z" />
                                    </svg>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php

get_footer();

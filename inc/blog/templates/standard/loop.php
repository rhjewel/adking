<div class="blog-standard-page mt-120 mb-120">
    <div class="container one">
        <div class="row gy-5 justify-content-between">
            <div class="<?php echo esc_attr(is_active_sidebar('blog_sidebar') ? 'col-xl-7 col-lg-8' : 'col-lg-10'); ?>">
                <?php
                if (have_posts()) {
                    while (have_posts()) : the_post();
                        // Include blog standard
                        if (is_single()) {
                            if (Egns\Helper\Egns_Helper::egns_check_template_part('blog', 'templates/single/post/post', get_post_format())) {
                                echo apply_filters('egns_filter_blog_single_template', Egns\Helper\Egns_Helper::egns_get_template_part('blog', 'templates/single/post/post', get_post_format() ? get_post_format() : 'default'));
                            } else {
                                echo apply_filters('egns_filter_blog_single_template', Egns\Helper\Egns_Helper::egns_get_template_part('blog', 'templates/single/post/post', 'default'));
                            }
                        } else {
                            if (Egns\Helper\Egns_Helper::egns_check_template_part('blog', 'templates/single/post/post', get_post_format())) {
                                echo apply_filters('egns_filter_blog_single_template', Egns\Helper\Egns_Helper::egns_get_template_part('blog', 'templates/standard/post/post', get_post_format() ? get_post_format() : 'default'));
                            } else {
                                echo apply_filters('egns_filter_blog_single_template', Egns\Helper\Egns_Helper::egns_get_template_part('blog', 'templates/standard/post/post', 'default'));
                            }
                        }
                    endwhile; // End of the loop.
                } else {
                    // Include global posts not found
                    Egns\Helper\Egns_Helper::egns_template_part('content', 'templates/posts-not-found');
                }
                wp_reset_postdata();
                ?>
            </div>
            <?php if (is_active_sidebar('blog_sidebar')): ?>
                <div class="col-lg-4 fade_anim" data-delay=".3" data-fade-from="right">
                    <div class="blog-sidebar-area">
                        <?php
                        // Include page content sidebar
                        Egns\Helper\Egns_Helper::egns_template_part('sidebar', 'templates/sidebar');
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php
        // Get the total number of pages.
        $total_pages = Egns\Inc\Blog_Helper::get_total_pages();
        // Only paginate if there are multiple pages.
        if ($total_pages > 1) {
            $current_page = max(1, get_query_var('paged'));
        ?>
            <div class="row mt-70">
                <div class="<?php echo esc_attr(is_active_sidebar('blog_sidebar') ? 'col-xl-7 col-lg-8' : 'col-lg-10'); ?>">
                    <div class="inner-pagination-area fade_anim" data-delay=".2" data-ease="bounce">
                        <?php if ($current_page > 1): ?>
                            <div class="paginations-button">
                                <a href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>">
                                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path d="M2.22201 5L8.88867 10V0L2.22201 5Z" />
                                        </g>
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
                                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path d="M8.88932 5L2.22266 10L2.22266 0L8.88932 5Z" />
                                        </g>
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
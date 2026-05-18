<?php

/**
 * The main template file
 *
 * Template Name: Blog Grid Template
 *
 * @link https:   //developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package adking
 * @since 1.0.0
 * 
 */

get_header();

if (!is_front_page()):
    // Include breadcrumb template
    Egns\Helper\Egns_Helper::egns_template_part('breadcrumb', 'templates/breadcrumb-archive');
endif;

?>

<div class="home1-blog-section mb-120">
    <div class="container">
        <div class="row gy-5 justify-content-center">
            <div class="<?php echo esc_attr(is_active_sidebar('blog_sidebar') ? 'col-lg-8' : 'col-lg-10'); ?>">
                <div class="row gy-5 gx-xl-4 gx-3 mb-100">
                    <?php
                    $args = array(
                        'post_type'      => 'post',
                        'order'          => 'DESC',
                        'post_status'    => 'publish',
                        'posts_per_page' => 6,
                        'paged'          => (get_query_var('paged')) ? get_query_var('paged') : 1
                    );
                    $blog_query = new WP_Query($args);

                    if ($blog_query->have_posts()) {
                        while ($blog_query->have_posts()) {
                            $blog_query->the_post();
                            echo apply_filters('egns_filter_blog_single_template', Egns\Helper\Egns_Helper::egns_get_template_part('blog', 'templates/grid/post/post', get_post_format() ? get_post_format() : 'default'));
                        }; // End of the loop.
                        wp_reset_postdata();
                    } else {
                        // Include global posts not found
                        Egns\Helper\Egns_Helper::egns_template_part('content', 'templates/posts-not-found');
                    }
                    ?>
                </div>
                <?php
                $total_pages = Egns\Inc\Blog_Helper::get_total_pages();

                if ($total_pages > 1) :
                    $current_page = max(1, get_query_var('paged'));
                ?>
                    <div class="row justify-content-center mt-70">
                        <div class="inner-pagination-area fade_anim" data-delay=".2" data-ease="bounce">
                            <?php if ($current_page > 1) : ?>
                                <div class="paginations-button">
                                    <a href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>">
                                        <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="M2.22201 5L8.88867 10V0L2.22201 5Z" />
                                            </g>
                                        </svg>
                                        <?php echo esc_html__('Prev', 'adking'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php Egns\Inc\Blog_Helper::egns_pagination(); ?>

                            <?php if ($current_page < $total_pages) : ?>
                                <div class="paginations-button">
                                    <a href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>">
                                        <?php echo esc_html__('Next', 'adking'); ?>
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
                <?php endif; ?>
            </div>
            <?php if (is_active_sidebar('blog_sidebar')): ?>
                <div class="col-lg-4">
                    <div class="news-article-sidebar-area">
                        <?php
                        // Include page content sidebar
                        Egns\Helper\Egns_Helper::egns_template_part('sidebar', 'templates/sidebar');
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>
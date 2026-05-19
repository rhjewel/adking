<?php

/**
 * The template for displaying archive pages
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

<div class="case-study-section mt-120 mb-120">
    <div class="container">
        <div class="row gy-5 g-4">
            <?php if (have_posts()) : ?>
                <?php
                while (have_posts()) :
                    the_post();

                    $case_study_terms = get_the_terms(get_the_ID(), 'case-study-category');
                    $case_study_term  = (!empty($case_study_terms) && !is_wp_error($case_study_terms)) ? $case_study_terms[0] : null;
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="case-study-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="case-study-img hover-img">
                                    <?php the_post_thumbnail('large', array('alt' => the_title_attribute(array('echo' => false)))); ?>
                                </a>
                            <?php endif; ?>
                            <div class="case-study-content">
                                <?php if ($case_study_term) : ?>
                                    <span><?php echo esc_html($case_study_term->name); ?></span>
                                <?php endif; ?>
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <?php if (get_the_excerpt()) : ?>
                                    <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 16)); ?></p>
                                <?php endif; ?>
                                <a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html__('View Details', 'adking'); ?> <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12">
                    <?php Egns\Helper\Egns_Helper::egns_template_part('content', 'templates/posts-not-found'); ?>
                </div>
            <?php endif; ?>
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
</div>

<?php
get_footer();

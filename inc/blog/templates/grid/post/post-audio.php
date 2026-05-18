<?php
$excerpt         = wp_trim_words(get_the_excerpt(), 16, '...');
$category_list   = get_the_category();
$category_name   = !empty($category_list) ? $category_list[0]->name : '';
$category_link   = !empty($category_list) ? get_category_link($category_list[0]->term_id) : '';
?>
<div class="col-lg-4 col-md-6 fade_anim" data-delay=".2">
    <div id="post-<?php the_ID(); ?>" <?php post_class('blog-card two'); ?>>
        <div class="blog-content">
            <?php if (!empty($category_name)) : ?>
                <a href="<?php echo esc_url($category_link); ?>" class="category">
                    <svg width="13" height="13" viewBox="0 0 13 13" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 0H6L0 13H7L13 0Z" />
                    </svg>
                    <?php echo esc_html($category_name); ?>
                </a>
            <?php endif; ?>
            <h2>
                <a href="<?php echo get_permalink(); ?>">
                    <?php echo get_the_title(); ?>
                </a>
            </h2>
            <?php
            Egns\Helper\Egns_Helper::egns_template_part('blog', 'templates/grid/parts/audio');
            ?>
            <p><?php echo esc_html($excerpt); ?></p>
            <a href="<?php echo get_permalink(); ?>" class="read-more-btn">
                <?php echo esc_html__('Read more', 'adking'); ?>
                <svg width="9" height="9" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path d="M8 4.5L2 9L2 0L8 4.5Z"></path>
                    </g>
                </svg>
            </a>
        </div>
    </div>
</div>
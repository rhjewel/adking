<?php

$categories = get_the_category();
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
    <?php
    Egns\Helper\Egns_Helper::egns_template_part('blog', 'templates/standard/parts/audio');
    ?>
    <div class="blog-content">
        <a href="<?php echo esc_url(home_url(get_the_date('Y/m/d'))) ?>" class="category">
            <svg width="13" height="13" viewBox="0 0 13 13" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 0H6L0 13H7L13 0Z" />
            </svg>
            <?php echo get_the_date('d F, Y'); ?>
        </a>
        <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
        <?php the_excerpt() ?>
    </div>
</div>
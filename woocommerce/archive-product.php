<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header();

if (!is_front_page()) {
	// Include breadcrumb template
	Egns\Helper\Egns_Helper::egns_template_part('breadcrumb', 'templates/breadcrumb-archive');
}

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

global $wp_query;

$current_page = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
$max_pages    = isset($wp_query->max_num_pages) ? (int) $wp_query->max_num_pages : 1;
$query_vars   = isset($wp_query->query_vars) && is_array($wp_query->query_vars) ? $wp_query->query_vars : array();
$query_json   = wp_json_encode($query_vars);
?>
<div class="adking-woocommerce-archive">
	<div class="row gy-5 adking-product-results">
		<?php if (woocommerce_product_loop()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php global $product; ?>
				<?php do_action('egns_aventis_shop_page_product_card'); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php do_action('egns_aventis_shop_page_no_products'); ?>
		<?php endif; ?>
	</div>

	<?php if (woocommerce_product_loop() && $current_page < $max_pages && !empty($query_json)) : ?>
		<div class="row">
			<div class="col-12 text-center mt-60">
				<button
					type="button"
					class="primary-btn1 adking-product-load-more"
					data-page="<?php echo esc_attr($current_page); ?>"
					data-max-pages="<?php echo esc_attr($max_pages); ?>"
					data-query="<?php echo esc_attr($query_json); ?>"
					data-text="<?php echo esc_attr__('Load More', 'adking'); ?>"
					data-loading-text="<?php echo esc_attr__('Loading...', 'adking'); ?>">
					<?php echo esc_html__('Load More', 'adking'); ?>
				</button>
			</div>
		</div>
	<?php endif; ?>
</div>


<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');


get_footer();

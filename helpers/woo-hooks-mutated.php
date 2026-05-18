<?php
/*-------------------------
**** WooCommerce Hooks ****
--------------------------*/

use Egns\Helper\Egns_Helper;

if (class_exists('WooCommerce')) {
    global $product;

    /**
     * 
     * WooCommerce before, after wrapper div change
     * 
     * */
    function aventis_wrapper_start()
    {
        echo '<div class="shop-page-wrapper mt-120 mb-120">
    <div class="container">';
    }

    function aventis_wrapper_end()
    {
        echo '</div>
	</div>';
    }
    add_action('woocommerce_before_main_content', 'aventis_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'aventis_wrapper_end', 10);

    /**
     * remove default woocommerce sidebar
     */
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

    /**
     * remove default breadcrumb product
     */
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

    /**
     * remove default product content wrapper
     */
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    /** 
     * Remove sale badge from single product page
     */
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

    /**
     * remove default related_products
     */
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

    /**
     * Show quantity minus button
     */
    function aventis_display_quantity_minus()
    {
        echo '<button type="button" class="minus" aria-label="' . esc_attr__('Decrease quantity', 'adking') . '"><i class="bi bi-dash"></i></button>';
    }
    add_action('woocommerce_before_quantity_input_field', 'aventis_display_quantity_minus');

    /**
     * Show quantity plus button
     */
    function aventis_display_quantity_plus()
    {
        echo '<button type="button" class="plus" aria-label="' . esc_attr__('Increase quantity', 'adking') . '"><i class="bi bi-plus"></i></button>';
    }
    add_action('woocommerce_after_quantity_input_field', 'aventis_display_quantity_plus');

    /**
     * Set default quantity only for single product page if empty
     */
    function aventis_set_default_quantity($args, $product)
    {
        if (is_product() && empty($args['input_value'])) {
            $args['input_value'] = max(1, isset($args['min_value']) ? (float) $args['min_value'] : 1);
        }

        return $args;
    }
    add_filter('woocommerce_quantity_input_args', 'aventis_set_default_quantity', 10, 2);

    /**
     * Quantity plus/minus script
     */
    function aventis_add_cart_quantity_plus_minus()
    {
        if (!function_exists('is_woocommerce') || (!is_woocommerce() && !is_cart() && !is_checkout() && !defined('YITH_WCQV'))) {
            return;
        }

        wc_enqueue_js("
        jQuery(function($){
            $(document).on('click', '.quantity .plus, .quantity .minus', function() {
                var \$qty  = $(this).closest('.quantity').find('.qty');
                var currentVal = parseFloat(\$qty.val());
                var max  = parseFloat(\$qty.attr('max'));
                var min  = parseFloat(\$qty.attr('min'));
                var step = parseFloat(\$qty.attr('step'));
                if (isNaN(currentVal)) {
                    currentVal = 0;
                }
                if (isNaN(step) || step <= 0) {
                    step = 1;
                }
                if (isNaN(min)) {
                    min = 0;
                }
                if (isNaN(max)) {
                    max = '';
                }
                if ($(this).hasClass('plus')) {
                    if (max !== '' && currentVal >= max) {
                        \$qty.val(max);
                    } else {
                        \$qty.val((currentVal + step).toFixed(step % 1 !== 0 ? 2 : 0));
                    }
                } else {
                    if (currentVal <= min) {
                        \$qty.val(min);
                    } else {
                        \$qty.val((currentVal - step).toFixed(step % 1 !== 0 ? 2 : 0));
                    }
                }
                \$qty.trigger('change');
            });
        });
    ");
    }
    add_action('wp_footer', 'aventis_add_cart_quantity_plus_minus');

    /**
     * Remove default WooCommerce archive item parts
     */
    function egns_aventis_remove_woocommerce_hooks()
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        if (is_shop() || is_product_category() || is_product_tag()) {
            remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        }
    }
    add_action('wp', 'egns_aventis_remove_woocommerce_hooks');


    function egns_aventis_product_card_rating($product)
    {
        $average      = (float) $product->get_average_rating();
        $review_count = (int) $product->get_review_count();
    ?>
        <div class="rating">
            <ul>
                <?php for ($star = 1; $star <= 5; $star++) : ?>
                    <li><i class="bi <?php echo $average >= $star ? 'bi-star-fill' : 'bi-star'; ?>"></i></li>
                <?php endfor; ?>
            </ul>
            <span>(<?php echo esc_html($review_count); ?>)</span>
        </div>
    <?php
    }

    function egns_aventis_wishlist_icon_svg()
    {
    ?>
        <svg class="heart-outline" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <g><path d="M16.528 2.20919C16.0674 1.71411 15.5099 1.31906 14.8902 1.04859C14.2704 0.778112 13.6017 0.637996 12.9255 0.636946C12.2487 0.637725 11.5794 0.777639 10.959 1.048C10.3386 1.31835 9.78042 1.71338 9.31911 2.20854L9.00132 2.54436L8.68352 2.20854C6.83326 0.217151 3.71893 0.102789 1.72758 1.95306C1.63932 2.03507 1.5541 2.12029 1.47209 2.20854C-0.490696 4.32565 -0.490696 7.59753 1.47209 9.71463L8.5343 17.1622C8.77862 17.4201 9.18579 17.4312 9.44373 17.1868C9.45217 17.1788 9.46039 17.1706 9.46838 17.1622L16.528 9.71463C18.4907 7.59776 18.4907 4.32606 16.528 2.20919ZM15.5971 8.82879H15.5965L9.00132 15.7849L2.40553 8.82879C0.90608 7.21113 0.90608 4.7114 2.40553 3.09374C3.76722 1.61789 6.06755 1.52535 7.5434 2.88703C7.61505 2.95314 7.68401 3.0221 7.75012 3.09374L8.5343 3.92104C8.79272 4.17781 9.20995 4.17781 9.46838 3.92104L10.2526 3.09438C11.6142 1.61853 13.9146 1.52599 15.3904 2.88767C15.4621 2.95378 15.531 3.02274 15.5971 3.09438C17.1096 4.71461 17.1207 7.2189 15.5971 8.82879Z" /></g>
        </svg>
        <svg class="heart-filled" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M16.528 2.20919C16.0674 1.71411 15.5099 1.31906 14.8902 1.04859C14.2704 0.778112 13.6017 0.637996 12.9255 0.636946C12.2487 0.637725 11.5794 0.777639 10.959 1.048C10.3386 1.31835 9.78042 1.71338 9.31911 2.20854L9.00132 2.54436L8.68352 2.20854C6.83326 0.217151 3.71893 0.102789 1.72758 1.95306C1.63932 2.03507 1.5541 2.12029 1.47209 2.20854C-0.490696 4.32565 -0.490696 7.59753 1.47209 9.71463L8.5343 17.1622C8.77862 17.4201 9.18579 17.4312 9.44373 17.1868C9.45217 17.1788 9.46039 17.1706 9.46838 17.1622L16.528 9.71463C18.4907 7.59776 18.4907 4.32606 16.528 2.20919Z" />
        </svg>
    <?php
    }

    function egns_aventis_quick_view_icon_svg()
    {
    ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
            <path d="M21.8601 10.5721C21.6636 10.3032 16.9807 3.98901 10.9999 3.98901C5.019 3.98901 0.335925 10.3032 0.139601 10.5718C0.0488852 10.6961 0 10.846 0 10.9999C0 11.1537 0.0488852 11.3036 0.139601 11.4279C0.335925 11.6967 5.019 18.011 10.9999 18.011C16.9807 18.011 21.6636 11.6967 21.8601 11.4281C21.951 11.3039 21.9999 11.154 21.9999 11.0001C21.9999 10.8462 21.951 10.6963 21.8601 10.5721ZM10.9999 16.5604C6.59432 16.5604 2.77866 12.3696 1.64914 10.9995C2.77719 9.62823 6.58487 5.43955 10.9999 5.43955C15.4052 5.43955 19.2206 9.62969 20.3506 11.0005C19.2225 12.3717 15.4149 16.5604 10.9999 16.5604Z" />
            <path d="M10.9999 6.64832C8.60039 6.64832 6.64819 8.60051 6.64819 11C6.64819 13.3994 8.60039 15.3516 10.9999 15.3516C13.3993 15.3515 15.3515 13.3994 15.3515 11C15.3515 8.60051 13.3993 6.64832 10.9999 6.64832ZM10.9999 13.9011C9.40013 13.9011 8.09878 12.5997 8.09878 11C8.09878 9.40029 9.40017 8.0989 10.9999 8.0989C12.5995 8.0989 13.9009 9.40029 13.9009 11C13.9009 12.5997 12.5996 13.9011 10.9999 13.9011Z" />
        </svg>
    <?php
    }

    function egns_aventis_product_card_wishlist_button($product_object)
    {
        $product_id   = $product_object->get_id();
        $product_type = $product_object->get_type();
        $exists       = function_exists('yith_wcwl_wishlists') ? yith_wcwl_wishlists()->is_product_in_wishlist($product_id) : false;

        if (defined('YITH_WCWL') && function_exists('YITH_WCWL')) {
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            $button_url   = $exists ? $wishlist_url : YITH_WCWL()->get_add_to_wishlist_url($product_id);
            $button_class = $exists ? 'yith-wcwl-wishlistaddedbrowse' : 'add_to_wishlist single_add_to_wishlist';
            $aria_label   = $exists ? esc_attr__('Browse wishlist', 'adking') : esc_attr__('Add to wishlist', 'adking');
        } else {
            $button_url   = add_query_arg('add-to-wishlist', $product_id, get_permalink($product_id));
            $button_class = '';
            $aria_label   = esc_attr__('Add to wishlist', 'adking');
        }
    ?>
        <li class="wishlist yith-wcwl-add-button add-to-wishlist-<?php echo esc_attr($product_id); ?><?php echo $exists ? ' exists' : ''; ?>">
            <a
                href="<?php echo esc_url($button_url); ?>"
                class="<?php echo esc_attr($button_class); ?>"
                data-product-id="<?php echo esc_attr($product_id); ?>"
                data-product-type="<?php echo esc_attr($product_type); ?>"
                data-original-product-id="<?php echo esc_attr($product_object->get_parent_id()); ?>"
                data-title="<?php echo esc_attr($aria_label); ?>"
                aria-label="<?php echo esc_attr($aria_label); ?>"
                rel="nofollow">
                <?php egns_aventis_wishlist_icon_svg(); ?>
            </a>
        </li>
    <?php
    }

    function egns_aventis_product_card_quick_view_button($product_object)
    {
        $product_id        = $product_object->get_id();
        $product_permalink = get_permalink($product_id);
        $is_quick_view     = defined('YITH_WCQV');
    ?>
        <li class="quick-view">
            <a
                href="<?php echo esc_url($is_quick_view ? '#' : $product_permalink); ?>"
                class="<?php echo esc_attr($is_quick_view ? 'button yith-wcqv-button' : ''); ?>"
                data-product_id="<?php echo esc_attr($product_id); ?>"
                aria-label="<?php echo esc_attr__('Quick view', 'adking'); ?>">
                <?php egns_aventis_quick_view_icon_svg(); ?>
            </a>
        </li>
    <?php
    }

    function egns_aventis_product_card($product_object = null, $wrapper_class = 'col-lg-4 col-md-6')
    {
        if (!$product_object) {
            global $product;
            $product_object = $product;
        }

        if (!$product_object || !is_a($product_object, 'WC_Product')) {
            return;
        }

        $product_id        = $product_object->get_id();
        $product_title     = $product_object->get_name();
        $product_permalink = get_permalink($product_id);
        $product_price     = $product_object->get_price_html();
        $primary_image     = wp_get_attachment_image_url($product_object->get_image_id(), 'woocommerce_thumbnail');
        $gallery_ids       = $product_object->get_gallery_image_ids();
        $secondary_image   = !empty($gallery_ids) ? wp_get_attachment_image_url($gallery_ids[0], 'woocommerce_thumbnail') : '';
        $primary_image     = $primary_image ? $primary_image : wc_placeholder_img_src('woocommerce_thumbnail');
        $secondary_image   = $secondary_image ? $secondary_image : $primary_image;
        $image_alt         = get_post_meta($product_object->get_image_id(), '_wp_attachment_image_alt', true);
        $image_alt         = $image_alt ? $image_alt : $product_title;
        $categories        = wc_get_product_category_list($product_id, ', ');
        $price_label       = $product_object->is_type('variable') ? esc_html__('Starting From :', 'adking') : esc_html__('Price :', 'adking');

        $button_classes = implode(' ', array_filter(array(
            'hover-btn3',
            'add-cart-btn',
            'button',
            'product_type_' . $product_object->get_type(),
            $product_object->is_purchasable() && $product_object->is_in_stock() ? 'add_to_cart_button' : '',
            $product_object->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : '',
        )));

        $add_to_cart_attrs = array(
            'href'              => $product_object->add_to_cart_url(),
            'data-quantity'     => '1',
            'data-product_id'   => $product_id,
            'data-product_sku'  => $product_object->get_sku(),
            'aria-label'        => $product_object->add_to_cart_description(),
            'rel'               => 'nofollow',
        );
    ?>

        <?php if (!empty($wrapper_class)) : ?>
            <div class="<?php echo esc_attr($wrapper_class); ?>">
        <?php endif; ?>
            <div class="product-card hover-btn">
                <div class="product-card-img double-img">
                    <a href="<?php echo esc_url($product_permalink); ?>">
                        <img src="<?php echo esc_url($primary_image); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="img1">
                        <img src="<?php echo esc_url($secondary_image); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="img2">
                    </a>
                    <div class="overlay">
                        <div class="cart-area">
                            <a class="<?php echo esc_attr($button_classes); ?>" <?php foreach ($add_to_cart_attrs as $attr => $value) : ?> <?php echo esc_attr($attr); ?>="<?php echo esc_attr($value); ?>"<?php endforeach; ?>>
                                <i class="bi bi-bag-check"></i><?php echo esc_html($product_object->add_to_cart_text()); ?>
                            </a>
                        </div>
                    </div>
                    <div class="view-and-favorite-area">
                        <ul>
                            <?php egns_aventis_product_card_wishlist_button($product_object); ?>
                            <?php egns_aventis_product_card_quick_view_button($product_object); ?>
                        </ul>
                    </div>
                </div>
                <div class="product-card-content">
                    <h6><a href="<?php echo esc_url($product_permalink); ?>" class="hover-underline"><?php echo esc_html($product_title); ?></a></h6>
                    <?php if (!empty($categories)) : ?>
                        <p><?php echo wp_kses_post($categories); ?></p>
                    <?php endif; ?>
                    <span><?php echo esc_html($price_label); ?></span>
                    <div class="price-and-rating">
                        <p class="price"><?php echo wp_kses_post($product_price); ?></p>
                        <?php egns_aventis_product_card_rating($product_object); ?>
                    </div>
                </div>
                <span class="for-border"></span>
            </div>
        <?php if (!empty($wrapper_class)) : ?>
            </div>
        <?php endif; ?>

    <?php
    }

    /**
     * Archive page product card
     */
    function egns_aventis_shop_product_card()
    {
        global $product;

        egns_aventis_product_card($product, 'col-lg-4 col-md-6');
    }
    add_action('egns_aventis_shop_page_product_card', 'egns_aventis_shop_product_card');



    /**
     * Add Custom WooCommerce Related Product card
     */
    function egns_woocommerce_related_products($current_product_id, $limit = 8)
    {
        if (!$current_product_id || !class_exists('WooCommerce')) {
            return;
        }

        $related_ids = wc_get_related_products($current_product_id, $limit);

        if (empty($related_ids)) {
            return;
        }

        $args = array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'posts_per_page'      => $limit,
            'post__in'            => $related_ids,
            'orderby'             => 'post__in',
            'ignore_sticky_posts' => 1,
        );

        $related_products = new WP_Query($args);

        if (!$related_products->have_posts()) {
            wp_reset_postdata();
            return;
        }
    ?>
        <div class="related-product-section mt-100">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3><?php echo esc_html__('Related Product', 'adking'); ?></h3>
                    </div>
                </div>
            </div>
            <div class="related-product-slider-area">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper related-product-slider">
                            <div class="swiper-wrapper">
                                <?php while ($related_products->have_posts()) : $related_products->the_post(); ?>
                                    <?php egns_aventis_product_card(wc_get_product(get_the_ID()), 'swiper-slide'); ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-btn-grp two">
                    <div class="slider-btn related-product-slider-prev">
                        <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path d="M2 6L10 12V0L2 6Z" />
                            </g>
                        </svg>
                    </div>
                    <div class="slider-btn related-product-slider-next">
                        <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path d="M10.6665 6L2.6665 12L2.6665 0L10.6665 6Z" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    <?php
        wp_reset_postdata();
    }

    function egns_related_products_output()
    {
        global $product;

        if (!$product || !is_a($product, 'WC_Product')) {
            return;
        }
        egns_woocommerce_related_products($product->get_id(), 8);
    }
    add_action('woocommerce_after_single_product_summary', 'egns_related_products_output', 20);

    /**
     * Archive product load more AJAX.
     */
    function egns_aventis_archive_load_more()
    {
        check_ajax_referer('ajax-nonce', 'nonce');

        $page      = isset($_POST['page']) ? max(1, absint($_POST['page'])) : 1;
        $raw_query = isset($_POST['query']) ? wp_unslash($_POST['query']) : '';
        $query     = json_decode($raw_query, true);

        if (!is_array($query)) {
            wp_send_json_error(array(
                'message' => esc_html__('Invalid product query.', 'adking'),
            ));
        }

        $query = wc_clean($query);
        unset($query['p'], $query['page_id'], $query['name']);

        $query['post_type']           = 'product';
        $query['post_status']         = 'publish';
        $query['paged']               = $page;
        $query['ignore_sticky_posts'] = 1;

        if (empty($query['posts_per_page'])) {
            $query['posts_per_page'] = (int) get_option('posts_per_page');
        }

        $products = new WP_Query($query);

        ob_start();
        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                egns_aventis_product_card(wc_get_product(get_the_ID()), 'col-lg-4 col-md-6');
            }
        }
        wp_reset_postdata();

        wp_send_json_success(array(
            'html'      => ob_get_clean(),
            'page'      => $page,
            'max_pages' => (int) $products->max_num_pages,
            'has_more'  => $page < (int) $products->max_num_pages,
        ));
    }
    add_action('wp_ajax_egns_aventis_archive_load_more', 'egns_aventis_archive_load_more');
    add_action('wp_ajax_nopriv_egns_aventis_archive_load_more', 'egns_aventis_archive_load_more');

    function egns_adking_header_wishlist_count()
    {
        if (function_exists('yith_wcwl_count_all_products')) {
            return (int) yith_wcwl_count_all_products();
        }

        return 0;
    }

    function egns_adking_header_wishlist_url()
    {
        if (defined('YITH_WCWL') && function_exists('YITH_WCWL')) {
            return YITH_WCWL()->get_wishlist_url();
        }

        return wc_get_page_permalink('shop');
    }

    function egns_adking_header_cart_count()
    {
        return WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
    }

    function egns_adking_header_cart_dropdown()
    {
        if (!WC()->cart) {
            return;
        }
    ?>
        <div class="cart-menu adking-header-cart-menu">
            <div class="cart-body">
                <?php if (!WC()->cart->is_empty()) : ?>
                    <ul>
                        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
                            <?php
                            $cart_product = isset($cart_item['data']) && $cart_item['data'] instanceof WC_Product ? $cart_item['data'] : null;

                            if (!$cart_product || !$cart_product->exists() || $cart_item['quantity'] <= 0) {
                                continue;
                            }

                            $product_id = $cart_product->get_id();
                            ?>
                            <li class="single-item">
                                <div class="item-area">
                                    <div class="item-img">
                                        <a href="<?php echo esc_url($cart_product->is_visible() ? $cart_product->get_permalink($cart_item) : '#'); ?>">
                                            <?php echo wp_kses_post($cart_product->get_image('woocommerce_thumbnail')); ?>
                                        </a>
                                    </div>
                                    <div class="content-and-quantity">
                                        <div class="content">
                                            <div class="price-and-btn d-flex align-items-center justify-content-between">
                                                <span><?php echo wp_kses_post(WC()->cart->get_product_price($cart_product)); ?></span>
                                                <a class="close-btn remove remove_from_cart_button" href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" aria-label="<?php echo esc_attr__('Remove this item', 'adking'); ?>" data-product_id="<?php echo esc_attr($product_id); ?>" data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>" data-product_sku="<?php echo esc_attr($cart_product->get_sku()); ?>">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                            </div>
                                            <p><a href="<?php echo esc_url($cart_product->is_visible() ? $cart_product->get_permalink($cart_item) : '#'); ?>"><?php echo esc_html($cart_product->get_name()); ?></a></p>
                                        </div>
                                        <div class="quantity-area">
                                            <div class="quantity">
                                                <span class="quantity__input"><?php echo esc_html(sprintf('%02d', (int) $cart_item['quantity'])); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="adking-header-cart-empty"><?php echo esc_html__('Your cart is empty.', 'adking'); ?></p>
                <?php endif; ?>
            </div>
            <div class="cart-footer">
                <div class="pricing-area">
                    <ul class="total">
                        <li><span><?php echo esc_html__('Subtotal', 'adking'); ?></span><span><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?></span></li>
                    </ul>
                </div>
                <div class="footer-button">
                    <ul>
                        <li><a class="primary-btn1 hover-btn4" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php echo esc_html__('Continue Shopping', 'adking'); ?></a></li>
                        <li><a class="primary-btn1 hover-btn3" href="<?php echo esc_url(wc_get_checkout_url()); ?>"><?php echo esc_html__('Product Checkout', 'adking'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    <?php
    }

    function egns_adking_header_nav_right()
    {
        $cart_count     = egns_adking_header_cart_count();
        $wishlist_count = egns_adking_header_wishlist_count();
    ?>
        <div class="nav-right position-inherit d-flex jsutify-content-end align-items-center adking-header-nav-right">
            <div class="dropdown">
                <button type="button" class="modal-btn header-cart-btn" aria-label="<?php echo esc_attr__('View cart', 'adking'); ?>">
                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.0139 18H3.98532C1.86389 18 0.128174 16.2643 0.128174 14.1429V14.0143L0.513888 3.72857C0.578174 1.60714 2.31389 0 4.37103 0H13.6282C15.6853 0 17.421 1.60714 17.4853 3.72857L17.871 14.0143C17.9353 15.0429 17.5496 16.0071 16.8425 16.7786C16.1353 17.55 15.171 18 14.1425 18H14.0139ZM4.37103 1.28571C2.95675 1.28571 1.86389 2.37857 1.7996 3.72857L1.41389 14.1429C1.41389 15.5571 2.57103 16.7143 3.98532 16.7143H14.1425C14.8496 16.7143 15.4925 16.3929 15.9425 15.8786C16.3925 15.3643 16.6496 14.7214 16.6496 14.0143L16.2639 3.72857C16.1996 2.31429 15.1067 1.28571 13.6925 1.28571H4.37103Z" />
                        <path d="M8.99951 7.71427C6.49237 7.71427 4.49951 5.72141 4.49951 3.21427C4.49951 2.82855 4.75665 2.57141 5.14237 2.57141C5.52808 2.57141 5.78523 2.82855 5.78523 3.21427C5.78523 5.01427 7.19951 6.42855 8.99951 6.42855C10.7995 6.42855 12.2138 5.01427 12.2138 3.21427C12.2138 2.82855 12.4709 2.57141 12.8567 2.57141C13.2424 2.57141 13.4995 2.82855 13.4995 3.21427C13.4995 5.72141 11.5067 7.71427 8.99951 7.71427Z" />
                    </svg>
                    <span class="adking-header-cart-count"><?php echo esc_html(sprintf('%02d', $cart_count)); ?></span>
                </button>
                <?php egns_adking_header_cart_dropdown(); ?>
            </div>
            <div class="save-btn">
                <a href="<?php echo esc_url(egns_adking_header_wishlist_url()); ?>" aria-label="<?php echo esc_attr__('View wishlist', 'adking'); ?>">
                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_68_10)">
                            <path d="M16.528 2.20922C16.0674 1.71414 15.5099 1.31909 14.8902 1.04862C14.2704 0.778143 13.6017 0.638026 12.9255 0.636976C12.2487 0.637756 11.5794 0.777669 10.959 1.04803C10.3386 1.31839 9.78042 1.71341 9.31911 2.20857L9.00132 2.54439L8.68352 2.20857C6.83326 0.217182 3.71893 0.102819 1.72758 1.95309C1.63932 2.0351 1.5541 2.12032 1.47209 2.20857C-0.490696 4.32568 -0.490696 7.59756 1.47209 9.71466L8.5343 17.1622C8.77862 17.4201 9.18579 17.4312 9.44373 17.1869C9.45217 17.1789 9.46039 17.1707 9.46838 17.1622L16.528 9.71466C18.4907 7.59779 18.4907 4.32609 16.528 2.20922ZM15.5971 8.82882H15.5965L9.00132 15.7849L2.40553 8.82882C0.90608 7.21116 0.90608 4.71143 2.40553 3.09377C3.76722 1.61792 6.06755 1.52538 7.5434 2.88706C7.61505 2.95317 7.68401 3.02213 7.75012 3.09377L8.5343 3.92107C8.79272 4.17784 9.20995 4.17784 9.46838 3.92107L10.2526 3.09441C11.6142 1.61856 13.9146 1.52602 15.3904 2.8877C15.4621 2.95381 15.531 3.02277 15.5971 3.09441C17.1096 4.71464 17.1207 7.21893 15.5971 8.82882Z" />
                        </g>
                    </svg>
                    <span class="adking-header-wishlist-count"><?php echo esc_html(sprintf('%02d', $wishlist_count)); ?></span>
                </a>
            </div>
            <div class="user-login">
                <?php if (is_user_logged_in()) : ?>
                    <a class="user-btn" href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" aria-label="<?php echo esc_attr__('My account', 'adking'); ?>">
                <?php else : ?>
                    <button type="button" class="user-btn" data-bs-toggle="modal" data-bs-target="#user-login" aria-label="<?php echo esc_attr__('Login', 'adking'); ?>">
                <?php endif; ?>
                        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_122_313)">
                                <path d="M15.364 11.636C14.3837 10.6558 13.217 9.93013 11.9439 9.49085C13.3074 8.55179 14.2031 6.9802 14.2031 5.20312C14.2031 2.33413 11.869 0 9 0C6.131 0 3.79688 2.33413 3.79688 5.20312C3.79688 6.9802 4.69262 8.55179 6.05609 9.49085C4.78308 9.93013 3.61631 10.6558 2.63605 11.636C0.936176 13.3359 0 15.596 0 18H1.40625C1.40625 13.8128 4.81279 10.4062 9 10.4062C13.1872 10.4062 16.5938 13.8128 16.5938 18H18C18 15.596 17.0638 13.3359 15.364 11.636ZM9 9C6.90641 9 5.20312 7.29675 5.20312 5.20312C5.20312 3.1095 6.90641 1.40625 9 1.40625C11.0936 1.40625 12.7969 3.1095 12.7969 5.20312C12.7969 7.29675 11.0936 9 9 9Z" />
                            </g>
                        </svg>
                <?php if (is_user_logged_in()) : ?>
                    </a>
                <?php else : ?>
                    </button>
                <?php endif; ?>
            </div>
            <div class="sidebar-button mobile-menu-btn ">
                <span></span>
            </div>
        </div>
    <?php
    }

    function egns_adking_header_nav_right_html()
    {
        ob_start();
        egns_adking_header_nav_right();
        return ob_get_clean();
    }

    function egns_adking_header_nav_right_ajax()
    {
        check_ajax_referer('ajax-nonce', 'nonce');

        wp_send_json_success(array(
            'html' => egns_adking_header_nav_right_html(),
        ));
    }
    add_action('wp_ajax_egns_adking_header_nav_right', 'egns_adking_header_nav_right_ajax');
    add_action('wp_ajax_nopriv_egns_adking_header_nav_right', 'egns_adking_header_nav_right_ajax');

    function egns_adking_header_cart_fragments($fragments)
    {
        $fragments['.adking-header-nav-right'] = egns_adking_header_nav_right_html();

        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'egns_adking_header_cart_fragments');

    function egns_adking_header_nav_right_script()
    {
        wp_add_inline_script(
            'custom-main',
            "
            jQuery(function($) {
                var keepCartMenuOpen = false;

                var refreshHeaderNavRight = function() {
                    var cartMenuWasOpen = keepCartMenuOpen || $('.adking-header-cart-menu').hasClass('active');

                    $.post(localize_params.ajaxurl, {
                        action: 'egns_adking_header_nav_right',
                        nonce: localize_params.nonce
                    }).done(function(response) {
                        if (response && response.success && response.data.html) {
                            $('.adking-header-nav-right').replaceWith(response.data.html);

                            if (cartMenuWasOpen) {
                                $('.adking-header-cart-menu').addClass('active');
                            }
                        }
                    }).always(function() {
                        keepCartMenuOpen = false;
                    });
                };

                $(document).on('click', '.adking-header-cart-menu .remove_from_cart_button', function() {
                    keepCartMenuOpen = true;
                });

                $(document.body).on('added_to_cart removed_from_cart wc_fragments_refreshed added_to_wishlist removed_from_wishlist', refreshHeaderNavRight);
            });
            "
        );
    }
    add_action('wp_enqueue_scripts', 'egns_adking_header_nav_right_script', 35);

    function egns_aventis_archive_load_more_script()
    {
        if (!is_shop() && !is_product_taxonomy()) {
            return;
        }

        wp_add_inline_script(
            'custom-main',
            "
            jQuery(function($) {
                $(document).on('click', '.adking-product-load-more', function(e) {
                    e.preventDefault();

                    var \$button = $(this);
                    var \$archive = \$button.closest('.adking-woocommerce-archive');
                    var \$results = \$archive.find('.adking-product-results');
                    var nextPage = parseInt(\$button.attr('data-page'), 10) + 1;
                    var maxPages = parseInt(\$button.attr('data-max-pages'), 10);

                    if (\$button.hasClass('disabled') || \$archive.hasClass('is-loading') || nextPage > maxPages) {
                        return;
                    }

                    \$archive.addClass('is-loading');
                    \$button.addClass('disabled').attr('aria-disabled', 'true').text(\$button.data('loading-text'));

                    $.post(localize_params.ajaxurl, {
                        action: 'egns_aventis_archive_load_more',
                        nonce: localize_params.nonce,
                        page: nextPage,
                        query: \$button.attr('data-query')
                    }).done(function(response) {
                        if (!response || !response.success || !response.data.html) {
                            \$button.remove();
                            return;
                        }

                        \$results.append(response.data.html);
                        \$button.attr('data-page', response.data.page);

                        if (!response.data.has_more) {
                            \$button.remove();
                        } else {
                            \$button.removeClass('disabled').attr('aria-disabled', 'false').text(\$button.data('text'));
                        }
                    }).fail(function() {
                        \$button.removeClass('disabled').attr('aria-disabled', 'false').text(\$button.data('text'));
                    }).always(function() {
                        \$archive.removeClass('is-loading');
                    });
                });
            });
            "
        );
    }
    add_action('wp_enqueue_scripts', 'egns_aventis_archive_load_more_script', 30);


    /**
     * Product not found message
     */
    function egns_aventis_shop_no_products()
    {
    ?>
        <div class="col-12">
            <div class="adking-product-no-results">
                <span class="no-results-title"><?php echo esc_html__('Sorry Nothing Found!', 'adking'); ?></span>
                <span class="no-results-description"><?php echo esc_html__('Nothing Match your search terms. Please try again with some different keywords.', 'adking'); ?></span>
            </div>
        </div>
    <?php
    }
    add_action('egns_aventis_shop_page_no_products', 'egns_aventis_shop_no_products');



    /**
     * woocommerce product single excerpt position change
     */
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 9);




    /**
     * Wrap WooCommerce tabs with custom parent div
     */
    function aventis_custom_product_tabs_wrapper()
    {
        echo '<div class="product-description-and-review-area">';
        woocommerce_output_product_data_tabs();
        echo '</div>';
    }

    function aventis_wrap_woocommerce_tabs()
    {
        if (!is_product()) {
            return;
        }

        // Remove default tabs output
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        // Add custom wrapped tabs
        add_action('woocommerce_after_single_product_summary', 'aventis_custom_product_tabs_wrapper', 10);
    }
    add_action('wp', 'aventis_wrap_woocommerce_tabs');

    /**
     * Rename description tab title and remove description tab title
     */
    function rename_description_tab($tabs)
    {
        if (isset($tabs['description'])) {
            $tabs['description']['title'] = __('Product Details', 'adking');
        }
        return $tabs;
    }
    add_filter('woocommerce_product_tabs', 'rename_description_tab', 98);

    function remove_description_tab_title($title)
    {
        if (is_product()) {
            return '';  // Return empty to remove the title
        }
        return $title;
    }
    add_filter('woocommerce_product_description_heading', 'remove_description_tab_title');


    /**
     * Change gallery thumbnail default size to custom size
     * */
    add_filter('woocommerce_get_image_size_gallery_thumbnail', function ($size) {
        return array(
            'width'  => 200,
            'height' => 250,
            'crop'   => 0,
        );
    });




    //   End WooCommerce class   
}

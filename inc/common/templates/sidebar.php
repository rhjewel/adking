<?php

use Egns\Helper\Egns_Helper;

$info_lists = Egns_Helper::egns_get_theme_option('header_sidebar_lists');

?>
<div class="right-sidebar-menu two">
    <div class="right-sidebar-close-btn">
        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M14.6694 3.0106C14.8839 2.78848 15.0026 2.49099 15 2.18219C14.9973 1.8734 14.8734 1.57801 14.6551 1.35966C14.4367 1.1413 14.1413 1.01744 13.8325 1.01475C13.5237 1.01207 13.2262 1.13078 13.0041 1.34531L8.00706 6.34236L3.01119 1.34531C2.90184 1.23589 2.77202 1.14907 2.62912 1.08983C2.48623 1.03058 2.33306 1.00005 2.17837 1C2.02368 0.999945 1.87049 1.03036 1.72756 1.08951C1.58462 1.14865 1.45473 1.23538 1.34531 1.34472C1.23589 1.45407 1.14907 1.58389 1.08983 1.72679C1.03058 1.86968 1.00005 2.02285 1 2.17754C0.999945 2.33223 1.03036 2.48542 1.08951 2.62835C1.14865 2.77129 1.23538 2.90118 1.34472 3.0106L6.34177 8.00765L1.34472 13.0047C1.12389 13.2257 0.99989 13.5253 1 13.8378C1.00011 14.1502 1.12432 14.4497 1.34531 14.6706C1.5663 14.8914 1.86596 15.0154 2.17837 15.0153C2.49078 15.0152 2.79036 14.891 3.01119 14.67L8.00706 9.67294L13.0041 14.67C13.2262 14.8845 13.5237 15.0032 13.8325 15.0005C14.1413 14.9979 14.4367 14.874 14.6551 14.6556C14.8734 14.4373 14.9973 14.1419 15 13.8331C15.0026 13.5243 14.8839 13.2268 14.6694 13.0047L9.67235 8.00765L14.6694 3.0106Z" />
        </svg>
    </div>
    <div class="sidebar-content-wrap">
        <h5 class="title"><?php echo Egns_Helper::egns_get_theme_option('header_sidebar_title') ?></h5>
        <div class="address-area">
            <h5><?php echo Egns_Helper::egns_get_theme_option('header_sidebar_adds_title') ?></h5>
            <a><?php echo Egns_Helper::egns_get_theme_option('header_sidebar_short_desc') ?></a>
        </div>
        <div class="contact-area">
            <h5><?php echo Egns_Helper::egns_get_theme_option('header_sidebar_contact_title') ?></h5>
            <?php if (!empty($info_lists)) : ?>
                <ul class="contact-list">
                    <?php foreach ((array)$info_lists as $list) : ?>
                        <li class="single-contact">
                            <div class="icon">
                                <?php echo  Egns_Helper::display_image($list['header_sidebar_list_icon']['url']) ?>
                            </div>
                            <a href="<?php echo esc_url($list['header_sidebar_content']['url']) ?>"><?php echo esc_html($list['header_sidebar_content']['text']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <a href="<?php echo esc_url(Egns_Helper::egns_get_theme_option('header_sidebar_button', 'url')) ?>" target=" <?php echo esc_attr(Egns_Helper::egns_get_theme_option('header_sidebar_button', 'target')) ?>" class="primary-btn1">
            <span>
                <?php echo Egns_Helper::egns_get_theme_option('header_sidebar_button', 'text') ?>
            </span>
            <span>
                <?php echo Egns_Helper::egns_get_theme_option('header_sidebar_button', 'text') ?>
            </span>
        </a>
    </div>
</div>
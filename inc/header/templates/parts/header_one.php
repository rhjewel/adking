<?php

use Egns\Helper\Egns_Helper;

if (!defined('ABSPATH')) {
    exit;
}

$logo_url = Egns_Helper::egns_get_theme_option('header_logo', 'url');
$mb_logo_url = Egns_Helper::egns_get_theme_option('header_mobile_logo', 'url');


?>
<header class="header-area style-2">
    <div class="container position-relative  d-flex flex-nowrap align-items-center justify-content-between">
        <div class="header-logo d-lg-none d-flex">
            <?php
            Egns_Helper::get_theme_logo($logo_url);
            ?>
        </div>
        <div class="company-logo d-lg-flex d-none">
            <?php
            Egns_Helper::get_theme_logo($logo_url);
            ?>
        </div>
        <div class="main-menu">
            <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
                <div class="mobile-logo-wrap">
                    <?php
                    Egns_Helper::get_theme_logo($mb_logo_url);
                    ?>
                </div>
            </div>
            <!-- Main Menu -->
            <?php Egns_Helper::egns_get_theme_menu('primary-menu', '', '', '', '<i class="d-lg-none d-flex bi bi-plus dropdown-icon"></i>', 'menu-list', 3); ?>
        </div>
        <?php
        if (function_exists('egns_adking_header_nav_right')) {
            egns_adking_header_nav_right();
        } else {
        ?>
            <div class="nav-right position-inherit d-flex jsutify-content-end align-items-center adking-header-nav-right">
                <div class="user-login">
                    <button type="button" class="user-btn" data-bs-toggle="modal" data-bs-target="#user-login" aria-label="<?php echo esc_attr__('Login', 'adking'); ?>">
                        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_122_313)">
                                <path d="M15.364 11.636C14.3837 10.6558 13.217 9.93013 11.9439 9.49085C13.3074 8.55179 14.2031 6.9802 14.2031 5.20312C14.2031 2.33413 11.869 0 9 0C6.131 0 3.79688 2.33413 3.79688 5.20312C3.79688 6.9802 4.69262 8.55179 6.05609 9.49085C4.78308 9.93013 3.61631 10.6558 2.63605 11.636C0.936176 13.3359 0 15.596 0 18H1.40625C1.40625 13.8128 4.81279 10.4062 9 10.4062C13.1872 10.4062 16.5938 13.8128 16.5938 18H18C18 15.596 17.0638 13.3359 15.364 11.636ZM9 9C6.90641 9 5.20312 7.29675 5.20312 5.20312C5.20312 3.1095 6.90641 1.40625 9 1.40625C11.0936 1.40625 12.7969 3.1095 12.7969 5.20312C12.7969 7.29675 11.0936 9 9 9Z" />
                            </g>
                        </svg>
                    </button>
                </div>
                <div class="sidebar-button mobile-menu-btn ">
                    <span></span>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</header>
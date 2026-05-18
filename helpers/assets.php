<?php

namespace Egns\Helper;

if (!class_exists('Egns_Assets')) {

    /**
     * Assets handlers class
     */
    class Egns_Assets
    {

        /**
         * Class constructor
         */
        function __construct()
        {
            // Theme setup and admin enqueue files
            add_action('admin_enqueue_scripts', array($this, 'egns_enqueue_admin_assets'));

            // Theme setup and enqueue files
            add_action('wp_enqueue_scripts', array($this, 'egns_enqueue_assets'));
        }

        /**
         * Return an asset version from its file modification time.
         *
         * @param string $relative_path Asset path relative to the assets directory.
         * @return int|string
         */
        private function egns_asset_version($relative_path)
        {
            $file = EGNS_ASSETS_ROOT_DIR . '/' . ltrim($relative_path, '/');

            return file_exists($file) ? filemtime($file) : EGNS_THEME_VERSION;
        }

        /**
         * Return all available scripts
         *
         * @version 1.0.0
         * @return array
         */
        function egns_get_scripts()
        {
            return [
                'popper' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/popper.min.js',
                    'version' => $this->egns_asset_version('js/popper.min.js'),
                    'deps'    => ['jquery'],
                ],
                'bootstrap' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/bootstrap.min.js',
                    'version' => $this->egns_asset_version('js/bootstrap.min.js'),
                    'deps'    => ['jquery', 'popper'],
                ],
                'jquery-ui-local' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/jquery-ui.js',
                    'version' => $this->egns_asset_version('js/jquery-ui.js'),
                    'deps'    => ['jquery'],
                ],
                'moment' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/moment.min.js',
                    'version' => $this->egns_asset_version('js/moment.min.js'),
                    'deps'    => [],
                ],
                'swiper' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/swiper-bundle.min.js',
                    'version' => $this->egns_asset_version('js/swiper-bundle.min.js'),
                    'deps'    => [],
                ],
                'wow' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/wow.min.js',
                    'version' => $this->egns_asset_version('js/wow.min.js'),
                    'deps'    => ['jquery'],
                ],
                'nice-select' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/jquery.nice-select.min.js',
                    'version' => $this->egns_asset_version('js/jquery.nice-select.min.js'),
                    'deps'    => ['jquery'],
                ],
                'fancybox' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/jquery.fancybox.min.js',
                    'version' => $this->egns_asset_version('js/jquery.fancybox.min.js'),
                    'deps'    => ['jquery'],
                ],
                'waypoints' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/waypoints.min.js',
                    'version' => $this->egns_asset_version('js/waypoints.min.js'),
                    'deps'    => ['jquery'],
                ],
                'counterup' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/jquery.counterup.min.js',
                    'version' => $this->egns_asset_version('js/jquery.counterup.min.js'),
                    'deps'    => ['jquery', 'waypoints'],
                ],
                'simple-parallax' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/simpleParallax.min.js',
                    'version' => $this->egns_asset_version('js/simpleParallax.min.js'),
                    'deps'    => [],
                ],
                'select-dropdown' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/select-dropdown.js',
                    'version' => $this->egns_asset_version('js/select-dropdown.js'),
                    'deps'    => ['jquery'],
                ],
                'custom-main' => [
                    'src'     => EGNS_ASSETS_ROOT . '/js/custom.js',
                    'version' => $this->egns_asset_version('js/custom.js'),
                    'deps'    => ['jquery', 'bootstrap', 'swiper', 'wow', 'nice-select', 'fancybox', 'counterup'],
                ],

            ];
        }


        /**
         * Return all available styles
         *
         * @version 1.0.0
         * @return array
         */
        function egns_get_styles()
        {
            $styles = [
                'egns-fonts' => [
                    'src'     => 'https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap',
                    'deps'    => [],
                    'version' => null,
                ],
                'swiper' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/swiper-bundle.min.css',
                    'version' => $this->egns_asset_version('css/swiper-bundle.min.css'),
                ],
                'fancybox' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/jquery.fancybox.min.css',
                    'version' => $this->egns_asset_version('css/jquery.fancybox.min.css'),
                ],
                'animate' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/animate.min.css',
                    'version' => $this->egns_asset_version('css/animate.min.css'),
                ],
                'nice-select' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/nice-select.css',
                    'version' => $this->egns_asset_version('css/nice-select.css'),
                ],
                'jquery-ui-local' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/jquery-ui.css',
                    'version' => $this->egns_asset_version('css/jquery-ui.css'),
                ],
                'bootstrap-icons' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/bootstrap-icons.css',
                    'version' => $this->egns_asset_version('css/bootstrap-icons.css'),
                ],
                'bootstrap' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/bootstrap.min.css',
                    'version' => $this->egns_asset_version('css/bootstrap.min.css'),
                ],
                'boxicons' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/boxicons.min.css',
                    'version' => $this->egns_asset_version('css/boxicons.min.css'),
                ],
                'blog-and-pages' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/blog-and-pages.css',
                    'version' => $this->egns_asset_version('css/blog-and-pages.css'),
                ],
                'woocommerce-custom' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/woocommerce-custom.css',
                    'version' => $this->egns_asset_version('css/woocommerce-custom.css'),
                ],
                'el-widgets' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/el-widgets.css',
                    'version' => $this->egns_asset_version('css/el-widgets.css'),
                ],
                'egns-style' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/style.css',
                    'version' => $this->egns_asset_version('css/style.css'),
                ],

            ];

            $styles['egns-theme'] = [
                'src'     => EGNS_ROOT . '/style.css',
                'version' => file_exists(EGNS_ROOT_DIR . '/style.css') ? filemtime(EGNS_ROOT_DIR . '/style.css') : EGNS_THEME_VERSION,
            ];

            return $styles;
        }


        /**
         * Egens enqueue scripts and styles 
         * 
         * @since 1.0.0
         * 
         * @return void
         */
        public function egns_enqueue_assets()
        {
            $scripts = $this->egns_get_scripts();
            $styles  = $this->egns_get_styles();


            // Applied filter hook for scripts and styles
            $scripts = apply_filters('egns_filter_scripts', $scripts);
            $styles  = apply_filters('egns_filter_styles', $styles);

            // Enqueue all styles
            foreach ($styles as $handle => $style) {
                $deps = isset($style['deps']) ? $style['deps'] : false;

                wp_enqueue_style($handle, $style['src'], $deps, $style['version'], 'all');
            }

            // Enqueue all scripts
            foreach ($scripts as $handle => $script) {
                $deps = isset($script['deps']) ? $script['deps'] : false;

                wp_enqueue_script($handle, $script['src'], $deps, $script['version'], true);
            }

            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }

            // Localize script 
            $objects = array(
                'sticky_header'  => class_exists('Egns_Core') ? Egns_Helper::sticky_header_enable() : '',
                'ajaxurl'        => admin_url('admin-ajax.php'),
                'posts_per_page' => get_option('posts_per_page'),
                'author_id'      => get_the_author_meta('ID'),
                'nonce'          => wp_create_nonce('ajax-nonce')
            );
            wp_localize_script('custom-main', 'localize_params', $objects);
        }


        /**
         * Return all available admin styles
         *
         * @version 1.0.0
         * @return array
         */
        function egns_get_admin_styles()
        {
            return [
                'egns-admin-style' => [
                    'src'     => EGNS_ASSETS_ROOT . '/css/admin.css',
                    'version' => $this->egns_asset_version('css/admin.css'),
                ],

            ];
        }


        /**
         * Egens enqueue admin scripts and styles 
         * 
         * @since 1.0.0
         * 
         * @return void
         */
        public function egns_enqueue_admin_assets()
        {
            $admin_styles = $this->egns_get_admin_styles();

            // Applied filter hook for styles
            $admin_styles = apply_filters('egns_filter_admin_styles', $admin_styles);

            // Enqueue all admin styles
            foreach ($admin_styles as $handle => $admin_style) {
                $deps = isset($admin_style['deps']) ? $admin_style['deps'] : false;

                wp_enqueue_style($handle, $admin_style['src'], $deps, $admin_style['version'], 'all');
            }
        }
    }
}

<?php
if (!function_exists('egns_breadcrumb')) {

    function egns_breadcrumb($list_style = 'ul', $list_id = 'breadcrumb', $list_class = 'breadcrumb-list', $active_class = 'active', $echo = true)
    {

        $svg_icon = '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <path d="M4.88174 0.633502L12.9342 6.57774C12.9975 6.62911 13.0485 6.69395 13.0835 6.76753C13.1185 6.84111 13.1367 6.92158 13.1367 7.00308C13.1367 7.08458 13.1185 7.16505 13.0835 7.23863C13.0485 7.31221 12.9975 7.37705 12.9342 7.42842L4.88174 13.3727C4.39775 13.5513 4.11824 13.4153 4.04321 12.9648L11.5446 7.42842C11.6078 7.37705 11.6588 7.31221 11.6939 7.23863C11.7289 7.16505 11.7471 7.08458 11.7471 7.00308C11.7471 6.92158 11.7289 6.84111 11.6939 6.76753C11.6588 6.69395 11.6078 6.62911 11.5446 6.57774L4.04691 1.04405C4.0518 0.949341 4.0819 0.857657 4.13409 0.778471C4.18628 0.699286 4.25866 0.635471 4.34376 0.59362C4.42887 0.551769 4.5236 0.5334 4.61818 0.540411C4.71275 0.547423 4.80374 0.57956 4.88174 0.633502ZM1.71148 13.3721L3.68127 11.9186L4.8754 11.0372L9.765 7.42842C9.83163 7.37931 9.8858 7.31524 9.92313 7.24136C9.96045 7.16748 9.9799 7.08586 9.9799 7.00308C9.9799 6.9203 9.96045 6.83869 9.92313 6.76481C9.8858 6.69092 9.83163 6.62685 9.765 6.57774L4.87487 2.96893L3.68127 2.08759L1.71201 0.634559L1.71095 0.633502C1.61585 0.567501 1.50184 0.534281 1.38617 0.538871C1.2705 0.543461 1.15948 0.585612 1.0699 0.658941C0.980332 0.732271 0.917089 0.832787 0.889751 0.945272C0.862412 1.05776 0.872466 1.17609 0.918389 1.28235L3.58828 7.00308L0.918919 12.7238C0.886177 12.7938 0.869221 12.8701 0.86925 12.9473C0.870887 13.0444 0.899018 13.1392 0.950607 13.2215C1.0022 13.3038 1.07528 13.3704 1.16197 13.4142C1.24867 13.458 1.34567 13.4773 1.44252 13.4699C1.53936 13.4626 1.63236 13.4285 1.71148 13.3721Z"></path>
                        </g>
                    </svg>';

        // Opening
        $breadcrumb = '<' . $list_style . ' id="' . $list_id . '" class="' . $list_class . '">';

        // Home link
        if (is_front_page()) {
            $breadcrumb .= '<li class="' . $active_class . '">' . esc_html__('Home', 'adking') . '</li>';
        } else {
            $breadcrumb .= '<li class="breadcrumb-item"><a href="' . esc_url(home_url()) . '">' . esc_html__('Home', 'adking') . '</a></li>';
        }

        // Blog page setup
        $blog_page_id = get_option('page_for_posts');

        if ('page' == get_option('show_on_front') && $blog_page_id) {

            // If on blog home
            if (is_home()) {
                $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon . esc_html(get_the_title($blog_page_id)) . '</li>';
            }
            // If inside Posts archive area (category, tag, date, single post)
            elseif (is_category() || is_tag() || is_author() || is_date() || is_singular('post')) {
                $breadcrumb .= '<li class="breadcrumb-item">' . $svg_icon . '<a href="' . esc_url(get_permalink($blog_page_id)) . '">' . esc_html(get_the_title($blog_page_id)) . '</a></li>';
            }
        }

        /*
        |----------------------------------------------------------
        | Category, Tag, Author, Date ARCHIVES (SVG FIXED)
        |----------------------------------------------------------
        */
        if (is_category() || is_tag() || is_author() || is_date()) {

            $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon;

            if (is_category()) {
                $breadcrumb .= single_cat_title('', false);
            } elseif (is_tag()) {
                $breadcrumb .= single_tag_title('', false);
            } elseif (is_author()) {
                $breadcrumb .= get_the_author();
            } elseif (is_day()) {
                $breadcrumb .= get_the_time('F j, Y');
            } elseif (is_month()) {
                $breadcrumb .= get_the_time('F, Y');
            } elseif (is_year()) {
                $breadcrumb .= get_the_time('Y');
            }

            $breadcrumb .= '</li>';
        }

        /*
        |----------------------------------------------------------
        | Single Post
        |----------------------------------------------------------
        */
        if (is_singular('post')) {
            $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon . esc_html(get_the_title()) . '</li>';
        }

        /*
        |----------------------------------------------------------
        | Page (With parents)
        |----------------------------------------------------------
        */
        if (is_page() && !is_front_page()) {

            $post = get_post(get_the_ID());

            if ($post->post_parent) {
                $crumbs = [];
                $parent_id = $post->post_parent;

                while ($parent_id) {
                    $page = get_post($parent_id);
                    $crumbs[] = '<li class="breadcrumb-item">' . $svg_icon .
                        '<a href="' . esc_url(get_permalink($page->ID)) . '">' .
                        esc_html(get_the_title($page->ID)) . '</a></li>';
                    $parent_id = $page->post_parent;
                }

                $crumbs = array_reverse($crumbs);

                foreach ($crumbs as $crumb) {
                    $breadcrumb .= $crumb;
                }
            }

            $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon . esc_html(get_the_title()) . '</li>';
        }

        /*
        |----------------------------------------------------------
        | Attachment
        |----------------------------------------------------------
        */
        if (is_attachment()) {

            $parent = get_post(get_post()->post_parent);

            if ($parent) {
                $breadcrumb .= '<li class="breadcrumb-item">' . $svg_icon .
                    '<a href="' . esc_url(get_permalink($parent->ID)) . '">' .
                    esc_html(get_the_title($parent->ID)) . '</a></li>';
            }

            $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon . esc_html(get_the_title()) . '</li>';
        }

        /*
        |----------------------------------------------------------
        | SEARCH
        |----------------------------------------------------------
        */
        if (is_search()) {
            $breadcrumb .= '<li class="' . $active_class . '">' .  $svg_icon . esc_html__('Explorer Data: ', 'adking') . esc_html(get_search_query()) . '</li>';
        }

        /*
        |----------------------------------------------------------
        | 404
        |----------------------------------------------------------
        */
        if (is_404()) {
            $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon . esc_html__('404', 'adking') . '</li>';
        }

        /*
        |----------------------------------------------------------
        | Custom Post Type Archive
        |----------------------------------------------------------
        */
        if (is_post_type_archive()) {
            $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon .
                esc_html(post_type_archive_title('', false)) . '</li>';
        }

        /*
        |----------------------------------------------------------
        | Custom Taxonomy (SVG fixed)
        |----------------------------------------------------------
        */
        if (is_tax()) {

            $term = get_queried_object();
            $taxonomy = $term->taxonomy;

            $cpt = get_taxonomy($taxonomy)->object_type[0];

            if ($cpt && get_post_type_archive_link($cpt)) {

                $cpt_obj = get_post_type_object($cpt);

                $breadcrumb .= '<li class="breadcrumb-item">' . $svg_icon .
                    '<a href="' . esc_url(get_post_type_archive_link($cpt)) . '">' .
                    esc_html($cpt_obj->labels->name) . '</a></li>';
            }

            $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon . esc_html($term->name) . '</li>';
        }

        /*
        |----------------------------------------------------------
        | Custom Post Type Single
        |----------------------------------------------------------
        */
        if (is_single() && !is_singular('post') && !is_attachment()) {

            $cpt = get_post_type();
            $cpt_obj = get_post_type_object($cpt);

            if ($cpt_obj && get_post_type_archive_link($cpt)) {
                $breadcrumb .= '<li class="breadcrumb-item">' . $svg_icon .
                    '<a href="' . esc_url(get_post_type_archive_link($cpt)) . '">' .
                    esc_html($cpt_obj->labels->name) . '</a></li>';
            }

            $breadcrumb .= '<li class="' . $active_class . '">' . $svg_icon . esc_html(get_the_title()) . '</li>';
        }

        $breadcrumb .= '</' . $list_style . '>';

        if ($echo) {
            echo sprintf(__("%s", 'adking'), $breadcrumb);
        } else {
            return $breadcrumb;
        }
    }
}

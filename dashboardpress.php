<?php

/**
 * Plugin Name: Dashboard-Press
 * Description: Dashboard-Press is new settings dashboard based on VUE JS.
 * Author URI:  https://profiles.wordpress.org/jahidcse/
 * Version:     1.0.0
 * Author:      jahidcse
 * Text Domain: dashboardpress
 */



class DashboardPress{
    function __construct(){
        add_action('admin_enqueue_scripts', [$this, 'dashboardpress_assets']);
        add_action('admin_menu', [$this, 'dashboardpress_adminmenu']);
        add_filter('script_loader_tag', [$this, 'dashboardpress_loadScript'], 10, 3);
        add_action('rest_api_init', [$this, 'dashboardpress_create_endpoint']);
    }

    public function dashboardpress_create_endpoint(){
        register_rest_route('dashboardpress/v1', '/news', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'news_list_callback' ),
        ));

        // Add News
        register_rest_route('dashboardpress/v1', '/add-news', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'create_news_callback' ),
        ));

        // Update News
        register_rest_route('dashboardpress/v1', '/update-news', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'update_news_callback' ),
        ));


        // leads
        register_rest_route('dashboardpress/v1', '/leads', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'leads_callback' ),
            'permission_callback' => array( $this, 'dashboardpress_permission_callback' ),
        ));
    }
    public function leads_callback($param){
        return $testing = "Hi How are you";
    }

    public function dashboardpress_permission_callback( $request ) {
        return current_user_can( 'manage_options' );
    }
    public function news_list_callback($param){
        if(!empty($param["ID"])){
            $news_id = $param["ID"];
            $news       = array();
            $news['id']             = $news_id;
            $news['title']          = get_the_title( $news_id );
            $news['content']        = get_post_field('post_content', $news_id);
            $news['news_location']  = get_post_meta( $news_id, 'news_location', true );
        }else{
            $query_news = new WP_Query( array(
                'post_type'      => 'post',
                'posts_per_page' => 10,
                'post_status'    => array( 'publish'),
                'paged'          => 1,
            ) );
            $news       = array();
            if ( $query_news->have_posts() ) {
                while ( $query_news->have_posts() ) {
                    $query_news->the_post();
                    $news_id = get_the_ID();
    
                    $news_data   = array();
    
                    $news_data['id']             = $news_id;
                    $news_data['permalink']      = get_permalink( $news_id );
                    $news_data['title']          = get_the_title( $news_id );
                    $news_data['content']        = get_the_content( $news_id );
                    $news_data['status']         = get_post_status( $news_id );
                    $news_data['author']         = get_the_author_meta( 'display_name', get_post_field( 'post_author', $news_id ) );
                    $news_data['news_location']  = get_post_meta( $news_id, 'news_location', true );
                    $news[]                     = $news_data;
                }
            }
            wp_reset_postdata();
            $news = array(
                'news' => $news,
                'total'  => $query_news->found_posts,
            );
        }
        return $news;
    }

    // Create News Callback
    public function create_news_callback($param){
        $reg_errors = new \WP_Error();
        $title = isset($param["title"]) ? sanitize_text_field($param["title"]) : null;
        $desc = isset($param["content"]) ? sanitize_text_field($param["content"]) : "";
        $location = isset($param["location"]) ? sanitize_text_field($param["location"]) : "";
        if ($reg_errors->get_error_messages()) {
            wp_send_json_error($reg_errors->get_error_messages());
        } else {
            $data = [
                "post_type" => "post",
                "post_title" => $title,
                "post_content" => $desc,
                "post_status" => "publish",
                "post_author" => get_current_user_id(),
                "menu_order"  => 0,
            ];
            $post_id = wp_insert_post($data);

            update_post_meta($post_id, 'news_location', $location);
            if (!is_wp_error($post_id)) {
                wp_send_json_success($post_id);
            } else {
                wp_send_json_error();
            }
        }
    }

    // Update News Callback
    public function update_news_callback($param){
        $reg_errors = new \WP_Error();
        $id = isset($param['news_single']['_value']["id"]) ? sanitize_text_field($param['news_single']['_value']["id"]) : null;
        $title = isset($param['news_single']['_value']["title"]) ? sanitize_text_field($param['news_single']['_value']["title"]) : null;
        $desc = isset($param['news_single']['_value']["content"]) ? sanitize_text_field($param['news_single']['_value']["content"]) : "";
        $location = isset($param['news_single']['_value']["news_location"]) ? sanitize_text_field($param['news_single']['_value']["news_location"]) : "";
        if ($reg_errors->get_error_messages()) {
            wp_send_json_error($reg_errors->get_error_messages());
        } else {
            $data = [
                "post_type" => "post",
                "ID" => $id,
                "post_title" => $title,
                "post_content" => $desc,
                "post_status" => "publish",
                "post_author" => get_current_user_id(),
                "menu_order"  => 0,
            ];
            $post_id = wp_update_post($data);

            update_post_meta($post_id, 'news_location', $location);
            if (!is_wp_error($post_id)) {
                wp_send_json_success($post_id);
            } else {
                wp_send_json_error();
            }
        }
    }

    // Admin Menu
    public function dashboardpress_adminmenu(){
        add_menu_page(
            esc_html__("Dashboard Press", "dashboardpress"),
            esc_html__("Dashboard Press", "dashboardpress"),
            "manage_options",
            "dashboardpress",
            [$this, "render"],
            "dashicons-desktop",
            5
        );

        add_submenu_page(
            "dashboardpress",
            esc_html__("Dashboard", "dashboardpress"),
            esc_html__("Dashboard", "dashboardpress"),
            "manage_options",
            "dashboardpress#",
            [$this, "render"]
        );

        // Others Submenu

        $settings_menu = [
            [
                "id" => "help",
                "label" => esc_html__("Get Help", "dashboardpress"),
                "capability" => "manage_options",
            ],
            [
                "id" => "report",
                "label" => esc_html__("Report", "dashboardpress"),
                "capability" => "manage_options",
            ],
            [
                "id" => "news",
                "label" => esc_html__("News", "dashboardpress"),
                "capability" => "manage_options",
            ],
            [
                "id" => "leads",
                "label" => esc_html__("Leads", "dashboardpress"),
                "capability" => "manage_options",
            ]
        ];

        foreach ($settings_menu as $menu) {
            $menu_id = $menu["id"];

            add_submenu_page(
                "dashboardpress",
                $menu["label"],
                $menu["label"],
                $menu["capability"],
                "dashboardpress#/" . $menu_id,
                [$this, "render"]
            );
        }

        remove_submenu_page("dashboardpress", "dashboardpress");
    }

    // Script Loader Tag
    public function dashboardpress_loadScript($tag, $handle, $src) {
        if ('dashboardpress-main' !== $handle) {
            return $tag;
        }
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        return $tag;
    }

    // Menu Page Callback
    public function render(){
        echo '<div class="wrap"><div id="dashboardpress_wrap"></div></div>'; 
    }

    // Admin Asset Enqueue
    public function dashboardpress_assets($screen){
        if('toplevel_page_dashboardpress'==$screen){
            wp_enqueue_script( 'tailwind', 'https://cdn.tailwindcss.com?plugins=forms', '', time(), false);
            wp_enqueue_script( 'dashboardpress-main', 'http://localhost:5173/src/main.js', '', time(), false);
            wp_localize_script( 'dashboardpress-main', 'dashboardpressExtra', array(
                'wp_rest_nonce' => wp_create_nonce( 'wp_rest' ),
                'admin_url' => site_url(),
            ) );
        }
    }

}

new DashboardPress();
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
    public function dashboardpress_assets(){
        wp_enqueue_script( 'tailwind', 'https://cdn.tailwindcss.com', '', time(), false);
        wp_enqueue_script( 'dashboardpress-main', 'http://localhost:5173/src/main.js', '', time(), false);
    }

}

new DashboardPress();
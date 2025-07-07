<?php
/**
 * Plugin Name: My Custom Plugin
 * Description: A base WordPress plugin for development practice.
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

if (!defined('ABSPATH')) exit;

define('PLUGINPATH', plugin_dir_path(__FILE__));
require_once PLUGINPATH . 'includes/settings-page.php';


class MyGenericPlugin {

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        register_activation_hook(__FILE__, [$this, 'on_activate']);
        register_deactivation_hook(__FILE__, [$this, 'on_deactivate']);
        add_action('init', [$this, 'custom_post_type']);

        // Initialize settings page
        new MyGenericPluginSettings();
    }

    public function enqueue_assets() {
        $plugin_url = plugin_dir_url(__FILE__);
        wp_enqueue_style('my-plugin-style', PLUGINPATH . 'assets/css/style.css');
        wp_enqueue_script('my-plugin-script', PLUGINPATH . 'assets/js/script.js', [], false, true);
    }

    public function on_activate() {
        error_log('MyGenericPlugin activated');
        flush_rewrite_rules();
    }

    public function on_deactivate() {
        error_log('MyGenericPlugin deactivated');
        flush_rewrite_rules();
    }

    public function custom_post_type() {
        register_post_type('example_post', [
            'labels' => [
                'name' => 'Examples',
                'singular_name' => 'Example'
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor'],
        ]);
    }
}

new MyGenericPlugin();



add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'my_plugin_settings_link');

function my_plugin_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=my-generic-plugin">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

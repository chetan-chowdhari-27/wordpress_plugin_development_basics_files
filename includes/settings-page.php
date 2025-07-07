<?php
if (!defined('ABSPATH')) exit;

class MyGenericPluginSettings {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_settings_page() {
        add_submenu_page(
        'edit.php?post_type=example_post', // CPT menu slug
        'My Generic Plugin Settings',      // Page title
        'Plugin Settings',                 // Menu title
        'manage_options',                  // Capability
        'my-generic-plugin',               // Menu slug
        [$this, 'render_settings_page']    // Callback
    );
		    }

    public function register_settings() {
        register_setting('my_generic_plugin_options', 'my_generic_plugin_option');

        add_settings_section(
            'my_generic_plugin_main_section',
            'Main Settings',
            null,
            'my-generic-plugin'
        );

        add_settings_field(
            'my_generic_plugin_option',
            'Sample Option',
            [$this, 'settings_field_html'],
            'my-generic-plugin',
            'my_generic_plugin_main_section'
        );
    }

    public function settings_field_html() {
        $value = get_option('my_generic_plugin_option', '');
        echo '<input type="text" name="my_generic_plugin_option" value="' . esc_attr($value) . '" />';
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>My Generic Plugin Settings</h1>
            <form method="post" action="options.php">
                <?php
                    settings_fields('my_generic_plugin_options');
                    do_settings_sections('my-generic-plugin');
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

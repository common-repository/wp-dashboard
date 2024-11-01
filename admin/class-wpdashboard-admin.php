<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpdashboard.io
 * @since      1.0.0
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/admin
 * @author     WP Dashboard <brianldj@gmail.com>
 */
class Wpdashboard_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the menu items for the admin area.
     *
     * @since    1.0.0
     */
    public function create_menu()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wpdashboard_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wpdashboard_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        add_menu_page('WP Dashboard', 'WP Dashboard', 'manage_options', $this->plugin_name . '_menu', 'generate_wpdashboard_admin');

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wpdashboard_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wpdashboard_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if(isset($_GET['page'])) {
            if ($_GET['page'] == 'wpdashboard_menu') {
                wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wpdashboard-admin.css', array(), $this->version, 'all');
            }
        }

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wpdashboard_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wpdashboard_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if(isset($_GET['page'])) {
            if ($_GET['page'] == 'wpdashboard_menu') {
                wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wpdashboard-admin.js', array('jquery'), $this->version, false);
            }
        }

    }

    /**
     * @param $name
     * @return mixed
     */
    public function get_option($name)
    {
        return get_option($this->plugin_name . '_' . $name);
    }

    /**
     * @param $key
     * @param $value
     * @param bool $autoload
     * @return mixed
     */
    public function set_option($key, $value, $autoload = false)
    {
        return update_option($this->plugin_name . '_' . $key, $value, $autoload);
    }

    public function perform_action() {
        if(isset($_GET['action'])) {
            $action = $_GET['action'];
            switch($action) {
                case 'remove_plugin':
                    $this->remove_plugin();
                    break;
                case 'connect':
                    $this->connect();
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * Remove Plugin
     *
     * Signal to remove the API key,
     * and reset the plugin back to a default state.
     *
     * THIS IS NOT REVERSIBLE!
     *
     * @since 2.0
     *
     * @return void
     */
    public function remove_plugin() {
        $this->set_option('removing', true);
    }

    /**
     * Connect
     *
     * Completes the connection between the
     * plugin and WP Dashboard. Sets the final
     * options up so they communicate like they
     * should.
     *
     * @since 2.0
     *
     * @return void
     */
    public function connect() {
        $this->set_option('site_id', sanitize_key($_GET['site_id']), false);
        $this->set_option('team_id', sanitize_key($_GET['team_id']), false);
        $this->set_option('team_name', sanitize_title($_GET['team_name']), false);
//        $this->set_option('public_key', $_GET['public_key'], false);
        $this->set_option('connected', true);
    }

    /**
     * Generate Admin
     *
     * Generates the Admin interface
     * for the end user.
     *
     * @since 2.0
     *
     * @return void
     */
    public function generate_admin()
    {
        if (isset($_GET['action'])) {
            $this->perform_action();
        }

        switch (@$_GET['tab']) {
            case 'status':
                $this->generate_status();
                break;
            case 'redirects':
                $this->generate_redirects();
                break;
            case 'settings':
                $this->generate_settings();
                break;
            default:
                $this->generate_status();
                break;
        }
    }

    /**
     * Generate Status
     *
     * Generates the status page
     * for the admin interface.
     *
     * @since 2.0
     *
     * @return void
     */
    private function generate_status() {
        $tab = 'status';
        require 'partials/wpdashboard-admin-status.php';
    }

    /**
     * Generate Redirects
     *
     * Generates the redirects page
     * for the admin interface.
     *
     * @since 2.0
     *
     * @return void
     */
    private function generate_redirects() {
        $tab = 'redirects';
        require 'partials/wpdashboard-admin-redirects.php';
    }

    /**
     * Generate Settings
     *
     * Generates the settings page
     * for the admin interface.
     *
     * @since 2.0
     *
     * @return void
     */
    private function generate_settings() {
        $tab = 'settings';
        require 'partials/wpdashboard-admin-settings.php';
    }

}

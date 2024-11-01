<?php

class WpDashboard_Api_Base extends WP_REST_Controller {

    /**
     * The ID of this plugin.
     *
     * @since    2.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    protected $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    2.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    protected $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    2.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Get Option from WordPress.
     *
     * @since    2.0.0
     *
     * @param $name
     * @return mixed
     */
    public function get_option($name) {
        return get_option($this->plugin_name . '_' . $name);
    }

    /**
     * Update Option from WordPress.
     *
     * @since    2.0.0
     *
     * @param $name
     * @param $value
     * @param $autoload
     * @return mixed
     */
    public function update_option($name, $value, $autoload) {
        return update_option($this->plugin_name . '_' . $name, $value, $autoload);
    }

    /**
     * Delete Option from WordPress.
     *
     * @since    2.0.0
     *
     * @param $name
     * @return mixed
     */
    public function delete_option($name) {
        return delete_option($this->plugin_name . '_' . $name);
    }

    /**
     * Required
     *
     * Include the required files,
     * only if the route is activated
     * though, otherwise... errors...
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function required() {
        include_once(ABSPATH . 'wp-admin/includes/file.php');
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        include_once(ABSPATH . 'wp-includes/plugin.php');
        include_once(ABSPATH . 'wp-admin/includes/theme.php');
        include_once(ABSPATH . 'wp-admin/includes/misc.php');
        include_once(ABSPATH . 'wp-admin/includes/template.php');
        include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
        include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
        include_once(ABSPATH . 'wp-admin/includes/update.php');
        require_once 'lib/class-wp-upgrade-skin.php';
    }

    /**
     * Check Permission
     *
     * Checks to see if the API Key that is given
     * matches what we have stored.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return bool|WP_Error
     */
    public function permission_check( $request ) {
        if(null !== $request->get_param('api_key')) {
            if($request->get_param('api_key') == $this->get_option('api_key')) {
                return true;
            }
        }
        return new WP_Error('unauthenticated', 'You are not authenticated to do this.');
    }

    /**
     * Coming Soon
     *
     * Let's whoever is trying to use the
     * API know that this function
     * is coming in a later version.
     *
     * @since 2.0.0
     *
     * @param $feature string The Feature that is missing.
     * @param $version float  The estimated version that the feature will show up in.
     *
     * @return WP_Error
     */
    public function coming_soon($feature, $version) {
        return new WP_Error(404, 'The feature, ' . $feature . ', is coming, hopefully in version ' . $version . ', but we will see.');
    }

    /**
     * Stupid
     *
     * Okay, let's face it, if you
     * are using end up seeing the
     * result of this function...
     * you probably deserve it...
     *
     * @since 2.0.0
     *
     * @param $huh string The stupid thing the end user is attempting to accomplish...
     *
     * @return WP_Error
     */
    public function stupid($huh) {
        return new WP_Error('wpd_69', '.... you want to... ' . $huh . '... okay, yeah, that is not going to happen??');
    }
}
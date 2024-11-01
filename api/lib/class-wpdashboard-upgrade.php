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
class WpDasbhoard_Upgrade {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The request made to the API.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $request_type    The current request made to the API.
     */
    private $request_type;

    /**
     * A GuzzleHTTP client used to communicate with WPDashboard.io.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $request_type    The current request made to the API.
     */
    private $client;

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

        @include_once(ABSPATH . 'wp-admin/includes/file.php');
        @include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        @include_once(ABSPATH . 'wp-includes/plugin.php');
        @include_once(ABSPATH . 'wp-admin/includes/theme.php');
        @include_once(ABSPATH . 'wp-admin/includes/misc.php');
        @include_once(ABSPATH . 'wp-admin/includes/template.php');
        @include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
        @require_once 'class-wp-upgrade-skin.php';
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->client = new WP_Http();

	}

    public function get_option($name) {
        return get_option($this->plugin_name . '_' . $name);
    }

    public function update_option($name, $value, $autoload) {
        return update_option($this->plugin_name . '_' . $name, $value, $autoload);
    }


    public function upgrade_plugin($plugin) {
        $resp = [];
        $skin = new WPDashboardUpdateSkin();
        $current = get_site_transient( 'update_plugins' );
        $upgrader = new Plugin_Upgrader( $skin );
        $file = null;
        $info = null;
        foreach( $current->response AS $f => $i) {
            if($f == $plugin) {
                $file = $f;
                $info = $i;
                break;
            }
        }
        $this->do_plugin_upgrade($upgrader, $file, $info);
        $resp = array_merge($resp, [$file => $skin->result]);
        return $resp;
    }


    public function upgrade_all_plugins() {
        $resp = [];
        $skin = new WPDashboardUpdateSkin();
        $current = get_site_transient( 'update_plugins' );
        $upgrader = new Plugin_Upgrader( $skin );
        foreach( $current->response AS $file => $info) {
            $this->do_plugin_upgrade($upgrader, $file, $info);
            $resp = array_merge($resp, [$file => $skin->result]);
        }
        return $resp;
    }

    protected function do_plugin_upgrade($upgrader, $file, $info) {
	    if($upgrader == null || $file == null || $info == null) {
	        return null;
        } else {
            return $upgrader->run(array(
                'package' => $info->package,
                'destination' => WP_PLUGIN_DIR,
                'clear_destination' => true,
                'clear_working' => true,
                'hook_extra' => array(
                    'plugin' => $file,
                    'type' => 'plugin',
                    'action' => 'update',
                ),
            ));
        }
    }

}

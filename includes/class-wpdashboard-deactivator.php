<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://wpdashboard.io
 * @since      1.0.0
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wpdashboard
 * @subpackage Wpdashboard/includes
 * @author     WP Dashboard <brianldj@gmail.com>
 */
class Wpdashboard_Deactivator {

	/**
	 * Deactivate Plugin.
	 *
	 * Delete options from Wordpress and
     * alert WP Dashboard to the
     * deactivation.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
	    $request = new WP_Http();
        $response = $request->post('http://wpdashboard.io.test/api/site/deactivate', ['body' => ['api_key' => get_option('wpdashboard_api_key')]]);
//        var_dump($response);
//        die();
        delete_option('wpdashboard_api_key');
        delete_option('wpdashboard_redirects');
        delete_option('wpdashboard_public_key');
        delete_option('wpdashboard_connected');
        delete_option('wpdashboard_admin_user');
        delete_option('wpdashboard_tag_manager_id');

        wp_clear_scheduled_hook( 'wpdashboard_send_updates_available' );
	}

}

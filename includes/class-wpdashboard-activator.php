<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpdashboard.io
 * @since      1.0.0
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wpdashboard
 * @subpackage Wpdashboard/includes
 * @author     WP Dashboard <brianldj@gmail.com>
 */
class Wpdashboard_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if(!get_option('wpdashboard_api_key')) {
            if (!extension_loaded('openssl')) {
                update_option('wpdashboard_api_key', self::__generate_random_string(random_bytes(16)), false);
            } else {
                update_option('wpdashboard_api_key', self::__generate_random_string(openssl_random_pseudo_bytes(16)), false);
            }
        }
        if(!get_option('wpdashboard_redirects')) {
            update_option('wpdashboard_redirects', json_encode([]), false);
        }
        if (! wp_next_scheduled ( 'wpdashboard_send_updates_available', [] )) {
            wp_schedule_event( time(), 'hourly', 'wpdashboard_send_updates_available', [] );
        }
	}

    protected static function __generate_random_string($data) {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }


}

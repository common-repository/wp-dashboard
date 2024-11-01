<?php

/**
 * Communicates Available Updates
 *
 * A class definition that will send updates
 * to WP Dashboard via webhooks.
 *
 * @link       https://wpdashboard.io
 * @since      2.0.0
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/includes
 */

/**
 * Communicates Available Updates
 *
 * A class definition that will send updates
 * to WP Dashboard via webhooks.
 *
 * @since      2.0.0
 * @package    Wpdashboard
 * @subpackage Wpdashboard/includes
 * @author     WP Dashboard <brianldj@gmail.com>
 */
class Wpdashboard_Updates {

    /**
     * @return mixed
     */
    public static function send() {
        
        if(!function_exists('get_theme_updates')) {
            require_once(ABSPATH . 'wp-admin/includes/update.php');
        }
        
        $client = new WP_Http();
        $body = [
            'themes' => [],
            'plugins' => [],
        ];

        $body['themes'] = get_theme_updates();
        $body['plugins'] = get_plugin_updates();

        $result = $client->post('https://my.wpdashboard.io/api/v2/sites/' . self::get_option('api_key') . '/updates', [
            'body' => $body
        ]);
        

    }

    /**
     * Get Option from Wordpress.
     *
     * @since    2.0.0
     *
     * @param $name
     * @return mixed
     */
    private static function get_option($name) {
        return get_option('wpdashboard_' . $name);
    }

}

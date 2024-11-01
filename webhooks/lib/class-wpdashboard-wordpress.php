<?php

/**
 * The webhoook-specific functionality of the plugin..
 *
 * @link       https://wpdashboard.io
 * @since      2.0.0
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/webhooks
 */

/**
 * The webhoook-specific functionality of the plugin.
 *
 * Handles sending information to WP Dashboard's server.
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/webhooks
 * @author     WP Dashboard <brianldj@gmail.com>
 */

/**
 * Required Classes
 */

trait Wpdashboard_Wordpress {

    public function initWordpress() {
        add_action( '_core_updated_successfully', [$this, 'core_update'], 10, 1);
    }

    public function core_update($version) {
        $body = [
            'version' => $version,
        ];
        $this->post('update', $body);
    }
}

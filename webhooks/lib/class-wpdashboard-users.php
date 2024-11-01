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

trait Wpdashboard_Users {

    /**
     * Init Users
     *
     * Initialize the Wordpress Users
     * class and add the actions to the
     * specified hooks required.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function initUsers() {
        add_action( 'user_register', [$this, 'user_registered'], 10, 1);
//        add_action( 'user_updated', [$this, 'user_updated'], 10, 3);
    }

    /**
     * User Registered
     *
     * Fires when a new user is registered.
     *
     * @since 2.0.0
     *
     * @param $user_id
     */
    public function user_registered($user_id) {
        $user = get_user_by('ID', $user_id);
        $body = [
            'user' => $user,
        ];
        $this->post('user/registered', $body);
    }

    /**
     * Update User
     *
     * Fires when a user is updated.
     *
     * @since 2.0.0
     *
     * @param $new_name
     * @param $new_theme
     * @param $old_theme
     */
    public function user_updated($new_name, $new_theme, $old_theme) {
        $body = [
            'name' => $new_name,
            'new_theme' => $new_theme,
            'old_theme' => $old_theme
        ];
        $this->post('theme/switched', $body);
    }
}

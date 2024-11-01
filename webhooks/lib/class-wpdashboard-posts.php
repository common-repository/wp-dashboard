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

trait Wpdashboard_Posts {

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
    public function initPosts() {
        add_action( 'wp_insert_post', [$this, 'insert_post'], 10, 2);
//        add_action( 'user_updated', [$this, 'user_updated'], 10, 3);
    }

    /**
     * Insert Post
     *
     * Fires when a post is saved.
     *
     * @since 2.0.0
     *
     * @param $post_id
     * @param $post
     *
     * @return void
     */
    public function insert_post($post_id, $post) {
        $body = (array) $post;
        $this->post('post/create', $body);
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
     *
     * @return void
     */
    public function post_updated($new_name, $new_theme, $old_theme) {
        $body = [
            'name' => $new_name,
            'new_theme' => $new_theme,
            'old_theme' => $old_theme
        ];
        $this->post('theme/switched', $body);
    }
}

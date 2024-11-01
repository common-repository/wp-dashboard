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

trait Wpdashboard_Themes {

    /**
     * Init Themes
     *
     * Initialize the Wordpress Themes
     * class and add the actions to the
     * specified hooks required.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function initThemes() {
        add_action( 'switch_theme', [$this, 'theme_switched'], 10, 3);
    }

    /**
     * Theme Switched
     *
     * Fires when a theme is switched.
     *
     * @since 2.0.0
     *
     * @param $new_name
     * @param $new_theme
     * @param $old_theme
     */
    public function theme_switched($new_name, $new_theme, $old_theme) {
        $body = [
            'name' => $new_name,
            'new_theme' => $new_theme,
            'old_theme' => $old_theme
        ];
        $this->post('theme/switched', $body);
    }
}

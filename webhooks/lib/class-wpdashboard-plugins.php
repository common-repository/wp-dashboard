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

trait Wpdashboard_Plugins {

    /**
     * Init Plugins
     *
     * Initialize the Wordpress Plugins
     * class and add the actions to the
     * specified hooks required.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function initPlugins() {
        add_action( 'upgrader_process_complete', [$this, 'plugin_installed'], 10, 2);
        add_action( 'activated_plugin', [$this, 'plugin_activated'], 10, 2);
//        add_action( 'set_site_transient_update_plugins', [$this, 'plugin_has_updates'], 10, 3);
        add_filter( "pre_set_site_transient_update_plugins", [$this, 'plugin_has_updates'], 10, 2 );
        add_action( 'upgrader_process_complete', [$this, 'plugin_updated'], 10, 2);
        add_action( 'deactivated_plugin', [$this, 'plugin_deactivated'], 10, 2);
        add_action( 'deleted_plugin', [$this, 'plugin_deleted'], 10, 2);
    }

    /**
     * Plugin Installed
     *
     * Fires when a plugin is installed.
     *
     * @since 2.0.0
     *
     * @param $upgrader
     * @param $hook
     */
    public function plugin_installed($upgrader, $hook) {
        if($hook['type'] == 'plugin' && $hook['action'] == 'install') {
            $p = $upgrader->result['destination_name'];
            $plugin = get_plugin_data(WP_DASHBOARD_PLUGIN_DIRECTORY . $p . '/' . $p . '.php');
            $body = [
                'action' => $hook['action'],
                'plugin' => $p . '/' . $p . '.php',
                'name' => $plugin['Name'],
                'version' => $plugin['Version'],
                'description' => $plugin['Description'],
            ];
            $this->post('plugin/create', $body);
        }
    }

    /**
     * Plugin Activated
     *
     * Fires when a plugin is activated.
     *
     * @since 2.0.0
     *
     * @param $p
     * @param $network_activation
     */
    public function plugin_activated($p, $network_activation) {
        $plugin = get_plugin_data(WP_DASHBOARD_PLUGIN_DIRECTORY . $p);
        $body = [
            'plugin' => $p,
            'name' => $plugin['Name'],
            'version' => $plugin['Version'],
            'description' => $plugin['Description'],
        ];
        $this->post('plugin/activate', $body);
    }

    /**
     * Plugin Has Updates
     *
     * Fires when a plugin has updates
     * available to it.
     *
     * @since 2.0.0
     *
     * @param $transient
     * @param $value
     *
     * @return mixed
     */
    public function plugin_has_updates($value, $transient) {
            if(isset($value->response)) {
                foreach ($value->response AS $plugin => $update) {
                    $p = get_plugin_data(WP_DASHBOARD_PLUGIN_DIRECTORY . $plugin);
                    $body = [
                        'plugin' => $plugin,
                        'name' => $p['Name'],
                        'version' => $p['Version'],
                        'description' => $p['Description'],
                        'new_version' => $update->new_version,
                    ];
                    if(isset($update->icons['2x'])) {
                        $body['icon'] =  $update->icons['2x'];
                    }
                    $this->post('plugin/has-update', $body);
                }
            }
            return $value;
    }

    /**
     * Plugin Updated
     *
     * Fires when a plugin is updated.
     *
     * @since 2.0.0
     *
     * @param $plugin
     * @param $network_deactivation
     */
    public function plugin_updated($upgrader, $hook) {
        if($hook['type'] == 'plugin' && $hook['action'] != 'install') {
            if(!isset($hook['plugins'])) {
                $plugin = get_plugin_data(WP_DASHBOARD_PLUGIN_DIRECTORY . $hook['plugin']);
                $body = [
                    'action' => $hook['action'],
                    'plugin' => $hook['plugin'],
                    'name' => $plugin['Name'],
                    'version' => $plugin['Version'],
                    'description' => $plugin['Description'],
                ];
                $this->post('plugin/update', $body);
            } else {
                foreach ($hook['plugins'] AS $p) {
                    $plugin = get_plugin_data(WP_DASHBOARD_PLUGIN_DIRECTORY . $p);
                    $body = [
                        'action' => $hook['action'],
                        'plugin' => $p,
                        'name' => $plugin['Name'],
                        'version' => $plugin['Version'],
                        'description' => $plugin['Description'],
                    ];
                    $this->post('plugin/update', $body);
                }
            }
        }
    }

    /**
     * Plugin Deactivated
     *
     * Fires when a plugin is deactivated.
     *
     * @since 2.0.0
     *
     * @param $plugin
     * @param $network_deactivation
     */
    public function plugin_deactivated($p, $network_deactivation) {
        $plugin = get_plugin_data(WP_DASHBOARD_PLUGIN_DIRECTORY . $p);
        $body = [
            'plugin' => $p,
            'name' => $plugin['Name'],
            'version' => $plugin['Version'],
            'description' => $plugin['Description'],
        ];
        $this->post('plugin/deactivate', $body);
    }

    /**
     * Plugin Deleted
     *
     * Fires when a plugin is deleted.
     *
     * @since 2.0.0
     *
     * @param $plugin
     * @param $deleted
     */
    public function plugin_deleted($plugin, $deleted) {
        $body = [
            'plugin' => $plugin,
            'deleted' => $deleted
        ];
        $this->post('plugin/delete', $body);
    }

}

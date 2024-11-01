<?php

/**
 * The base of the API portion.
 *
 * Sets up the base needs for the WP Dashboard
 * API. Can be used elsewhere too.
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/api
 * @author     WP Dashboard <brianldj@gmail.com>
 */

/**
 * Required Classes
 */

include_once(ABSPATH . 'wp-admin/includes/file.php');
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
include_once(ABSPATH . 'wp-includes/plugin.php');
include_once(ABSPATH . 'wp-admin/includes/theme.php');
include_once(ABSPATH . 'wp-admin/includes/misc.php');
include_once(ABSPATH . 'wp-admin/includes/template.php');
include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
require_once 'class-wp-upgrade-skin.php';

class WpDashboard_Api_Plugins extends WP_REST_Controller
{

    /**
     * WpDashboard_Api_Plugins constructor.
     * @param string $plugin_name
     * @param string $version
     */
    public function __construct($plugin_name, $version)
    {
        $this::register_routes();
    }

    /**
     * @param WP_REST_Request $request
     * @return array
     */
    public function get_all_plugins(WP_REST_Request $request)
    {
        $plugins = get_plugins();
        return $plugins;
    }

    /**
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function install_plugin(WP_REST_Request $request)
    {
        $plugin = $request->get_param('plugin');
        if ($this->check_plugin_installed($plugin)) {
            $error = new WP_Error('plugin_already_installed', 'The plugin is already installed on the site.', ['plugin' => $plugin]);
            return $error;
        }
        $plugin_slug = explode('/', $plugin)[0];
        $api = plugins_api('plugin_information', array(
            'slug' => $plugin_slug,
            'fields' => array(
                'short_description' => false,
                'sections' => false,
                'requires' => false,
                'rating' => false,
                'ratings' => false,
                'downloaded' => false,
                'last_updated' => false,
                'added' => false,
                'tags' => false,
                'compatibility' => false,
                'homepage' => false,
                'donate_link' => false,
            ),
        ));
        if (is_wp_error($api)) {
            $error = new WP_Error('plugin_not_found', 'The plugin was not found in the WordPress repository.', ['plugin' => $plugin]);
            return $error;
        }
        $skin = new WPDashboardUpdateSkin();
        $upgrader = new Plugin_Upgrader($skin);
        $install = $upgrader->install($api->download_link);
        if ($install) {
            return [
                'plugin' => $plugin,
                'installed' => true
            ];
        } else {
            $error = new WP_Error('plugin_not_installed', 'Unable to install the plugin.', ['plugin' => $plugin]);
            return $error;
        }
    }

    /**
     * @param WP_REST_Request $request
     * @return array|bool|string|WP_Error
     */
    public function update_plugin(WP_REST_Request $request)
    {
        $skin = new WPDashboardUpdateSkin();
        $current = get_site_transient('update_plugins');
        $upgrader = new Plugin_Upgrader($skin);
        $file = null;
        $info = null;
        foreach ($current->response AS $f => $i) {
            if ($f == $request->get_param('plugin')) {
                $file = $f;
                $info = $i;
                break;
            }
        }
        $update = $this->do_plugin_upgrade($upgrader, $file, $info);
        if ($update) {
            return [$file => $skin->result, 'update_info' => $update];
        } else {
            return $skin->result;
        }
    }

    /**
     * @param WP_REST_Request $request
     * @return array|null|WP_Error
     */
    public function activate_plugin(WP_REST_Request $request)
    {
        $plugin = $request->get_param('plugin');
        if (!$this->check_plugin_status($plugin)) {
            $activate = activate_plugin($plugin);
            if (is_wp_error($activate)) {
                return $activate;
            } else {
                return [
                    'plugin' => $plugin,
                    'activated' => true
                ];
            }
        } else {
            $error = new WP_Error('plugin_already_active', 'Plugin is already active.', ['plugin' => $plugin]);
            return $error;
        }
    }

    /**
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function deactivate_plugin(WP_REST_Request $request)
    {
        $plugin = $request->get_param('plugin');
        if ($this->check_plugin_status($plugin)) {
            deactivate_plugins($plugin);
            return [
                'plugin' => $plugin,
                'deactivated' => true
            ];
        } else {
            $error = new WP_Error('plugin_already_deactivated', 'Plugin is already deactivated.', ['plugin' => $plugin]);
            return $error;
        }
    }

    /**
     * @param WP_REST_Request $request
     * @return array|bool|null|WP_Error
     */
    public function delete_plugin(WP_REST_Request $request)
    {
        $plugin = $request->get_param('plugin');
        if ($this->check_plugin_status($plugin)) {
            $error = new WP_Error('plugin_is_active', 'Your plugin is active, you must deactivate it before deleting it.', ['plugin' => $plugin]);
            return $error;
        }
        $uninstall = uninstall_plugin($plugin);
        $delete = delete_plugins([$plugin]);
        if (is_wp_error($delete)) {
            return $delete;
        } else {
            return [
                'plugin' => $plugin,
                'deleted' => true
            ];
        }
    }

    /**
     * @param $plugin
     * @return bool
     */
    protected function check_plugin_status($plugin)
    {
        return is_plugin_active($plugin);
    }

    /**
     * @param $check
     * @return bool
     */
    protected function check_plugin_installed($check)
    {
        $plugins = get_plugins();
        foreach ($plugins AS $f => $i) {
            if ($f == $check) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $upgrader
     * @param $file
     * @param $info
     * @return null
     */
    protected function do_plugin_upgrade($upgrader, $file, $info)
    {
        if ($upgrader == null || $file == null || $info == null) {
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

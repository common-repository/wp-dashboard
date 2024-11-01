<?php

class WpDashboard_Plugin_Routes extends WpDashboard_Api_Base {

    /**
     * Register Routes
     *
     * Register the routes for the objects of the controller.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function register_routes() {
        $version = '1';
        $namespace = $this->plugin_name . '/v' . $version;
        $base = 'plugin';
        register_rest_route( $namespace, '/' . $base . '', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_plugins' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/install', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'install_plugin' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/activate', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'activate_plugin' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/update', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'update_plugin' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/deactivate', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'deactivate_plugin' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/delete', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'delete_plugin' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
    }

    /**
     * Get Plugins
     *
     * Get the plugins if authenticated
     * to do so.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_plugins( $request ) {

        $this->required();
        $plugins = get_plugins();
        foreach($plugins AS $plugin => $info) {
            $plugins[$plugin]['Active'] = is_plugin_active($plugin);
        }
        return new WP_REST_Response($plugins);

    }

    /**
     * Install Plugin
     *
     * Installs the plugin if authenticated
     * to do so.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_Error|WP_REST_Response
     */
    public function install_plugin( $request ) {

        $this->required();

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
            return new WP_REST_Response([
                'plugin' => $plugin,
                'installed' => true
            ], 200);
        } else {
            $error = new WP_Error('plugin_not_installed', 'Unable to install the plugin.', ['plugin' => $plugin]);
            return $error;
        }

    }

    /**
     * Activate Plugin
     *
     * Activates the plugin on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function activate_plugin($request)
    {
        $this->required();
        $plugin = $request->get_param('plugin');
        if (!is_plugin_active($plugin)) {
            $activate = activate_plugin($plugin);
            if (is_wp_error($activate)) {
                return $activate;
            } else {
                return new WP_REST_Response([
                    'plugin' => $plugin,
                    'activated' => true
                ]);
            }
        } else {
            $error = new WP_Error('plugin_already_active', 'Plugin is already active.', ['plugin' => $plugin]);
            return $error;
        }
    }

    /**
     * Update Plugin
     *
     * Updates the plugin on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function update_plugin($request)
    {
        $this->required();
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
        if ($upgrader == null || $file == null || $info == null) {
            $update = null;
        } else {
            $update = $upgrader->run(array(
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
        if ($update) {
            return new WP_REST_Response([$file => $skin->result, 'update_info' => $update]);
        } else {
            return $skin->result;
        }
    }

    /**
     * Deactivate Plugin
     *
     * Deactivates the plugin on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function deactivate_plugin($request)
    {
        $this->required();
        $plugin = $request->get_param('plugin');
        if (is_plugin_active($plugin)) {
            deactivate_plugins($plugin);
            return new WP_REST_Response([
                'plugin' => $plugin,
                'deactivated' => true
            ], 200);
        } else {
            return new WP_Error('plugin_already_deactivated', 'Plugin is already deactivated.', ['plugin' => $plugin]);
        }
    }

    /**
     * Delete Plugin
     *
     * Delete the plugin on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function delete_plugin($request)
    {
        $this->required();
        $plugin = $request->get_param('plugin');
        if (is_plugin_active($plugin)) {
            $error = new WP_Error('plugin_is_active', 'Your plugin is active, you must deactivate it before deleting it.', ['plugin' => $plugin]);
            return $error;
        }
        $uninstall = uninstall_plugin($plugin);
        $delete = delete_plugins([$plugin]);
        if (is_wp_error($delete)) {
            return $delete;
        } else {
            return new WP_REST_Response([
                'plugin' => $plugin,
                'deleted' => true
            ]);
        }
    }

    /**
     * Check Plugin Installed
     *
     * Checks to see if the plugin is
     * installed in the current
     * instance of Wordpress.
     *
     * @param $plugin
     *
     * @return bool
     */
    protected function check_plugin_installed($plugin)
    {
        $plugins = get_plugins();
        foreach ($plugins AS $f => $i) {
            if ($f == $plugin) {
                return true;
            }
        }
        return false;
    }
}
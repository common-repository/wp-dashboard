<?php

class WpDashboard_Core_Routes extends WpDashboard_Api_Base {

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
        $base = 'core';
        register_rest_route( $namespace, '/' . $base . '', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_core' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/install', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'install_core' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/activate', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'activate_core' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/update', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'update_core' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/deactivate', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'deactivate_core' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/delete', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'delete_core' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
    }

    /**
     * Get Core
     *
     * Get the core info if authenticated
     * to do so.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_core( $request ) {

        $this->required();
        $resp = [];
        $resp['themes'] = [];
        foreach(wp_get_themes(['errors' => null, 'allowed' => null]) AS $theme) {
            $resp['themes'][] = [
                'name' => $theme->Name,
                'theme_uri' => $theme->ThemeURI,
                'description' => $theme->Description,
                'author' => $theme->Author,
                'author_uri' => $theme->AuthorURI,
                'version' => $theme->Version,
                'template' => $theme->Template,
                'status' => $theme->Status,
                'tags' => $theme->Tags,
                'text_domain' => $theme->TextDomain,
                'domain_path' => $theme->DomainPath,
                'update' => $theme->update,
                'screenshot' => $theme->get_screenshot()
            ];
        }
        foreach(get_theme_updates() AS $update) {
            foreach($resp['themes'] AS $key => $theme) {
                if($theme['name'] == $update->name) {
                    $resp['themes'][$key]['update'] = $update->update;
                }
            }
        }
        return new WP_REST_Response($resp);

    }

    /**
     * Install Core
     *
     * Installs the core if authenticated
     * to do so.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_Error|WP_REST_Response
     */
    public function install_theme( $request )
    {
        return $this->stupid('install the core of wordpress');
    }

    /**
     * Activate Core
     *
     * Activates the core on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function activate_core($request)
    {
        return $this->stupid('activate the core of wordpress');
    }

    /**
     * Update Theme
     *
     * Updates the theme on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function update_theme($request)
    {
        $this->required();

        $update_available = find_core_update(get_bloginfo('version'), get_bloginfo('language'));

        if(!$update_available) {

            return new WP_REST_Response([
                'updated' => false,
                'version' => get_bloginfo('version')
            ]);

        } else {

            $upgrader = new Core_Upgrader();
            $update = $upgrader->upgrade($update_available);
            if(is_wp_error($update)) {
                return $update;
            } else {
                return new WP_REST_Response([
                    'updated' => true,
                    'version' => get_bloginfo('version')
                ]);
            }

        }
    }

    /**
     * Deactivate Core
     *
     * Deactivates the core on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function deactivate_core($request)
    {
        return $this->stupid('deactivate the core of wordpress');
    }

    /**
     * Delete Core
     *
     * Delete the core on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function delete_core($request)
    {
        return $this->stupid('delete the core of wordpress');
    }
}
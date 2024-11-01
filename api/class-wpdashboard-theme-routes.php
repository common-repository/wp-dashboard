<?php

class WpDashboard_Theme_Routes extends WpDashboard_Api_Base {

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
        $base = 'theme';
        register_rest_route( $namespace, '/' . $base . '', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_themes' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/install', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'install_theme' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/activate', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'activate_theme' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/update', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'update_theme' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/deactivate', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'deactivate_theme' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/delete', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'delete_theme' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
    }

    /**
     * Get Themes
     *
     * Get the themes if authenticated
     * to do so.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_themes( $request ) {

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
     * Install Theme
     *
     * Installs the theme if authenticated
     * to do so.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_Error|WP_REST_Response
     */
    public function install_theme( $request ) {

        $this->required();

        return $this->coming_soon('install plugin', 2.1);

    }

    /**
     * Activate Theme
     *
     * Activates the theme on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function activate_theme($request)
    {
        $this->required();

        return $this->coming_soon('activate theme', 2.1);
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

        return $this->coming_soon('update theme', 2.1);
    }

    /**
     * Deactivate Theme
     *
     * Deactivates the theme on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function deactivate_theme($request)
    {
        $this->required();

        return $this->coming_soon('deactivate theme', 2.1);
    }

    /**
     * Delete Theme
     *
     * Delete the theme on
     * the site.
     *
     * @since 2.0.0
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function delete_theme($request)
    {
        $this->required();

        return $this->coming_soon('delete theme', 2.1);
    }
}
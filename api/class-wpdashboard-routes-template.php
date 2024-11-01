<?php

class WpDashboard_Routes_Template extends WpDashboard_Api_Base {

    /**
     * Register Routes
     *
     * Register the routes for the objects of the controller.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function register_routes()
    {
        $version = '1';
        $namespace = $this->plugin_name . '/v' . $version;
        $base = 'page';
        register_rest_route( $namespace, '/' . $base . '', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/install', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'install_item' ),
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
                'callback'            => array( $this, 'update_item' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/deactivate', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'deactivate_item' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/delete', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'delete_item' ),
                'permission_callback' => array( $this, 'permission_check' ),
                'args'                => [

                ]
            ),
        ) );
    }

    /**
     * Get Items
     *
     * Get the items if authenticated
     * to do so.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_items( $request )
    {
        $this->required();

        return new WP_REST_Response();
    }

    /**
     * Install Item
     *
     * Installs the theme if authenticated
     * to do so.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @return WP_Error|WP_REST_Response
     */
    public function install_item( $request )
    {
        $this->required();
    }

    /**
     * Activate Item
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
    }

    /**
     * Update Item
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
    public function update_item($request)
    {
        $this->required();
    }

    /**
     * Deactivate Item
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
    public function deactivate_item($request)
    {
        $this->required();
    }

    /**
     * Delete Item
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
    public function delete_item($request)
    {
        $this->required();
    }
}
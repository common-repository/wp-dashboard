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
require_once 'lib/class-wpdashboard-plugins.php';
require_once 'lib/class-wpdashboard-posts.php';
require_once 'lib/class-wpdashboard-themes.php';
require_once 'lib/class-wpdashboard-users.php';
require_once 'lib/class-wpdashboard-wordpress.php';

class Wpdashboard_WebHooks {

    use Wpdashboard_Plugins;
    use Wpdashboard_Themes;
    use Wpdashboard_Users;
    use Wpdashboard_Posts;
    use Wpdashboard_Wordpress;

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    2.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The request made to the API.
     *
     * @since    2.0.0
     * @access   private
     * @var      string    $request_type    The current request made to the API.
     */
    private $request_type;

    /**
     * A GuzzleHTTP client used to communicate with WPDashboard.io.
     *
     * @since    2.0.0
     * @access   private
     * @var      string    $request_type    The current request made to the API.
     */
    private $client;

    /**
     * The endpoint for the API.
     *
     * @since    2.0.0
     * @access   private
     * @var      string    $url    The URL endpoint for the API.
     */

    private $url = 'https://my.wpdashboard.io/api/site/';

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->client = new WP_Http();

	}

    /**
     * Init
     *
     * Initializes the script and adds the webhook catches
     * into place.
     *
     * @since    2.0.0
     *
     * @returns void
     */
    public function init() {
        $this->initPlugins();
        $this->initThemes();
        $this->initUsers();
        $this->initWordpress();
        $this->initPosts();
    }

    /**
     * Post
     *
     * Send the request to the webhook endpoints.
     *
     * @since    2.0.0
     *
     * @param $endpoint string The endpoint for the webhooks to hit.
     * @param $data array The body of the post, including all of the data.
     * @return mixed
     */
    protected function post($endpoint, $data) {
        $result = $this->client->post($this->url . $endpoint, [
            'body' => array_merge($data, ['api_key' => $this->get_option('api_key')])
        ]);
        return $result;
    }

    /**
     * Get Option from Wordpress.
     *
     * @since    2.0.0
     *
     * @param $name
     * @return mixed
     */
    public function get_option($name) {
        return get_option($this->plugin_name . '_' . $name);
    }

    /**
     * Update Option from Wordpress.
     *
     * @since    2.0.0
     *
     * @param $name
     * @param $value
     * @param $autoload
     * @return mixed
     */
    public function update_option($name, $value, $autoload) {
        return update_option($this->plugin_name . '_' . $name, $value, $autoload);
    }

    /**
     * Delete Option from Wordpress.
     *
     * @since    2.0.0
     *
     * @param $name
     * @return mixed
     */
    public function delete_option($name) {
        return delete_option($this->plugin_name . '_' . $name);
    }



}

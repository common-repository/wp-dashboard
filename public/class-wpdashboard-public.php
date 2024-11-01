<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpdashboard.io
 * @since      1.0.0
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/public
 * @author     WP Dashboard <brianldj@gmail.com>
 */
class Wpdashboard_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

    /**
     * Get Option from Wordpress.
     *
     * @since    1.0.0
     *
     * @param $name
     * @return mixed
     */
    public function get_option($name) {
        return get_option($this->plugin_name . '_' . $name);
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpdashboard_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpdashboard_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

//		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpdashboard-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpdashboard_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpdashboard_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        if(get_option('wpdashboard_connected')) {
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpdashboard-public.js', array( 'jquery' ), $this->version, false );
            wp_add_inline_script( $this->plugin_name, "let wpdashboard_key = '" . get_option('wpdashboard_public_key') ."';", 'before' );
            wp_add_inline_script( $this->plugin_name, "let is_404 = '" . (is_404()?'false':'true') ."';", 'before' );
            add_action('wp_head', function() {
                $id = $this->get_option('tag_manager_id');
            	if($id) {
                    ?>
<script>
	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','<?php echo $id; ?>');
</script>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $id; ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                    <?php
                }
            });

            if($this->get_option('hubspot_id')) {
                wp_enqueue_script( 'hubspot-tracking-script', '//js.hs-scripts.com/' . $this->get_option('hubspot_id') . '.js', [], false, true );
			}

        	add_filter('script_loader_tag', array($this, 'asyncDeferScript'), 10, 2);
        }
	}

    /**
     * Async Defer Script
     *
     * Defer the Hubspot Script to
     * load later.
     *
     * @since 2.0
     *
     * @param $tag
     * @param $handle
     *
     * @return mixed
     */
    public function asyncDeferScript($tag, $handle) {

        if ($handle == 'hubspot-tracking-script') {
            return str_replace(' src', ' async defer src', $tag);
        } else {
            return $tag;
		}
	}

    /**
     * Autologin
     *
     * Function to autologin to account
     * based on the URL.
     *
     * @since 2.0
     *
     * @return void
     */
    function autologin() {
	    if(isset($_GET['autologin'])) {
            if ($_GET['autologin'] == $this->get_option('api_key')) {
                $user = get_user_by('login', $_GET['user_login']);
                wp_clear_auth_cookie();
                wp_set_current_user ( $user->ID );
                wp_set_auth_cookie  ( $user->ID );
                $redirect_to = user_admin_url();
                wp_safe_redirect( $redirect_to );
            }
        }
    }

}
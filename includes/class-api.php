<?php
/**
 * Register custom routes for retrieving values via REST API.
 *
 * @package         ifblock
 * @since           1.2.0
 */

namespace IfBlock\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	wp_die();
} // End If Statement

if ( ! class_exists( 'API' ) ) :
	/**
	 * The REST API - Class
	 */
	final class API {
		/**
		 * Version of the route.
		 *
		 * @var  string   $version
		 */
		private $version;

		/**
		 * The first URL segment after core prefix.
		 *
		 * @var  string   $namespace
		 */
		private $namespace;

		/**
		 * Constructor.
		 *
		 * @return  void
		 */
		public function __construct() {
			$this->version   = '1';
			$this->namespace = sprintf( '%s/v%s', IFBLOCK_SLUG, $this->version );
		}

		/**
		 * Initialize all of the plugin functions.
		 *
		 * @return  void
		 */
		public function init() {
			add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
		}

		/**
		 * Register REST API routes
		 *
		 * @return  void
		 */
		public function register_rest_routes() {
			// Registers custom REST API routes.
			register_rest_route(
				$this->namespace,
				'/user-roles',
				array(
					'methods'             => 'GET',
					'callback'            => sprintf( '%s::get_user_roles', __CLASS__ ),
					'permission_callback' => sprintf( '%s::get_permission', __CLASS__ ),
				)
			);
			register_rest_route(
				$this->namespace,
				'/browsers',
				array(
					'methods'             => 'GET',
					'callback'            => sprintf( '%s::get_browsers', __CLASS__ ),
					'permission_callback' => sprintf( '%s::get_permission', __CLASS__ ),
				)
			);
		}

		/**
		 * Get the user roles
		 *
		 * @return $roles JSON feed of returned objects
		 */
		public static function get_user_roles() {
			// Core class used to implement a user roles API.
			global $wp_roles;

			$roles      = array(
				array(
					'value' => '',
					'label' => esc_html_x( 'None', 'role name', 'ifblock' ),
				),
			);
			$user_roles = $wp_roles->roles;

			foreach ( $user_roles as $key => $role ) {
				$roles[] = array(
					'value' => (string) $key,
					'label' => (string) $role['name'],
				);
			} // End of the loop.

			// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores, WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
			return apply_filters( sprintf( '%s_api_user_roles', __NAMESPACE__ ), $roles );
		}

		/**
		 * Get the browser names
		 *
		 * @return $browsers JSON feed of static objects
		 */
		public static function get_browsers() {
			$browsers = array(
				array(
					'value' => '',
					'label' => esc_html_x( 'None', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_chrome',
					'label' => esc_html_x( 'Google Chrome', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_safari',
					'label' => esc_html_x( 'Safari', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_iphone',
					'label' => esc_html_x( 'iPhone Safari', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_NS4',
					'label' => esc_html_x( 'Netscape 4', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_gecko',
					'label' => esc_html_x( 'FireFox', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_opera',
					'label' => esc_html_x( 'Opera', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_edge',
					'label' => esc_html_x( 'Microsoft Edge', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_IE',
					'label' => esc_html_x( 'Internet Explorer', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_macIE',
					'label' => esc_html_x( 'Mac Internet Explorer', 'browser name', 'ifblock' ),
				),
				array(
					'value' => 'is_winIE',
					'label' => esc_html_x( 'Windows Internet Explorer', 'browser name', 'ifblock' ),
				),
			);

			// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores, WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
			return apply_filters( sprintf( '%s_api_browsers', __NAMESPACE__ ), $browsers );
		}

		/**
		 * Determine whether the current user has at least "Editor" role capabilities.
		 *
		 * @return bool
		 */
		public static function get_permission() {
			return current_user_can( 'edit_others_posts' );
		}

	}
endif;

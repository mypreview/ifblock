<?php
/**
 * Register custom routes for retrieving values via REST API.
 *
 * @package         ifblocks\mypreview
 * @since           1.0.0
 */

namespace ifblocks\mypreview;

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
		 * Slug of the namespace.
		 *
		 * @var  string   $slug
		 */
		private $slug;

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
			$this->slug      = str_replace( '-', '', IFBLOCKS_SLUG );
			$this->namespace = sprintf( '%s/v%s', $this->slug, $this->version );

		}

		/**
		 * Initialize all of the plugin functions.
		 *
		 * @return  void
		 */
		public function init() {

			add_action( 'init', array( $this, 'user_roles' ) );

		}

		/**
		 * Register REST API routes
		 *
		 * @return  void
		 */
		public function user_roles() {

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

			$roles      = array();
			$user_roles = $wp_roles->roles;

			foreach ( $user_roles as $key => $role ) {
				$roles[] = array(
					'value' => (string) $key,
					'label' => (string) $role['name'],
				);
			}

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
					'value' => 'is_chrome',
					'label' => esc_html_x( 'Google Chrome', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_safari',
					'label' => esc_html_x( 'Safari', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_iphone',
					'label' => esc_html_x( 'iPhone Safari', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_NS4',
					'label' => esc_html_x( 'Netscape 4', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_gecko',
					'label' => esc_html_x( 'FireFox', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_opera',
					'label' => esc_html_x( 'Opera', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_edge',
					'label' => esc_html_x( 'Microsoft Edge', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_IE',
					'label' => esc_html_x( 'Internet Explorer', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_macIE',
					'label' => esc_html_x( 'Mac Internet Explorer', 'browser name', 'ifblocks' ),
				),
				array(
					'value' => 'is_winIE',
					'label' => esc_html_x( 'Windows Internet Explorer', 'browser name', 'ifblocks' ),
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

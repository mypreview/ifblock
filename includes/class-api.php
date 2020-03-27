<?php
/**
 * Register custom routes for retrieving values via REST API.
 *
 * @package         ifblocks
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
			$this->namespace = sprintf( 'ifblocks/v%s', $this->version );

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
		 * Register REST API
		 *
		 * @return  void
		 */
		public function user_roles() {

			// Registers a REST API route.
			register_rest_route(
				$this->namespace,
				'/user-roles',
				array(
					'methods'             => 'GET',
					'callback'            => sprintf( '%s::get_user_roles', __CLASS__ ),
					'permission_callback' => function () {
						return current_user_can( 'edit_others_posts' );
					},
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

			return $roles;

		}

	}
endif;

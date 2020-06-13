<?php
/**
 * The main loader class for the displaying if-block.
 *
 * @package         ifblock
 * @since           1.2.0
 */

namespace IfBlock\Includes;

use IfBlock\Includes\API as API;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	wp_die();
} // End If Statement

if ( ! class_exists( 'Block' ) ) :
	/**
	 * The If Block - Class
	 */
	final class Block {
		/**
		 * Constructor.
		 *
		 * @return  void
		 */
		public function __construct() {}

		/**
		 * Initialize all of the plugin functions.
		 *
		 * @return  void
		 */
		public function init() {
			$this->includes();
			$this->register_block();
		}

		/**
		 * Include required files.
		 *
		 * @return void
		 */
		private function includes() {
			$api = new API();
			$api->init();
		}

		/**
		 * Register the dynamic block.
		 *
		 * @return void
		 */
		public function register_block() {
			// Hook server side rendering into render callback.
			register_block_type(
				'mypreview/ifblock',
				array(
					'editor_style'    => sprintf( '%s-style', IFBLOCK_SLUG ),
					'editor_script'   => sprintf( '%s-script', IFBLOCK_SLUG ),
					'render_callback' => sprintf( '%s::render_callback', __CLASS__ ),
				)
			);
		}

		/**
		 * Render callback for the dynamic block.
		 *
		 * @param  array $attributes     Attributes passed from the JS file.
		 * @param  mixed $content        Content of the block.
		 * @return mixed
		 */
		public static function render_callback( $attributes, $content ) {
			// Bail early, in case the request is for an administrative interface page.
			if ( is_admin() ) {
				return $content;
			} // End If Statement

			$get_operator = isset( $attributes['operator'] ) ? (string) strtolower( $attributes['operator'] ) : null;
			$get_role     = isset( $attributes['role'] ) ? (string) strtolower( $attributes['role'] ) : null;
			$get_browser  = isset( $attributes['browser'] ) ? (string) strtolower( $attributes['browser'] ) : null;

			// Bail early, in case both role and browser are empty/missing/not-provided.
			if ( empty( $get_role ) && empty( $get_browser ) ) {
				return $content;
			} elseif ( empty( $get_role ) || empty( $get_browser ) ) {
				// Set the conditional operator to `OR` in case (only) one of the conditions are set.
				$get_operator = 'or';
			} // End If Statement

			$is_match                 = false;
			$is_role                  = false;
			$is_browser               = false;
			$get_current_user_role    = self::get_current_user_role();
			$get_current_user_browser = self::get_current_user_browser();

			// Check whether the `Role` condition has set?
			if ( ! empty( $get_role ) && $get_role === $get_current_user_role ) {
				$is_role = true;
			} // End If Statement

			// Check whether the `Browser` condition has set?
			if ( ! empty( $get_browser ) && $get_browser === $get_current_user_browser ) {
				$is_browser = true;
			} // End If Statement

			if ( 'or' === $get_operator ) {
				if ( $is_role || $is_browser ) {
					$is_match = true;
				} // End If Statement
			} else {
				if ( $is_role && $is_browser ) {
					$is_match = true;
				} // End If Statement
			} // End If Statement

			// Serves as the root of the document tree.
			$dom = new \DOMDocument();
			// Load XML from the given post content.
			$dom->loadXML( $content );

			// Retrieve selected html from the DOM.
			$finder                 = new \DomXPath( $dom );
			$if_block_classname     = 'wp-block-mypreview-ifblock-inner-if';
			$if_block_content       = $finder->query( "//div[contains(@class, '$if_block_classname')]" );
			$else_block_classname   = 'wp-block-mypreview-ifblock-inner-else';
			$else_block_content     = $finder->query( "//div[contains(@class, '$else_block_classname')]" );
			$if_block_content_dom   = new \DOMDocument();
			$else_block_content_dom = new \DOMDocument();

			foreach ( $if_block_content as $node ) {
				// Adds new child at the end of the children.
				$if_block_content_dom->appendChild( $if_block_content_dom->importNode( $node, true ) );
			} // End of the loop.

			foreach ( $else_block_content as $node ) {
				// Adds new child at the end of the children.
				$else_block_content_dom->appendChild( $else_block_content_dom->importNode( $node, true ) );
			} // End of the loop.

			$if_block_content   = trim( $if_block_content_dom->saveHTML() );
			$else_block_content = trim( $else_block_content_dom->saveHTML() );

			if ( $is_match ) {
				return $if_block_content;
			} else {
				return $else_block_content;
			} // End If Statement
		}

		/**
		 * Get user's role.
		 *
		 * @return  bool|string       The user's role, or false on failure.
		 */
		public static function get_current_user_role() {
			// Retrieve the current user object.
			$user = wp_get_current_user();
			return $user->roles ? strtolower( $user->roles[0] ) : false;
		}

		/**
		 * Get user's browser.
		 *
		 * @return  null|string       The user's browser name.
		 */
		public static function get_current_user_browser() {
			$browser  = null;
			$browsers = apply_filters(
				'ifblock_wp_global_browser_names',
				array(
					'is_iphone',
					'is_chrome',
					'is_safari',
					'is_NS4',
					'is_opera',
					'is_macIE',
					'is_winIE',
					'is_gecko',
					'is_lynx',
					'is_IE',
					'is_edge',
				)
			);

			if ( is_array( $browsers ) && ! empty( $browsers ) ) {
				// Search and filter the classnames using a callback function.
				$browser = join(
					' ',
					array_filter(
						$browsers,
						function( $browser ) {
							return $GLOBALS[ $browser ];
						}
					)
				);
			} // End If Statement

			return strtolower( $browser );
		}

	}
endif;

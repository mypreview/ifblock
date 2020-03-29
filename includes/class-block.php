<?php
/**
 * The main loader class for the displaying if-block.
 *
 * @package         ifblock\mypreview
 * @since           1.0.0
 */

namespace ifblock\mypreview;

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

			require_once sprintf( '%sincludes/class-api.php', IFBLOCK_DIR_PATH );
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
		 * @param  html  $content        Content of the block.
		 * @return html
		 */
		public static function render_callback( $attributes, $content ) {

			if ( is_admin() ) {
				return $content;
			}

			$get_role    = isset( $attributes['role'] ) ? (string) strtolower( $attributes['role'] ) : null;
			$get_browser = isset( $attributes['browser'] ) ? (string) strtolower( $attributes['browser'] ) : null;

			if ( empty( $get_role ) && empty( $get_browser ) ) {
				return $content;
			}

			$has_match                = false;
			$get_current_user_role    = self::get_current_user_role();
			$get_current_user_browser = self::get_current_user_browser();

			if ( ! empty( $get_role ) && $get_role === $get_current_user_role ) {
				$has_match = true;
			}

			$dom = new \DomDocument();
			$dom->loadXML( $content );

			$finder                 = new \DomXPath( $dom );
			$if_block_classname     = 'wp-block-mypreview-ifblock-inner-if';
			$if_block_content       = $finder->query( "//div[contains(@class, '$if_block_classname')]" );
			$else_block_classname   = 'wp-block-mypreview-ifblock-inner-else';
			$else_block_content     = $finder->query( "//div[contains(@class, '$else_block_classname')]" );
			$if_block_content_dom   = new \DOMDocument();
			$else_block_content_dom = new \DOMDocument();

			foreach ( $if_block_content as $node ) {
				$if_block_content_dom->appendChild( $if_block_content_dom->importNode( $node, true ) );
			}

			foreach ( $else_block_content as $node ) {
				$else_block_content_dom->appendChild( $else_block_content_dom->importNode( $node, true ) );
			}

			$if_block_content   = trim( $if_block_content_dom->saveHTML() );
			$else_block_content = trim( $else_block_content_dom->saveHTML() );

			if ( $has_match ) {
				return $if_block_content;
			} else {
				return $else_block_content;
			}

		}

		/**
		 * Get user's role.
		 *
		 * @return  bool|string       The user's role, or false on failure.
		 */
		public static function get_current_user_role() {

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
				// Search and filter the classnames using a callback function
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

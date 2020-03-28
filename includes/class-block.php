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
					'render_callback' => sprintf( '%s::render_callback()', __CLASS__ ),
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

			return $content;

		}

	}
endif;

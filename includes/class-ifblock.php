<?php
/**
 * The main loader class for the displaying if-block.
 *
 * @package         ifblocks\mypreview
 * @since           1.0.0
 */

namespace ifblocks\mypreview;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	wp_die();
} // End If Statement

if ( ! class_exists( 'IfBlock' ) ) :

	/**
	 * The If Block - Class
	 */
	final class IfBlock {

		/**
		 * Slug of registering block type.
		 *
		 * @var  string   $slug
		 */
		private $slug;

		/**
		 * Constructor.
		 *
		 * @return  void
		 */
		public function __construct() {

			$this->slug = str_replace( '\\', '/', __NAMESPACE__ );

		}

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

			require_once sprintf( '%sincludes/class-api.php', IFBLOCKS_DIR_PATH );
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
				$this->slug,
				array(
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

		}

	}
endif;

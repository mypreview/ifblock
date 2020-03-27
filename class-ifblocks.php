<?php
/**
 * The `If Blocks` bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * You can redistribute this plugin/software and/or modify it under
 * the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * @link                    https://www.mypreview.one
 * @since                   1.0.0
 * @package                 ifblocks\mypreview
 *
 * @wordpress-plugin
 * Plugin Name:             If Blocks
 * Plugin URI:              https://www.mypreview.one
 * Description:             XXXX
 * Version:                 1.0.0
 * Author:                  MyPreview
 * Author URI:              https://www.mypreview.one
 * License:                 GPL-3.0
 * License URI:             http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:             ifblocks
 * Domain Path:             /languages
 */

namespace ifblocks\mypreview;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	wp_die();
} // End If Statement

/**
 * Gets the path to a plugin file or directory.
 *
 * @see     https://codex.wordpress.org/Function_Reference/plugin_basename
 * @see     http://php.net/manual/en/language.constants.predefined.php
 */
define( 'IFBLOCKS_FILE', __FILE__ );
define( 'IFBLOCKS_VERSION', get_file_data( IFBLOCKS_FILE, array( 'version' => 'Version' ) )['version'] );
define( 'IFBLOCKS_NAME', get_file_data( IFBLOCKS_FILE, array( 'name' => 'Plugin Name' ) )['name'] );
define( 'IFBLOCKS_SLUG', dirname( plugin_basename( IFBLOCKS_FILE ) ) );
define( 'IFBLOCKS_BASENAME', basename( IFBLOCKS_FILE ) );
define( 'IFBLOCKS_PLUGIN_BASENAME', plugin_basename( IFBLOCKS_FILE ) );
define( 'IFBLOCKS_DIR_URL', plugin_dir_url( IFBLOCKS_FILE ) );
define( 'IFBLOCKS_DIR_PATH', plugin_dir_path( IFBLOCKS_FILE ) );

if ( ! class_exists( 'IfBlocks' ) ) :

	/**
	 * The If Blocks - Class
	 */
	final class IfBlocks {

		/**
		 * Instance of the class.
		 *
		 * @var  object   $instance
		 */
		private static $instance = null;

		/**
		 * Main IfBlocks Instance.
		 *
		 * Insures that only one instance of IfBlocks exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @return object|IfBlocks The one true IfBlocks
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof IfBlocks ) ) {
				self::$instance = new IfBlocks();
				self::$instance->init();
				self::$instance->includes();
			}
			return self::$instance;
		}

		/**
		 * Cloning instances of this class is forbidden.
		 *
		 * @return  void
		 */
		protected function __clone() {

			_doing_it_wrong( __FUNCTION__, esc_html_x( 'Cloning instances of this class is forbidden.', 'clone', 'ifblocks' ), esc_html( IFBLOCKS_FILE ) );

		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @return  void
		 */
		public function __wakeup() {

			_doing_it_wrong( __FUNCTION__, esc_html_x( 'Unserializing instances of this class is forbidden.', 'wakeup', 'ifblocks' ), esc_html( IFBLOCKS_FILE ) );

		}

		/**
		 * Load actions
		 *
		 * @return void
		 */
		private function init() {

			add_action( 'plugins_loaded', array( self::instance(), 'load_textdomain' ), 99 );
			add_action( 'enqueue_block_editor_assets', array( self::instance(), 'block_localization' ) );

		}

		/**
		 * Include required files.
		 *
		 * @return void
		 */
		private function includes() {

			require_once sprintf( '%sincludes/class-ifblock.php', IFBLOCKS_DIR_PATH );
			$if_block = new IfBlock();
			$if_block->init();

		}

		/**
		 * Load languages file and text domains.
		 * Define the internationalization functionality.
		 *
		 * @return void
		 */
		public function load_textdomain() {

			load_plugin_textdomain( 'ifblocks', false, sprintf( '%s/languages/', IFBLOCKS_SLUG ) );

		}

		/**
		 * Enqueue localization data for our blocks.
		 *
		 * @return void
		 */
		public function block_localization() {

			wp_set_script_translations( 'ifblocks-editor', 'ifblocks', sprintf( '%s/languages/', IFBLOCKS_DIR_PATH ) );

		}

	}
endif;

/**
 * The main function for that returns IfBlocks
 *
 * The main function responsible for returning the one true IfBlocks
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @return object|IfBlocks The one true IfBlocks Instance.
 */
function ifblocks() {
	return IfBlocks::instance();
}

// Get the plugin running. Load on plugins_loaded action to avoid issue on multisite.
if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	add_action( 'plugins_loaded', sprintf( '%s\ifblocks', __NAMESPACE__ ), 90 );
} else {
	ifblocks();
}

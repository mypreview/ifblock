<?php
/**
 * The `If Block` bootstrap file.
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
 * @package                 ifblock\mypreview
 *
 * @wordpress-plugin
 * Plugin Name:             If Block — Visibility control for Blocks
 * Plugin URI:              https://www.mypreview.one
 * Description:             This block enables you to configure certain content to appear only if specified conditions are met (or be hidden) by setting different visibility rules.
 * Version:                 1.0.0
 * Author:                  MyPreview
 * Author URI:              https://www.mypreview.one
 * License:                 GPL-3.0
 * License URI:             http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:             ifblock
 * Domain Path:             /languages
 */

namespace ifblock\mypreview;

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
define( 'IFBLOCK_FILE', __FILE__ );
define( 'IFBLOCK_SLUG', 'ifblock' );
define( 'IFBLOCK_VERSION', get_file_data( IFBLOCK_FILE, array( 'version' => 'Version' ) )['version'] );
define( 'IFBLOCK_DIR_URL', plugin_dir_url( IFBLOCK_FILE ) );
define( 'IFBLOCK_DIR_PATH', plugin_dir_path( IFBLOCK_FILE ) );

if ( ! class_exists( 'IfBlock' ) ) :
	/**
	 * The If Block - Class
	 */
	final class IfBlock {
		/**
		 * Instance of the class.
		 *
		 * @var  object   $instance
		 */
		private static $instance = null;

		/**
		 * Main IfBlock Instance.
		 *
		 * Insures that only one instance of IfBlock exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @return object|IfBlock The one true IfBlock
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof IfBlock ) ) {
				self::$instance = new IfBlock();
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
			_doing_it_wrong( __FUNCTION__, esc_html_x( 'Cloning instances of this class is forbidden.', 'clone', 'ifblock' ), esc_html( IFBLOCK_FILE ) );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @return  void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html_x( 'Unserializing instances of this class is forbidden.', 'wakeup', 'ifblock' ), esc_html( IFBLOCK_FILE ) );
		}

		/**
		 * Load actions
		 *
		 * @return void
		 */
		private function init() {
			add_action( 'plugins_loaded', array( self::instance(), 'load_textdomain' ), 99 );
			add_action( 'enqueue_block_editor_assets', array( self::instance(), 'block_editor_assets' ) );
		}

		/**
		 * Include required files.
		 *
		 * @return void
		 */
		private function includes() {
			require_once sprintf( '%sincludes/class-block.php', IFBLOCK_DIR_PATH );
			$block = new Block();
			$block->init();
		}

		/**
		 * Load languages file and text domains.
		 * Define the internationalization functionality.
		 *
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'ifblock', false, sprintf( '%s/languages/', IFBLOCK_SLUG ) );
		}

		/**
		 * Enqueue localization data for our blocks.
		 *
		 * @return void
		 */
		public function block_editor_assets() {
			// Enqueue the stylesheet.
			wp_register_style( sprintf( '%s-style', IFBLOCK_SLUG ), sprintf( '%sdist/style.css', IFBLOCK_DIR_URL ), array( 'wp-edit-blocks' ), IFBLOCK_VERSION, 'screen' );
			// Add metadata to the stylesheet.
			wp_style_add_data( sprintf( '%s-style', IFBLOCK_SLUG ), 'rtl', 'replace' );

			$script_path       = sprintf( '%sdist/script.js', IFBLOCK_DIR_PATH );
			$script_asset_path = sprintf( '%sdist/script.asset.php', IFBLOCK_DIR_PATH );
			$script_asset      = file_exists( $script_asset_path ) ? require $script_asset_path : array(
				'dependencies' => array( 'wp-blocks', 'wp-dom-ready' ),
				'version'      => filemtime( $script_path ),
			);
			$script_url        = sprintf( '%sdist/script.js', IFBLOCK_DIR_URL );
			// Enqueue the JavaScript.
			wp_register_script( sprintf( '%s-script', IFBLOCK_SLUG ), $script_url, $script_asset['dependencies'], $script_asset['version'], true );
			wp_set_script_translations( sprintf( '%s-script', IFBLOCK_SLUG ), 'ifblock', sprintf( '%s/languages/', IFBLOCK_DIR_PATH ) );
		}

	}
endif;

/**
 * The main function for that returns IfBlock
 *
 * The main function responsible for returning the one true IfBlock
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @return object|IfBlock The one true IfBlock Instance.
 */
function ifblock() {
	return IfBlock::instance();
}

// Get the plugin running. Load on plugins_loaded action to avoid issue on multisite.
if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	add_action( 'plugins_loaded', sprintf( '%s\ifblock', __NAMESPACE__ ), 90 );
} else {
	ifblock();
} // End If Statement

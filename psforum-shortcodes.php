<?php
/**
 * Plugin Name: PS Forum Shortcodes
 * Plugin URI:  https://n3rds.work/docs/ps-forum-shortcodes-handbuch/
 * Description: Das PS Forum Shortcodes-Plugin bietet eine TinyMCE-Dropdown-Schaltfläche im visuellen Editor, auf die Benutzer zugreifen können, um alle PSForum-Shortcodes zu verwenden.
 * Version:     2.1
 * Author:      DerN3rd
 * Author URI:  https://n3rds.work
 * License:     GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * Text Domain: psforum-shortcodes
 *
 *
 * PSForum Shortcodes is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * PSForum Shortcodes is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PSForum Shortcodes. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */
require 'psource/psource-plugin-update/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://n3rds.work//wp-update-server/?action=get_metadata&slug=ps-forum-shortcodes', 
	__FILE__, 
	'ps-forum-shortcodes' 
);

/**
 * Includes necessary dependencies and starts the plugin.
 *
 * @package PSFS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exits if accessed directly.
}

if ( ! class_exists( 'PSForum_Shortcodes' ) ) {

	/**
	 * Main PSForum Shortcodes Class.
	 *
	 * @class PSForum_Shortcodes
	 */
	final class PSForum_Shortcodes {

		/**
		 * Stores plugin options.
		 */
		public $opt;

		/**
		 * Core singleton class
		 * @var self
		 */
		private static $_instance;

		/**
		 * PSForum Shortcodes Constructor.
		 */
		public function __construct() {
			$this->opt = get_option( 'psforum_shortcodes' );
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
		}

		/**
		 * Gets the instance of this class.
		 *
		 * @return self
		 */
		public static function getInstance() {
			if ( ! ( self::$_instance instanceof self ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Defines PSForum Shortcodes Constants.
		 */
		private function define_constants() {
			define( 'PSFS_VERSION', '2.1' );
			define( 'PSFS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			define( 'PSFS_PLUGIN_FILE', __FILE__ );
		}

		/**
		 * Includes required core files used in admin and on the frontend.
		 */
		public function includes() {
			require_once PSFS_PLUGIN_DIR . 'includes/class-psfs-activator.php';
			require_once PSFS_PLUGIN_DIR . 'includes/class-psfs-deactivator.php';
			require_once PSFS_PLUGIN_DIR . 'includes/class-psfs-i18n.php';
			if ( is_admin() ) {
				require_once PSFS_PLUGIN_DIR . 'admin/class-psfs-admin.php';
			} else {
				require_once PSFS_PLUGIN_DIR . 'public/class-psfs-public.php';
			}
			require_once PSFS_PLUGIN_DIR . 'includes/class-psfs-loader.php';
		}

		/**
		 * Hooks into actions and filters.
		 */
		private function init_hooks() {
			// Executes necessary actions on plugin activation and deactivation.
			register_activation_hook( PSFS_PLUGIN_FILE, array( 'PSFS_Activator', 'activate' ) );
			register_deactivation_hook( PSFS_PLUGIN_FILE, array( 'PSFS_Deactivator', 'deactivate' ) );
		}
	}
}

/**
 * Starts plugin execution.
 */
$psfs = PSForum_Shortcodes::getInstance();
new PSFS_Loader( $psfs );

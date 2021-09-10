<?php
/**
 * Defines the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0
 * @package    PSFS
 * @subpackage PSFS/includes
 * @author     Free WPTP <mozillavvd@gmail.com>
 */

if ( ! class_exists( 'PSFS_i18n' ) ) {

	class PSFS_i18n {

		/**
		 * Core singleton class
		 * @var self
		 */
		private static $_instance;

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
		 * Loads the plugin text domain for translation.
		 *
		 * @since    1.0
		 */
		public function load_plugin_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'psforum-shortcodes' );

			load_textdomain( 'psforum-shortcodes', trailingslashit( WP_LANG_DIR ) . 'psforum-shortcodes/psforum-shortcodes-' . $locale . '.mo' );
			load_plugin_textdomain( 'psforum-shortcodes', false, dirname( dirname( plugin_basename( PSFS_PLUGIN_FILE ) ) ) . '/languages/' );
		}


		/**
		 * TinyMCE locales function.
		 */
		function add_tinymce_locales( $locales ) {
			$locales['psforum_shortcodes'] = plugin_dir_path( __FILE__ ) . 'psf-shortcodes-editor-i18n.php';

			return $locales;
		}
	}
}

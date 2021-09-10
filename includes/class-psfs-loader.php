<?php
/**
 * The class is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin.
 *
 * The class includes an instance to the plugin
 * Loader which is responsible for coordinating the hooks that exist within the
 * plugin.
 *
 * @since    1.0
 * @package PSFS
 */

if ( ! class_exists( 'PSFS_Loader' ) ) {

	class PSFS_Loader {

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
		 * Instantiates the plugin by setting up the core properties and loading
		 * all necessary dependencies and defining the hooks.
		 *
		 * The constructor uses internal functions to import all the
		 * plugin dependencies, and will leverage the PSFress_Shortcodes for
		 * registering the hooks and the callback functions used throughout the plugin.
		 */
		public function __construct( $psfs = null ) {
			$this->opt = ( null !== $psfs ) ? $psfs->opt : get_option( 'psforum_shortcodes' );
			$this->set_locale();

			if ( is_admin() ) {
				$this->admin_hooks();
			} else {
				$this->public_hooks();
			}
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
		 * Defines the locale for this plugin for internationalization.
		 *
		 * Uses the PSFS_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since    1.0
		 * @access   private
		 */
		private function set_locale() {
			$psfs_i18n = PSFS_i18n::getInstance();
			add_filter( 'mce_external_languages', array( $psfs_i18n, 'add_tinymce_locales' ), 20, 1 );
			add_action( 'plugins_loaded', array( $psfs_i18n, 'load_plugin_textdomain' ) );
		}

		/**
		 * Defines the hooks and callback functions that are used for setting up the plugin's admin options.
		 *
		 * @access    private
		 */
		private function admin_hooks() {
			$admin = PSFS_Admin::getInstance();

			if ( ! isset( $this->opt['dismiss_admin_notices'] ) || ! $this->opt['dismiss_admin_notices'] ) {
				add_action( 'all_admin_notices', array( $admin, 'setup_notice' ) );
			}

			add_action( 'plugins_loaded', array( $admin, 'check_psf_installed' ) );
			add_action( 'admin_head', array( $admin, 'add_shortcode_button' ) );
			add_filter( 'tiny_mce_version', array( $admin, 'refresh_mce' ) );
			add_action( 'plugin_action_links', array( $admin, 'plugin_settings_link' ), 10, 2 );
			add_action( 'admin_menu', array( $admin, 'admin_menu_setup' ) );
			add_action( 'wp_ajax_nopriv_dismiss_notice', array( $admin, 'dismiss_notice' ) );
			add_action( 'wp_ajax_dismiss_notice', array( $admin, 'dismiss_notice' ) );
			add_action( 'admin_enqueue_scripts', array( $admin, 'admin_script_style' ) );
			add_action( 'admin_init', array( $admin, 'settings_init' ) );
		}

		/**
		 * Defines the hooks and callback functions that are used for executing plugin functionality
		 * in the front end of site.
		 *
		 * @access    private
		 */
		private function public_hooks() {
			$public = PSFS_Public::getInstance();
			if ( isset( $this->opt['psforum_shortcodes_enable'] ) && $this->opt['psforum_shortcodes_enable'] ) {
				add_filter( 'psf_get_reply_content', array( $public, 'do_psf_shortcodes' ), 10, 2 );
				add_filter( 'psf_get_topic_content', array( $public, 'do_psf_shortcodes' ), 10, 2 );
			}
		}
	}
}

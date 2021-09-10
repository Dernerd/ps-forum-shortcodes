<?php
/**
 * This class defines all plugin functionality for the site front.
 *
 * @package PSFS
 * @since    1.0
 */

if ( ! class_exists( 'PSFS_Public' ) ) {

	class PSFS_Public {

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
		 * Initializes this class and stores the plugin options.
		 */
		public function __construct() {
			$psfs = PSForum_Shortcodes::getInstance();
			$this->opt = ( null !== $psfs ) ? $psfs->opt : get_option( 'psforum_shortcodes' );
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
		 * Parses short codes placed in topic and reply content.
		 */
		function do_psf_shortcodes( $content, $reply_id ) {

			$reply_author = psf_get_reply_author_id( $reply_id );

			if ( user_can( $reply_author, $this->psfs_parse_capability() ) ) {
				return do_shortcode( $content );
			}

			return $content;
		}

		/**
		 * Checks capability to parse short codes placed in topic and reply content.
		 */
		function psfs_parse_capability() {
			return apply_filters( 'psfs_parse_shortcodes_cap', 'publish_forums' );
		}
	}
}

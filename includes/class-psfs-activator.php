<?php
/**
 * Fires during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0
 * @package    PSFS
 * @subpackage PSFS/includes
 * @author     Free WPTP <mozillavvd@gmail.com>
 */

if ( ! class_exists( 'PSFS_Activator' ) ) {

	class PSFS_Activator {

		/**
		 * The code that runs during plugin activation.
		 *
		 * @since    1.0
		 */
		public static function activate() {
			$opt = get_option( 'psforum_shortcodes' );

			if ( ! isset( $opt['psforum_shortcodes_posts'] ) ) {

				$args = array( 'public' => true );
				$posts = get_post_types( $args );
				$post_keys = array_keys( $posts );

				foreach ( $post_keys as $post_key ) {
					$opt['psforum_shortcodes_posts'][ $post_key ] = $post_key;
				}

				update_option( 'psforum_shortcodes', $opt );
			}
		}
	}
}

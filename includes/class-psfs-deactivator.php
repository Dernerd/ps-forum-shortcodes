<?php
/**
 * Fires during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0
 * @package    PSFS
 * @subpackage PSFS/includes
 * @author     Free WPTP <mozillavvd@gmail.com>
 */

if ( ! class_exists( 'PSFS_Deactivator' ) ) {

	class PSFS_Deactivator {

		/**
		 * The code that runs during plugin deactivation.
		 *
		 * @since    1.0
		 */
		public static function deactivate() {
			$opt = get_option( 'psforum_shortcodes' );

			if ( isset( $opt['dismiss_admin_notices'] ) ) {
				unset( $opt['dismiss_admin_notices'] );
				update_option( 'psforum_shortcodes', $opt );
			}
		}
	}
}

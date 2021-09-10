/**
 * Dismisses plugin notices.
 */
( function( $ ) {
	'use strict';
	$( document ).ready( function() {
		$( '.notice.is-dismissible.psforum-shortcodes .notice-dismiss' ).on( 'click', function() {

			$.ajax( {
				url: psforum_shortcodes.ajax_url,
				data: {
					action: 'dismiss_notice'
				}
			} );

		} );
	} );
} )( jQuery );

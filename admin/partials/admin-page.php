<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package PSFS
 */
?>
<div class="wrap">
	<form id="psforum_shortcodes_options" action="options.php" method="post">
		<?php
			settings_fields( 'psforum_shortcodes' );
			do_settings_sections( 'psforum_shortcodes' );
			submit_button( 'Save Options', 'primary', 'psforum_shortcodes_options_submit' );
		?>
		<div id="after-submit">
			<p>
				<?php esc_html_e( 'Like PSForum Shortcodes?', 'psforum-shortcodes' ); ?> <a href="https://wordpress.org/support/plugin/psf-shortcodes/reviews/?filter=5#new-post" target="_blank"><?php esc_html_e( 'Give us a rating', 'psforum-shortcodes' ); ?></a>
			</p>
			<p>
				<?php esc_html_e( 'Need Help or Have Suggestions?', 'psforum-shortcodes' ); ?> <?php esc_html_e( 'contact us on', 'psforum-shortcodes' ); ?> <a href="https://wordpress.org/support/plugin/psforum-shortcodes/" target="_blank"><?php esc_html_e( 'Plugin support forum', 'psforum-shortcodes' ); ?></a>
			</p>
		</div>
	 </form>
</div>


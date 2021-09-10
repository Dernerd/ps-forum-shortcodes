<?php
/**
 * The class defines all functionality for the dashboard of the plugin.
 *
 * @package PSFS
 * @since    1.0
 */

if ( ! class_exists( 'PSFS_Admin' ) ) {

	class PSFS_Admin {

		/**
		 * Stores plugin options.
		 */
		public $opt;

		/**
		 * Stores network activation status.
		 */
		private $networkactive;

		/**
		 * Core singleton class
		 * @var self
		 */
		private static $_instance;

		/**
		 * Initializes this class.
		 *
		 */
		public function __construct() {
			$psfs = PSFress_Shortcodes::getInstance();
			$this->opt = ( null !== $psfs ) ? $psfs->opt : get_option( 'psforum_shortcodes' );
			$this->networkactive = ( is_multisite() && array_key_exists( plugin_basename( PSFS_PLUGIN_FILE ), (array) get_site_option( 'active_sitewide_plugins' ) ) );
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
		 * Loads plugin javascript and stylesheet files in the admin area.
		 */
		function admin_script_style(){
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_register_script( 'psforum-shortcodes-scripts', plugins_url( '/admin/js/psfs-admin' . $suffix . '.js', PSFS_PLUGIN_FILE ), array( 'jquery' ), PSFS_VERSION, true  );
			wp_localize_script( 'psforum-shortcodes-scripts', 'psforum_shortcodes', array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			) );
			wp_enqueue_script( 'psforum-shortcodes-scripts' );
			wp_enqueue_style( 'psforum-shortcodes-styles', plugins_url( '/admin/css/psfs-admin.css', PSFS_PLUGIN_FILE ), array(), PSFS_VERSION );
		}

		/**
		 * Adds a link to the settings page in the plugins list.
		 *
		 * @param array  $links array of links for the plugins, adapted when the current plugin is found.
		 * @param string $file  the filename for the current plugin, which the filter loops through.
		 *
		 * @return array $links
		 */
		function plugin_settings_link( $links, $file ) {
			if ( false !== strpos( $file, 'psforum-shortcodes' ) ) {
				$mylinks = array(
					'<a href="https://wordpress.org/support/plugin/psforum-shortcodes/">' . esc_html__( 'Get Support', 'psforum-shortcodes' ) . '</a>',
					'<a href="options-general.php?page=psforum_shortcodes">' . esc_html__( 'Settings', 'psforum-shortcodes' ) . '</a>'
				);
				$links = array_merge( $mylinks, $links );
			}
			return $links;
		}

		/**
		 * Displays plugin configuration notice in admin area.
		 */
		function setup_notice(){
			if (  0 === strpos( get_current_screen()->id, 'settings_page_psforum_shortcodes' ) ) {
				return;
			}

			$hascaps = $this->networkactive ? is_network_admin() && current_user_can( 'manage_network_plugins' ) : current_user_can( 'manage_options' );

			if ( $hascaps ) {
				$url = is_network_admin() ? network_site_url() : site_url( '/' );
				echo '<div class="notice notice-info is-dismissible psforum-shortcodes"><p>' . sprintf( __( 'To configure <em>PSForum Shortcodes plugin</em> please visit its <a href="%1$s">configuration page</a> and to get plugin support contact us on <a href="%2$s" target="_blank">plugin support forum</a>.', 'psforum-shortcodes'), $url . 'wp-admin/options-general.php?page=psforum_shortcodes', 'https://wordpress.org/support/plugin/' ) . '</p></div>';
			}
		}

		/**
		 * Handles plugin notice dismiss functionality using AJAX.
		 */
		function dismiss_notice() {
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				$this->opt['dismiss_admin_notices'] = 1;
				update_option( 'psforum_shortcodes', $this->opt );
			}
			die();
		}

		/**
		 * Displays PSForum missing admin notice.
		 */
		function psf_missing_notice() {
			echo '<div class="error"><p>' . sprintf( __( 'PSForum Shortcodes depends on the %s to work so please activate it on your site.', 'psforum-shortcodes' ), '<a href="https://wordpress.org/plugins/psforum/" target="_blank">' . __( 'PSForum', 'psforum-shortcodes' ) . '</a>' ) . '</p></div>';
		}

		/**
		 * Checks whether the PSForum is installed.
		 */
		function check_psf_installed() {

			if ( ! class_exists( 'PSForum' ) ) {
				add_action( 'admin_notices', array( $this, 'psf_missing_notice' ) );
			}
		}

		/**
		 * Adds a button for shortcodes to the WP editor.
		 */
		function add_shortcode_button() {
			if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
				return;
			}

			if ( 'true' == get_user_option( 'rich_editing' ) && isset( $this->opt['psforum_shortcodes_posts'] ) && ! empty( $this->opt['psforum_shortcodes_posts'] ) ) {
				global $current_screen;
				if ( ! empty( $current_screen->post_type ) && in_array( $current_screen->post_type, $this->opt['psforum_shortcodes_posts'] ) ) {
					add_filter( 'mce_external_plugins', array( $this, 'add_shortcode_tinymce_plugin' ) );
					add_filter( 'mce_buttons', array( $this, 'register_shortcode_button' ) );
				}
			}
		}

		/**
		 * Registers the shortcode button.
		 */
		function register_shortcode_button( $buttons ) {
			array_push( $buttons, '|', 'psforum_shortcodes' );

			return $buttons;
		}

		/**
		 * Adds the shortcode button to TinyMCE.
		 */
		function add_shortcode_tinymce_plugin( $plugins ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			$plugins['psforum_shortcodes'] = plugins_url( 'admin/js/psfs-admin-editor' . $suffix . '.js', PSFS_PLUGIN_FILE );

			return $plugins;
		}

		/**
		 * Force TinyMCE to refresh.
		 */
		function refresh_mce( $version ) {
			$version += 3;

			return $version;
		}

		/**
		 * Registers plugin admin menu item.
		 */
		function admin_menu_setup(){
			add_submenu_page( 'options-general.php', __( 'PSForum Shortcodes Settings', 'psforum-shortcodes' ), __( 'PSForum Shortcodes', 'psforum-shortcodes' ), 'manage_options', 'psforum_shortcodes', array( $this, 'admin_page_screen' ) );
		}

		/**
		 * Renders the settings page for this plugin.
		 */
		function admin_page_screen() {
			include_once( 'partials/admin-page.php' );
		}

		/**
		 * Registers plugin settings.
		 */
		function settings_init(){
			add_settings_section( 'psforum_shortcodes_section', __( 'PSForum Shortcodes Settings', 'psforum-shortcodes' ),  array( $this, 'settings_section_desc'), 'psforum_shortcodes' );

			add_settings_field( 'psforum_shortcodes_posts', __( 'Use in Post Types : ', 'psforum-shortcodes' ),  array( $this, 'list_post_types' ), 'psforum_shortcodes', 'psforum_shortcodes_section' );
			add_settings_field( 'psforum_shortcodes_enable', __( 'Execute Shortcodes: ', 'psforum-shortcodes' ),  array( $this, 'enable_shortcode' ), 'psforum_shortcodes', 'psforum_shortcodes_section' );

			register_setting( 'psforum_shortcodes', 'psforum_shortcodes' );
		}

		/**
		 * Displays plugin description text.
		 */
		function settings_section_desc(){
			echo '<p>' . esc_html__( 'Configure the PSForum Shortcodes plugin settings here.', 'psforum-shortcodes' ) . '</p>';
		}

		/**
		 * Displays choose post types field.
		 */
		function list_post_types() {
			$html = '';
			$args = array( 'public' => true );

			$posts = get_post_types( $args );

			if ( ! empty( $posts ) ){

				foreach ( $posts as $key => $post ) {

					$check_value = isset( $this->opt['psforum_shortcodes_posts'][$key] ) ? $this->opt['psforum_shortcodes_posts'][ $key ] : 0;
					$html .= '<input type="checkbox" id="psforum_shortcodes_posts' . esc_attr( $key ) . '" name="psforum_shortcodes[psforum_shortcodes_posts][' . esc_attr( $key ) . ']" value="' . esc_attr( $key ) . '" ' . checked( $key, $check_value, false ) . '/>';
					$html .= '<label for="psforum_shortcodes_posts' . esc_attr( $key ) . '"> ' . esc_html( $post ) . '</label><br />';
				}
			} else {
				$html = __( 'No post types registered on your site.', 'psforum-shortcodes' );
			}
			echo $html;

		}

		/**
		 * Displays do shortcode field.
		 */
		function enable_shortcode() {
			$check_value = isset( $this->opt['psforum_shortcodes_enable'] ) ? $this->opt['psforum_shortcodes_enable'] : 0;
			$html = '<input type="checkbox" id="psforum_shortcodes_enable" name="psforum_shortcodes[psforum_shortcodes_enable]" value="psforum_shortcodes_enable" ' . checked( 'psforum_shortcodes_enable', $check_value, false ) . ' />';
			$html .= '<label for="psforum_shortcodes_enable"> ' . esc_html__( 'Parse shortcodes placed in topic and reply content', 'psforum-shortcodes' ) . '</label>';
			$html .= '<br /><label for="psforum_shortcodes_enable" style="font-size: 10px;">' . esc_html__( "By default PSForum does not render short codes placed into forum posts, this option enables shortcodes.", 'psforum-shortcodes' ) . '</label>';
			echo $html;
		}
	}
}

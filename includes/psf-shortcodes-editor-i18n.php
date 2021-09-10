<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$strings = 'tinyMCE.addI18n({' . _WP_Editors::$mce_locale . ': {
	psforum_shortcodes: {
		shortcode_title: "' . esc_js( __( 'PS Forum', 'psforum-shortcodes' ) ) . '",
		forums: "' . esc_js( __( 'Foren', 'psforum-shortcodes' ) ) . '",
		forum_index: "' . esc_js( __( 'Forum-Index', 'psforum-shortcodes' ) ) . '",
		forum_form: "' . esc_js( __( 'Neues Forum Formular', 'psforum-shortcodes' ) ) . '",
		single_forum: "' . esc_js( __( 'Einzelforum', 'psforum-shortcodes' ) ) . '",
		forum_id: "' . esc_js( __( 'Forum ID', 'psforum-shortcodes' ) ) . '",
		topic_id: "' . esc_js( __( 'Thema ID', 'psforum-shortcodes' ) ) . '",
		reply_id: "' . esc_js( __( 'Reply ID', 'psforum-shortcodes' ) ) . '",
		tag_id: "' . esc_js( __( 'Tag ID', 'psforum-shortcodes' ) ) . '",
		need_id: "' . esc_js( __( 'You need to use an ID!', 'psforum-shortcodes' ) ) . '",
		topics: "' . esc_js( __( 'Topics', 'psforum-shortcodes' ) ) . '",
		topic_index: "' . esc_js( __( 'Topic Index', 'psforum-shortcodes' ) ) . '",
		topic_form: "' . esc_js( __( 'New Topic Form', 'psforum-shortcodes' ) ) . '",
		forum_topic_form: "' . esc_js( __( 'Specific Forum New Topic Form', 'psforum-shortcodes' ) ) . '",
		single_topic: "' . esc_js( __( 'Single Topic', 'psforum-shortcodes' ) ) . '",
		replies: "' . esc_js( __( 'Replies', 'psforum-shortcodes' ) ) . '",
		reply_form: "' . esc_js( __( 'New Reply Form', 'psforum-shortcodes' ) ) . '",
		single_reply: "' . esc_js( __( 'Single Reply', 'psforum-shortcodes' ) ) . '",
		topic_tags: "' . esc_js( __( 'Topic Tags', 'psforum-shortcodes' ) ) . '",
		display_topic_tags: "' . esc_js( __( 'Display Topic Tags', 'psforum-shortcodes' ) ) . '",
		single_tag: "' . esc_js( __( 'Single Tag', 'psforum-shortcodes' ) ) . '",
		views: "' . esc_js( __( 'Views', 'psforum-shortcodes' ) ) . '",
		popular: "' . esc_js( __( 'Popular', 'psforum-shortcodes' ) ) . '",
		no_replies: "' . esc_js( __( 'No Replies', 'psforum-shortcodes' ) ) . '",
		search: "' . esc_js( __( 'Search', 'psforum-shortcodes' ) ) . '",
		search_input: "' . esc_js( __( 'Search Input Form', 'psforum-shortcodes' ) ) . '",
		search_form: "' . esc_js( __( 'Search Form Template', 'psforum-shortcodes' ) ) . '",
		account: "' . esc_js( __( 'Account', 'psforum-shortcodes' ) ) . '",
		login: "' . esc_js( __( 'Login', 'psforum-shortcodes' ) ) . '",
		register: "' . esc_js( __( 'Register', 'psforum-shortcodes' ) ) . '",
		lost_pass: "' . esc_js( __( 'Lost Password', 'psforum-shortcodes' ) ) . '",
		statistics: "' . esc_js( __( 'Statistics', 'psforum-shortcodes' ) ) . '"
	}
}});';

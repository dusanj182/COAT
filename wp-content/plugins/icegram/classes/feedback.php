<?php

/**
 * Get additional system & plugin specific information for feedback
 *
 */
if ( ! function_exists( 'ig_get_additional_info' ) ) {

	/**
	 * Get TLWP specific information
	 *
	 * @param $additional_info
	 * @param bool $system_info
	 *
	 * @return mixed
	 *
	 * @since 1.5.17
	 */
	function ig_get_additional_info( $additional_info, $system_info = false ) {
		global $icegram, $ig_tracker;
		$additional_info['version'] = $icegram->version;
		if ( $system_info ) {

			$additional_info['active_plugins']   = implode( ', ', $ig_tracker::get_active_plugins() );
			$additional_info['inactive_plugins'] = implode( ', ', $ig_tracker::get_inactive_plugins() );
			$additional_info['current_theme']    = $ig_tracker::get_current_theme_info();
			$additional_info['wp_info']          = $ig_tracker::get_wp_info();
			$additional_info['server_info']      = $ig_tracker::get_server_info();

			// IG Specific information
			$additional_info['plugin_meta_info'] = Icegram::get_ig_meta_info();
		}

		return $additional_info;

	}

}

add_filter( 'ig_additional_feedback_meta_info', 'ig_get_additional_info', 10, 2 );

if ( ! function_exists( 'ig_review_message_data' ) ) {
	/**
	 * Filter 5 star review data
	 *
	 * @param $review_data
	 *
	 * @return mixed
	 *
	 * @since 1.10.36
	 */
	function ig_review_message_data( $review_data ) {

		$review_url = 'https://wordpress.org/support/plugin/icegram/reviews/';
		$icon_url   = IG_PLUGIN_URL . 'assets/images/icon-64.png';

		$review_data['review_url'] = $review_url;
		$review_data['icon_url']   = $icon_url;

		return $review_data;
	}
}

add_filter( 'ig_review_message_data', 'ig_review_message_data', 10 );

if ( ! function_exists( 'ig_can_ask_user_for_review' ) ) {
	/**
	 * Can we ask user for 5 star review?
	 *
	 * @return bool
	 *
	 * @since 1.10.36
	 */
	function ig_can_ask_user_for_review( $enable, $review_data ) {

		if ( $enable ) {

			$screen = get_current_screen();
			if ( ! in_array( $screen->id, array( 'ig_campaign', 'ig_message', 'edit-ig_message', 'edit-ig_campaign' ), true ) ) {
				return false;
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				return false;
			}

			$total_campaigns         = wp_count_posts( 'ig_campaign' );
			$total_campaigns_publish = $total_campaigns->publish;
			$total_campaigns_draft   = $total_campaigns->draft;

			if ( $total_campaigns_draft == 0 && $total_campaigns_publish == 0 ) {
				return false;
			}
		}

		return $enable;
	}
}

add_filter( 'ig_can_ask_user_for_review', 'ig_can_ask_user_for_review', 50, 2 );

/**
 * Render Icegram-Email Subscribers merge feedback widget.
 *
 * @since 1.10.38
 */
function ig_render_iges_merge_feedback() {

	global $ig_feedback, $icegram;

	if ( is_admin() ) {

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! in_array( $screen->id, array( 'ig_campaign', 'ig_message', 'edit-ig_message', 'edit-ig_campaign' ), true ) ) {
			return false;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$total_campaigns = wp_count_posts( 'ig_campaign' );

		$total_campaigns_publish = $total_campaigns->publish;

		if ( $total_campaigns_publish >= 1 ) {

			$event = 'poll.merge_iges';

			// If user has already given feedback on Email Subscribers page, don't ask them again
			$is_event_tracked = $ig_feedback->is_event_tracked( 'ig_es', $event );

			if ( $is_event_tracked ) {
				return;
			}

			$params = array(
				'type'              => 'poll',
				'title'             => __( 'Subscription forms and CTAs??', 'email-subscribers' ),
				'event'             => $event,
				'desc'              => '<div><p>You use <a href="https://wordpress.org/plugins/icegram" target="_blank"><b>Icegram</b></a> to show onsite campaigns like popups and action bars.</p> <p>Would you like us to include email campaigns in the plugin as well? This way you can <b>convert visitors to subscribers, drive traffic and run email marketing from a single plugin</b>.</p> <p>Why do we ask?</p> <p>Our <a href="https://wordpress.org/plugins/email-subscribers" target="_blank"><b>Email Subscribers</b></a> plugin already does email campaigns. We are thinking of merging Icegram & Email Subscribers into a single plugin.</p> <p><b>Will a comprehensive ConvertKit / MailChimp like email + onsite campaign plugin be useful to you?</b></p> </div>',
				'poll_options'      => array(
					'yes' => array( 'text' => '<b>' . __( 'Yes', 'email-subscribers' ) . '</b>', 'color' => 'green' ),
					'no'  => array( 'text' => '<b>' . __( 'No', 'email-subscribers' ) . '</b>', 'color' => 'red' )
				),
				'allow_multiple'    => false,
				'position'          => 'bottom-center',
				'width'             => 400,
				'delay'             => 2, // seconds
				'confirmButtonText' => __( 'Send my feedback to <b>Icegram team</b>', 'email-subscribers' ),
				'show_once'         => true
			);

			$icegram->render_feedback_widget( $params );
		}

	}
}

add_action( 'admin_footer', 'ig_render_iges_merge_feedback' );

/**
 * Can load sweetalert js file
 *
 * @param bool $load
 *
 * @return bool
 *
 * @since 1.10.38
 */
function ig_can_load_sweetalert_js( $load = false ) {

	$screen = get_current_screen();
	if ( ! in_array( $screen->id, array( 'ig_campaign', 'ig_message', 'edit-ig_message', 'edit-ig_campaign' ), true ) ) {
		return false;
	}

	return $load;
}

add_filter( 'ig_can_load_sweetalert_js', 'ig_can_load_sweetalert_js', 10, 1 );

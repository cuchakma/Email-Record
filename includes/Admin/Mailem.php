<?php

namespace Em\Re\Admin;

/**
 * Mail Class Handler
 */
class Mailem {

	/**
	 * Mail Function Initializer
	 */
	public function __construct() {
		add_filter( 'wp_mail', array( $this, 'grab_email' ) );
		add_filter( 'wp_mail_failed', array( $this, 'grab_error' ) );
	}

	/**
	 * Grab emails which are fired using wp_mail function in WordPress
	 *
	 * @param array $genuine_email email content.
	 * @return void
	 */
	public function grab_email( $genuine_email ) {

		$genuine_email = apply_filters( 'email_record_content', $genuine_email );

		$sanitized_email_args = array(
			'to_email'    => is_array( $genuine_email['to'] ) ? filter_var( implode( ', ', $genuine_email['to'] ), FILTER_SANITIZE_EMAIL ) : filter_var( $genuine_email['to'], FILTER_SANITIZE_EMAIL ),
			'subject'     => $genuine_email['subject'],
			'message'     => $genuine_email['message'],
			'headers'     => $genuine_email['headers'],
			'attachments' => is_array( $genuine_email['attachments'] ) ? implode( '\n', $genuine_email['attachments'] ) : $genuine_email['attachments'],
			'sent_date'   => current_time( 'mysql' ),
		);

		insert_email_content( $sanitized_email_args );

	}

	/**
	 * Throws WP_Error only if email sending is unsucessful
	 *
	 * @param object $wp_error wp_error object.
	 * @return void
	 */
	public function grab_error( $wp_error ) {
		if ( ! is_wp_error( $wp_error ) ) {
			return;
		}

		$error_value  = $wp_error->get_error_data( 'wp_mail_failed' );
		$error_noitce = $wp_error->get_error_message( 'wp_mail_failed' );

		$this->update_email_record_unsuccessful( $error_value, $error_noitce );

	}

	/**
	 * Update email as unsuccessful
	 *
	 * @param array  $error_data error datas.
	 * @param string $error_message error message.
	 * @return void
	 */
	protected function update_email_record_unsuccessful( $error_data, $error_message = '' ) {
		if ( ! is_array( $error_data ) ) {
			return;
		}

		if ( ! isset( $error_data['to'] ) && ! isset( $error_data['subject'] ) ) {
			return;
		}

		$error_data_id = get_email_content_id( $error_data );

		if ( empty( $error_data_id ) ) {
			return;
		} else {
			update_successful_column( $error_data_id, $error_message );
		}

	}

}

<?php

namespace Em\Re;

/**
 * Ajax Class Handler For Email Recorder
 */
class Ajax {

	public function __construct() {
		add_action( 'wp_ajax_email-delete-record', array( $this, 'delete_email_record' ) );
	}

	public function delete_email_record() {
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'email-delete-nonce' ) ) {
			die( 'Unauthorized To Access Files Directly' );
		}
		$record_id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';
		delete_email_record( $record_id );
	}
}

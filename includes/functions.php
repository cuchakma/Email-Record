<?php

use function cli\err;

/**
 * Insert/Update Email Records
 *
 * @param array $data contains email message content.
 * @return void
 */
function insert_email_content( $data = array() ) {

	global $wpdb;

	$defaults = array(
		'to_email'    => '',
		'subject'     => '',
		'message'     => '',
		'headers'     => '',
		'attachments' => array(),
		'ip_address'  => filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP ) ? $_SERVER['REMOTE_ADDR'] : 'No A Valid IP Address',
		'sent_date'   => current_time( 'mysql' ),
	);

	$mod_email_content = wp_parse_args( $data, $defaults );

	if ( empty( $mod_email_content['attachments'] ) ) {
		$mod_email_content['attachments'] = 0;
	} else {
		$mod_email_content['attachments'] = 1;
	}

	$data_insert = $wpdb->insert(
		"{$wpdb->prefix}email_recorder",
		$mod_email_content,
		array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%f',
			'%s',
			'%s',
		)
	);

	error_log( print_r( $data_insert, true ) );
}

<?php


/**
 * Insert Email Records
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
			'%d',
			'%s',
			'%s',
		)
	);

}

/**
 * Get current email data id only for wp_error object
 *
 * @param array $data error data.
 * @return int
 */
function get_email_content_id( $data ) {

	global $wpdb;
	$table_name = $wpdb->prefix . 'email_recorder';

	if ( empty( $data ) || ! is_array( $data ) ) {
		return 0;
	}

	if ( isset( $data['to'] ) ) {
		$to_email            = trim( esc_sql( implode( ',', $data['to'] ) ) );
		$columns['to_email'] = $to_email;
	}

	if ( isset( $data['subject'] ) ) {
		$subject            = trim( esc_sql( $data['subject'] ) );
		$columns['subject'] = $subject;
	}

	if ( isset( $data['attachments'] ) ) {
		if ( is_array( $data['attachments'] ) ) {
			$attachments = count( $data['attachments'] ) > 0 ? 'true' : 'false';
		} else {
			$attachments = empty( $data['attachments'] ) ? 'false' : 'true';
		}
		$columns['attachments'] = trim( esc_sql( $attachments ) );
	}
	$sql = "SELECT id FROM {$table_name} WHERE to_email = '{$columns['to_email']}' AND subject = '{$columns['subject']}' AND attachments = {$columns['attachments']} ORDER BY id DESC LIMIT 1";
	return absint( $wpdb->get_var( $sql ) );
}

/**
 * Update successful column as failed
 *
 * @param int    $error_email_id error email id.
 * @param string $error_message error message.
 * @return void
 */
function update_successful_column( $error_email_id, $error_message = '' ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'email_recorder';

	$data = array(
		'successful'    => '0',
		'error_message' => $error_message,
	);

	$where = array(
		'id' => $error_email_id,
	);

	$updated = $wpdb->update(
		$table_name,
		$data,
		$where,
		array(
			'%d',
			'%s',
		),
		array(
			'%d',
		)
	);
}

/**
 * Fetches all email records present inside the table
 *
 * @param array $args
 * @return array
 */
function get_all_email_records( $args = array() ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'email_recorder';

	$defaults = array(
		'number'  => 20,
		'offset'  => 0,
		'orderby' => 'id',
		'order'   => 'ASC',
	);

	$args          = wp_parse_args( $args, $defaults );
	$email_records = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM {$table_name} ORDER BY {$args['orderby']} {$args['order']} LIMIT %d, %d",
			$args['offset'],
			$args['number']
		)
	);

	return $email_records;
}

/**
 * Gets the total count of email records from the database.
 *
 * @return int
 */
function count_email_records() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'email_recorder';
	$sql        = "SELECT COUNT(*) FROM $table_name";
	return absint( $wpdb->get_var( $sql ) );
}

/**
 * Delete Email Record By Id
 *
 * @param int $email_record_id record id.
 * @return void
 */
function delete_email_record( $email_record_id ) {
	global $wpdb;
	$email_record_id = absint( $email_record_id );
	$table_name      = $wpdb->prefix . 'email_recorder';
	$sql             = "DELETE FROM {$table_name} WHERE id = {$email_record_id}";

	$data_delete = $wpdb->delete( $table_name, array( 'id' => $email_record_id ) );
}

/**
 * Fetches All Email Records By Date
 *
 * @param string $date YYYY/MM/DD format.
 * @return array
 */
function get_email_records_by_date( $date ) {
	global $wpdb;
	$table_name            = $wpdb->prefix . 'email_recorder';
	$email_records_by_date = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM {$table_name} WHERE sent_date LIKE %s",
			'%' . $date . '%'
		),
	);

	return $email_records_by_date;
}




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
		'ip_address'  => filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP ) ? $_SERVER['REMOTE_ADDR'] : 'Invalid IP',
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
 * Get Current Email Data Id Only For WP_Error Object
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
 * Update Successful Column As Failed
 *
 * @param int    $error_email_id error email id.
 * @param string $error_message error message.
 * @return int|false
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
 * Fetches All Email Records Present Inside The Table
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
 * Gets The Total Count Of Email Records From The Database.
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
 * @param array $email_record_ids record id.
 * @return bool
 */
function delete_email_record( $email_record_ids ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'email_recorder';
	$ids = $email_record_ids;
	if( !empty( $ids ) ) { 
	 	$ids = is_array( $ids ) ? implode( ',',  $ids ) : $ids;
	 	$query = "DELETE FROM {$table_name} WHERE ID IN($ids)";
		$result = $wpdb->query( $query );
		return $result;
	}
	return false;
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

/**
 * Get Edit Email Contents By Id
 *
 * @param int $id
 * @return array|object|null
 */
function get_editted_selected_email_contents_by_id( $id ) {
	global $wpdb;
	$table_name  = $wpdb->prefix . 'email_recorder';
	$id = absint($id);
	$contents = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT to_email, subject, ip_address, sent_date, message FROM {$table_name} where id = %s",
			$id
		)
	);
	
	return $contents;
}

/**
 * Update The Edited Email Contents
 *
 * @param array $data
 * @param int $id
 * @return int|false
 */
function update_edit_email_contents( $data, $id ){
	global $wpdb;

	$table_name = $wpdb->prefix . 'email_recorder';

	$data = array(
		'to_email'    => $data['to_email'],
		'subject'     => $data['subject'],
		'ip_address'  => $data['ip_address'],
		'sent_date'   => $data['sent_date'],
		'message'     => $data['message']
	);

	$where = array(
		'id' => absint( $id )
	);

	$updated = $wpdb->update(
		$table_name,
		$data,
		$where,
		array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		),
		array(
			'%d',
		)
	);
	
	return $updated;

}


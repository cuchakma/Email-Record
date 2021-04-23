<?php

namespace Em\Re\Admin;

use DateTime;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Record List Class Handler
 */
class Record_List extends \WP_List_Table {
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'email-record',
				'plural'   => 'email-records',
				'ajax'     => 'false',
			)
		);
	}

	public function get_columns() {
		$columns = array(
			'cb'         => '<input type="checkbox"/>',
			'sent_date'  => '<strong>Sent Date | Time</strong>',
			'successful' => '<strong>Email Status</strong>',
			'to_email'   => '<strong>Email Receiver</strong>',
			'subject'    => '<strong>Email Subject</strong>',
			'ip_address' => '<strong>IP</strong>',
		);

		return $columns;
	}


	public function get_sortable_columns() {
		$sortable_columns = array(
			'sent_date' => array( 'sent_date', true ),
		);

		return $sortable_columns;
	}

	protected function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'value':
				break;
			default:
				return isset( $item->$column_name ) ? $item->$column_name : '';
		}
	}

	/**
	 * Modified column checkbox
	 *
	 * @param object $item stdClass object.
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="email_record_id" value="%d"/>',
			$item->id
		);
	}

	public function column_sent_date( $item ) {
		$time = new DateTime( $item->sent_date );
		return $time->format( 'd/m/Y | h:i:s a' );
	}
	/**
	 * Modified column email status
	 *
	 * @param object $item stdClass object.
	 * @return string
	 */
	public function column_successful( $item ) {

	}

	/**
	 * Prepare the total columns to be displayed
	 *
	 * @return void
	 */
	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		$per_page     = 20;
		$current_page = $this->get_pagenum();
		$offset       = ( $current_page - 1 ) * $per_page;

		$arguments = array(
			'number' => $per_page,
			'offset' => $offset,
		);

		if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
			$arguments['orderby'] = $_REQUEST['orderby'];
			$arguments['order']   = $_REQUEST['order'];
		}

		$this->items = get_all_email_records( $arguments );
		$this->set_pagination_args(
			array(
				'total_items' => count_email_records(),
				'per_page'    => $per_page,
			),
		);

	}


}

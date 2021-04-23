<?php

namespace Em\Re\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Record_List extends \WP_List_Table {
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'record',
				'plural'   => 'records',
				'ajax'     => 'false',
			)
		);
	}

	public function get_columns() {
		$columns = array(
			'cb'             => '<input type="checkbox"/>',
			'sent_date'      => 'Sent Date',
			'email status'   => 'Email Status',
			'email_receiver' => 'Email Receiver',
			'email_subject'  => 'Email Subject',
		);

		return $columns;
	}

	protected function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'value':
				break;

			default:
				return isset( $item->$column_name ) ? $item->$column_name : '';
		}
	}

	public function prepare_items() {
		$columns               = $this->get_columns();
		$this->_column_headers = array( $columns );

		$per_page     = 20;
		$current_page = $this->get_pagenum();
		$offset       = ( $current_page - 1 ) * $per_page;

		$args = array(
			'number' => $per_page,
			'offser' => $offset,
		);
	}


}

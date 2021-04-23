<?php

namespace Em\Re\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

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
			'sent_date'  => 'Sent Date',
			'successful' => 'Email Status',
			'to_email'   => 'Email Receiver',
			'subject'    => 'Email Subject',
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

	/**
	 * Column checkbox modified
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

	/**
	 * Prepare the total columns to be displayed
	 *
	 * @return void
	 */
	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$per_page              = 20;
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = get_all_email_records();
		$this->set_pagination_args(
			array(
				'total_items' => count_email_records(),
				'per_page'    => $per_page,
			),
		);
		// $per_page     = 20;
		// $current_page = $this->get_pagenum();
		// $offset       = ( $current_page - 1 ) * $per_page;

		// $args = array(
		// 'number' => $per_page,
		// 'offser' => $offset,
		// 'order'  => 'ASC',
		// );
	}


}

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
	/**
	 * Initialize The WP List Table
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'email-record',
				'plural'   => 'email-records',
				'ajax'     => 'false',
			)
		);
	}

	/**
	 * Set Columns And Type's
	 *
	 * @return array
	 */
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

	/**
	 * Sortable Columns
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'sent_date'  => array( 'sent_date', true ),
			'successful' => array( 'successful', true ),
			'to_email'   => array( 'to_email', true ),
			'subject'    => array( 'subject', true ),
			'ip_address' => array( 'ip_address', true ),
		);

		return $sortable_columns;
	}

	/**
	 * Render Default Columns
	 *
	 * @param object $item stdClass object.
	 * @param string $column_name name of column table's.
	 * @return string
	 */
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
			'<input type="checkbox" name="email_record_id[]" value="%d"/>',
			$item->id
		);
	}

	/**
	 * Send Date Column Modified
	 *
	 * @param object $item stdClass object.
	 * @return string html's row actions
	 */
	public function column_sent_date( $item ) {
		$actions['delete'] = sprintf( '<a href="#" class="submitdelete" data-id="%s">%s</a>', $item->id, 'Delete' );
		$time              = new DateTime( $item->sent_date );
		echo esc_attr( $time->format( 'd/m/Y | h:i:s a' ) );
		return $this->row_actions( $actions );

	}

	/**
	 * Set Bulk Options
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions['delete'] = 'Delete';
		return $actions;
	}

	/**
	 * When No Email Record Is Found
	 *
	 * @return string
	 */
	public function no_items() {
		echo 'There are no email-records found';
	}

	/**
	 * Bulk Action's Logic
	 *
	 * @return void
	 */
	public function process_bulk_options() {

		// security check!
		if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

			// security check!
			if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

				$nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
				$action = 'bulk-' . $this->_args['plural'];

				if ( ! wp_verify_nonce( $nonce, $action ) ) {
					wp_die( 'Nope! Security check failed!' );
				}
			}
		}

		$action = $this->current_action();

		switch ( $action ) {
			case 'delete':
				$ids     = isset( $_POST['email_record_id'] ) ? wp_unslash( $_POST['email_record_id'] ) : '';
				$deleted = 0;
				if ( ! empty( $ids ) ) {
					foreach ( $ids as $id ) {
						delete_email_record( $id );
					}
					$deleted = 1;
				}
				if ( $deleted ) {
					$url = add_query_arg(
						array(
							'_wpnonce' => wp_create_nonce( 'bulk-delete-nonce' ),
						),
						admin_url( 'admin.php?page=email-records&bulk-delete=true' )
					);
					wp_redirect( $url );
				}
				break;
			default:
				return;
		}
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

		$this->process_bulk_options();

		$per_page     = 20;
		$current_page = $this->get_pagenum();
		$offset       = ( $current_page - 1 ) * $per_page;
		$arguments    = array(
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

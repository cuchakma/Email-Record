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
			'resend'     => '',
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
		$actions['edit']   = sprintf( '<a href="%s" class="edit" >%s</a>', admin_url( 'admin.php?page=email-records&action=edit-record&id=' . $item->id ), 'Edit With TinyMce' );
		$time              = new DateTime( $item->sent_date );
		echo esc_attr( $time->format( 'd/m/Y | h:i:s a' ) );
		return $this->row_actions( $actions );

	}

	/**
	 * Resend Column
	 *
	 * @param object $item stdClass object
	 * @return string html
	 */
	public function column_resend( $item ) {
		return sprintf( '<a href="%s" class="button button-secondary" data-id="%s">%s</a>', admin_url('admin.php?page=email-records&id='.$item->id),$item->id, 'Resend' );
	}

	public function column_successful( $item ) {
		$success_path = ASSET_PATH . '/img/status.png';
		$failed_path  = ASSET_PATH . '/img/failed.jpg';
		$message      = empty( $item->error_message ) ? 'Sent Successfully!' : $item->error_message;

		return ( absint( $item->successful ) == 0 || absint( $item->successful ) == null ) ?

		"<span data-text='$item->error_message'  class='tooltip' ><img src=$failed_path alt='sent' width='30' height='30' style='position: relative;left: 20px;'></span>" :
		"<span data-text='$message'  class='tooltip' ><img src=$success_path alt='sent' width='30' height='30' style='position: relative; left: 20px;'></span>";

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
	 * Bulk Action's Delete Logic
	 *
	 * @return void
	 */
	public function process_bulk_options() {
		$action = $this->current_action();

		if ( $action === 'delete' ) {
			$ids     = isset( $_POST['email_record_id'] ) ? wp_unslash( $_POST['email_record_id'] ) : '';
			$deleted = delete_email_record( $ids );
			if ( $deleted ) {
				$notice = new \Em\Re\Notices();
				add_action( 'admin_notices', array( $notice, 'bulk_delete_message' ) );
			}
		}
	}

	/**
	 * Process Resend Email
	 *
	 * @return bool
	 */
	public function reSendMail( $id ) {
		$mail_contents_by_id = get_editted_selected_email_contents_by_id( $id, 'resend' );
		$mail_contents_by_id = $mail_contents_by_id[0];
		$to     			 = isset( $mail_contents_by_id->to_email ) ? $mail_contents_by_id->to_email: '';
		$subject 			 = isset( $mail_contents_by_id->subject ) ? $mail_contents_by_id->subject: '';
		$message 			 = isset( $mail_contents_by_id->message ) ? $mail_contents_by_id->message: '';
		$headers 			 = isset( $mail_contents_by_id->headers ) ? $mail_contents_by_id->headers: '';
		$attachments 		 = isset( $mail_contents_by_id->attachments) ? $mail_contents_by_id->attachments : '';
		wp_mail( $to, $subject, $message, $headers, $attachments );
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

		$resend_mail_id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';
		if( $resend_mail_id ) {
			$this->reSendMail( $resend_mail_id );
		}

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

		$search_date = isset( $_REQUEST['s'] ) ? $_REQUEST['s'] : '';

		if ( ! empty( $search_date ) ) {
			$this->items = get_email_records_by_date( $search_date );
			$this->set_pagination_args(
				array(
					'total_items' => count( $this->items ),
					'per_page'    => $per_page,
				),
			);
		} else {
			$this->items = get_all_email_records( $arguments );
			$this->set_pagination_args(
				array(
					'total_items' => count_email_records(),
					'per_page'    => $per_page,
				),
			);
		}

	}

}

<?php

namespace Em\Re\Admin;

/**
 * Record Page Class Handler
 */
class Records {

	/**
	 * Initialize The Class
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'handle_email_datas' ) );
	}

	/**
	 * Main Records Template
	 *
	 * @return void
	 */
	public function email_record_lists() {
		$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

		switch($action) {

			case 'edit-record':
				$template = __DIR__ . '/views/edit-template.php';
				break;
			default:
				$template = __DIR__ . '/views/email-list.php';
				wp_enqueue_style( 'email-recorder-st' );
				wp_enqueue_script( 'email-recorder-sc' );
				
		}
		
		if ( file_exists( $template ) ) {
			include $template;
		}
	}

	/**
	 * Process The Email Datas
	 *
	 * @return void
	 */
	public function handle_email_datas() {

		if( ! isset( $_POST['submit_datas' ]) ) {
			return;
		}

		if( !current_user_can('manage_email_record_options') ) {
			wp_die( 'Are you cheating?' );
		}

		$data = array(
			'to_email'    => $_REQUEST['to_email'],
			'subject'     => $_REQUEST['subject'],
			'ip_address'  => $_REQUEST['ip_address'],
			'sent_date'   => $_REQUEST['sent_date']." ".$_REQUEST['time'],
			'message'     => $_REQUEST['email_template_message']
		);

		$id = $_REQUEST['id'];	

		update_edit_email_contents( $data, $id );
	}

}

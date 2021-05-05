<?php

namespace Em\Re\Admin;

/**
 * Record Page Class Handler
 */
class Records {

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

}

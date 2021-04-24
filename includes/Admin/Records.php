<?php

namespace Em\Re\Admin;

/**
 * Record Page Class Handler
 */
class Records {

	/**
	 * Main Page Template
	 *
	 * @return void
	 */
	public function email_record_lists() {
		$template = __DIR__ . '/views/email-list.php';
		if ( file_exists( $template ) ) {
			wp_enqueue_style( 'email-recorder-st' );
			wp_enqueue_script( 'email-recorder-sc' );
			include $template;
		}
	}

}

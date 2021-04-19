<?php

namespace Em\Re;

/**
 * Admin Class Handler
 */
class Admin {

	/**
	 * Admin Class Initialize
	 */
	public function __construct() {
		$email_record_page = new \Em\Re\Admin\records();
		new \Em\Re\Admin\menu( $email_record_page );
		$this->run_hook_actions( $email_record_page );
	}

	/**
	 * Executes Actions In A Class Function(action hooks are hooked into functions belonging to a page object or class)
	 *
	 * @param object $page_object page object load.
	 * @return void
	 */
	public function run_hook_actions( $page_object ) {
		add_action( 'admin_init', array( $page_object, 'email_records' ) );
	}
}

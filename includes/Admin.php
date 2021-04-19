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
		$email_record_page  = new \Em\Re\Admin\Records();
		$email_setting_page = new \Em\Re\Admin\Setting();
		new \Em\Re\Admin\Menu( $email_record_page, $email_setting_page );
		$this->run_hook_actions( $email_record_page, $email_setting_page );
	}

	/**
	 * Executes Actions In A Class Function(action hooks are hooked into functions belonging to a page object or class)
	 *
	 * @param object $page_object_1, $page_object_2 page object load.
	 * @return void
	 */
	public function run_hook_actions( $page_object_1, $page_object_2 ) {
		add_action( 'admin_init', array( $page_object_1, 'email_records' ) );
		add_action( 'admin_init', array( $page_object_2, 'email_settings' ) );
	}
}

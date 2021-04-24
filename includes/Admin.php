<?php

namespace Em\Re;

use function cli\err;

/**
 * Admin Class Handler
 */
class Admin {

	/**
	 * Admin Class Initializer
	 */
	public function __construct() {
		$email_record_page  = new \Em\Re\Admin\Records();
		$email_setting_page = new \Em\Re\Admin\Setting();
		new \Em\Re\Admin\Menu( $email_record_page, $email_setting_page );
		new \Em\Re\Assets();
	}


}

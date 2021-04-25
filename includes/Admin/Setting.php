<?php

namespace Em\Re\Admin;

/**
 * Class Setting Handler
 */
class Setting {

	/**
	 * Main Email Recorder Settings Page Template
	 *
	 * @return void
	 */
	public function email_config() {
		$template = __DIR__ . '/views/email-config.php';
		if ( file_exists( $template ) ) {
			wp_enqueue_style( 'email-settings-st' );
			wp_enqueue_script( 'email-settings-sc' );
			include $template;
		}
	}



}

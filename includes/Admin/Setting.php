<?php

namespace Em\Re\Admin;

/**
 * Class Setting Handler
 */
class Setting {

	/**
	 * Setting callback
	 *
	 * @var object
	 */
	public $callbacks;

	/**
	 * Initialize The Settings
	 */
	public function __construct() {
		$this->callbacks = new \Em\Re\Admin\Callbacks();
		add_action( 'admin_init', array( $this, 'register_email_settings' ) );
	}

	/**
	 * Email Configuration Menu's
	 *
	 * @return void
	 */
	public function register_email_settings() {
		register_setting( 'selected-role', 'selected_role' );
		add_settings_section( 'select-roles', 'User Role Accessibility', array( $this->callbacks, 'setting_section_callback' ), 'email-configuration' );
		add_settings_field( 'select-role-checkboxes', 'Allowed User Roles', array( $this->callbacks, 'setting_field_callback' ), 'email-configuration', 'select-roles' );
	}

	/**
	 * Main Email Recorder Settings Page Template
	 *
	 * @return void
	 */
	public function email_config() {
		$template = __DIR__ . '/views/email-config.php';
		if ( file_exists( $template ) ) {
			wp_enqueue_style( 'email-settings-st' );
			wp_enqueue_script( 'email-settings-set' );
			include $template;
		}
	}



}

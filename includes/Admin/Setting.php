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
		add_action( 'admin_init', array( $this, 'add_capabilities' ) );
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
	 * Add Capability To Users Selected By Admin & Delete Unchecked Role's Capability
	 *
	 * @return void
	 */
	public function add_capabilities() {
		global $wp_roles;
		$custom_cap                 = 'manage_email_record_options';
		$all_roles                  = $wp_roles->roles;
		$current_selected_roles     = empty( get_option( 'selected_role' ) ) ? array() : get_option( 'selected_role' );
		$current_selected_roles_old = get_option( 'temp_values_roles' );

		if ( ! $current_selected_roles_old ) {
			update_option( 'temp_values_roles', $current_selected_roles );
		}

		foreach ( $all_roles as $role => $keys ) {
			if ( in_array( $role, $current_selected_roles, true ) ) {
				$role_object = get_role( $role );
				if ( ! $role_object->has_cap( $custom_cap ) ) {
					$role_object->add_cap( $custom_cap, true );
				}
			}
		}

		if ( $current_selected_roles !== $current_selected_roles_old ) {
			$deleted_roles = array_diff( $current_selected_roles_old, $current_selected_roles );
			foreach ( $deleted_roles as $role ) {
				$wp_roles->remove_cap( $role, $custom_cap );
			}
			update_option( 'temp_values_roles', $current_selected_roles );
		}
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
			wp_enqueue_script( 'email-settings-sc' );
			include $template;
		}
	}



}

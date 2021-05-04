<?php

namespace Em\Re;

/**
 * Ajax Class Handler For Email Recorder
 */
class Ajax {

	public function __construct() {
		add_action( 'wp_ajax_email-delete-record', array( $this, 'delete_email_record' ) );
		add_action( 'wp_ajax_add-capability', array( $this, 'add_capabilities' ) );
	}

	/**
	 * Delete Email Record Using Ajax
	 *
	 * @return void
	 */
	public function delete_email_record() {
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'email-delete-nonce' ) ) {
			die( 'Unauthorized To Access Files Directly' );
		}
		$record_id = isset( $_REQUEST['id'] ) ?  $_REQUEST['id'] : '';
		delete_email_record( $record_id );
	}

	/**
	 * Add Capability To Users Selected By Admin & Delete Unchecked Role's Capability Using Ajax
	 *
	 * @return void
	 */
	public function add_capabilities() {
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'addcapabil' ) ) {
			die( 'Unauthorized To Access Files Directly' );
		}
		
		global $wp_roles;
		$custom_cap                 = 'manage_email_record_options';
		$all_roles                  = $wp_roles->roles;
		$current_selected_roles     = empty( explode(',', $_POST['selected_roles'] ) ) ? array() : explode(',', $_POST['selected_roles'] );
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
			update_option( 'selected_role', $current_selected_roles );
		}
	}
}

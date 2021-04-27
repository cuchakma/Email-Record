<?php

namespace Em\Re;

/**
 * Insaller Class Handler
 */
class Installer {

	/**
	 * Installer Class Initializer
	 *
	 * @return void
	 */
	public function initializer() {
		$this->add_custom_capability();
		$this->add_version();
		$this->add_database_table();
	}

	/**
	 * Updates or Adds Email Version & Installed Time
	 *
	 * @return void
	 */
	public function add_version() {
		$installed = get_option( 'email_recorder_installed' );

		if ( ! $installed ) {
			update_option( 'email_recorder_installed', time() );
		}

		update_option( 'email_recorder_version', PLUGIN_VERSION );
	}

	/**
	 * Database Table Installation During Activation
	 *
	 * @return void
	 */
	public function add_database_table() {

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}

		global $wpdb;
		$table_name      = $wpdb->prefix . 'email_recorder';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				to_email VARCHAR(500) NOT NULL,
				subject VARCHAR(500) NOT NULL,
				message TEXT NOT NULL,
				headers TEXT NOT NULL,
				attachments TEXT NOT NULL,
				sent_date timestamp NOT NULL,
				attachment_name VARCHAR(1000) NOT NULL,
				ip_address VARCHAR(15),
				successful TINYINT(1),
				error_message VARCHAR(1000),
				PRIMARY KEY  (id)
			) ' . $charset_collate . ';';

		dbDelta( $sql );
	}

	/**
	 * Added Custom Capability To Users For Email-log Accessibility
	 *
	 * @return void
	 */
	public function add_custom_capability() {
		$custom_cap = 'manage_email_record_options';
		$role_names = get_editable_roles();
		foreach ( $role_names as $role ) {
			if ( 'Administrator' === $role['name'] ) {
				$role_object = get_role( 'administrator' );
				if ( ! $role_object->has_cap( $custom_cap ) ) {
					$role_object->add_cap( $custom_cap );
				}
			} else {

			}
		}
	}
}

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
	public static function initializer() {
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
	 * @return string
	 */
	public function add_database_table() {
		global $wpdb;
		$table_name      = 'email_recorder';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = 'CREATE TABLE ' . $table_name . ' (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				to_email VARCHAR(500) NOT NULL,
				subject VARCHAR(500) NOT NULL,
				message TEXT NOT NULL,
				headers TEXT NOT NULL,
				attachments TEXT NOT NULL,
				sent_date timestamp NOT NULL,
				attachment_name VARCHAR(1000),
				ip_address VARCHAR(15),
				result TINYINT(1),
				error_message VARCHAR(1000),
				PRIMARY KEY  (id)
			) ' . $charset_collate . ';';

		return $sql;
	}
}

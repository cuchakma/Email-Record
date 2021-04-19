<?php

namespace Em\Re\Admin;

/**
 * Admin Menu Class Handler
 */
class Menu {

	public $page;

	public function __construct( $page ) {
		$this->page = $page;
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function admin_menu() {
		$capability  = 'manage_options';
		$parent_slug = 'email-records';
		add_menu_page( 'email-records', 'Email Recorder', $capability, $parent_slug, array( $this->page, 'email_records' ), 'dashicons-portfolio' );
		add_submenu_page( $parent_slug, 'view-records', 'View Records', $capability, $parent_slug, array( $this->page, 'email_records' ) );
		add_submenu_page( $parent_slug, 'settings', 'Settings', $capability, 'settings', array( $this, 'settings_page' ) );
	}

	public function settings_page() {
		echo 'Hello From Settings Page';
	}
}

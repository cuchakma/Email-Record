<?php

namespace Em\Re\Admin;

/**
 * Admin Menu Class Handler
 */
class Menu {

	/**
	 * Object variable 1
	 *
	 * @var page1
	 */
	public $page1;

	/**
	 * Object variable 2
	 *
	 * @var page2
	 */
	public $page2;

	/**
	 * Menu Class Initializer
	 *
	 * @param object $page1 page object variable.
	 * @param object $page2 page object variable.
	 */
	public function __construct( $page1, $page2 ) {
		$this->page1 = $page1;
		$this->page2 = $page2;
		add_action( 'admin_menu', array( $this, 'email_recorder_menus' ) );
	}

	/**
	 * Load Plugin Menus
	 *
	 * @return void
	 */
	public function email_recorder_menus() {
		$capability  = 'manage_options';
		$parent_slug = 'email-records';
		add_menu_page( 'view-records', 'Email Recorder', $capability, $parent_slug, array( $this->page1, 'email_record_lists' ), 'dashicons-portfolio' );
		add_submenu_page( $parent_slug, 'View Records', 'View Records', $capability, $parent_slug, array( $this->page1, 'email_record_lists' ) );
		add_submenu_page( $parent_slug, 'Email Configurations', 'Email Configurations', $capability, 'email-configuration', array( $this->page2, 'email_config' ) );
	}

}

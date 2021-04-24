<?php
/**
 * Plugin Name: Email-Recorder
 * Plugin URI:  www.facebook.com
 * Description: This plugin is used to record email fired using wp_mail
 * Version:     1.0
 * Author:      Cupid Chakma
 * Author URI:  www.facebook.com
 * Text Domain: email-recorder
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package     Email-Recorder
 * @author      Cupid Chakma
 * @copyright   2020
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      Plugin Functions Prefix
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Main Class
 */
final class Main {

	/**
	 * Plugin version
	 */
	const VERSION = '1.0';

	/**
	 * Main Class Initializer
	 */
	public function __construct() {
		$this->define_constants();
		$this->init_classes();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
	}

	/**
	 * Constants For The Plugin
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'PLUGIN_VERSION', self::VERSION );
		define( 'CURRENT_FILE', __FILE__ );
		define( 'CURRENT_FOLDER', __DIR__ );
		define( 'PLUGIN_URL', plugins_url( '', CURRENT_FILE ) );
		define( 'ASSET_PATH', PLUGIN_URL . '/assets' );
	}

	/**
	 * Main Functionaity Class Loader
	 *
	 * @return void
	 */
	public function init_classes() {
		new \Em\Re\Assets();
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			new \Em\Re\Ajax();
		}
		if ( is_admin() ) {
			new Em\Re\Admin();
		}
		new \Em\Re\Admin\Mailem();

	}

	/**
	 * Singleton Instance Loader
	 *
	 * @return \Main(object)
	 */
	public static function single() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Activate Function Trigerred During Plugin Activation
	 *
	 * @return void
	 */
	public function activate() {
		$installer_instance = new \Em\Re\Installer();
		$installer_instance->initializer();
	}


}

new Main();

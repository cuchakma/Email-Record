<?php
/**
 * Plugin Name: Email-Recorder
 * Plugin URI:  www.facebook.com
 * Description: This plugin is used to create data columns
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
	}

	/**
	 * Constants For The Plugin
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'ASSETS_PATH', __DIR__ . '/assets' );
		define( 'PLUGIN_VERSION', self::VERSION );
		define( 'CURRENT_DIRECTORY', __DIR__ );
		define( 'CURRENT_FILE', __FILE__ );

	}

	/**
	 * Main Functionaity Class Loader
	 *
	 * @return void
	 */
	public function init_classes() {
		new Em\Re\Admin();
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

	public function activate() {

	}


}

new Main();

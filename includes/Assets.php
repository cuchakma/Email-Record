<?php

namespace Em\Re;

/**
 * Assets Class Handler
 */
class Assets {

	/**
	 * Initialize the assets
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_assets_scripts' ) );
	}

	/**
	 * Array containing all the scripts
	 *
	 * @return array
	 */
	public function all_scripts() {
		$script = array(
			'email-recorder-sc' => array(
				'src'     => ASSET_PATH . '/js/admin.js',
				'version' => filemtime( CURRENT_FOLDER . '/assets/js/admin.js' ),
				'deps'    => array( 'jquery' ),
			),
		);
		return $script;
	}

	public function all_styles() {
		$style = array(
			'email-recorder-st' => array(
				'src'     => ASSET_PATH . '/css/admin.css',
				'version' => filemtime( CURRENT_FOLDER . '/assets/css/admin.css' ),
			),
		);

		return $style;
	}

	/**
	 * Register all scripts and styles
	 *
	 * @return void
	 */
	public function register_assets_scripts() {
		$scripts = $this->all_scripts();
		$styles  = $this->all_styles();

		foreach ( $scripts as $handle => $script ) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : false;
			wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
		}

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;
			wp_register_style( $handle, $style['src'], $deps, $style['version'] );
		}

		wp_localize_script(
			'email-recorder-sc',
			'deleteobject',
			array(
				'nonce'    => wp_create_nonce( 'email-delete-nonce' ),
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);

	}


}

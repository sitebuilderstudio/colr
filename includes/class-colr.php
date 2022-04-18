<?php

class Colr {

	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'COLR_VERSION' ) ) {
			$this->version = COLR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'colr';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once COLR_DIR_PATH . 'includes/class-colr-loader.php';

		require_once COLR_DIR_PATH . 'includes/class-colr-i18n.php';

		require_once COLR_DIR_PATH . 'admin/class-colr-admin.php';

		require_once COLR_DIR_PATH . 'public/class-colr-public.php';

		$this->loader = new Colr_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Colr_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Colr_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'colr_admin_menu' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'register_options' );
	}

	private function define_public_hooks() {

		$plugin_public = new Colr_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_post_colr_picker', $plugin_public, 'colr_picker_form_handler' );
        $this->loader->add_action( 'wp_head', $plugin_public, 'colr_head' );

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}

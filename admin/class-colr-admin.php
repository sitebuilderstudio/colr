<?php

class Colr_Admin {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Colr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Colr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/colr-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, COLR_DIR_PATH . 'js/colr-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function colr_admin_menu() {
        add_options_page( 'Colr Plugin Options', 'Colr Schemes', 'manage_options', 'colr', [$this,'colr_admin_options'] );
    }

    public function register_options() {
        register_setting( 'colr-options-defaults-group', 'colr_default' );
        register_setting( 'colr-options-defaults-group', 'colr_default_dark' );
        register_setting( 'colr-options-defaults-group', 'colr_default_class_qty' );
        register_setting( 'colr-options-map-group', 'colr_map' );

    }

    public function colr_admin_options() {

        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        ob_start();
        require COLR_DIR_PATH . 'admin/partials/colr-admin-display.php';
        $html = ob_get_clean();
        echo $html;
        exit();
    }

}

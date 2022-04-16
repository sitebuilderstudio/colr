<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       htts://wpcolr.com
 * @since      1.0.0
 *
 * @package    Colr
 * @subpackage Colr/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Colr
 * @subpackage Colr/admin
 * @author     Joe Kneeland <joe@gens.dev>
 */
class Colr_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
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

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/colr-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function colr_admin_menu() {
        add_options_page( 'Colr Plugin Options', 'Colr Schemes', 'manage_options', 'colr-options-page', [$this,'colr_admin_options'] );
    }

    public function register_options() {
        register_setting( 'colr-options-defaults-group', 'colr_default' );
        register_setting( 'colr-options-defaults-group', 'colr_default_dark' );
    }

    public function colr_admin_options() {

        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        ob_start();
        ?>
        <div class="wrap">
            <h1>Colr Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'colr-options-defaults-group' ); ?>
                <?php do_settings_sections( 'colr-options-defaults-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Default Colr Scheme</th>
                        <td><input type="text" name="colr_default" value="<?php echo esc_attr( get_option('colr_default') ); ?>" /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Default Dark Mode</th>
                        <td><input type="text" name="colr_default_dark" value="<?php echo esc_attr( get_option('colr_default_dark') ); ?>" /></td>
                    </tr>

                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
        $html = ob_get_clean();
        echo $html;
        exit();
        echo '<div class="wrap">';
        echo '<p>Here is where the form would go if I actually had options.</p>';
        echo '</div>';
    }

}

<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       htts://wpcolr.com
 * @since      1.0.0
 *
 * @package    Colr
 * @subpackage Colr/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Colr
 * @subpackage Colr/public
 * @author     Joe Kneeland <joe@gens.dev>
 */
class Colr_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/colr-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/colr-public.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * return the picker shortcode
     */
    public static function colr_picker(){
        ob_start();
        // require_once COLR_DIR_PATH . 'public/class-colr-public.php';
        require COLR_DIR_PATH . 'public/partials/picker.php';
        $html = ob_get_clean();
        echo $html;
        exit();
    }

    /**
     * add css declarations of scheme to site head
     */
    public static function colr_head(){
        global $wpdb;
        ob_start();
        // get users color scheme from database
        $scheme_id = 1;
        $table_name = $wpdb->prefix . "colr";
        $query = "SELECT * FROM `$table_name` WHERE `scheme` = '$scheme_id'";
        $colr_schme_json = $wpdb->get_results($query);
        echo "<script></script>";
        $html = ob_get_clean();
        echo $html;
    }

    /**
     * handle the color picker form submit
     */
    public static function colr_picker_form_handler(){

        if ( isset( $_REQUEST['nonce'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'colr_picker' ) ) {

            global $wpdb;
            $wpdb->show_errors = true;
            $table = $wpdb->prefix.'colr';
            $colr_scheme_id = $_POST['colr_scheme_id'];
            unset(
                $_POST['colr_scheme_id'],
                $_POST['nonce'],
                $_POST['action']
            );

            $json_colrs = json_encode($_POST);

            if(!empty($colr_scheme_id)){
                // update scheme
                $data = array(
                    'uid' => get_current_user_id(),
                    'scheme' => $json_colrs
                );
                $format = array('%d','%s'); // d= int, s= string
                $where_format = '%d'; // d for int
                $where = ['id' => $colr_scheme_id];
                $update = $wpdb->update($table,$data,$where,$format,$where_format);
                if ($update!==false){
                    update_user_meta(get_current_user_id(),'colr_scheme',$colr_scheme_id);
                }else{
                    echo "error updating colr scheme - ".$wpdb->last_error;
                    exit;
                }
            }else{
                $data = array(
                    'uid' => get_current_user_id(),
                    'scheme' => $json_colrs
                );
                $format = array('%d','%s');
                $insert = $wpdb->insert($table,$data,$format);
                if($insert!==false){
                    // set users meta
                    update_user_meta(get_current_user_id(),'colr_scheme',$wpdb->insert_id);
                }else{
                    echo "error adding colr scheme - ".$wpdb->last_error;
                    exit;
                }
                $new_scheme_id = $wpdb->insert_id;
                echo "insert successful, new scheme id - ".$wpdb->insert_id;
                die;
                // TODO - store new scheme id as user colr_scheme meta data
            }

        } else {
            die(__('Security check failed', 'textdomain'));
        }

        wp_safe_redirect(wp_get_referer());
        exit;
    }

    /**
     * get current users color scheme
     * returns object
     */
    public static function getCurrentUsersColrScheme(){

        $users_colr_scheme_id = get_user_meta(get_current_user_id(),'colr_scheme',true);

        if(empty($users_colr_scheme_id)){
            return self::getDefaultColrScheme();
        }else{
            return self::getSchemeByID($users_colr_scheme_id);
        }

    }

    /**
     * get default color scheme
     * returns object
     */
    public static function getDefaultColrScheme(){

        // TODO - admin option to set default
        // then get that option here and use id to get the scheme
        $id = get_option('colr_default');
        return self::getSchemeByID($id);
    }

    /**
     * @param $id
     * @return json decoded object , color scheme
     */
    public static function getSchemeByID($id){
        // get color scheme from db
        global $wpdb;
        $table_name = $wpdb->prefix . "colr";
        $query = "SELECT `scheme` FROM `$table_name` WHERE `id` = '$id'";
        $colr_schme_json = $wpdb->get_var($query);
        if($colr_schme_json!==false){
            return json_decode($colr_schme_json);
        }else{
            echo "unable to find colr scheme, TODO: set default";
            die;
        }
    }

}

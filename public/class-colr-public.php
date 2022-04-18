<?php

class Colr_Public {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/colr-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name."-picker", plugin_dir_url( __FILE__ ) . 'css/colr-picker.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, COLR_DIR_PATH . 'js/colr-public.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name.'-footer', COLR_DIR_PATH . 'js/colr-public-footer.js', array( 'jquery' ), time(), true );
        wp_enqueue_script( $this->plugin_name.'-picker', COLR_DIR_PATH . 'js/colr-picker.js', array( 'jquery' ), $this->version, true );

	}

    /**
     * return the picker shortcode
     */
    public static function colr_picker(){
        ob_start();
        require COLR_DIR_PATH . 'public/partials/colr-public-display.php';
        $html = ob_get_clean();
        echo $html;
    }

    /**
     * add css declarations of scheme to site head
     */
    public static function colr_head(){

        if(is_user_logged_in()){

            ob_start();

            $colrs = (array) self::getCurrentUsersColrScheme();
            $map = get_option('colr_map');

            echo "<!-- colr -->".PHP_EOL."<style>".PHP_EOL;

            $i = 1;
            foreach($map as $dec){

                $ret = $dec['selector']."{";
                switch($dec['type']){
                    case 1:
                        $ret .= "color";
                        break;
                    case 2:
                        $ret .= "background-color";
                        break;
                    case 3:
                        $ret .= "border-color";
                        break;
                }

                // get value from users scheme using i as key
                $ret .= ":".$colrs[$i]." !important;}".PHP_EOL;

                if(!empty($colrs[$i]) && !empty($dec['selector']) && !empty($dec['type'])){
                    echo $ret;
                }
                $i++;
            }
            echo "</style>".PHP_EOL;
        }
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
                    wp_safe_redirect(wp_get_referer());
                    exit;
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
                    wp_safe_redirect(wp_get_referer());
                    exit;
                }else{
                    echo "error adding colr scheme - ".$wpdb->last_error;
                    exit;
                }
            }
        } else {
            die(__('Security check failed', 'textdomain'));
        }
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

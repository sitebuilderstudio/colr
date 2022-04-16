<?php

/**
 * Fired during plugin activation
 *
 * @link       htts://wpcolr.com
 * @since      1.0.0
 *
 * @package    Colr
 * @subpackage Colr/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Colr
 * @subpackage Colr/includes
 * @author     Joe Kneeland <joe@gens.dev>
 */
class Colr_Activator {

    public function __construct() {
        $this->activate();
    }
	public static function activate() {

        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'colr';
        $sql        = "CREATE TABLE $table_name (
          id int(11) NOT NULL AUTO_INCREMENT,
          uid int(11) NOT NULL,
          type int(11) NOT NULL,
          theme_name varchar(250) NOT NULL,
          theme varchar(250) NOT NULL,
          PRIMARY KEY  (id)
	) $charset_collate;";
            dbDelta( $sql );
	}

}

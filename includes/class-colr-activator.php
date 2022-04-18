<?php

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

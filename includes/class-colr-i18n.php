<?php

class Colr_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'colr',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}

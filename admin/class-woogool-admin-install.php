<?php

class WooGool_Admin_Install {

	private static $instance;

    public static function getInstance() {
        if( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct( $current_version ) {
    	
    }

}
new WooGool_Admin_Install( $current_version );
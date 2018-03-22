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
    	//$this->set_feed_default();
    }

	function set_feed_default() {
        $offset = 20;
        $products = woogool_get_products( 20 );

        while( count( $products ) ) {
            $new_some_products = woogool_get_products( 20, $offset );
            $products          = array_merge( $products, $new_some_products );
            if ( ! count( $new_some_products ) ) {
                break;
            }
            $offset            = $offset + 20;
        }

        foreach ( $products as $key => $product ) {
            $product_id = $product->ID;

            update_post_meta( $product_id, '_google_product_category', 'default' );
            update_post_meta( $product_id, '_product_type', 'default' );
            update_post_meta( $product_id, '_availability', 'default' );
            update_post_meta( $product_id, '_availability_date_default', 'default' );
            update_post_meta( $product_id, '_brand_default', 'default' );
            update_post_meta( $product_id, '_mpn_default', 'default' );
            update_post_meta( $product_id, '_color_default', 'default' );
            update_post_meta( $product_id, '_size_default', 'default' );
            update_post_meta( $product_id, '_custom_label_0_default', 'default' );
            update_post_meta( $product_id, '_custom_label_1_default', 'default' );
            update_post_meta( $product_id, '_custom_label_2_default', 'default' );
            update_post_meta( $product_id, '_custom_label_3_default', 'default' );
            update_post_meta( $product_id, '_custom_label_4_default', 'default' );
            update_post_meta( $product_id, '_promotion_id_default', 'default' );
            update_post_meta( $product_id, '_gender', 'default' );
            update_post_meta( $product_id, '_age_group', 'default' );
            update_post_meta( $product_id, '_size_type', 'default' );
            update_post_meta( $product_id, '_size_system', 'default' );
            update_post_meta( $product_id, '_expiration_date_default', 'default' );
        }
    }
}
new WooGool_Admin_Install( $current_version );
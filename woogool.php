<?php
/**
 * Plugin Name: Google Product Feed
 * Plugin URI: https://github.com/asaquzzaman/woocommerce-to-google-merchant-center
 * Description: WooCommerce product export
 * Author: asaquzzaman
 * Version: 1.0
 * Author URI: http://mishubd.com
 * License: GPL2
 * TextDomain: wogol
 */

/**
 * Copyright (c) 2013 Asaquzzaman Mishu (email: joy.mishu@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 * **********************************************************************
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require_once dirname(__FILE__) . '/includes/pages.php';
require_once dirname(__FILE__) . '/includes/function.php';

class WP_WooGool {

    private $merchant_account_id;
    public $individual;
    public static $version = '0.5';

    /**
     * @var The single instance of the class
     * 
     */
    protected static $_instance = null;

    /**
     * Main woogool Instance
     *
     * @static
     * @see woogool()
     * @return woogool - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * class handelar or initial readable function
     * @return void
     */
    function __construct() {

        $this->init();
        $this->instantiate();

        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_filter( 'manage_edit-product_columns', array( $this, 'product_columns_head' ), 20, 1 );
        add_action( 'manage_product_posts_custom_column', array( $this, 'product_columns' ), 10, 2 );
        
        add_action( 'admin_init', array( $this, 'delete_product' ) );
        add_action( 'settings_text_field', array( $this, 'settings_text_field' ), 10, 2 );
        add_action( 'admin_enqueue_scripts', array( $this, 'scripts') );
    }

    function init() {
        $this->define_constants();
        spl_autoload_register( array( __CLASS__, 'autoload' ) );
    }

    function autoload( $class ) {
        
        if ( stripos( $class, 'WooGool_' ) !== false ) {
            $admin = ( stripos( $class, '_Admin_' ) !== false ) ? true : false;

            if ( $admin ) {
                $class_name = str_replace( array('_'), array('-'), $class );
                $filename = dirname( __FILE__ ) . '/admin/class-' . strtolower( $class_name ) . '.php';
            } else {
                $class_name = str_replace( array('WooGool_', '_'), array('', '-'), $class );
                $filename = dirname( __FILE__ ) . '/class/' . strtolower( $class_name ) . '.php';
            }

            if ( file_exists( $filename ) ) {
                require_once $filename;
            }
        }
    }

    /**
     * Define woogool Constants
     *
     * @return type
     */
    private function define_constants() {
        $this->define( 'WOOGOOL_PATH', dirname( __FILE__ ) );
        $this->define( 'WOOGOOL_INCLUDES_PATH', dirname( __FILE__ ) . '/includes' );
        $this->define( 'WOOGOOL_VIEWS_PATH', dirname( __FILE__ ) . '/views' );
    }

    /**
     * Define constant if not already set
     *
     * @param  string $name
     * @param  string|bool $value
     * @return type
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }

    public static function install() {
        $current_version = self::$version;
        require_once dirname(__FILE__) . '/admin/class-woogool-admin-install.php';
        update_option( 'woogool_version', $current_version );
    }

    function delete_product() {
        if( !isset( $_GET['page'] ) ) {
            return;
        }

        if ( $_GET['page'] != 'product_woogool' ) {
            return;
        }

        if ( !isset( $_GET['product_id'] ) || empty( $_GET['product_id'] ) ) {
            return;
        }

        if ( !isset( $_GET['action'] ) ) {
            return;
        }
        if ( $_GET['action'] != 'delete' ) {
            return;
        }

        $this->delete_product_from_merchant( $_GET['product_id'] );
        wp_redirect( admin_url('edit.php?post_type=product&page=product_woogool') );
    }

    /**
     * Delete product form google merchant center
     * @param  init $post_id
     * @return void
     */
    function product_delete( $post_id ) {
        global $post_type;
        if ( $post_type != 'product' ) return;
        $this->delete_product_from_merchant( $post_id );
    }

    function delete_product_from_merchant( $product_id ) {
        $merchant_status = get_post_meta( $product_id, 'merchant_status', true );

        if ( $merchant_status != 'yes' ) {
            return;
        }

        $merchant_id = get_post_meta( $product_id, 'merchant_id', true );
        $merchant_product_id = get_post_meta( $product_id, 'merchant_product_id', true );

        $client = woogool_get_client();

        if ( !$client ) {
            wp_redirect( admin_url( 'edit.php?post_type=product&page=product_woogool' ) );
        }

        $shoppinContent = new Google_Service_ShoppingContent($client);
        try {

            $shoppinContent->products->delete( $merchant_id, $merchant_product_id );
            delete_post_meta( $product_id, 'merchant_status' );
            delete_post_meta( $product_id, 'merchant_product_id' );
            delete_post_meta( $product_id, 'merchant_id' );
        }  catch( Google_Service_Exception $e ) {
            if ( strpos( $e->getMessage(), 'item not found' ) === false ) {

            } else {
                delete_post_meta( $product_id, 'merchant_status' );
                delete_post_meta( $product_id, 'merchant_product_id' );
                delete_post_meta( $product_id, 'merchant_id' );
            }
        }
    }

    /**
     * Initialy instantiate some class
     * @return void
     */
    function instantiate() {
        $this->individual = WooGool_Admin_single_product::instance();
        new WooGool_Admin_ajax();
    }

    /**
     * Load script
     * @return  void
     */
    function scripts() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'woogool-chosen', plugins_url( '/assets/js/chosen.jquery.min.js', __FILE__ ), array( 'jquery' ), false, true);
        wp_enqueue_script( 'woogool-script', plugins_url( 'assets/js/woogool.js', __FILE__ ), array( 'jquery' ), false, true );
        wp_localize_script( 'woogool-script', 'woogool_var', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'woogool_nonce' ),
            'country_details' => json_encode( woogool_country_details() ),
            'is_admin' => is_admin() ? 'yes' : 'no',
        ));
        wp_enqueue_style( 'woogool-chosen', plugins_url( '/assets/css/chosen.min.css', __FILE__ ), false, false, 'all' );
        wp_enqueue_style( 'woogool-style', plugins_url( 'assets/css/woogool.css', __FILE__ ) );
        wp_enqueue_style( 'woogool-jquery-ui', plugins_url( '/assets/css/jquery-ui.css', __FILE__ ), false, false, 'all' );
    }
    /**
     * Set woocommerce submenu
     * @return void
     */
    function admin_menu() {
        $woogool = add_submenu_page( 'edit.php?post_type=product', __( 'WooGool', 'woogool' ), __( 'WooGool', 'woogool' ), 'manage_product_terms', woogool_page_slug() , array( $this, 'woogool_page' ) );
        add_action( 'admin_print_styles-' . $woogool, array( $this, 'scripts' ) );
    }
    /**
     * View page controller
     * @return [type] [description]
     */
    function woogool_page() {
        if( !is_user_logged_in() ) {
            sprintf( 'Please <a href="%s">login</a>', wp_login_url() );
            return;
        }

        $current_user_id = get_current_user_id();

        if ( isset( $_GET['product_id'] ) ) {
            update_user_meta( $current_user_id, 'woogool_product_id', $_GET['product_id'] );
        }

        $query_args = woogool_get_query_args();
        $page       = $query_args['page'];
        $tab        = $query_args['tab'];
        $subtab     = $query_args['sub_tab'];
            
        echo '<div class="woogool wrap" id="woogool">';
            WooGool_Admin_Settings::getInstance()->show_tab_page( $page, $tab, $subtab );
        echo '</div>';
    }

    /**
     * Product listing table header
     * @return product table column
     */
    function product_columns( $column_name, $post_id  ) {
        if ( $column_name != 'merchent_center' ) {
            return;
        }
        $url = admin_url( 'edit.php?post_type=product&page=product_woogool&woogool_tab=woogool_single&woogool_sub_tab=new_product&product_id=' . $post_id );
        $merchant_status = get_post_meta( $post_id, 'merchant_status', true );
        if ( $merchant_status == 'yes' ) {
            $merchant_product_id = get_post_meta( $post_id, 'merchant_product_id', true );
            $merchant_id = get_post_meta( $post_id, 'merchant_id', true );

            echo '<a class="woogool-delete-product" data-post_id="'.$post_id.'" data-merchant_product_id="'.$merchant_product_id.'" data-merchant_id="'.$merchant_id.'" href="#">
            Delete</a>';
            return;
        }

        ?>
        <a data-post_id="<?php echo $post_id; ?>" class="woogool-add-product" href="<?php echo $url; ?>"><?php _e( 'Add', 'woogool' ); ?></a>
        <div class="woogool-merchant-wrap woogool-product-<?php echo $post_id; ?>"></div>
        <?php

    }

    /**
     * Product table column head
     * @param  array $existing_columns
     * @return array
     */
    function product_columns_head( $existing_columns ) {

        unset( $existing_columns['date'] );
        $head = array();
        $head['merchent_center'] = __('WooGool', 'woogool' );
        $head['date'] = __( 'Date', 'woocommerce' );

        return array_merge( $existing_columns, $head );
    }

    /**
     * Filter for add something after text field
     * @param  string $name
     * @param  array $element
     * @return void
     */
    function settings_text_field( $name, $element ) {

        if ( isset( $element['extra']['data-add_more'] ) && $element['extra']['data-add_more'] === true ) {
            ?>
            <i class="woogool-more-field">+</i>
            <?php
        }
        if ( isset( $element['extra']['data-remove_more'] ) && $element['extra']['data-remove_more'] === true ) {
            ?>
                <i class="woogool-remove-more">-</i>
            <?php
        }
    }
}

register_activation_hook( __FILE__, array( 'WP_WooGool', 'install' ) );

add_action( 'plugins_loaded', 'WooGool' );

function WooGool() {
    return new WP_WooGool();
}



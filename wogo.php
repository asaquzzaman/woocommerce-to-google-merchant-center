<?php
/**
 * Plugin Name: WP Woocommerce to Google Merchant Center
 * Plugin URI: https://github.com/asaquzzaman/woocommerce-to-google-merchant-center
 * Description: Submit your product woocommerce to google merchant center.
 * Author: asaquzzaman
 * Version: 0.4
 * Author URI: http://mishubd.com
 * License: GPL2
 * TextDomain: wogo
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
require_once dirname(__FILE__) . '/includes/function.php';
class WP_Wogo {

    private $client_id;
    private $client_secret;
    private $merchant_account_id;
    public static $version = '0.4';

    /**
     * @var The single instance of the class
     * 
     */
    protected static $_instance = null;

    /**
     * Main woogoo Instance
     *
     * @static
     * @see woogoo()
     * @return woogoo - Main instance
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
        add_action( 'admin_init', array( $this, 'get_token_from_url_code' ) );
        add_action( 'admin_init', array( $this, 'delete_product' ) );
        add_action( 'settings_text_field', array( $this, 'settings_text_field' ), 10, 2 );
        add_action( 'admin_enqueue_scripts', array( $this, 'scripts') );
        add_action( 'add_meta_boxes', array( $this, 'feed_meta_box' ) );
    }

    function feed_meta_box( $post_type ) {
        if ( $post_type != 'product' ) {
            return;
        }

        $msg1 = __( 'WooGoo Feed Information     (This feature is available for pro version)' );
        $msg2 =  __( 'Update to pro version', 'wogo' );
        $msg3 = sprintf( '%s       <a class="button button-primary" href="http://mishubd.com/product/woogoo/" target="_blank">%s</a>', $msg1, $msg2 );
        add_meta_box( 'wogo-feed-metabox-wrap', $msg3, array( $this, 'wogo_meta_box_callback' ), $post_type, 'normal', 'core' );
    }

    function wogo_meta_box_callback( $post ) {
        if ( $post->post_type != 'product' ) {
            return;
        }
        $post_id = $post->ID;
        include_once WOOGOO_PATH . '/views/new-feed.php';
    }

    function init() {
        $this->define_constants();
        spl_autoload_register( array( __CLASS__, 'autoload' ) );
    }

    function autoload( $class ) {
        if ( stripos( $class, 'WOGO_' ) !== false ) {

            $admin = ( stripos( $class, '_Admin_' ) !== false ) ? true : false;

            if ( $admin ) {
                $class_name = str_replace( array('WOGO_Admin_', '_'), array('', '-'), $class );
                $filename = dirname( __FILE__ ) . '/admin/' . strtolower( $class_name ) . '.php';
            } else {
                $class_name = str_replace( array('WOGO_', '_'), array('', '-'), $class );
                $filename = dirname( __FILE__ ) . '/class/' . strtolower( $class_name ) . '.php';
            }
            if ( file_exists( $filename ) ) {
                require_once $filename;
            }
        }
    }

    /**
     * Define woogoo Constants
     *
     * @return type
     */
    private function define_constants() {
        $this->define( 'WOOGOO_PATH', dirname( __FILE__ ) );
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

        update_option( 'wogo_version', self::$version );
        self::set_feed_default();
    }

    public static function set_feed_default() {
        $offset = 20;
        $products = woogoo_get_products( 20 );

        while( count( $products ) ) {
            $new_some_products = woogoo_get_products( 20, $offset );
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

    function delete_product() {
        if( !isset( $_GET['page'] ) ) {
            return;
        }

        if ( $_GET['page'] != 'product_wogo' ) {
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
        wp_redirect( admin_url('edit.php?post_type=product&page=product_wogo') );
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

        $client = wogo_get_client();

        if ( !$client ) {
            wp_redirect( admin_url( 'edit.php?post_type=product&page=product_wogo' ) );
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
        
        $user_id = get_current_user_id();
        $client_id = get_user_meta( $user_id, 'wogo_client_id', true );
        $client_secret = get_user_meta( $user_id, 'wogo_client_secret', true );
        $this->client_id = str_replace( ' ', '', $client_id );
        $this->client_secret = str_replace( ' ', '', $client_secret );

        new WOGO_Admin_ajax();
    }

    /**
     * Load script
     * @return  void
     */
    function scripts() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'wogo-chosen', plugins_url( '/assets/js/chosen.jquery.min.js', __FILE__ ), array( 'jquery' ), false, true);
        wp_enqueue_script( 'wogo-script', plugins_url( 'assets/js/wogo.js', __FILE__ ), array( 'jquery' ), false, true );
        wp_localize_script( 'wogo-script', 'wogo_var', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'wogo_nonce' ),
            'is_admin' => is_admin() ? 'yes' : 'no',
        ));
        wp_enqueue_style( 'wogo-chosen', plugins_url( '/assets/css/chosen.min.css', __FILE__ ), false, false, 'all' );
        wp_enqueue_style( 'wogo-style', plugins_url( 'assets/css/wogo.css', __FILE__ ) );
        wp_enqueue_style( 'wogo-jquery-ui', plugins_url( '/assets/css/jquery-ui.css', __FILE__ ), false, false, 'all' );
    }
    /**
     * Set woocommerce submenu
     * @return void
     */
    function admin_menu() {
        $wogo = add_submenu_page( 'edit.php?post_type=product', __( 'WooGoo', 'woocommerce' ), __( 'WooGoo', 'woocommerce' ), 'manage_product_terms', 'product_wogo', array( $this, 'wogo_page' ) );
        add_action( 'admin_print_styles-' . $wogo, array( $this, 'scripts' ) );
    }
    /**
     * View page controller
     * @return [type] [description]
     */
    function wogo_page() {

        if ( isset( $_GET['product_id'] ) ) {
            update_user_meta( get_current_user_id(), 'wogo_product_id', $_GET['product_id'] );
        }

        include_once dirname (__FILE__) . '/views/header.php';

    }

    /**
     * check google authenticate for show submitted product form
     * @return boolen
     */
    function check_authenticate() {

        if ( ! isset( $_GET['post_type'] ) || $_GET['post_type'] != 'product' ) {
            return false;
        }

        if ( ! isset( $_GET['page'] ) || $_GET['page'] != 'product_wogo' ) {
            return false;
        }

        if ( wogo_get_access_token() ) {
           return true;
        }

        return false;
    }

    function authentication_process() {
        $client = wogo_google_class();
        $scriptUri = admin_url( 'edit.php?post_type=product&page=product_wogo' );
        $client->setClientId( $this->client_id );
        $client->setClientSecret( $this->client_secret );
        $client->setRedirectUri( $scriptUri );
        $client->setScopes( 'https://www.googleapis.com/auth/content' );

        if ( ! isset($_GET['code']) ) {
            $loginUrl = $client->createAuthurl();
            echo '<h1>Expired Access Token Please Click <a class="button button-primary" href="'.$loginUrl.'">Here </a> To Login</h1>';
        }
    }

    /**
     * Save WooGoo setting and get token from url code
     * @return void
     */
    function get_token_from_url_code() {
        if ( !isset( $_GET['post_type'] ) || $_GET['post_type'] != 'product' ) {
            return;
        }

        if ( !isset( $_GET['page'] ) || $_GET['page'] != 'product_wogo' ) {
            return;
        }

        $this->save_setting();
        $this->get_new_token();
    }

    /**
     * Save WooGoo settings
     * @return void
     */
    function save_setting() {
        if ( isset( $_POST['wogo_settings'] ) ) {
            update_user_meta( get_current_user_id(), 'wogo_client_id', $_POST['client_id'] );
            update_user_meta( get_current_user_id(), 'wogo_client_secret', $_POST['client_secret'] );
            update_user_meta( get_current_user_id(), 'merchant_account_id', $_POST['merchant_account_id'] );
            $redirect_url = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_settings' );
            wp_redirect( $redirect_url );
            exit();
        }
    }

    /**
     * Get google token from url parametar code
     * @return void
     */
    function get_new_token() {

        $client = wogo_google_class();
        $scriptUri = admin_url( 'edit.php?post_type=product&page=product_wogo' );
        $client->setClientId( $this->client_id );
        $client->setClientSecret( $this->client_secret );
        $client->setRedirectUri( $scriptUri );
        $client->setScopes( 'https://www.googleapis.com/auth/content' );

        if ( isset($_GET['code']) ) {
            $client->authenticate( $_GET['code'] );
            $access_token = $client->getAccessToken();
            $user_id = get_current_user_id();
            update_user_meta( $user_id, 'access_token', $access_token );
            wp_redirect( $scriptUri );
            exit();
        }
    }

    /**
     * Product listing table header
     * @return product table column
     */
    function product_columns( $column_name, $post_id  ) {
        if ( $column_name != 'merchent_center' ) {
            return;
        }
        $url = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_new_product&product_id=' . $post_id );
        $merchant_status = get_post_meta( $post_id, 'merchant_status', true );
        if ( $merchant_status == 'yes' ) {
            $merchant_product_id = get_post_meta( $post_id, 'merchant_product_id', true );
            $merchant_id = get_post_meta( $post_id, 'merchant_id', true );

            echo '<a class="wogo-delete-product" data-post_id="'.$post_id.'" data-merchant_product_id="'.$merchant_product_id.'" data-merchant_id="'.$merchant_id.'" href="#">
            Delete</a>';
            return;
        }

        ?>
        <a data-post_id="<?php echo $post_id; ?>" class="wogo-add-product" href="<?php echo $url; ?>"><?php _e( 'Add', 'wogo' ); ?></a>
        <div class="wogo-merchant-wrap wogo-product-<?php echo $post_id; ?>"></div>
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
        $head['merchent_center'] = __('WooGoo', 'wogo' );
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
            <i class="wogo-more-field">+</i>
            <?php
        }
        if ( isset( $element['extra']['data-remove_more'] ) && $element['extra']['data-remove_more'] === true ) {
            ?>
                <i class="wogo-remove-more">-</i>
            <?php
        }
    }
}

register_activation_hook( __FILE__, array( 'WP_Wogo', 'install' ) );
add_action( 'plugins_loaded', 'woogoo_init' );

function woogoo_init() {
    new WP_Wogo();
}



<?php
/**
 * Plugin Name: WP Woocommerce to Google merchant center
 * Plugin URI: https://github.com/asaquzzaman/woocommerce-to-google-merchant-center
 * Description: Submit your product woocommerce to google merchant center.
 * Author: asaquzzaman
 * Version: 0.1
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



/**
 * Autoload class files on demand
 *
 * @param string $class requested class name
 */
function WOGO_autoload( $class ) {

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
spl_autoload_register( 'WOGO_autoload' );
require_once dirname(__FILE__) . '/includes/function.php';
class WP_Wogo {

    private $client_id;
    private $client_secret;
    private $merchant_account_id;

    /**
     * class handelar or initial readable function
     * @return void
     */
    function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_filter( 'manage_edit-product_columns', array( $this, 'product_columns_head' ), 20, 1 );
        add_action( 'manage_product_posts_custom_column', array( $this, 'product_columns' ), 10, 2 );
        add_action( 'admin_init', array( $this, 'get_token_from_url_code' ) );
        add_action( 'admin_init', array( $this, 'delete_product' ) );
        add_action( 'settings_text_field', array( $this, 'settings_text_field' ), 10, 2 );
        add_action( 'admin_enqueue_scripts', array( $this, 'scripts') );
        //add_action( 'before_delete_post', array( $this, 'product_delete' ) );

        $this->instantiate();
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
        wp_enqueue_script( 'wogo-script', plugins_url( 'assets/js/wogo.js', __FILE__ ), array( 'jquery' ), false, true );
        wp_localize_script( 'wogo-script', 'wogo_var', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'wogo_nonce' ),
            'is_admin' => is_admin() ? 'yes' : 'no',
        ));
        wp_enqueue_style( 'wogo-style', plugins_url( 'assets/css/wogo.css', __FILE__ ) );
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
        $is_access_premission = $this->check_authenticate();

        require_once dirname (__FILE__) . '/views/header.php';

    }

    /**
     * check google authenticate for show submitted product form
     * @return boolen
     */
    function check_authenticate() {

        if ( !isset( $_GET['post_type'] ) || $_GET['post_type'] != 'product' ) {
            return;
        }

        if ( !isset( $_GET['page'] ) || $_GET['page'] != 'product_wogo' ) {
            return;
        }

        if ( wogo_get_access_token() ) {
           return true;
        }

        $client = wogo_google_class();
        $scriptUri = admin_url( 'edit.php?post_type=product&page=product_wogo' );
        $client->setClientId( $this->client_id );
        $client->setClientSecret( $this->client_secret );
        $client->setRedirectUri( $scriptUri );
        $client->setScopes( 'https://www.googleapis.com/auth/content' );

        if ( !isset($_GET['code']) ) {
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
     * Get woocommerce all product
     * @return array()
     */
    function get_products() {
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'product',
            'post_status'      => 'publish',
        );

        return get_posts( $args );
    }

    /**
     * Product table column head
     * @param  array $existing_columns
     * @return array
     */
    function product_columns_head( $existing_columns ) {

        unset( $existing_columns['date'] );
        $head = array();
        $head['merchent_center'] = __('Google Merchant Center', 'wogo' );
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

add_action( 'plugins_loaded', function() {
    new WP_Wogo();
});

/**
 * Google client class Instantiate
 * @return object
 */
function wogo_google_class() {
    static $client;
    if ( !$client ) {
        $plugin_path = plugin_dir_path( __FILE__ ) . 'includes';
        set_include_path( $plugin_path . PATH_SEPARATOR . get_include_path());

        require_once 'Google/Client.php';
        require_once 'Google/Service/ShoppingContent.php';

        $client = new Google_Client();
    }

    return $client;
}

/**
 * Check token validate
 * @return string
 */
function wogo_get_access_token() {

    $user_id = get_current_user_id();
    $access_token = get_user_meta( $user_id, 'access_token', true );
    if ( empty( $access_token ) ) {
        return false;
    }

    $client = wogo_google_class();

    $client->setAccessToken( $access_token );

    if ( $client->isAccessTokenExpired() ) {
        return false;
    }
    return $access_token;
}

/**
 * Get client token
 * @return string or boolen
 */
function wogo_get_client() {
    $client = wogo_google_class();
    $access_token = wogo_get_access_token();
    if ( $access_token ) {
        $client->setAccessToken( $access_token );
        $client->getAccessToken();

        return $client;
    }
    return false;
}

function wogo_get_products_list() {
    $client         = wogo_get_client();
    $shoppinContent = new Google_Service_ShoppingContent($client);
    $merchant_id    = get_user_meta( get_current_user_id(), 'merchant_account_id', true );
    $products       = $shoppinContent->products->listProducts( $merchant_id );

    return $products;
}

function wogo_get_product( $product_id ) {
    $client         = wogo_get_client();
    $shoppinContent = new Google_Service_ShoppingContent($client);
    $merchant_id    = get_user_meta( get_current_user_id(), 'merchant_account_id', true );
    $products       = $shoppinContent->products->get( $merchant_id, $product_id );

    return $products;
}

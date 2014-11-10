<?php
/**
 * Ajax request handelar
 */
class WOGO_Admin_ajax {
    function __construct() {
        add_action( 'wp_ajax_new_merchant', array( $this, 'new_merchant' ) );
        add_action( 'wp_ajax_delete_product', array( $this, 'delete_product' ) );
        add_action( 'wp_ajax_wogo_merchant_form', array( $this, 'google_merchant' ) );
        add_action( 'wp_ajax_change_product', array( $this, 'change_product' ) );
    }

    /**
     * From dropdown menu change product and get form value from the product metadata
     * @return array
     */
    function change_product() {
        $product_id = $_POST['product_id'];
        $url = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_new_product&product_id=' . $product_id );
        wp_send_json_success( array( 'url' => $url ) );
    }

    /**
     * Delete product
     * @return json
     */
    function delete_product() {
    	check_ajax_referer( 'wogo_nonce' );
    	$merchant_id = $_POST['merchant_id'];
    	$merchant_product_id = $_POST['merchant_product_id'];
    	$product_id = $_POST['post_id'];
    	$client = wogo_get_client();

        if ( !$client ) {
            wp_send_json_error( array( 'url' => admin_url( 'edit.php?post_type=product&page=product_wogo' ) ) );
        }

        $shoppinContent = new Google_Service_ShoppingContent($client);
        try {
            $product_status = $shoppinContent->products->get( $merchant_id, $merchant_product_id );

            $shoppinContent->products->delete( $merchant_id, $merchant_product_id );
            delete_post_meta( $product_id, 'merchant_status' );
            delete_post_meta( $product_id, 'merchant_product_id' );
            delete_post_meta( $product_id, 'merchant_id' );
            wp_send_json_success(array( 'success_msg' => __( 'Product delete successfully from google merchant center', 'wogo' ) ));
        }  catch( Google_Service_Exception $e ) {
            if ( strpos( $e->getMessage(), 'item not found' ) === false ) {

            } else {
                delete_post_meta( $product_id, 'merchant_status' );
                delete_post_meta( $product_id, 'merchant_product_id' );
                delete_post_meta( $product_id, 'merchant_id' );
                wp_send_json_success(array( 'success_msg' => __( 'Product delete successfully from google merchant center', 'wogo' ) ));
            }
        }

    }

    function new_merchant() {
        check_ajax_referer( 'wogo_nonce' );
        ob_start();
        WOGO_Admin_Merchant::merchatn_form();
        wp_send_json_success( array( 'append_data' => ob_get_clean() ) );
    }

    /**
     * Insert product to merchant center
     * @return json
     */
    function google_merchant() {

        if ( !isset( $_POST['product_id'] ) ) {
            wp_send_json_error( array( 'error_code' => 400, 'error_msg' => __( 'Product id required', 'wogo' ) ) );
        }
        update_post_meta( $_POST['product_id'], 'wogo_product', $_POST );
        update_user_meta( get_current_user_id(), 'wogo_product_id', $_POST['product_id'] );

        $client = wogo_get_client();


        $postdatas = $_POST;
        $product_id = $_POST['product_id'];
        unset($postdatas['wogo_submit']);
        unset($postdatas['action']);
        unset($postdatas['product_id']);

        if ( ! $client ) {
            wp_send_json_error( array( 'authentication_fail' => true ) );
        }

        $shoppinContent = new Google_Service_ShoppingContent($client);

        try {
            $merchant_id = get_user_meta( get_current_user_id(), 'merchant_account_id', true );
            $product = $shoppinContent->products->insert( $merchant_id, new Google_Service_ShoppingContent_Product( $postdatas ) );
            if ( $product ) {
                update_post_meta( $product_id, 'merchant_status', 'yes' );
                update_post_meta( $product_id, 'merchant_product_id', $product->id );
                update_post_meta( $product_id, 'merchant_id', $merchant_id );

            }

            wp_send_json_success(array('success_msg' => __( 'Update successfully! Please check your merchant account', 'wogo' ) ));

        } catch( Google_ServiceException $e ) {
            wp_send_json_error( array( 'error_code' => $e->getCode(), 'error_msg' => $e->getMessage() ) );
        } catch (Google_Exception $e) {
            wp_send_json_error( array( 'error_code' => $e->getCode(), 'error_msg' => $e->getMessage() ) );
        }

    }
}
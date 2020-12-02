<?php
/**
 * Ajax request handelar
 */
class WooGool_Admin_ajax {
    function __construct() {
        add_action( 'wp_ajax_new_merchant', array( $this, 'new_merchant' ) );
        add_action( 'wp_ajax_delete_product', array( $this, 'delete_product' ) );
        add_action( 'wp_ajax_woogool_merchant_form', array( $this, 'google_merchant' ) );
        add_action( 'wp_ajax_change_product', array( $this, 'change_product' ) );
        add_action( 'wp_ajax_woogool-new-feed', array( $this, 'new_feed' ) );
        add_action( 'wp_ajax_woogool-get-feed', array( $this, 'get_feed' ) );
        add_action( 'wp_ajax_woogool-get-feeds', array( $this, 'get_feeds' ) );
        add_action( 'wp_ajax_woogool-get-feed-delete', array( $this, 'delete_feed' ) );
        add_action( 'wp_ajax_woogool-download-feed_file', array( $this, 'download_feed_file' ) );
        add_action( 'wp_ajax_woogool-new-feed-continue', array( $this, 'new_feed_continue' ) );
        add_action( 'wp_ajax_woogool-generate-feed-file', array( $this, 'update_feed_file' ) );
        add_action( 'wp_ajax_woogool-create-xml-file', array( $this, 'create_xml_file' ) );
    }

    function download_feed_file() {
        check_ajax_referer( 'woogool_nonce' );

        $postdata = wp_unslash( $_GET );
        $feed_id  = intval( $postdata['feed_id'] ) ? $postdata['feed_id'] : false;

        if ( ! $feed_id ) {
            wp_send_json_error();
        }

        $file       = get_post_meta( $feed_id, 'feed_file_name', true );
        $wp_dir     = wp_upload_dir();
        $upload_dir = $wp_dir['baseurl'] . '/woogool-product-feed';
        $mime_type  = 'application/xml';
        $file_path  = $upload_dir . '/' . $file . '.xml';

        wp_safe_redirect( $file_path );
        exit();
        // serve the file with right header
        //if ( is_readable( $file_path ) ) {
            
            // header( 'Content-Type: ' . $mime_type );
            // header( 'Content-Transfer-Encoding: binary' );
            // header( 'Content-Disposition: inline; filename=' . basename( $file_path ) );
            // readfile( $file_path );
        //}

        // wp_send_json_success();
    }

    function create_xml_file() {
        check_ajax_referer( 'woogool_nonce' );
        
        $postdata   = wp_unslash( $_POST );
        $feed_id    = intval( $postdata['feed_id'] ) ? $postdata['feed_id'] : false;
        $post = false;
        
        if ( $feed_id ) {
            $post = get_post( $feed_id );
        }
        if( $post ) {
            $feed_title = $post->post_title;
        } else {
            $feed_title = '';
        }
        
        
        if ( ! $feed_id ) {
            wp_send_json_error();
            exit();
        }
        
        $feed = WooGool_Admin_Feed::instance()->create_xml_file( $feed_id, $feed_title );

        if ( ! $feed ) {
            wp_send_json_error();
            exit();
        }

        wp_send_json_success(array(
            'file_name' => $feed
        ));

        exit();
    }

    function update_feed_file() {
        check_ajax_referer( 'woogool_nonce' );

        $postdata = wp_unslash( $_POST );
        $feed_id = intval( $postdata['feed_id'] ) ? $postdata['feed_id'] : false ;

        if ( ! $feed_id ) {
            wp_send_json_error( array( 'errors' => [
                'feed_id' => 'Feed ID required'
            ] ) );
        }

        $feed = WooGool_Admin_Feed::instance()->update_feed_file( $postdata );
        
        wp_send_json_success($feed);

        exit();
    }

    function new_feed_continue() {
        check_ajax_referer( 'woogool_nonce' );
        $postdata = $_POST['form_data']['postdata'];
        $res                 = WooGool_Admin_Feed::instance()->new_feed( $postdata );
        $postdata['id']      = isset( $res['id'] ) ? intval( $res['id'] ) : 0;
        $postdata['offset']  = $res['offset']; 
        $postdata['woogool_continue']= $woogool_continue = isset( $res['woogool_continue'] ) ? $res['woogool_continue'] : false;
        $redirect_url        = woogool_subtab_menu_url( 'woogool_multiple', 'feed-lists' );

        wp_send_json_success( array( 'postdata' => $postdata, 'woogool_continue' => $woogool_continue, 'redirect' => $redirect_url, 'count' => $res['count'] ) );
    }

    function get_feeds() {
        check_ajax_referer( 'woogool_nonce' );

        $feeds = woogool_get_feeds();

        wp_send_json_success( 
            [
                'posts' => $feeds->posts
            ]
        );
    }

    function get_feed() {
        check_ajax_referer( 'woogool_nonce' );
        $post_id   = empty( $_POST['post_id'] ) ? 0 : intval( $_POST['post_id'] );
        $post = get_post( $post_id );

        wp_send_json_success([
            'post' => $post,
            'header' => [
                'feedByCatgory'    => get_post_meta( $post_id, 'feed_by_category', true ),
                'activeVariation'  => get_post_meta( $post_id, 'active_variation', true ),
                'refresh'          => get_post_meta( $post_id, 'refresh', true ),
                'categories'       => get_post_meta( $post_id, 'categories', true ),
                'googleCategories' => get_post_meta( $post_id, 'google_categories', true ),
                'name'             => $post->post_title,
                'country'          => get_post_meta( $post_id, 'country', true ),
                'channel'          => empty( $post->post_content ) ? 'google_shopping' : $post->post_content
            ],
            'contentAttrs' => get_post_meta( $post_id, 'content_attributes', true ),
            'logic' => get_post_meta( $post_id, 'logic', true ),
        ]);
    }

    function delete_feed() {
        check_ajax_referer( 'woogool_nonce' );

        $feed_id = empty( intval( $_POST['feed_id'] ) ) ? false : $_POST['feed_id'];

        if ( $feed_id ) {

            wp_delete_post( $feed_id );
            wp_send_json_success();

        }

        wp_send_json_error();
    }

    function new_feed() {
        check_ajax_referer( 'woogool_nonce' );
        
        // parse_str( $_POST['form_data'], $postdata );
        $feed_id = WooGool_Admin_Feed::instance()->insert_feed( $_POST  );
        // $postdata['id']      = isset( $res['id'] ) ? intval( $res['id'] ) : 0;
        // $postdata['offset']  = $res['offset']; 
        // $postdata['woogool_continue']= $woogool_continue = isset( $res['woogool_continue'] ) ? $res['woogool_continue'] : false;
        // $redirect_url        = woogool_subtab_menu_url( 'woogool_multiple', 'feed-lists' );

        // wp_send_json_success( array( 'postdata' => $postdata, 'woogool_continue' => $woogool_continue, 'redirect' => $redirect_url, 'count' => $res['count'] ) );
        wp_send_json_success( array(
            'feed_id' => $feed_id
        ) );
    }

    /**
     * From dropdown menu change product and get form value from the product metadata
     * @return array
     */
    function change_product() {
        $product_id = $_POST['product_id'];
        $url = admin_url( 'admin.php?page=woogool&tab=new_product&product_id=' . $product_id );
        wp_send_json_success( array( 'url' => $url ) );
    }

    /**
     * Delete product
     * @return json
     */
    function delete_product() {
    	check_ajax_referer( 'woogool_nonce' );
    	$merchant_id = $_POST['merchant_id'];
    	$merchant_product_id = $_POST['merchant_product_id'];
    	$product_id = $_POST['post_id'];
    	$client = woogool_get_client();

        if ( !$client ) {
            wp_send_json_error( array( 'url' => admin_url( 'edit.php?post_type=product&page=product_woogool' ) ) );
        }

        $shoppinContent = new Google_Service_ShoppingContent($client);
        try {
            $product_status = $shoppinContent->products->get( $merchant_id, $merchant_product_id );

            $shoppinContent->products->delete( $merchant_id, $merchant_product_id );
            delete_post_meta( $product_id, 'merchant_status' );
            delete_post_meta( $product_id, 'merchant_product_id' );
            delete_post_meta( $product_id, 'merchant_id' );
            wp_send_json_success(array( 'success_msg' => __( 'Product delete successfully from google merchant center', 'woogool' ) ));
        }  catch( Google_Service_Exception $e ) {
            if ( strpos( $e->getMessage(), 'item not found' ) === false ) {

            } else {
                delete_post_meta( $product_id, 'merchant_status' );
                delete_post_meta( $product_id, 'merchant_product_id' );
                delete_post_meta( $product_id, 'merchant_id' );
                wp_send_json_success(array( 'success_msg' => __( 'Product delete successfully from google merchant center', 'woogool' ) ));
            }
        }

    }

    function new_merchant() {
        check_ajax_referer( 'woogool_nonce' );
        ob_start();
        woogool_Admin_Merchant::merchatn_form();
        wp_send_json_success( array( 'append_data' => ob_get_clean() ) );
    }

    /**
     * Insert product to merchant center
     * @return json
     */
    function google_merchant() {

        if ( !isset( $_POST['product_id'] ) ) {
            wp_send_json_error( array( 'error_code' => 400, 'error_msg' => __( 'Product id required', 'woogool' ) ) );
        }
        update_post_meta( $_POST['product_id'], 'woogool_product', $_POST );
        update_user_meta( get_current_user_id(), 'woogool_product_id', $_POST['product_id'] );

        $client = woogool_get_client();


        $postdatas = $_POST;
        $product_id = $_POST['product_id'];
        unset($postdatas['woogool_submit']);
        unset($postdatas['action']);
        unset($postdatas['product_id']);

        if ( ! $client ) {
            wp_send_json_error( array( 'authentication_fail' => true ) );
        }

        $shoppinContent = new Google_Service_ShoppingContent($client);

        try {

            $submited_products = get_option( 'woogool_submited_products', 0 );

            // if ( $submited_products >= 20 ) {
            //     $url = 'http://wpspear.com/product-feed/';
            //     $notice = sprintf( 'You have to purchase this plugin (WooGool) to submit more than 5 products. <a href="%s" target="_blank">Purchase Link</a>', $url );
            //     wp_send_json_error( array( 'error_code' => 'unknown', 'error_msg' => $notice ) );
            // }
            
            $merchant_id = get_user_meta( get_current_user_id(), 'merchant_account_id', true );
            $product = $shoppinContent->products->insert( $merchant_id, new Google_Service_ShoppingContent_Product( $postdatas ) );
            
            if ( $product ) {
                update_post_meta( $product_id, 'merchant_status', 'yes' );
                update_post_meta( $product_id, 'merchant_product_id', $product->id );
                update_post_meta( $product_id, 'merchant_id', $merchant_id );

                $new_submited_products = $submited_products + 1;

                update_option( 'woogool_submited_products', $new_submited_products );

            }

            wp_send_json_success(array('success_msg' => __( 'Update successfully! Please check your merchant account', 'woogool' ) ));

        } catch( Google_ServiceException $e ) {
            wp_send_json_error( array( 'error_code' => $e->getCode(), 'error_msg' => $e->getMessage() ) );
        } catch (Google_Exception $e) {
            wp_send_json_error( array( 'error_code' => $e->getCode(), 'error_msg' => $e->getMessage() ) );
        }

    }
}
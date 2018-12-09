<?php

class WooGool_Admin_single_product {

	private $client_id;
    private $client_secret;

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
        add_action( 'admin_init', array( $this, 'get_token_from_url_code' ) );
    }

    function init() {
        $user_id             = get_current_user_id();
        $client_id           = get_user_meta( $user_id, 'wogo_client_id', true );
        $client_secret       = get_user_meta( $user_id, 'wogo_client_secret', true );
        $this->client_id     = str_replace( ' ', '', $client_id );
        $this->client_secret = str_replace( ' ', '', $client_secret );
    }


    /**
     * check google authenticate for show submitted product form
     * @return boolen
     */
    function check_authenticate() {

        if ( ! isset( $_GET['page'] ) || $_GET['page'] != 'woogool' ) {
            return false;
        }

        if ( woogool_get_access_token() ) {
           return true;
        }

        return false;
    }

    function authentication_process() {
        $client = woogool_google_class();
        $scriptUri = admin_url( "admin.php?page=woogool&tab=new_product" );
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
     * Save woogool setting and get token from url code
     * @return void
     */
    function get_token_from_url_code() {

        if ( !isset( $_GET['page'] ) || $_GET['page'] != woogool_page_slug() ) {
            return;
        }

        $this->save_setting();
        $this->get_new_token();
    }

    /**
     * Save woogool settings
     * @return void
     */
    function save_setting() {
        if ( isset( $_POST['woogool_settings'] ) ) {
            $client_id           = preg_replace('/\s+/', '', $_POST['client_id'] );
            $client_secret       = preg_replace('/\s+/', '', $_POST['client_secret'] );
            $merchant_account_id = preg_replace('/\s+/', '', $_POST['merchant_account_id'] );

            update_user_meta( get_current_user_id(), 'wogo_client_id', $client_id );
            update_user_meta( get_current_user_id(), 'wogo_client_secret', $client_secret );
            update_user_meta( get_current_user_id(), 'merchant_account_id', $merchant_account_id );
            
            $redirect_url = admin_url( 'admin.php?page=' . woogool_page_slug() . '&tab=settings' );
            wp_safe_redirect( $redirect_url );
            exit();
        }
    }

        /**
     * Get google token from url parametar code
     * @return void
     */
    function get_new_token() {

        $client = woogool_google_class();
        $scriptUri = admin_url( 'admin.php?page=woogool&tab=new_product' );
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
}


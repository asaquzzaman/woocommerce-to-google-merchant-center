<?php
function woogool_get_currency( $currency = '' ) {

    switch ($currency) {
        case 'BRL' :
            $symbol = '&#82;&#36;';
            break;
        case 'AUD' :
        case 'CAD' :
        case 'MXN' :
        case 'NZD' :
        case 'HKD' :
        case 'SGD' :
        case 'USD' :
            $symbol = '&#36;';
            break;
        case 'EUR' :
            $symbol = '&euro;';
            break;
        case 'CNY' :
        case 'RMB' :
        case 'JPY' :
            $symbol = '&yen;';
            break;
        case 'KRW' : $symbol = '&#8361;';
            break;
        case 'TRY' : $symbol = '&#84;&#76;';
            break;
        case 'NOK' : $symbol = '&#107;&#114;';
            break;
        case 'ZAR' : $symbol = '&#82;';
            break;
        case 'CZK' : $symbol = '&#75;&#269;';
            break;
        case 'MYR' : $symbol = '&#82;&#77;';
            break;
        case 'DKK' : $symbol = '&#107;&#114;';
            break;
        case 'HUF' : $symbol = '&#70;&#116;';
            break;
        case 'IDR' : $symbol = 'Rp';
            break;
        case 'INR' : $symbol = '&#8377;';
            break;
        case 'ILS' : $symbol = '&#8362;';
            break;
        case 'PHP' : $symbol = '&#8369;';
            break;
        case 'PLN' : $symbol = '&#122;&#322;';
            break;
        case 'SEK' : $symbol = '&#107;&#114;';
            break;
        case 'CHF' : $symbol = '&#67;&#72;&#70;';
            break;
        case 'TWD' : $symbol = '&#78;&#84;&#36;';
            break;
        case 'THB' : $symbol = '&#3647;';
            break;
        case 'GBP' : $symbol = '&pound;';
            break;
        case 'RON' : $symbol = 'lei';
            break;
        default : $symbol = '';
            break;
    }

    return $symbol;
}

/**
 * Google client class Instantiate
 * @return object
 */
function woogool_google_class() {
    static $client;
    if ( !$client ) {
        $plugin_path = WOOGOOL_PATH . '/includes';
        set_include_path( $plugin_path . PATH_SEPARATOR . get_include_path());

        require_once WOOGOOL_PATH . '/includes/Google/Client.php';
        require_once WOOGOOL_PATH . '/includes/Google/Service/ShoppingContent.php';

        $client = new Google_Client();
    }

    return $client;
}

/**
 * Check token validate
 * @return string
 */
function woogool_get_access_token() {

    $user_id = get_current_user_id();
    $access_token = get_user_meta( $user_id, 'access_token', true );
    if ( empty( $access_token ) ) {
        return false;
    }

    $client = woogool_google_class();

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
function woogool_get_client() {
    $client = woogool_google_class();
    $access_token = woogool_get_access_token();
    if ( $access_token ) {
        $client->setAccessToken( $access_token );
        $client->getAccessToken();

        return $client;
    }
    return false;
}

function woogool_get_products_list() {
    $client         = woogool_get_client();
    $shoppinContent = new Google_Service_ShoppingContent($client);
    $merchant_id    = get_user_meta( get_current_user_id(), 'merchant_account_id', true );
    $products       = $shoppinContent->products->listProducts( $merchant_id );

    return $products;
}

function woogool_get_product( $product_id ) {
    $client         = woogool_get_client();
    $shoppinContent = new Google_Service_ShoppingContent($client);
    $merchant_id    = get_user_meta( get_current_user_id(), 'merchant_account_id', true );
    $products       = $shoppinContent->products->get( $merchant_id, $product_id );

    return $products;
}

function woogool_get_google_product_type() {
    $request = wp_remote_get( 'http://www.google.com/basepages/producttype/taxonomy.en-US.txt' );
    if ( is_wp_error( $request ) || ! isset( $request['response']['code'] ) || '200' != $request['response']['code'] ) {
        return array();
    }
    $taxonomies = explode( "\n", $request['body'] );
    // Strip the comment at the top
    array_shift( $taxonomies );
    // Strip the extra newline at the end
    array_pop( $taxonomies );
    $taxonomies = array_merge( array( __( '-Select-', 'woogool' ) ), $taxonomies );
    return $taxonomies;
}

function woogool_get_feeds() {

    $args = array(
        'posts_per_page'   => -1,
        'post_type'        => array( 'woogoo_feed', 'woogool_feed' ),
        'post_status'      => 'publish',
    );

    return get_posts( $args );
}

function woogool_get_minute_diff( $current_time, $request_time ) {
    $current_time = new DateTime( $current_time );
    $request_time = new DateTime( $request_time );
    $interval     = $request_time->diff( $current_time );
    $day          = $interval->d ? $interval->d * 24 * 60 : 0;
    $hour         = $interval->h ? $interval->h * 60 : 0;
    $minute       = $interval->i ? $interval->i : 0;
    $total_minute = $day + $hour + $minute;

    return $total_minute;
}

function woogool_is_product_attribute_taxonomy( $attr, $porduct_obj ) {

    $attributes = $porduct_obj->get_attributes();

    $attr = sanitize_title( $attr );

    if ( isset( $attributes[ $attr ] ) || isset( $attributes[ 'pa_' . $attr ] ) ) {

        $attribute = isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : $attributes[ 'pa_' . $attr ];
        if ( $attribute['is_taxonomy'] ) {
            return true;
        } else {
         return false;
        }
    }
    return false;
}

function woogool_get_query_args() {

    $menu = woogool_pages();

    if ( isset( $_GET['woogool_tab'] ) && ! empty( $_GET['woogool_tab'] ) ) {
        $tab = $_GET['woogool_tab'];
    } else {
        $tab = array_keys( $menu );
        $tab = reset( $tab ); 
    }

    if ( isset( $_GET['woogool_sub_tab'] ) && !empty( $_GET['woogool_sub_tab'] ) ) {
        $subtab = $_GET['woogool_sub_tab'];
    } else if ( isset( $menu[$tab]['submenu'] ) && count( $menu[$tab]['submenu'] ) ) {
        $subtab = array_keys( $menu[$tab]['submenu'] );
        $subtab = reset( $subtab );
    } else {
        $subtab = false;
    }

    return array(
        'page' => woogool_page_slug(),
        'tab'  => $tab,
        'sub_tab' => $subtab
    );
}

/**
 * Get woocommerce all product
 * @return array()
*/
function woogool_get_products( $count = '-1', $offset = 0 ) {
    $args = array(
        'posts_per_page'   => $count,
        'post_type'        => 'product',
        'post_status'      => 'publish',
        'offset'           => $offset
    );

    return get_posts( $args );
}

function woogool_tab_menu_url( $tab ) {
    $url = sprintf( '%1s?post_type=%2s&page=%3s&woogool_tab=%4s', admin_url( 'edit.php' ), 'product', woogool_page_slug(), $tab );
    return apply_filters( 'woogool_tab_menu_url', $url, woogool_page_slug(), $tab );
}

function woogool_subtab_menu_url( $tab, $sub_tab ) {
    $url = sprintf( '%1s?post_type=%2s&page=%3s&woogool_tab=%4s&woogool_sub_tab=%5s', admin_url( 'edit.php' ), 'product', woogool_page_slug(), $tab, $sub_tab );
    return apply_filters( 'hrm_subtab_menu_url', $url, woogool_page_slug(), $tab, $sub_tab );
}

require_once dirname(__FILE__) . '/ISD-code.php';


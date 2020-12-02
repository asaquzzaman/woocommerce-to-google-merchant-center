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
    $google_taxonomy = apply_filters( 'woogool_google_taxonomy_url', 'https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt' );
    $request = wp_remote_get( $google_taxonomy );
    if ( is_wp_error( $request ) || ! isset( $request['response']['code'] ) || '200' != $request['response']['code'] ) {
        return array();
    }
    $taxonomies = explode( "\n", $request['body'] );
    unset( $taxonomies[0] );
    $stores = [];
    
    foreach ( $taxonomies as $key => $taxonomie ) {
        if ( strpos( $taxonomie , '-' ) !== false ) {
            $txon        = explode( '-', $taxonomie );
            $id          = trim( $txon[0] );
            $label       = trim( $taxonomie );
            
            $stores[] = [
                'id' => $id,
                'label' => $label
            ];
        }
    }

    return $stores;
}

function woogool_get_feeds() {

    $feeds = new WP_Query (
        array (
            'post_type'      => array( 'woogoo_feed', 'woogool_feed' ),
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'meta_key'       => '',
            'meta_value'     => '',
        ) 
    );

    foreach ( $feeds->posts as $key => $post ) {
        $post->feed_url = woogool_get_feed_file_url( $post->ID );
    }

    return $feeds;
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
    $page = $_GET['page'];
    $menu = woogool_pages();

    if ( isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ) {
        $tab = $_GET['tab'];
    } else {
        $tab = array_keys( $menu[$page] );
        $tab = reset( $tab ); 

    }

    if ( isset( $_GET['woogool_sub_tab'] ) && !empty( $_GET['woogool_sub_tab'] ) ) {
        $subtab = $_GET['woogool_sub_tab'];
    } else if ( isset( $menu[$page][$tab]['submenu'] ) && count( $menu[$page][$tab]['submenu'] ) ) {
        $subtab = array_keys( $menu[$page][$tab]['submenu'] );
        $subtab = reset( $subtab );
    } else {
        $subtab = false;
    }

    return array(
        'page' => $page,
        'tab'  => $tab,
        'sub_tab' => $subtab
    );
}

/**
 * Get woocommerce all product
 * @return array()
*/
function woogool_get_products( $count = '-1', $offset = 0, $args = array() ) {
    
    $defaults = array(
        'posts_per_page'   => $count,
        'post_type'        => 'product',
        'post_status'      => 'publish',
        'offset'           => $offset,
    );

    $args = wp_parse_args( $args, $defaults ); 
    $query = NEW WP_Query( $args );
    
    return $query;
}

/**
 * Get woocommerce all product
 * @return array()
*/
function woogool_free_get_products( $count = '-1', $offset = 0, $args = array() ) {
    
    $defaults = array(
        'posts_per_page'   => $count,
        'post_type'        => 'product',
        'post_status'      => 'publish',
        'offset'           => $offset,
    );

    $args = wp_parse_args( $args, $defaults );
    $query = NEW WP_Query( $args );

    return $query->posts;
}

function woogool_tab_menu_url( $page, $tab ) {
    $url = sprintf( '%1s?page=%2s&tab=%4s', admin_url( 'admin.php' ), $page, $tab );
    return apply_filters( 'tab_menu_url', $url, $page, $tab );
}

function woogool_subtab_menu_url( $tab, $sub_tab ) {
    $url = sprintf( '%1s?post_type=%2s&page=%3s&tab=%4s&woogool_sub_tab=%5s', admin_url( 'edit.php' ), 'product', woogool_page_slug(), $tab, $sub_tab );
    return apply_filters( 'woogool_subtab_menu_url', $url, woogool_page_slug(), $tab, $sub_tab );
}

require_once dirname(__FILE__) . '/ISD-code.php';

function woogool_get_products_terms_dropdown_array() {
    $terms = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    ) );

    $products_term = array();

    foreach ( $terms as $term ) {
        $products_term[$term->term_id] = $term->name;      
    }

    return $products_term;
}

function woogool_generte_save_cat( $feed_id, $taxonomies, $get_products_cat ) {
    $products_cat = get_post_meta( $feed_id, '_cat_map', true );
    
    
    if ( empty( $products_cat ) || empty( $get_products_cat ) ) {
        return '';
    } 

    $products_cat = array_intersect_key( $products_cat, $get_products_cat );
    
    ob_start();
    ?>
    <ul class="woogool-google-cat-ul">
        <?php foreach ( $products_cat as $product_cat_id => $google_cat_id ) { ?>
            <li class="woogool-cat-map-li woogool-clearfix">
                <input class="woogool-cat-map-field" type="hidden" name="cat_map[<?php echo absint( $product_cat_id ); ?>]" value="<?php echo absint( $google_cat_id ); ?>">
                <span class="woogool-cat-title"><?php echo $get_products_cat[$product_cat_id] ?></span>
                <div class="woogool-cat-dropdown">
                <?php
                $google_cat = array(
                    'type'     => 'select',
                    //'label'    => __( 'Category Maping', 'woogool' ),
                    'option'   => $taxonomies,
                    'class'    => 'woogool-cat-select woogool-chosen-custom', //Do not change the "woogool-google-cat" class 
                    'selected' => $google_cat_id,//get_post_meta( $feed_id, '_google_product_category', true ),
                    'desc'     => __( 'Google product ​​category. <a href="https://support.google.com/merchants/answer/6324436" target="_blank">More Details</a>' , 'woogool' )
                );
                echo WooGool_Admin_Settings::getInstance()->select_field( 'google_cat', $google_cat );
                ?>
                </div>
            </li>

        <?php } ?>
    </ul>

    <?php

    return ob_get_clean();
}

function woogool_shipping_html() {
    ob_start();
    ?>
        <p>
            <label for=""><?php _e( 'Shipping', 'woogool' ); ?></label>
            <h4>
                <span class="woogool-field">
                    <?php _e( 'Please configure your shipping settings from your google merchant account.', 'woogool' ); ?>
                    <a href="https://www.google.com/retail/merchant-center/" target="_blank"><?php _e('Merchant Account', 'woogool'); ?></a>
                </span>
            </h4>
        </p>
    
    <?php
    return ob_get_clean();
}

function woogool_tax_html() {
    ob_start();
    ?>
        <div>
        <label for=""><?php _e( 'Tax', 'woogool' ); ?></label>
        <h4>
            <span class="woogool-field">
                <?php _e( 'Please configure your tax settings from your google merchant account.', 'woogool' ); ?>
                <a href="https://www.google.com/retail/merchant-center/" target="_blank"><?php _e('Merchant Account', 'woogool'); ?></a>
            </span>
        </h4>
        </div>
        
    
    <?php
    return ob_get_clean();
}

function woogool_is_wc_new() {
    if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
        return false;
    }

    return true;
}

function woogool_xml_count() {
    $count = array();

    for( $i=0; $i<=10000; $i+=WOOGOOL_FEED_PER_PAGE  ) {
        $k = $i + (WOOGOOL_FEED_PER_PAGE-1);
        $count[$i] = $i . '-' . $k;
    }

    return $count;
}

function woogool_warning() {
    ?>
    <div class="wrap">
        <div class="woogool-notice woogool-warning" style="margin-bottom: 9px;">
            With this free version you can process only 40 products. For getting unlimited please go with the
            <a class="woogool-link" href="https://www.google.com/retail/solutions/merchant-center/" target="_blank">
                <b>Pro Version.</b>
            </a> 
        </div>
    </div>
    <?php
}

function woogool_merchan_configure_warning() {
    ?>
    <div class="woogool-notice woogool-warning">
        If you did not cofigure your shipping and tax information correctly according 
        to your targeted coutnry and did not verify your website then please do all these things 
        from your 
        <a class="woogool-link" href="https://www.google.com/retail/solutions/merchant-center/" target="_blank">
            google merchant account
        </a> before submitting the form
    </div>
    <?php
}

function woogool_is_pro() {
    return apply_filters( 'woogool_filter_is_pro', false );
}

if ( ! function_exists( 'pmpr' ) ) {
    function pmpr() {
        $args = func_get_args();

        foreach ( $args as $arg ) {
            echo '<pre>'; print_r( $arg ); '</pre>';
        }
    }  
}

if ( ! function_exists( 'pm_log' ) ) {
    function pm_log( $type = '', $msg = '' ) {
        $msg = sprintf( "[%s][%s] %s\n", date( 'd.m.Y h:i:s' ), $type, print_r($msg, true) );
        error_log( $msg, 3, WOOGOOL_PATH . '/tmp/woogool-debug.log' );
    } 
}

function woogool_get_feed_file_path( $feed_id ) {
    $upload_dir = wp_upload_dir();
    $base       = $upload_dir['basedir']; 
    $dir_path   = $base . '/woogool-product-feed/';
    $file_name  = md5( 'woogool' . $feed_id );

    return $dir_path . $file_name . '.xml';
}

function woogool_get_feed_file_url( $feed_id ) {
    $upload_dir = wp_upload_dir();
    $base       = $upload_dir['baseurl'];
    $dir_path   = $base . '/woogool-product-feed/';
    $file_name  = md5( 'woogool' . $feed_id );
    
    return $dir_path . $file_name . '.xml';
}

if ( !function_exists( 'pmpr' ) ) {
    function pmpr() {
        $args = func_get_args();

        foreach ( $args as $arg ) {
            echo '<pre>'; print_r( $arg ); '</pre>';
        }
    }
}





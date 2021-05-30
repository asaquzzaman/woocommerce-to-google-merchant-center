<?php

class WooGool_Admin_Feed {
    
    private $number_per_page = 20;

    private $google_cat = array();
    private $feed_settings = array();
    protected $start_time = 0;
    
    /**
     * @var The single instance of the class
     * 
     */
    protected static $_instance = null;

    protected $found_posts = 0;
    protected $fetch_all_product = false;

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

    function __construct() {
        global $woogool_debug;
        $woogool_debug = [];

        add_action( 'admin_init', array( $this, 'register_post_type' ) );
        //add_action( 'admin_init', array( $this, 'new_feed' ) );
        add_action( 'admin_init', array( $this, 'feed_delete' ) );
        add_action( 'admin_init', array( $this, 'check_categori_fetch' ) );
    
        //add_action( 'admin_init', array( $this, 'new_feed' ) );
        //add_action( 'add_meta_boxes', array( $this, 'feed_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_post_meta' ), 10, 3 );
        add_action( 'template_redirect', array( $this, 'xml_download' ) );
        //add_action( 'admin_init', array( $this, 'test' ) );
    }


    public function create_xml_file( $feed_id, $feed_title ) {
        $upload_dir = wp_upload_dir();
        $base       = $upload_dir['basedir'];
        $dir_path   = $base . '/woogool-product-feed/';
        $file_name  = md5( 'woogool' . $feed_id );
        $file_path  = woogool_get_feed_file_path( $feed_id ); 
        $feed       = get_post( $feed_id );

        if( ! is_dir( $dir_path ) ) {
            wp_mkdir_p( $dir_path );
        }

        if ( file_exists( $file_path ) ) {
            unlink ( $file_path ); 
        }
       // woopr($feed->post_content); die();
        // Check if directory in uploads exists, if not create one  
        if ( ! file_exists( $file_path ) ) {

            if ( $feed->post_content == 'fruugous' || $feed->post_content == 'fruugouk' ) {

                $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><products></products>'); 
                $xml->addAttribute('version', '1.0' ); 
                $xml->addAttribute('standalone', 'yes' );  
                $xml->addChild('datetime', date( 'Y-m-d H:i:s', strtotime( current_time('mysql') ) ) );
                $xml->addChild('title', 'fruugous');
                $xml->addChild('link', site_url());
                $xml->addChild('description', 'WooCommerce Product Feed - This product feed is created for WooCommerce plugin');

                $xml->asXML( $file_path );

            } else if ( $feed->post_content == 'manomano' ) {

                $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><products></products>'); 
                $xml->addAttribute('version', '1.0' ); 
                $xml->addAttribute('standalone', 'yes' );  
                $xml->addChild('datetime', date( 'Y-m-d H:i:s', strtotime( current_time('mysql') ) ) );
                $xml->addChild('title', 'manomano');
                $xml->addChild('link', site_url());
                $xml->addChild('description', 'WooCommerce Product Feed - This product feed is created for WooCommerce plugin');

                $xml->asXML( $file_path );

            } else if ( $feed->post_content == 'yandex' ) {

                $main_currency = get_woocommerce_currency();

                $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><yml_catalog></yml_catalog>');   
                $xml->addAttribute('date', date('Y-m-d H:i'));
                $shop = $xml->addChild('shop');
                $shop->addChild('name', htmlspecialchars( $feed_title ));
                $shop->addChild('company', get_bloginfo());
                $shop->addChild('url', site_url());
                $shop->addChild('platform', 'WooCommerce');
                $currencies = $shop->addChild('currencies');
                $currency = $currencies->addChild('currency');
                $currency->addAttribute('id', $main_currency);
                $currency->addAttribute('rate', '1');

                $args = array(
                    'taxonomy' => "product_cat",
                );
                $product_categories = get_terms( 'product_cat', $args );
                $count = count($product_categories);
                
                if ($count > 0){
                    $categories = $shop->addChild('categories');

                    foreach ($product_categories as $product_category){
                        $category = $categories->addChild('category', htmlspecialchars($product_category->name));
                        $category->addAttribute('id', $product_category->term_id);
                        if ($product_category->parent > 0){
                            $category->addAttribute('parentId', $product_category->parent);

                        }
                    }
                }

                $shop->addChild('offers');

                $xml->asXML( $file_path );

            } else if ( $feed->post_content == 'custom_feed' ) {

                $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><products></products>'); 
                $xml->addChild('datetime', date( 'Y-m-d H:i:s', strtotime( current_time('mysql') ) ) );
                $xml->addChild('title', 'custom');
                $xml->addChild('link', site_url());
                $xml->addChild('description', 'WooCommerce Product Feed - This product feed is created for WooCommerce plugin');

                $xml->asXML( $file_path );

            } else {
                $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss xmlns:g="http://base.google.com/ns/1.0"></rss>');
                $xml->addAttribute( 'version', '2.0' );
                $xml->addChild( 'channel' );
                $xml->channel->addChild( 'title', htmlspecialchars( $feed_title ) );
                $xml->channel->addChild( 'link', site_url() );
                $xml->channel->addChild( 'description', 'WooCommerce Product Feed for google shopping' );
                $xml->asXML( $file_path );
            }
            

            update_post_meta( $feed_id, 'feed_file_name', $file_name );

            return $file_name;
        }

        return false;
    }

    /**
     * Memory exceeded
     *
     * Ensures the batch process never exceeds 90%
     * of the maximum WordPress memory.
     *
     * @return bool
     */
    protected function memory_exceeded() {
        $memory_limit   = $this->get_memory_limit() * 0.9; // 90% of max memory
        $current_memory = memory_get_usage( true );
        $return         = false;

        if ( $current_memory >= $memory_limit ) {
            $return = true;
        }

        return $return;
    }

    /**
     * Get memory limit
     *
     * @return int
     */
    protected function get_memory_limit() {
        if ( function_exists( 'ini_get' ) ) {
            $memory_limit = ini_get( 'memory_limit' );
        } else {
            // Sensible default.
            $memory_limit = '128M';
        }

        if ( ! $memory_limit || -1 === intval( $memory_limit ) ) {
            // Unlimited, set to 32GB.
            $memory_limit = '32000M';
        }

        return intval( $memory_limit ) * 1024 * 1024;
    }

    /**
     * Time exceeded.
     *
     * Ensures the batch never exceeds a sensible time limit.
     * A timeout limit of 30s is common on shared hosting.
     *
     * @return bool
     */
    public function time_exceeded() {
        $finish = $this->start_time +  20; // 20 seconds
        $return = false;

        if ( time() >= $finish ) {
            $return = true;
        }

        return $return;
    }

    public function has_namespace( $feed_id ) {
        $post = get_post( $feed_id );
        $no_namespace = [
            'bing_shopping',
            'google_shopping_promotion',
            'yandex',
            'fruugous',
            'custom_feed',
            'manomano',
            'fruugouk'
        ];
        
        if ( in_array( $post->post_content, $no_namespace ) ) {
            return false;
        }

        return true;
    }

    public function get_xml_node( $feed_id ) {
        $file = woogool_get_feed_file_path( $feed_id );

        if ( file_exists( $file ) ) {
            return simplexml_load_file( $file, 'SimpleXMLElement', LIBXML_NOCDATA );
        }
        
        return false;
    }

    public function get_google_feed_name_space() {
        return array( 'g' => 'http://base.google.com/ns/1.0' );
    }

    public function get_feed( $feed_id ) {
        $feed                = get_post( $feed_id );
        $feed->feed_settings = array();
        $metas = get_post_meta( $feed_id );

        foreach ( $metas as $meta_name => $meta ) {
            $value = array_shift( $meta );
            $value = is_serialized( $value ) ? maybe_unserialize( $value ) : $value;
            
            $feed->feed_settings[$meta_name] = $value;
        }

        return $feed;
    }

    public function update_feed_file( $postdata ) {
        global $woogool_debug;

        $this->start_time = time();
        $feed_id          = intval( $postdata['feed_id'] ) ? $postdata['feed_id'] : false ; 
        $post_feed        = get_post( $feed_id );
        $offset           = empty( $postdata['offset'] ) ? 0 : intval( $postdata['offset'] );
        $logic            = get_post_meta( $feed_id, 'logic', true );
        
        $category_map     = get_post_meta( $feed_id, 'google_categories', true );
        $feed_contents    = get_post_meta( $feed_id, 'content_attributes', true ); 
        $active_variation = get_post_meta( $feed_id, 'active_variation', true );
        
        $settings         = get_post_meta( $feed_id );
  
        $products         = $this->xml_get_products( $feed_id, $page=false, $offset );
        
        $file             = woogool_get_feed_file_path( $feed_id );
        $xml              = $this->get_xml_node( $feed_id );
        $namespace        = $this->get_google_feed_name_space();
        $has_namespace    = $this->has_namespace( $feed_id );
        
        foreach ( $products as $key => $product ) {
            $offset     = $offset + 1;
            $product_id = $product->ID;
            $wc_product = wc_get_product( $product_id );

            if ( $this->is_exclude_from_filter( $wc_product, $logic ) ) {
                continue;
            }

            $product_type = $wc_product->get_type();
            
            if ( 
                $active_variation != 'false'
                    &&

                ($product_type == 'variable' || $product_type == 'variation' ) 
            ) {
                $variable   = new WC_Product_Variable( $wc_product );
                $variations = $variable->get_available_variations();
                $attrs      = $variable->get_variation_attributes();

                foreach ( $variations as $key => $child ) {
                    
                    if ( ! $child['variation_is_active'] || ! $child['variation_is_visible'] ) {
                        
                        if ( WOOGOOL_DEBUG ) {
                            $woogool_debug[$child['variation_id']][] = [
                                'variation_is_active' => $child['variation_is_active'],
                                'variation_is_visible' => $child['variation_is_visible']

                            ];
                        }
                        
                        continue;
                    }

                    $variable_product = wc_get_product( $child['variation_id'] );

                    if ( $this->is_exclude_from_filter( $variable_product, $logic ) ) {
                        continue;
                    }

                    $variable_feed = $this->set_xml_wrap( $xml, $post_feed ); //$xml->channel->addChild('item');

                    if ( $this->has_item_group_id( $post_feed ) ) {
                        if ( $has_namespace ) {
                            $variable_feed->addChild( 'g:item_group_id', $wc_product->get_id(), $namespace['g'] );
                        } else {
                            $variable_feed->addChild( 'g:item_group_id', $wc_product->get_id() );
                        }
                    }
                    
                    $this->set_common_tags( $variable_feed, $post_feed, $variable_product );
                    
                    foreach ( $feed_contents as $key => $feed_content ) {
                        $this->feed_tag_generate( $feed_content, $variable_product, $settings, $post_feed, $has_namespace, $variable_feed, $namespace );
                    }
                }

            } else {

                $feed = $this->set_xml_wrap( $xml, $post_feed ); //$xml->channel->addChild('item');
                $this->set_common_tags( $feed, $post_feed, $wc_product );

                foreach ( $feed_contents as $key => $feed_content ) {

                    $this->feed_tag_generate( $feed_content, $wc_product, $settings, $post_feed, $has_namespace, $feed, $namespace );
                } 
            }
        }
        
        if ( WOOGOOL_DEBUG && !empty($woogool_debug) ) {
            pm_log( 'woogool_debug', $woogool_debug );
        }
        
        if ( method_exists( $xml, 'asXML') ) {
            $xml->asXML( $file );
        }

        $return = [
            'has_product' => empty( $products ) ? false : true, //apply_filters( 'woogool_has_product', false, $products ), 
            'offset'      => $offset, //apply_filters( 'woogool_offset', 20, $offset ), 
            'found_posts' => $this->found_posts //apply_filters( 'woogool_found_posts', 20, $this->found_posts ) //$this->found_posts
        ];

        if ( $this->time_exceeded() || $this->memory_exceeded() ) {
            return $return;
        }

        return $return;
    }

    private function has_item_group_id( $post ) {
        $no_group_id = [
            'yandex',
            'fruugous',
            'custom_feed',
            'manomano',
            'fruugouk'
        ];
        
        if ( in_array( $post->post_content, $no_group_id ) ) {
            return false;
        }

        return true;
    }

    private function set_common_tags( $feed, $post_feed, $wc_product ) {
        if ( $post_feed->post_content == 'custom_feed' ) {

            $product_cats = $wc_product->get_category_ids();

            if ( ! empty( $product_cats ) ) {
                $categories = $feed->addChild('categories');
            }
            
            foreach ( $product_cats as $key => $cat_id ) {
                $cat = get_term_by( 'id', $cat_id, 'product_cat' );
                $categories->addChild('category', $cat->name);
            }
        }
        
        if ( $post_feed->post_content == 'yandex' ) {
            $feed->addAttribute( 'id', $wc_product->get_id() );
            $stock_status = $wc_product->get_stock_status();
            
            if ( $stock_status == 'instock' ) {
                $feed->addAttribute( 'available', 'true' );
            } else {
                $feed->addAttribute( 'available', 'false' );
            }

            $categories = $wc_product->get_category_ids();

            foreach ( $categories as $categorieId ) {
                $feed->addChild( 'categoryId', $categorieId );
            }
        }
    }

    private function feed_tag_generate( $feed_content, $wc_product, $settings, $post_feed, $has_namespace, $feed, $namespace ) {
        global $woogool_debug;
        
        $feed_value = $this->get_value( $feed_content, $wc_product, $settings );

        if ( ! empty( $feed_value ) ) {
            if ( $has_namespace ) {
                $feed->addChild( $feed_content['feed_name'], $feed_value, $namespace['g'] );
            } else {
                $feed->addChild( $feed_content['feed_name'], $feed_value );
            }
        
        } else if (WOOGOOL_DEBUG) {
            $woogool_debug[$wc_product->get_id()][] = [
                'empty_value' => true,
                'feed_content' => $feed_content

            ];
        }
    }

    function set_xml_wrap( $xml, $feed ) {
        $xml_parent = '';
        
        if ( $feed->post_content == 'yandex' ) {
            $xml_parent = $xml->shop->offers->addChild('offer');
        } else if ( 
            $feed->post_content == 'fruugous' 
                || 
            $feed->post_content == 'fruugouk'
                ||
            $feed->post_content == 'manomano'
                ||
            $feed->post_content == 'custom_feed'
        ) {
            $xml_parent = $xml->addChild('product');
        } else {
            $xml_parent = $xml->channel->addChild('item');
        }

        return $xml_parent;
    }

    function is_exclude_from_filter( $wc_product, $logic ) {
        global $woogool_debug;

        $val_func  = woogool_product_value_maping_func();
        $cond_func = woogool_condition_maping_func();
        $exclude   = [];

        $meta_exclude = get_post_meta( $wc_product->get_id(), '_woogool_exclude_product', true );

        if ( $meta_exclude == 'yes' ) {
            if ( WOOGOOL_DEBUG ) {
                $woogool_debug[$wc_product->get_id()][] = [
                    'type' => 'Exclue',
                    '_woogool_exclude_product' => true
                ];
            }
            return true;
        }
        
        foreach ( $logic as $key => $logic_attr ) {
            if ( $logic_attr['type'] != 'filter' ) continue;

            $name = $logic_attr['if_cond'];
            
            if ( function_exists( $val_func[$name] ) ) {
                
                $product_value = $val_func[$name]( $wc_product );
                $cond_name     = $logic_attr['condition'];
                $cond_value    = $logic_attr['value'];
                
                if ( function_exists( $cond_func[$cond_name] ) ) {
                    $is_exclude = $cond_func[$cond_name]( $product_value, $cond_value );
                    
                    if ( WOOGOOL_DEBUG && $is_exclude ) {
                        $woogool_debug[$wc_product->get_id()][] = [
                            'type' => 'Exclue',
                            'product_key'     => $name,
                            'product_value'   => $product_value, 
                            'condition_value' => $cond_value,
                            'condition'       => $cond_name
                        ];
                    }

                    $exclude[] = $is_exclude;

                }
            } 
        }

        return  in_array( true, $exclude ) ? true : false;
    }

    public function get_value( $feed_content, $wc_product, $settings ) {
        $val_func = woogool_product_attributes_maping_func();
        $name     = $feed_content['woogool_suggest'];
        $value    = '';
        
        $call = empty( $val_func[$name] ) ? '' : $val_func[$name];
        
        if ( function_exists( $call ) ) {
            $value = $call( $wc_product, $settings, $feed_content );
        } else if( $name == 'static_value' ) {
            $value = woogool_get_product_compare_static_value( $wc_product, $settings, $feed_content );
        } else {
            $value = woogool_get_product_compare_dynamic_value( $wc_product, $settings, $name );
        }
        
        return empty( $value ) ? false : $value;
    }

    public function get_file_path( $feed_id ) {
        $upload_dir = wp_upload_dir();

        $base      = $upload_dir['basedir'];
        $dir_path  = $base . '/woogool-product-feed/';
        $file_name = get_post_meta( $feed_id, 'feed_file_name', true );
        $file_path = $dir_path . $file_name . '.xml';

        return $file_path;
    }

    function register_post_type() {
        register_post_type( 'woogool_feed', array(
            'label'               => __( 'Feed', 'hrm' ),
            'public'              => false,
            'show_in_admin_bar'   => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'show_in_admin_bar'   => false,
            'show_ui'             => false,
            'show_in_menu'        => false,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'rewrite'             => array('slug' => ''),
            'query_var'           => true,
            'supports'            => array('title', 'editor'),
        ));
    }

    function new_feed() {
        if ( ! isset( $_POST['woogool_submit_feed'] ) ) {
            return;
        }

        if ( 
            ! isset( $_POST['feed_nonce'] ) 
            || ! wp_verify_nonce( $_POST['feed_nonce'], 'woogool_feed_nonce' ) 
        ) {

           print 'Sorry, your nonce did not verify.';
           return;
        } 

        $post = wp_unslash( $_POST );
        $feed_update_id = $this->insert_feed( $post );

        $feed_list_url = woogool_subtab_menu_url( 'woogool_multiple', 'feed-lists' );
        wp_safe_redirect( $feed_list_url );
        exit;
    }

    function insert_feed( $post ) {
        
        $arg = array(
            'post_type'    => 'woogool_feed',
            'post_title'   => $post['header']['name'],
            'post_content' => $post['header']['channel']['id'],
            'post_status'  => 'publish'
        );

        $feed_id = isset( $post['feed_id'] ) ? intval( $post['feed_id'] ) : false;
        $post_id = false;

        if ( $feed_id ) {
            $arg['ID'] = $feed_id;
            $post_id = wp_update_post( $arg );
        } else {
            $post_id = wp_insert_post( $arg );
        }
        
        if ( $post_id ) {
            $this->update_feed_meta( $post_id, $post );
        }

        return $post_id;
    }

    function delete_xml_meta_content( $feed_id ) {
        return delete_post_meta( $feed_id, '_woogool_xml_content' );
    }

    function update_xml_meta_content( $feed_id, $xml_content ) {
        add_post_meta( $feed_id, '_woogool_xml_content', $xml_content );
    }

    function update_feed_meta( $post_id, $post ) {

        $header = $post['header'];

        $feedByCatgory = isset( $header['feedByCatgory'] ) ? $header['feedByCatgory'] : false;
        update_post_meta( $post_id, 'feed_by_category', $feedByCatgory );

        $activeVariation = isset( $header['activeVariation'] ) ? $header['activeVariation'] : false;
        update_post_meta( $post_id, 'active_variation', $activeVariation );

        $country = isset( $header['country'] ) ? $header['country'] : [];
        update_post_meta( $post_id, 'country', $country );

        $refresh = isset( $header['refresh'] ) ? $header['refresh'] : 1;
        update_post_meta( $post_id, 'refresh', $refresh );

        $categories = isset( $header['categories'] ) ? $header['categories'] : [];
        update_post_meta( $post_id, 'categories', $categories );

        $googleCategories = isset( $header['googleCategories'] ) ? $header['googleCategories'] : [];
        update_post_meta( $post_id, 'google_categories', $googleCategories );

        $contentAttrs = isset( $post['contentAttrs'] ) ? $post['contentAttrs'] : [];
        update_post_meta( $post_id, 'content_attributes', $contentAttrs );

        $logic = isset( $post['logic'] ) ? $post['logic'] : [];
        update_post_meta( $post_id, 'logic', $logic );
    }

    function xml_get_products( $feed_id, $page=false, $offset=false ) {
        $per_page = apply_filters( 'woogool_feed_per_page', 20 );
        
        if ( $offset === false ) {
            $offset   = ( $page - 1 ) * $per_page;
        } 
         
        $feed_by_cat = get_post_meta( $feed_id, 'feed_by_category', true );
        
        if ( $feed_by_cat && $feed_by_cat !== 'false' ) {   
            $products_cats = get_post_meta( $feed_id, 'categories', true );
            $products_cats = wp_list_pluck( $products_cats, 'catId' );

            $tax_query['tax_query'] = array(
                'relation' => 'OR',
                array(
                    'taxonomy'         => 'product_cat',
                    'field'            => 'term_id',
                    'terms'            => $products_cats,
                    'include_children' => false,
                    'operator'         => 'IN',
                )
            );

            $query = woogool_get_products( $per_page,  $offset, $tax_query );
            $this->found_posts = $query->found_posts;

        } else {
            $query = woogool_get_products( $per_page, $offset );
            $this->found_posts = $query->found_posts;
        }

        if ( empty( $query->posts ) ) {
            $this->fetch_all_product = true;
        }
        
        return $query->posts;
    }

    function xml_download() {

        if ( ! isset( $_GET['woogool_feed_download'] ) || ! isset( $_GET['nonce'] ) ) {
            return;
        }

        $feed_id = absint( $_GET['feed_id'] ) ? $_GET['feed_id'] : 0;

        if ( ! $feed_id ) {
            return;
        }

        global $wpdb;

        // Don't cache feed under WP Super-Cache
        define( 'DONOTCACHEPAGE', TRUE );

        // Cater for large stores
        $wpdb->hide_errors();
        @set_time_limit( 0 );
        while ( ob_get_level() ) {
            @ob_end_clean();
        }

        // wp_suspend_cache_addition is buggy prior to 3.4
        if ( version_compare( get_bloginfo( 'version' ), '3.4', '>=' ) ) {
            wp_suspend_cache_addition( true );
        }

        header( 'Content-Type: application/xml; charset=UTF-8' );
        if ( $_GET['woogool_feed_download'] ) {
            header( 'Content-Disposition: attachment; filename="woogool-product-List.xml"' );  
        } else {
            header( 'Content-Disposition: inline; filename="woogool-product-List.xml"' );
        }

        
        echo "<?xml version='1.0' encoding='UTF-8'?>\n";
        echo "<rss version='2.0' xmlns:atom='http://www.w3.org/2005/Atom' xmlns:g='http://base.google.com/ns/1.0'>\n";
        echo "   <channel>\n";
        echo "       <atom:link href='".htmlspecialchars( home_url() )."' rel='self' type='application/rss+xml' />\n";
                        $this->get_xml_content( $feed_id );
        echo "  </channel>\n";
        echo '</rss>';

        exit();
    }

    function multipack() {
        $feed_settings = $this->feed_settings;
        $multipack     = empty( $feed_settings['_woogool_multipack'] ) ? false : absint( reset( $feed_settings['_woogool_multipack'] ) );

        return $multipack;
    }

    function material() {
        $feed_settings = $this->feed_settings;
        $material = empty( $feed_settings['_woogool_material'] ) ? false : reset( $feed_settings['_woogool_material'] );
        return $material;
    }

    function pattern() {
        $feed_settings = $this->feed_settings;
        $pattern = empty( $feed_settings['_woogool_pattern'] ) ? false : reset( $feed_settings['_woogool_pattern'] );
        return $pattern;
    }

    function variable_product_sale_price( $attr, $regular_price = false ) {
        $price = 0;
        $feed_settings = $this->feed_settings;
        $price_status = reset( $feed_settings['_woogool_price'] );

        if ( $price_status != 'sale' ) {
            return false;
        }

        $price = abs( $attr['display_price'] );

        return $price; 
    }

    function variable_product_regular_price( $attr, $regular_price = false ) {
        $price = 0;
        $feed_settings = $this->feed_settings;
        $price = abs( $attr['display_regular_price'] ); 
        $price = empty( $price ) ? abs( $attr['display_price'] ) : $price;
        
        return $price; 
    }

    function get_product_sale_price( $wc_product ) {
        $price = 0;
        $feed_settings = $this->feed_settings;
        $price_status = reset( $feed_settings['_woogool_price'] );

        if ( $price_status != 'sale' ) {
            return false;
        }

        $price =  abs( $wc_product->get_sale_price() );

        return $price;
    }

    function get_product_regular_price( $wc_product ) {
       
        $price =  abs( $wc_product->get_regular_price() ); 
        $price = empty( $price ) ? abs( $wc_product->get_sale_price() ) : $price;
       
        return $price;
    }

    function get_description( $wc_product ) {
        $description = reset( $this->feed_settings['_woogool_description'] );
        
        if ( $description == 'short_description' ) {
            $description  = $wc_product->get_short_description();
        } else {
            $description  = $wc_product->get_description();
        }

        return $description;
    }

    function get_variable_size_attr( $attr ) {
        $size_attr = empty( $attr['attributes']['attribute_size'] ) ? false : $attr['attributes']['attribute_size'];
        
        if ( ! $size_attr ) {
            $size_attr  = empty( $attr['attributes']['attribute_pa_size'] ) ? false : $attr['attributes']['attribute_pa_size'];  
        }

        return $size_attr;
    }

    function get_variable_color_attr( $attr ) {
        $color_attr = empty( $attr['attributes']['attribute_color'] ) ? false : $attr['attributes']['attribute_color'];
        
        if ( ! $color_attr ) {
            $color_attr = empty( $attr['attributes']['attribute_pa_color'] ) ? false : $attr['attributes']['attribute_pa_color'];  
        }

        return $color_attr;
    }

    function get_variable_products( $wc_product, $feed_settings ) {
        if ( empty( $feed_settings['_woogool_include_variable_products'] ) ) {
            return false;
        }

        if ( 'yes' != reset( $feed_settings['_woogool_include_variable_products'] ) ) {
            return false;
        }

        $get_product_type = $wc_product->get_type();
        
        if ( $get_product_type != 'variable' ) {
            return false;
        }

        $variable       = new WC_Product_Variable( $wc_product );
        $get_variations = $variable->get_available_variations();
        $get_attrs      = $variable->get_variation_attributes();
        $content        = '';
        
        if ( $get_variations ) {

            foreach ( $get_variations as $key => $attr ) {
                 
                if ( ! $attr['variation_is_active'] || ! $attr['variation_is_visible'] ) {
                    continue;
                }

                $variation_content = $this->xml_for_product_variation( $wc_product,  $attr, $get_attrs );
                $content           .= $variation_content;
            }
        }

        return empty( $content ) ? false : $content;
    }

    function get_gtin( $product_id ) {
        $feed_settings = $this->feed_settings;

        if ( empty( $feed_settings['_gtin'] ) ) {
            return array();
        }

        if ( 'on' != reset( $feed_settings['_gtin'] ) ) {
            return array();
        }
        
        $gtins        = get_post_meta( $product_id, 'woogool_gtin', true );
        $gtins        = explode( '&', $gtins );
        $product_gtin = array();

        foreach ( $gtins as $key => $gtin ) {
            $exp = explode( '=', $gtin );

            $gtin_pro_id = isset( $exp[0] ) ? intval( str_replace( ' ', '', $exp[0] ) ) : 0;
            $gtin_pro    = isset( $exp[1] ) ? str_replace( ' ', '', $exp[1] ) : 0;
            $product_gtin[$gtin_pro_id] = $gtin_pro;
        }
        
        return $product_gtin;
    }

    function set_gtin( $product_id, $variation_id ) {
        $gtin = $this->get_gtin( $product_id );
        if ( isset( $gtin[$variation_id] ) && ! empty( $gtin[$variation_id] ) ) {
            return $gtin[$product_id];
        }
        
        return false;
    }

    function get_sale_price_effective_date( $product_id ) {
        $feed_settings = $this->feed_settings;
        
        if ( empty( $feed_settings['_sale_price_effective_date'] ) ) {
            return false;
        }
        
        if ( 'yes' != reset( $feed_settings['_sale_price_effective_date'] ) ) {
            return false;
        }

        $sale_price_dates_from  = ( $date = get_post_meta( $product_id, '_sale_price_dates_from', true ) ) ? $this->get_availability_value( date_i18n( 'Y-m-d', $date ) ) : false;
        
        if ( ! $sale_price_dates_from ) {
            return false;
        }
        $sale_price_dates_to    = ( $date = get_post_meta( $product_id, '_sale_price_dates_to', true ) ) ? $this->get_availability_value( date_i18n( 'Y-m-d', $date ) ) : false;

        if ( ! $sale_price_dates_to ) {
            return false;
        }

        return $sale_price_dates_from .'/'. $sale_price_dates_to;
    }

    function get_identifier() {
        $feed_settings = $this->feed_settings;
        
        if ( empty( $feed_settings['_identifier_exists'] ) ) {
            return 'yes';
        }
        
        if ( 'on' != reset( $feed_settings['_identifier_exists'] ) ) {
            return 'yes';
        }
        
        return 'no';
    }

    function get_condition() {
        $feed_settings = $this->feed_settings;
        $consdition = empty( $feed_settings['_condition'] ) ? false : reset( $feed_settings['_condition'] );

        return $consdition;
    }


    function get_availability() {
        $feed_settings = $this->feed_settings;
        $availability = empty( $feed_settings['_availability'] ) ? false : reset( $feed_settings['_availability'] );
        return $availability;
    }

    function get_category( $wc_product ) {
        $product_id  = $wc_product->get_id();
        $product_cat = get_the_terms( $product_id, 'product_cat' );
        $product_cat = $product_cat ? $product_cat : array();
        $product_cat = wp_list_pluck( $product_cat, 'term_id' );
        
        $cat_map     = empty( $this->feed_settings['_cat_map'] ) ? array() : $this->feed_settings['_cat_map'];
        $cat_map     = array_flip( maybe_unserialize( reset( $cat_map ) ) );
        
        $result      = array_intersect( $product_cat, $cat_map );
        $result      = reset( $result );

        $cat_key     = array_search( $result, $cat_map );
        
        if ( $cat_key === false ) {
            return false;
        }

        $google_cat = $this->google_cat;
        
        $category = empty( $google_cat[$cat_key] ) ? false : $google_cat[$cat_key];
        
        if ( $category === false ) {
            return false;
        }
        
        $category = $category ? str_replace( "&", "&amp;", $category ) : false;
        $category = $category ? str_replace( ">", "&gt;", $category ) : false;
        
        return $category;
    }


    function get_availability_date() {
        $feed_settings = $this->feed_settings;
        $availability_date = empty( $feed_settings['_availability_date'] ) ? false : reset( $feed_settings['_availability_date'] );
        return $availability_date;
    }

    function get_expiration_date() {
        $feed_settings = $this->feed_settings;

        $expiration_date = empty( $feed_settings['_expiration_date'] ) ? false : reset( $feed_settings['_expiration_date'] );

        if ( $expiration_date ) {
            return $this->get_availability_value( $expiration_date );
        }

        return false;
    }

    function get_availability_value( $availability_date ) {
        $availability_value = '';

        if ( $availability_date ) {
            $tz_offset = get_option( 'gmt_offset' );
            $availability_value = $availability_date.'T00:00:00' . sprintf( '%+03d', $tz_offset ) . '00';
        }

        return $availability_value;
    }

    function get_variable_mpn( $attr ) {
        $feed_settings = $this->feed_settings;
        
        if ( empty( $feed_settings['_mpn'] ) ) {
            return false;
        }
        
        if ( 'on' != reset( $feed_settings['_mpn'] ) ) {
            return false;
        }
        $mpn = empty( $attr['sku'] ) ? false : $attr['sku'];
        return $mpn;
    }

    function get_sku_as_mpn ( $wc_product ) {
        $feed_settings = $this->feed_settings;
        
        if ( empty( $feed_settings['_mpn'] ) ) {
            return false;
        }
        if ( 'on' != reset( $feed_settings['_mpn'] ) ) {
            return false;
        }

        $sku = $wc_product->get_sku();
        $sku = empty( $sku ) ? false: $sku;

        return $sku;
    }

    function get_gender() {
        $feed_settings = $this->feed_settings;

        if ( empty( $feed_settings['_gender'] ) ) {
            return false;
        }

        if ( '-1' == reset( $feed_settings['_gender'] ) ) {
            return false;
        }
        $gender = reset( $feed_settings['_gender'] );
        return $gender;
    }

    function get_age_group() {
        $feed_settings = $this->feed_settings;

        if ( empty( $feed_settings['_age_group'] ) ) {
            return false;
        }

        if ( '-1' == reset( $feed_settings['_age_group'] ) ) {
            return false;
        }
        $age_group = reset( $feed_settings['_age_group'] );
        return $age_group;
    }

    function adult() {
        $feed_settings = $this->feed_settings;

        if ( empty( $feed_settings['_woogool_adult'] ) ) {
            return false;
        }

        if ( '-1' == reset( $feed_settings['_woogool_adult'] ) ) {
            return false;
        }
        $adult = reset( $feed_settings['_woogool_adult'] ); 
        return $adult;
    }

    function is_bundle() {
        $feed_settings = $this->feed_settings;

        if ( empty( $feed_settings['_woogool_is_bundle'] ) ) {
            return false;
        }

        if ( '-1' == reset( $feed_settings['_woogool_is_bundle'] ) ) {
            return false;
        }
        $is_bundle = reset( $feed_settings['_woogool_is_bundle'] );
        return $is_bundle;
    }

    function get_size_type() {
        $feed_settings = $this->feed_settings;

        if ( empty( $feed_settings['_size_type'] ) ) {
            return false;
        }

        if ( '-1' == reset( $feed_settings['_size_type'] ) ) {
            return false;
        }
        $size_type = reset( $feed_settings['_size_type'] );
        return $size_type;
    }

    function get_size_system() {
        $feed_settings = $this->feed_settings;

        if ( empty( $feed_settings['_size_system'] ) ) {
            return false;
        }

        if ( '-1' == reset( $feed_settings['_size_system'] ) ) {
            return false;
        }
        $size_system = reset( $feed_settings['_size_system'] );
        return $size_system;
    }

    function get_custom_label_0() {
        $feed_settings = $this->feed_settings;
        $custom_label_0 = empty( $feed_settings['_custom_label_0'] ) ? false : reset( $feed_settings['_custom_label_0'] ); 
        return $custom_label_0;
    }

    function get_custom_label_1() {
        $feed_settings = $this->feed_settings;

        $custom_label_1 = empty( $feed_settings['_custom_label_1'] ) ? false : reset( $feed_settings['_custom_label_1'] ); 
        return $custom_label_1;
    }

    function get_custom_label_2() {
        $feed_settings = $this->feed_settings;

        $custom_label_2 = empty( $feed_settings['_custom_label_2'] ) ? false : reset( $feed_settings['_custom_label_2'] ); 
        return $custom_label_2;

    }

    function get_custom_label_3() {
        $feed_settings = $this->feed_settings;

        $custom_label_3 = empty( $feed_settings['_custom_label_3'] ) ? false : reset( $feed_settings['_custom_label_3'] ); 
        return $custom_label_3;
    }

    function get_custom_label_4() {
        $feed_settings = $this->feed_settings;

        $custom_label_4 = empty( $feed_settings['_custom_label_4'] ) ? false : reset( $feed_settings['_custom_label_4'] ); 
        return $custom_label_4;
    }

    function get_promotion_id() {
        $feed_settings = $this->feed_settings;
        $promotion_id = empty( $feed_settings['_promotion_id'] ) ? false : reset( $feed_settings['_promotion_id'] );
        return $promotion_id;
    }

    function get_brand() {
        $feed_settings = $this->feed_settings;
        $brand         = empty( $feed_settings['_brand'] ) ? false : reset( $feed_settings['_brand'] );

        return $brand;
    }

    function get_additional_images( $wc_product ) {
        $additional_images = array();
        foreach ( $wc_product->get_gallery_image_ids() as $key => $link_id ) {
            $additional_images[] =  wp_get_attachment_url( $link_id ); 
            if ( count( $additional_images ) > 9 ) {
                break;
            }
        }

        return $additional_images;
    }

    function get_size_attr( $wc_product ) {
        $feed_settings = $this->feed_settings;
        
        if ( empty( $feed_settings['_size']  ) ) {
            return false;
        }
        if ( 'on' != reset( $feed_settings['_size'] ) ) {
            return false;
        }

        $size = $wc_product->get_attribute('size');

        if ( ! empty( $size ) ) {
            $size = str_replace(' ', '', $size );
            $size_attr = woogool_is_product_attribute_taxonomy( 'size', $wc_product ) ? str_replace( ',', '/', $size ) : str_replace( '|', '/', $size );
        } else {
            $size_attr = false;
        }

        return $size_attr;
    }

    function get_color_attr( $wc_product ) {

        $feed_settings = $this->feed_settings;
        
        if ( empty( $feed_settings['_color']  ) ) {
            return false;
        }
        if ( 'on' != reset( $feed_settings['_color'] ) ) {
            return false;
        }

        $color = $wc_product->get_attribute('color');
            
        if ( ! empty( $color ) ) {
            $color = str_replace(' ', '', $color );
            $color_attr = woogool_is_product_attribute_taxonomy( 'color', $wc_product ) ? str_replace( ',', '/', $color ) : str_replace( '|', '/', $color );
        } else {
            $color_attr = false;
        }

        return $color_attr;
    }

    function is_product_feed_disabled( $product_id ) {
        if ( get_post_meta( $product_id, '_disabled_feed', true ) == 'disabled' ) {
            return true;
        }

        return false;
    }

    function feed_delete() {
        if( ! isset( $_GET['page'] ) || ! isset( $_GET['woogool_tab'] ) || ! isset( $_GET['action'] ) ) {
            return;
        }

        if ( $_GET['page'] != 'product_woogool' || $_GET['woogool_tab'] != 'woogool_multiple' || $_GET['action'] != 'delete' ) {
            return;
        }

        $feed_id = isset( $_GET['feed_id'] ) ? intval( $_GET['feed_id'] ) : 0;

        if ( ! $feed_id ) {
            return;
        }

        wp_delete_post( $feed_id, true );

        $url_feed_list   = admin_url( 'edit.php?post_type=product&page=product_woogool&woogool_tab=woogool_multiple&woogool_sub_tab=feed-lists' );
        wp_redirect( $url_feed_list );
        exit();
    }

    function check_categori_fetch() {
        
        $feed_cat_fetch_time = get_option( 'woogool_google_product_cat_fetch_time', false );
        
        if ( ! $feed_cat_fetch_time ) {
            $this->store_google_product_type();
            return;
        }

        $cat = get_option( 'woogool_google_product_type' );
        if ( ! $cat || ! count( $cat ) || empty( $cat ) ) {
            $this->store_google_product_type();
            return;
        }
        $minute_diff = woogool_get_minute_diff( current_time( 'mysql' ), $feed_cat_fetch_time );

        if ( $minute_diff > 600 ) {
            $this->store_google_product_type();
        }
    }

    function store_google_product_type() {
        $cat = woogool_get_google_product_type();
        $cat = $cat ? $cat : array();
        update_option( 'woogool_google_product_type', $cat );
        update_option( 'woogool_google_product_cat_fetch_time', current_time( 'mysql' ) );
    }

    function feed_meta_box( $post_type ) {
        add_meta_box( 'woogool-feed-metabox-wrap', __( 'Feed Information' ), array( $this, 'woogool_meta_box_callback' ), $post_type, 'normal', 'core' );
    }

    function woogool_meta_box_callback( $post ) {
        if ( ! isset( $post->post_type ) ) {
            return;
        }
        
        if ( $post->post_type != 'product' ) {
            return;
        }
        $post_id = $post->ID;
        include_once WOOGOOL_PATH . '/views/single/product-meta.php';
    }

    function save_post_meta( $post_id, $post, $update ) {
        if ( $post->post_type != 'product' ) {
            return;
        }

        if ( ! isset( $_POST['woogool_sinlge_product_feed'] ) ) {
            return;
        }

        $disabled = isset( $_POST['disabled_feed'] ) ? $_POST['disabled_feed'] : 1;
        update_post_meta( $post_id, '_disabled_feed', $disabled );

        update_post_meta( $post_id, '_google_product_category', $_POST['google_product_category'] );
        update_post_meta( $post_id, '_product_type', $_POST['product_type'] );

        update_post_meta( $post_id, '_availability', $_POST['availability'] );

        $availability_date_default = isset( $_POST['availability_date_default'] ) ? $_POST['availability_date_default'] : '';
        update_post_meta( $post_id, '_availability_date_default', $availability_date_default );
        update_post_meta( $post_id, '_availability_date', $_POST['availability_date'] );

        update_post_meta( $post_id, '_condition', $_POST['condition'] );

        $brand_default = isset( $_POST['brand_default'] ) ? $_POST['brand_default'] : '';
        update_post_meta( $post_id, '_brand_default', $brand_default );
        update_post_meta( $post_id, '_brand', $_POST['brand'] );

        $mpn_default = isset( $_POST['mpn_default'] ) ? $_POST['mpn_default'] : '';
        update_post_meta( $post_id, '_mpn_default', $mpn_default );
        update_post_meta( $post_id, '_mpn', $_POST['mpn'] );

        update_post_meta( $post_id, '_gender', $_POST['gender'] );
        update_post_meta( $post_id, '_age_group', $_POST['age_group'] );

        $color_default = isset( $_POST['color_default'] ) ? $_POST['color_default'] : '';
        update_post_meta( $post_id, '_color_default', $color_default );
        update_post_meta( $post_id, '_color', $_POST['color'] );

        $size_default = isset( $_POST['size_default'] ) ? $_POST['size_default'] : '';
        update_post_meta( $post_id, '_size_default', $size_default );
        update_post_meta( $post_id, '_size', $_POST['size'] );

        update_post_meta( $post_id, '_size_type', $_POST['size_type'] );
        update_post_meta( $post_id, '_size_system', $_POST['size_system'] );

        $expiration_date_default = isset( $_POST['expiration_date_default'] ) ? $_POST['expiration_date_default'] : '';
        update_post_meta( $post_id, '_expiration_date_default', $expiration_date_default );
        update_post_meta( $post_id, '_expiration_date', $_POST['expiration_date'] );

        $custom_label_0_default = isset( $_POST['custom_label_0_default'] ) ? $_POST['custom_label_0_default'] : '';
        update_post_meta( $post_id, '_custom_label_0_default', $custom_label_0_default );
        update_post_meta( $post_id, '_custom_label_0', $_POST['custom_label_0'] );

        $custom_label_1_default = isset( $_POST['custom_label_1_default'] ) ? $_POST['custom_label_1_default'] : '';
        update_post_meta( $post_id, '_custom_label_1_default', $custom_label_1_default );
        update_post_meta( $post_id, '_custom_label_1', $_POST['custom_label_1'] );

        $custom_label_2_default = isset( $_POST['custom_label_2_default'] ) ? $_POST['custom_label_2_default'] : '';
        update_post_meta( $post_id, '_custom_label_2_default', $custom_label_2_default );
        update_post_meta( $post_id, '_custom_label_2', $_POST['custom_label_2'] );

        $custom_label_3_default = isset( $_POST['custom_label_3_default'] ) ? $_POST['custom_label_3_default'] : '';
        update_post_meta( $post_id, '_custom_label_3_default', $custom_label_3_default );
        update_post_meta( $post_id, '_custom_label_3', $_POST['custom_label_3'] );

        $custom_label_4_default = isset( $_POST['custom_label_4_default'] ) ? $_POST['custom_label_4_default'] : '';
        update_post_meta( $post_id, '_custom_label_4_default', $custom_label_4_default );
        update_post_meta( $post_id, '_custom_label_4', $_POST['custom_label_4'] );

        $promotion_id_default = isset( $_POST['promotion_id_default'] ) ? $_POST['promotion_id_default'] : '';
        update_post_meta( $post_id, '_promotion_id_default', $promotion_id_default );
        update_post_meta( $post_id, '_promotion_id', $_POST['promotion_id'] );
    }

    function is_product_disabled( $product_id ) {
        $disabled = get_post_meta( $product_id, '_woogool_exclude_product', true );
        return $disabled == 'yes' ? true : false;
    }

    function test() {
        //$this->variable_product_delete_from_xml(69, 59); die();
        $this->update_feed_file_by_product( 63, 59 );
        //$this->delete_from_xml(65, 59);
    }

    function get_product_xml_wrapper_tag( $feed ) {
        $tag = '';
        
        if ( $feed->post_content == 'yandex' ) {
            $tag = 'offer';
        } else if ( 
            $feed->post_content == 'fruugous' 
                || 
            $feed->post_content == 'fruugouk'
                ||
            $feed->post_content == 'manomano'
                ||
            $feed->post_content == 'custom_feed'
        ) {
            $tag = 'product';
        } else {
            $tag = 'item';
        }

        return $tag;
    }

    function variable_product_dom_query( $channel, $product_id ) {
        $query = array(
            'google_shopping_feed' => "//g:id[.={$product_id}]"
        );

        return empty( $query[$channel] ) ? '' : $query[$channel];
    }

    function dom_query( $channel, $product_id ) {
        $query = array(
            'google_shopping_feed' => "//g:id[.={$product_id}]"
        );

        return empty( $query[$channel] ) ? '' : $query[$channel];
    }

    function get_variable_product_dom_items( $dom_xpath, $product_id ) {
        $google_shopping_feed_query = $this->variable_product_dom_query( 'google_shopping_feed', $product_id );
        $google_shopping_feed = $dom_xpath->query( $google_shopping_feed_query );

        if ( ! empty( $google_shopping_feed->length ) ) {
            return array(
                'channel' => 'google_shopping_feed',
                'dom'    => $google_shopping_feed
            );
        } 

        return false;
    }

    function get_product_dom_items( $dom_xpath, $product_id ) {
        $google_shopping_feed_query = $this->dom_query( 'google_shopping_feed', $product_id );
        $google_shopping_feed = $dom_xpath->query( $google_shopping_feed_query );

        if ( ! empty( $google_shopping_feed->length ) ) {
            return array(
                'channel' => 'google_shopping_feed',
                'dom'    => $google_shopping_feed
            );
        } 

        return false;
    }

    public function variable_product_delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath ) {
        // $xml_file = woogool_get_feed_file_path( $feed_id );
        // $store_xml = $this->get_xml_node( $feed_id );
        // $store_xml->xpath( "parent::*" );

        // $store_xml_dom = new DomDocument;
        // $store_xml_dom->loadXML( $store_xml->asXML() );
        // $store_xml_dom_xpath = new DOMXpath( $store_xml_dom );
        $product_dom_items =  $this->get_variable_product_dom_items( $store_xml_dom_xpath, $product_id );

        if ( $product_dom_items !== false &&  ! empty( $product_dom_items['dom']->length ) ) {
            $product_id_dom     = $product_dom_items['dom'];
            
            $product_dom = $product_id_dom->item(0)->parentNode;
            $product_dom->parentNode->removeChild( $product_dom );

            return true;
        }

        return false;
    }

    public function delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath ) {
        // $xml_file  = woogool_get_feed_file_path( $feed_id );
        // $store_xml = $this->get_xml_node( $feed_id );
        // $store_xml->xpath( "parent::*" );

        // $store_xml_dom = new DomDocument;
        // $store_xml_dom->loadXML( $store_xml->asXML() );
        // $store_xml_dom_xpath = new DOMXpath( $store_xml_dom );

        $product_dom_items =  $this->get_product_dom_items( $store_xml_dom_xpath, $product_id );

        if ( $product_dom_items !== false &&  ! empty( $product_dom_items['dom']->length ) ) {
            $product_id_dom = $product_dom_items['dom'];
            
            $product_dom = $product_id_dom->item(0)->parentNode;
            $product_dom->parentNode->removeChild( $product_dom );

            //$store_xml_dom->saveXML(); 
            //$store_xml_dom->save( $xml_file );

            return true;
        }

        return false;
    }

    function add_variable_product_item_in_xml( $parent_id, $product_id, $feed_id ) {

        $product = wc_get_product( $product_id );
        $feed    = $this->get_feed( $feed_id );
        $logic   = empty( $feed->feed_settings['logic'] ) ? array() : $feed->feed_settings['logic'];

        $tag       = $this->get_product_xml_wrapper_tag( $feed );
        $xml_file  = woogool_get_feed_file_path( $feed_id );
        $store_xml = $this->get_xml_node( $feed_id );
        $store_xml->xpath( "parent::*" );

        $store_xml_dom = new DomDocument;
        $store_xml_dom->loadXML( $store_xml->asXML() );
        $store_xml_dom_xpath = new DOMXpath( $store_xml_dom );

        // if ( $product->get_status() != 'publish' ) {
        //     $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
        //     $this->delete_from_xml( $parent_id, $feed_id, $store_xml_dom_xpath );
        //     $store_xml_dom->save( $xml_file );
        //     return;
        // }

        // if ( $this->is_product_disabled( $product_id ) ) {
        //     $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
        //     $this->delete_from_xml( $parent_id, $feed_id, $store_xml_dom_xpath );
        //     $store_xml_dom->save( $xml_file );
        //     return;
        // }

        // if ( $this->is_exclude_from_filter( $product, $logic ) ) {
        //     $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
        //     $this->delete_from_xml( $parent_id, $feed_id, $store_xml_dom_xpath );
        //     $store_xml_dom->save( $xml_file );
        //     return;
        // }

        $product_dom     = $store_xml_dom_xpath->query( "//{$tag}" );
        $current_product_wrap = $product_dom->item(0);
        
        $new_xml          = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss xmlns:g="http://base.google.com/ns/1.0"></rss>');
        $new_product_wrap = $new_xml->addChild( $tag );

        $settings = get_post_meta( $feed_id );
        $has_namespace = $this->has_namespace( $feed_id );
        $namespace = $this->get_google_feed_name_space();

        if ( $this->has_item_group_id( $feed ) ) {
            if ( $has_namespace ) {
                $new_product_wrap->addChild( 'g:item_group_id', $parent_id, $namespace['g'] );
            } else {
                $new_product_wrap->addChild( 'g:item_group_id', $parent_id );
            }
        }

        // product all items are set under $new_product_wrap
        foreach ( $feed->feed_settings['content_attributes'] as $key => $feed_content ) {
            $this->feed_tag_generate( $feed_content, $product, $settings, $feed, true, $new_product_wrap, $this->get_google_feed_name_space() );
        }

        $new_dom = new DomDocument;
        $new_dom->loadXML( $new_xml->asXML() );
        $new_dom_xpath = new DOMXpath( $new_dom );
        $new_product_dom = $new_dom_xpath->query("//{$tag}")->item(0);

        //set new product dom in main dom
        $new_product = $store_xml_dom->importNode( $new_product_dom, true );

        $current_product_wrap->parentNode->appendChild( $new_product );

        //$store_xml_dom->saveXML(); 
        $store_xml_dom->save( $xml_file );

        return $new_product_dom;
    }

    function add_product_item_in_xml( $product_id, $feed_id ) {
        $product = wc_get_product( $product_id );
        $feed    = $this->get_feed( $feed_id );
        $logic   = empty( $feed->feed_settings['logic'] ) ? array() : $feed->feed_settings['logic'];

        $tag       = $this->get_product_xml_wrapper_tag( $feed );
        $xml_file  = woogool_get_feed_file_path( $feed_id );
        $store_xml = $this->get_xml_node( $feed_id );
        $store_xml->xpath( "parent::*" );

        $store_xml_dom = new DomDocument;
        $store_xml_dom->loadXML( $store_xml->asXML() );
        $store_xml_dom_xpath = new DOMXpath( $store_xml_dom );

        // if ( $product->get_status() != 'publish' ) {
        //     $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
        //     $this->delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath );
        //     $store_xml_dom->save( $xml_file );
        //     return;
        // }

        // if ( $this->is_product_disabled( $product_id ) ) {
        //     $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
        //     $this->delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath );
        //     $store_xml_dom->save( $xml_file );
        //     return;
        // }

        // if ( $this->is_exclude_from_filter( $product, $logic ) ) {
        //     $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
        //     $this->delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath );
        //     $store_xml_dom->save( $xml_file );
        //     return;
        // }

        $product_dom     = $store_xml_dom_xpath->query( "//{$tag}" );
        $current_product_wrap = $product_dom->item(0);
        
        $new_xml          = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss xmlns:g="http://base.google.com/ns/1.0"></rss>');
        $new_product_wrap = $new_xml->addChild( $tag );

        $settings = get_post_meta( $feed_id );

        // product all items are set under $new_product_wrap
        foreach ( $feed->feed_settings['content_attributes'] as $key => $feed_content ) {
            $this->feed_tag_generate( $feed_content, $product, $settings, $feed, true, $new_product_wrap, $this->get_google_feed_name_space() );
        }

        $new_dom = new DomDocument;
        $new_dom->loadXML( $new_xml->asXML() );
        $new_dom_xpath = new DOMXpath( $new_dom );
        $new_product_dom = $new_dom_xpath->query("//{$tag}")->item(0);

        //set new product dom in main dom
        $new_product = $store_xml_dom->importNode( $new_product_dom, true );
        //pmpr($new_product, $current_product_wrap); die();
        $current_product_wrap->parentNode->appendChild( $new_product );
        
        //$store_xml_dom->saveXML(); 
        $store_xml_dom->save( $xml_file );
    }

    function update_feed_file_by_product( $product_id, $feed_id ) {
        $product      = wc_get_product( $product_id );
        $product_type = $product->get_type();
        $feed         = $this->get_feed( $feed_id );
        $logic        = empty( $feed->feed_settings['logic'] ) ? array() : $feed->feed_settings['logic'];

        $xml_file  = woogool_get_feed_file_path( $feed_id );
        $store_xml = $this->get_xml_node( $feed_id );
        $store_xml->xpath( "parent::*" );

        $store_xml_dom = new DomDocument;
        $store_xml_dom->loadXML( $store_xml->asXML() );
        $store_xml_dom_xpath = new DOMXpath( $store_xml_dom );

        if ( $product->get_status() != 'publish' ) {
            $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
            $this->delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath );
            
            $store_xml_dom->save( $xml_file );
            return;
        }

        if ( $this->is_product_disabled( $product_id ) ) {
            $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
            $this->delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath );
            
            $store_xml_dom->save( $xml_file );
            return;
        }

        if ( $this->is_exclude_from_filter( $product, $logic ) ) {
            $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
            $this->delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath );
            
            $store_xml_dom->save( $xml_file );
            return;
        }

        if ( 
            $feed->feed_settings['active_variation'] == 'true'
                &&
            ( $product_type == 'variable' || $product_type == 'variation' ) 
        ) {
            $this->update_feed_file_by_variable_product( $product_id, $feed_id );
            return;
        }

        if ( 
            $product_type != 'variable' && $product_type != 'variation'
        ) {
            $this->delete_all_variation_by_parent( $product, $store_xml_dom_xpath, $feed_id );
        }

        $product_dom_items =  $this->get_product_dom_items( $store_xml_dom_xpath, $product_id );
        
        $settings = get_post_meta( $feed_id );
        $product  = wc_get_product( $product_id );
        $tag      = $this->get_product_xml_wrapper_tag( $feed );
       
        if ( $product_dom_items === false ) {
            $this->add_product_item_in_xml( $product_id, $feed_id );
        } 
        
        if ( $product_dom_items !== false &&  ! empty( $product_dom_items['dom']->length ) ) {

            $channel         = $product_dom_items['channel'];
            $product_dom     = $product_dom_items['dom'];
            $current_product = $product_dom->item(0)->parentNode;

            $new_xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss xmlns:g="http://base.google.com/ns/1.0"></rss>');
            $product_xml_wrap = $new_xml->addChild( $tag );
            
            // product all items are set under $product_xml_wrap
            foreach ( $feed->feed_settings['content_attributes'] as $key => $feed_content ) {
                $this->feed_tag_generate( $feed_content, $product, $settings, $feed, true, $product_xml_wrap, $this->get_google_feed_name_space() );
            }

            $new_dom = new DomDocument;
            $new_dom->loadXML( $new_xml->asXML() );
            $new_dom_xpath = new DOMXpath( $new_dom );
            $updated_product_dom = $new_dom_xpath->query("//{$tag}")->item(0);
            
            //set new product dom in main dom
            $updated_product = $store_xml_dom->importNode( $updated_product_dom, true );
            
            $current_product->parentNode->replaceChild( $updated_product, $current_product );
            
            //$store_xml_dom->saveXML(); 
            $store_xml_dom->save( $xml_file );
        }

        return true;
    }
    
    function update_feed_file_by_variable_product( $product_id, $feed_id ) {
        
        $wc_product              = wc_get_product( $product_id );
        $feed                    = $this->get_feed( $feed_id );
        $logic                   = empty( $feed->feed_settings['logic'] ) ? array() : $feed->feed_settings['logic'];
        $parent_product_status   = $wc_product->get_status();

        $variable   = new WC_Product_Variable( $wc_product );
        $variations = $variable->get_available_variations();
        $attrs      = $variable->get_variation_attributes();

        $xml_file  = woogool_get_feed_file_path( $feed_id );
        $store_xml = $this->get_xml_node( $feed_id );
        $store_xml->xpath( "parent::*" );

        $store_xml_dom = new DomDocument;
        $store_xml_dom->loadXML( $store_xml->asXML() );
        $store_xml_dom_xpath = new DOMXpath( $store_xml_dom );

        $tag           = $this->get_product_xml_wrapper_tag( $feed );
        $settings      = get_post_meta( $feed_id );
        $has_namespace = $this->has_namespace( $feed_id );
        $namespace     = $this->get_google_feed_name_space();

        if ( $parent_product_status != 'publish' ) {
            $this->delete_all_variation_by_parent( $wc_product, $store_xml_dom_xpath, $feed_id );
            $this->delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath );
            $store_xml_dom->saveXML();
        }

        //Delete parent product.
        $this->delete_from_xml( $product_id, $feed_id, $store_xml_dom_xpath );
        $this->delete_variation( $wc_product, $store_xml_dom_xpath, $feed_id );
        $store_xml_dom->saveXML();

        foreach ( $variations as $key => $child ) {
            $variable_product    = wc_get_product( $child['variation_id'] );
            $variable_product_id = $variable_product->get_id();

            if ( 
                $this->is_exclude_from_filter( $variable_product, $logic )
                    || 
                $this->is_product_disabled( $variable_product_id )
            ) {
                $this->variable_product_delete_from_xml( $variable_product_id, $feed_id, $store_xml_dom_xpath );
                $store_xml_dom->saveXML();
                continue;
            }

            $product_dom_items =  $this->get_variable_product_dom_items( $store_xml_dom_xpath, $variable_product_id );
            
            if ( $product_dom_items === false ) {
                $new_var_pro_dom = $this->add_variable_product_item_in_xml( $product_id, $variable_product_id, $feed_id );
                
                //set new product dom in main dom
                $new_product          = $store_xml_dom->importNode( $new_var_pro_dom, true );
                $new_product_dom      = $store_xml_dom_xpath->query( "//{$tag}" );
                $current_product_wrap = $new_product_dom->item(0);
                $current_product_wrap->parentNode->appendChild( $new_product );

                $store_xml_dom->saveXML();
                continue;
            } 

            if ( $product_dom_items !== false &&  ! empty( $product_dom_items['dom']->length ) ) {

                $channel         = $product_dom_items['channel'];
                $product_dom     = $product_dom_items['dom'];
                $current_product = $product_dom->item(0)->parentNode;

                $new_xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss xmlns:g="http://base.google.com/ns/1.0"></rss>');
                $product_xml_wrap = $new_xml->addChild( $tag );

                if ( $this->has_item_group_id( $feed ) ) {
                    if ( $has_namespace ) {
                        $product_xml_wrap->addChild( 'g:item_group_id', $wc_product->get_id(), $namespace['g'] );
                    } else {
                        $product_xml_wrap->addChild( 'g:item_group_id', $wc_product->get_id() );
                    }
                }
                
                // product all items are set under $product_xml_wrap
                foreach ( $feed->feed_settings['content_attributes'] as $key => $feed_content ) {
                    $this->feed_tag_generate( $feed_content, $variable_product, $settings, $feed, true, $product_xml_wrap, $namespace );
                }

                $new_dom = new DomDocument;
                $new_dom->loadXML( $new_xml->asXML() );
                $new_dom_xpath = new DOMXpath( $new_dom );
                $updated_product_dom = $new_dom_xpath->query("//{$tag}")->item(0);
                
                //set new product dom in main dom
                $updated_product = $store_xml_dom->importNode( $updated_product_dom, true );
               
                $current_product->parentNode->replaceChild( $updated_product, $current_product );  
            }

            $store_xml_dom->saveXML();
        }

        $store_xml_dom->save( $xml_file );
    }

    private function delete_variation( $wc_product, $store_xml_dom_xpath, $feed_id ) {
        $variations    = $wc_product->get_available_variations();
        $variations_id = wp_list_pluck( $variations, 'variation_id' );
        $parent_id     = $wc_product->get_id();
        $xmls_id       = array(); 

        $childs = $store_xml_dom_xpath->query( ".//item" );

        foreach ( $childs as $key => $child ) {
          
            $parent_node = $store_xml_dom_xpath->query( ".//g:item_group_id[.={$parent_id}]", $child );

            if( $parent_node->length <= 0 ) {
                continue;
            }

            $var_id = $store_xml_dom_xpath->query( ".//g:id", $child );
            $xmls_id[] = $var_id->item(0)->nodeValue;
        }

        $delete_ids = array_diff( $xmls_id, $variations_id );

        foreach ( $delete_ids as $key => $id ) {
            $this->variable_product_delete_from_xml( $id, $feed_id, $store_xml_dom_xpath );
        }
    }

    private function delete_all_variation_by_parent( $wc_product, $store_xml_dom_xpath, $feed_id ) {
        $parent_id     = $wc_product->get_id();
        $xmls_id       = array(); 

        $childs = $store_xml_dom_xpath->query( ".//item" );

        foreach ( $childs as $key => $child ) {
          
            $parent_node = $store_xml_dom_xpath->query( ".//g:item_group_id[.={$parent_id}]", $child );

            if( $parent_node->length <= 0 ) {
                continue;
            }

            $var_id = $store_xml_dom_xpath->query( ".//g:id", $child );
            $xmls_id[] = $var_id->item(0)->nodeValue;
        }

        foreach ( $xmls_id as $key => $id ) {
            $this->variable_product_delete_from_xml( $id, $feed_id, $store_xml_dom_xpath );
        }
    }
}




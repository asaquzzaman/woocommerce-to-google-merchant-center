<?php

class WooGool_Admin_Feed {
    
    private $number_per_page = 20;

    private $google_cat = array();
    private $feed_settings = array();
    
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

    function __construct() {
        add_action( 'admin_init', array( $this, 'register_post_type' ) );
        //add_action( 'admin_init', array( $this, 'new_feed' ) );
        add_action( 'admin_init', array( $this, 'feed_delete' ) );
        add_action( 'admin_init', array( $this, 'check_categori_fetch' ) );
        //add_action( 'admin_init', array( $this, 'new_feed' ) );
        //add_action( 'add_meta_boxes', array( $this, 'feed_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_post_meta' ), 10, 3 );
        add_action( 'template_redirect', array( $this, 'xml_download' ) );
    }

    function register_post_type() {
        register_post_type( 'new_woogool_feed', array(
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
            'post_type'    => 'new_woogool_feed',
            'post_title'   => $post['header']['name'],
            'post_content' => '',//$xml_content,
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

       
        // $all_products = isset( $post['all_products'] ) ? $post['all_products'] : 0;
        // update_post_meta( $post_id, '_all_products', $all_products );

        // $products = isset( $post['xml_count'] ) ? $post['xml_count'] : array();
        // update_post_meta( $post_id, '_xml_count', $products );

        // $woogool_description = isset( $post['woogool_description'] ) ? $post['woogool_description'] : array();
        // update_post_meta( $post_id, '_woogool_description', $woogool_description );

        // $products_cat = isset( $post['products_cat'] ) ? $post['products_cat'] : array();
        // update_post_meta( $post_id, '_products_cat', $products_cat );

        // $var_products = isset( $post['variable_products'] ) ? $post['variable_products'] : 'no';
        // update_post_meta( $post_id, '_woogool_include_variable_products', $var_products );

        // $google_product_category = isset( $post['google_product_category'] ) ? $post['google_product_category'] : '';
        // update_post_meta( $post_id, '_google_product_category', $google_product_category );

        // $product_type = isset( $post['product_type'] ) ? $post['product_type'] : '';
        // update_post_meta( $post_id, '_product_type', $product_type );

        // $availability = isset( $post['availability'] ) ? $post['availability'] : '';
        // update_post_meta( $post_id, '_availability', $availability );

        // $availability_date = isset( $post['availability_date'] ) ? $post['availability_date'] : '';
        // update_post_meta( $post_id, '_availability_date', $availability_date );

        // $condition = isset( $post['condition'] ) ? $post['condition'] : '';
        // update_post_meta( $post_id, '_condition', $condition );

        // $brand = isset( $post['brand'] ) ? $post['brand'] : '';
        // update_post_meta( $post_id, '_brand', $brand );

        // $mpn = isset( $post['mpn'] ) ? $post['mpn'] : '';
        // update_post_meta( $post_id, '_mpn', $mpn );

        // $gtin = isset( $post['gtin'] ) ? $post['gtin'] : '';
        // update_post_meta( $post_id, '_gtin', $gtin );

        // $gender = isset( $post['gender'] ) ? $post['gender'] : '';
        // update_post_meta( $post_id, '_gender', $gender );

        // $age_group = isset( $post['age_group'] ) ? $post['age_group'] : '';
        // update_post_meta( $post_id, '_age_group', $age_group );

        // $color = isset( $post['color'] ) ? $post['color'] : '';
        // update_post_meta( $post_id, '_color', $color );

        // $size = isset( $post['size'] ) ? $post['size'] : '';
        // update_post_meta( $post_id, '_size', $size );

        // $size_type = isset( $post['size_type'] ) ? $post['size_type'] : '';
        // update_post_meta( $post_id, '_size_type', $size_type );

        // $size_system = isset( $post['size_system'] ) ? $post['size_system'] : '';
        // update_post_meta( $post_id, '_size_system', $size_system );

        // $expiration_date = isset( $post['expiration_date'] ) ? $post['expiration_date'] : '';
        // update_post_meta( $post_id, '_expiration_date', $expiration_date );

        // $sale_price = isset( $post['sale_price'] ) ? $post['sale_price'] : 'no';
        // update_post_meta( $post_id, '_sale_price', $sale_price );

        // $sale_price_effective_date = isset( $post['sale_price_effective_date'] ) ? $post['sale_price_effective_date'] : 'no';
        // update_post_meta( $post_id, '_sale_price_effective_date', $sale_price_effective_date );

        // $custom_label_0 = isset( $post['custom_label_0'] ) ? $post['custom_label_0'] : '';
        // update_post_meta( $post_id, '_custom_label_0', $custom_label_0 );

        // $custom_label_1 = isset( $post['custom_label_1'] ) ? $post['custom_label_1'] : '';
        // update_post_meta( $post_id, '_custom_label_1', $custom_label_1 );

        // $custom_label_2 = isset( $post['custom_label_2'] ) ? $post['custom_label_2'] : '';
        // update_post_meta( $post_id, '_custom_label_2', $custom_label_2 );

        // $custom_label_3 = isset( $post['custom_label_3'] ) ? $post['custom_label_3'] : '';
        // update_post_meta( $post_id, '_custom_label_3', $custom_label_3 );

        // $custom_label_4 = isset( $post['custom_label_4'] ) ? $post['custom_label_4'] : '';
        // update_post_meta( $post_id, '_custom_label_4', $custom_label_4 );

        // $promotion_id = isset( $post['promotion_id'] ) ? $post['promotion_id'] : '';
        // update_post_meta( $post_id, '_promotion_id', $promotion_id );

        // $promotion_id = isset( $post['identifier_exists'] ) ? $post['identifier_exists'] : '';
        // update_post_meta( $post_id, '_identifier_exists', $promotion_id );

        // $cat_map = isset( $post['cat_map'] ) ? $post['cat_map'] : array();
        // update_post_meta( $post_id, '_cat_map', $cat_map );

        // $woogool_price = isset( $post['woogool_price'] ) ? $post['woogool_price'] : '';
        // update_post_meta( $post_id, '_woogool_price', $woogool_price );

        // $woogool_adult = isset( $post['woogool_adult'] ) ? $post['woogool_adult'] : '';
        // update_post_meta( $post_id, '_woogool_adult', $woogool_adult );

        // $woogool_is_bundle = isset( $post['woogool_is_bundle'] ) ? $post['woogool_is_bundle'] : '';
        // update_post_meta( $post_id, '_woogool_is_bundle', $woogool_is_bundle );

        // $woogool_multipack = isset( $post['woogool_multipack'] ) ? $post['woogool_multipack'] : '';
        // update_post_meta( $post_id, '_woogool_multipack', $woogool_multipack );

        // $woogool_material = isset( $post['woogool_material'] ) ? $post['woogool_material'] : '';
        // update_post_meta( $post_id, '_woogool_material', $woogool_material );

        // $woogool_pattern = isset( $post['woogool_pattern'] ) ? $post['woogool_pattern'] : '';
        // update_post_meta( $post_id, '_woogool_pattern', $woogool_pattern );
    }

    function xml_get_products( $xml_count, $products_cat ) {
        $products = array();
        $per_page = WOOGOOL_FEED_PER_PAGE;
        
        if ( empty( $products_cat ) ) {   
            $products = woogool_get_products( $per_page, $xml_count );

        } else {
            $tax_query['tax_query'] = array(
                array(
                    'taxonomy'         => 'product_cat',
                    'field'            => 'term_id',
                    'terms'            => $products_cat,
                    'include_children' => false,
                    'operator'         => 'IN',
            ));

            $products = woogool_get_products( $per_page,  $xml_count, $tax_query );
        }
        
        return $products;
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

    function get_xml_content( $feed_id ) {

        $this->feed_settings = $feed_settings  = get_post_meta( $feed_id );
        $xml_count       = empty( $feed_settings['_xml_count'] ) ? 0 : reset( $feed_settings['_xml_count'] );
        $products_cat     = empty( $feed_settings['_products_cat'] ) ? array() : maybe_unserialize( reset( $feed_settings['_products_cat'] ) );
        $xml_content      = '';
        
        $this->google_cat = get_option( 'woogool_google_product_type' );
         
        $products = $this->xml_get_products( $xml_count, $products_cat );
     
        
        foreach ( $products as $product ) {
            $this->generate_xml_content( $product, $feed_settings );
        }
        

        //return true;
    }


    function generate_xml_content( $product, $feed_settings ) {
        
        $product_id        = $product->ID;
        $wc_product        = wc_get_product( $product_id );
        $product_type      = $wc_product->get_type();
    
        if ( $product_type == 'variable' ) {
            $this->get_variable_products( $wc_product, $feed_settings );
            return true;
        }
        
        $description        = $this->get_description( $wc_product );
        $size_attr          = $this->get_size_attr( $wc_product );
        $color_attr         = $this->get_color_attr( $wc_product );
        $price              = $this->get_product_regular_price( $wc_product );
        $sale_price         = $this->get_product_sale_price( $wc_product );
        $additional_images  = $this->get_additional_images( $wc_product );
        $currency           = get_woocommerce_currency();
        $post_title         = $wc_product->get_title();
        $description        = strip_tags( html_entity_decode( stripslashes( nl2br( $description ) ) ) );
        $link               = $wc_product->get_permalink();
        $feed_image_url     = wp_get_attachment_url( $wc_product->get_image_id() );
        $condition          = $this->get_condition();
        $availability       = $this->get_availability();
        $category           = $this->get_category( $wc_product );
        //$type               = $this->get_type( $post, $product_id,  $product_cat );
        $availability_date  = $this->get_availability_date();
        $availability_value = $this->get_availability_value( $availability_date );
        $sku_as_mpn         = $this->get_sku_as_mpn( $wc_product );
        $gender             = $this->get_gender();
        $age_group          = $this->get_age_group();
        $size_type          = $this->get_size_type();
        $size_system        = $this->get_size_system();
        $custom_label_0     = $this->get_custom_label_0();
        $custom_label_1     = $this->get_custom_label_1();
        $custom_label_2     = $this->get_custom_label_2();
        $custom_label_3     = $this->get_custom_label_3();
        $custom_label_4     = $this->get_custom_label_4();
        $promotion_id       = $this->get_promotion_id();
        $brand              = $this->get_brand();
        $identifier         = $this->get_identifier();
        $expiration_date    = $this->get_expiration_date();
        $gtin               = $this->set_gtin( $product_id, $product_id );
        $adult              = $this->adult();
        $is_bundle          = $this->is_bundle();
        $multipack          = $this->multipack();
        $material           = $this->material();
        $pattern            = $this->pattern();


        $description = preg_replace( '/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]/u', '', $description );
        $description = str_replace( ']]>', ']]]]><![CDATA[>', $description );
        $description = substr( $description, 0, 5000 );
        //$description = html_entity_decode( $description, ENT_HTML401 | ENT_QUOTES );
        $description = iconv('UTF-8', 'ASCII//TRANSLIT', $description );
        $description = trim( $description );
        
        $effective_date = $this->get_sale_price_effective_date( $product_id ); 
        $content = '';
        

        echo "       <item>\n";
        echo "           <g:id><![CDATA[$product_id]]></g:id>\n";
        //echo ( $wc_product->product_type == 'variable' && $enable_variable_product ) ? "           <g:item_group_id>$product_id</g:item_group_id>\n" : '';
        echo "           <title><![CDATA[$post_title]]></title>\n";
        echo "           <description><![CDATA[$description]]></description>\n";
        echo "           <link><![CDATA[$link]]></link>\n";
        echo "           <g:image_link><![CDATA[$feed_image_url]]></g:image_link>\n";
        echo "           <g:condition><![CDATA[$condition]]></g:condition>\n";
        echo "           <g:availability><![CDATA[$availability]]></g:availability>\n";
        echo $price ? "           <g:price><![CDATA[$price $currency]]></g:price>\n" : '';
        echo $category ?  "          <g:google_product_category><![CDATA[$category]]></g:google_product_category>\n" : '';
        //echo $type ? "           <g:product_type>$type</g:product_type>\n" : '';
        echo $availability_date ? "          <g:availability_date><![CDATA[$availability_value]]></g:availability_date>\n" : '';
        echo ! empty( $sale_price ) ? "          <g:sale_price><![CDATA[$sale_price $currency]]></g:sale_price>\n" : '';
        echo $sku_as_mpn ? "         <g:mpn><![CDATA[$sku_as_mpn]]></g:mpn>\n" : '';
        echo $gender ? "         <g:gender><![CDATA[$gender]]></g:gender>\n" : '';
        echo $age_group ? "          <g:age_group><![CDATA[$age_group]]></g:age_group>\n" : '';
        echo $brand ? "          <g:brand><![CDATA[$brand]]></g:brand>\n" : '';
        echo $gtin ? "          <g:gtin><![CDATA[$gtin]]></g:gtin>\n" : '';
        echo $expiration_date ? "          <g:expiration_date><![CDATA[$expiration_date]]></g:expiration_date>\n" : '';
        echo $size_type ? "          <g:size_type><![CDATA[$size_type]]></g:size_type>\n" : '';
        echo $size_system ? "            <g:size_system><![CDATA[$size_system]]></g:size_system>\n" : '';
        echo $adult ? "                  <g:adult><![CDATA[$adult]]></g:adult>\n" : '';
        echo $is_bundle ? "       <g:is_bundle><![CDATA[$is_bundle]]></g:is_bundle>\n" : '';
        echo $multipack ? "       <g:multipack><![CDATA[$multipack]]></g:multipack>\n" : '';
        echo $material ? "       <g:material><![CDATA[$material]]></g:material>\n" : '';
        echo $pattern ? "       <g:pattern><![CDATA[$pattern]]></g:pattern>\n" : '';
        echo $effective_date ? "         <g:sale_price_effective_date><![CDATA[$effective_date]]></g:sale_price_effective_date>\n" : ''; 
        echo $custom_label_0 ? "         <g:custom_label_0><![CDATA[$custom_label_0]]></g:custom_label_0>\n" : '';
        echo $custom_label_1 ? "         <g:custom_label_1><![CDATA[$custom_label_1]]></g:custom_label_1>\n" : '';
        echo $custom_label_2 ? "         <g:custom_label_2><![CDATA[$custom_label_2]]></g:custom_label_2>\n" : '';
        echo $custom_label_3 ? "         <g:custom_label_3><![CDATA[$custom_label_3]]></g:custom_label_3>\n" : '';
        echo $custom_label_4 ? "         <g:custom_label_4><![CDATA[$custom_label_4]]></g:custom_label_4>\n" : '';
        echo $promotion_id ? "           <g:promotion_id><![CDATA[$promotion_id]]></g:promotion_id>\n" : '';
        echo $color_attr ? "         <g:color><![CDATA[$color_attr]]></g:color>\n" : '';
        echo $size_attr ? "          <g:size><![CDATA[$size_attr]]></g:size>\n" : '';
        echo $identifier ? "         <g:identifier_exists><![CDATA[$identifier]]></g:identifier_exists>\n" : '';
        
        $additional_img_count = 1;
        
        foreach ( $additional_images as $image_url ) {
            // Google limit the number of additional images to 10
            if ( $additional_img_count == 10 ) {
                
                break;
            }

            echo "           <g:additional_image_link><![CDATA[$image_url]]></g:additional_image_link>\n";
            $additional_img_count++;
        }

        echo "       </item>\n";
        return true;
    }


    function xml_for_product_variation( $wc_product,  $attr, $get_attrs ) {

        //$product_id         = $wc_product->id; 
        $product_id         = $wc_product->get_id(); 
        $variation_product_id       = $attr['variation_id'];
        
        $size_attr          = $this->get_variable_size_attr( $attr );
        $color_attr         = $this->get_variable_color_attr( $attr ); 
        $brand              = $this->get_brand();
        
        $currency           = get_woocommerce_currency();
        
        $post_title         = $wc_product->get_title();
        $description        = empty( $attr['variation_description'] ) ? $this->get_description( $wc_product ) : strip_tags( html_entity_decode( stripslashes( nl2br( $attr['variation_description'] ) ) ) );
        $link               = $wc_product->get_permalink();
        $feed_image_url     = ! empty( $attr['image_src'] ) ? $attr['image_src'] : wp_get_attachment_url( $wc_product->get_image_id() );
        $condition          = $this->get_condition();
        $availability       = $this->get_availability();
        $category           = $this->get_category( $wc_product );
        $availability_date  = $this->get_availability_date();
        $availability_value = $this->get_availability_value( $availability_date );
        $sku_as_mpn         = $this->get_variable_mpn( $attr );
        $gender             = $this->get_gender();
        $age_group          = $this->get_age_group();
        $size_type          = $this->get_size_type();
        $size_system        = $this->get_size_system();
        $custom_label_0     = $this->get_custom_label_0();
        $custom_label_1     = $this->get_custom_label_1();
        $custom_label_2     = $this->get_custom_label_2();
        $custom_label_3     = $this->get_custom_label_3();
        $custom_label_4     = $this->get_custom_label_4();
        $promotion_id       = $this->get_promotion_id();
        $identifier         = $this->get_identifier();
        $expiration_date    = $this->get_expiration_date();
        $gtin               = $this->set_gtin( $product_id, $variation_product_id );
        
        $price              = $this->variable_product_regular_price( $attr );
        $sale_price         = $this->variable_product_sale_price( $attr );
        
        $description = preg_replace( '/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]/u', '', $description );
        $description = str_replace( ']]>', ']]]]><![CDATA[>', $description );
        $description = substr( $description, 0, 5000 );
        //$description = html_entity_decode( $description, ENT_HTML401 | ENT_QUOTES );
        $description = iconv('UTF-8', 'ASCII//TRANSLIT', $description );
        $description = trim( $description );
        
        $effective_date = $this->get_sale_price_effective_date( $variation_product_id ); 
        $adult          = $this->adult();
        $is_bundle      = $this->is_bundle();
        $multipack      = $this->multipack() ;
        $material       = $this->material();
        $pattern        = $this->pattern();

        echo  "       <item>\n";
        echo  "           <g:id><![CDATA[$variation_product_id]]></g:id>\n";
        echo  "           <g:item_group_id><![CDATA[$product_id]]></g:item_group_id>\n";
        echo  "           <title><![CDATA[$post_title]]></title>\n";
        echo  "           <description><![CDATA[$description]]></description>\n";
        echo  "           <link><![CDATA[$link]]></link>\n";
        echo  "           <g:image_link><![CDATA[$feed_image_url]]></g:image_link>\n";
        echo  "           <g:condition><![CDATA[$condition]]></g:condition>\n";
        echo  "           <g:availability><![CDATA[$availability]]></g:availability>\n";
        echo  $price ? "           <g:price><![CDATA[$price $currency]]></g:price>\n" : '';
        echo  $category ?  "          <g:google_product_category><![CDATA[$category]]></g:google_product_category>\n" : '';
        //echo  $type ? "           <g:product_type>$type</g:product_type>\n" : '';
        echo  $availability_date ? "          <g:availability_date><![CDATA[$availability_value]]></g:availability_date>\n" : '';
        echo  ! empty( $sale_price ) ? "          <g:sale_price><![CDATA[$sale_price $currency]]></g:sale_price>\n" : '';
        echo  $sku_as_mpn ? "         <g:mpn><![CDATA[$sku_as_mpn]]></g:mpn>\n" : '';
        echo  $gtin ? "         <g:gtin><![CDATA[$gtin]]></g:gtin>\n" : '';
        echo  $gender ? "         <g:gender><![CDATA[$gender]]></g:gender>\n" : '';
        echo  $age_group ? "          <g:age_group><![CDATA[$age_group]]></g:age_group>\n" : '';
        echo  $brand ? "          <g:brand><![CDATA[$brand]]></g:brand>\n" : '';
        echo  $expiration_date ? "          <g:expiration_date><![CDATA[$expiration_date]]></g:expiration_date>\n" : '';
        echo  $size_type ? "          <g:size_type><![CDATA[$size_type]]></g:size_type>\n" : '';
        echo  $size_system ? "            <g:size_system><![CDATA[$size_system]]></g:size_system>\n" : '';
        echo  $is_bundle ? "       <g:is_bundle><![CDATA[$is_bundle]]></g:is_bundle>\n" : '';
        echo  $multipack ? "       <g:multipack><![CDATA[$multipack]]></g:multipack>\n" : '';
        echo  $material ? "       <g:material><![CDATA[$material]]></g:material>\n" : '';
        echo  $pattern ? "       <g:pattern><![CDATA[$pattern]]></g:pattern>\n" : '';
        echo  $effective_date ? "         <g:sale_price_effective_date><![CDATA[$effective_date]]></g:sale_price_effective_date>\n" : '';
        echo  $custom_label_0 ? "         <g:custom_label_0><![CDATA[$custom_label_0]]></g:custom_label_0>\n" : '';
        echo  $custom_label_1 ? "         <g:custom_label_1><![CDATA[$custom_label_1]]></g:custom_label_1>\n" : '';
        echo  $custom_label_2 ? "         <g:custom_label_2><![CDATA[$custom_label_2]]></g:custom_label_2>\n" : '';
        echo  $custom_label_3 ? "         <g:custom_label_3><![CDATA[$custom_label_3]]></g:custom_label_3>\n" : '';
        echo  $custom_label_4 ? "         <g:custom_label_4><![CDATA[$custom_label_4]]></g:custom_label_4>\n" : '';
        echo  $promotion_id ? "           <g:promotion_id><![CDATA[$promotion_id]]></g:promotion_id>\n" : '';
        echo  $adult ? "                  <g:adult><![CDATA[$adult]]></g:adult>\n" : '';
        echo  $color_attr ? "         <g:color><![CDATA[$color_attr]]></g:color>\n" : '';
        echo  $size_attr ? "          <g:size><![CDATA[$size_attr]]></g:size>\n" : '';
        echo  $identifier ? "         <g:identifier_exists><![CDATA[$identifier]]></g:identifier_exists>\n" : '';


        echo  "       </item>\n";
        return true;
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

        $feed_cat_fetch_time = get_option( 'woogool_google_product_type_fetch_time', false );
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
        update_option( 'woogool_google_product_type_fetch_time', current_time( 'mysql' ) );
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
}




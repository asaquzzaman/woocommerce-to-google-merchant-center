<?php
/**
 * Plugin Name: WP Woocommerce to Google merchant center new
 * Plugin URI: https://github.com/asaquzzaman/woocommerce-to-google-merchant-center
 * Description: Submit your product woocommerce to google merchant center.
 * Author: asaquzzaman
 * Version: 1.6.0
 * Author URI: http://mishubd.com
 * License: GPL2
 * TextDomain: woogool
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

if ( ! class_exists('WP_WooGool') ) {
    class WP_WooGool {

        private $merchant_account_id;
        public $individual;
        public static $version = '1.6.0';
        static $woocommerce;
        static $woogool_free;

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
            //add_filter( 'manage_edit-product_columns', array( $this, 'product_columns_head' ), 20, 1 );
            add_action( 'admin_init', array( $this, 'update' ) );
            
            add_action( 'admin_init', array( $this, 'delete_product' ) );
            add_action( 'settings_text_field', array( $this, 'settings_text_field' ), 10, 2 );
            add_action( 'admin_enqueue_scripts', array( $this, 'scripts') );

            do_action( 'woogool_after_loaded' );
        }

        function update() {
            require_once dirname(__FILE__) . '/admin/updates/update-2.0.php';
        }

        function init() {
            $this->define_constants();
            spl_autoload_register( array( __CLASS__, 'autoload' ) );

            require_once dirname(__FILE__) . '/includes/function.php';
            require_once dirname(__FILE__) . '/includes/pages.php';
            require_once dirname(__FILE__) . '/includes/google-info.php';
            require_once dirname(__FILE__) . '/includes/google-shopping-attributes.php';
            require_once dirname(__FILE__) . '/includes/woogool-product-attributes.php';
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
            $this->define( 'WOOGOOL_VERSION', self::$version );
            $this->define( 'WOOGOOL_FEED_PER_PAGE', 2 );
            $this->define( 'WOOGOOL_REQUEST_AMOUNT', 2 );
            $this->define( 'WOOGOOL_DEBUG', true );
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
            WooGool_Admin_Feed::instance();
            new WooGool_Admin_ajax();
            new WooGool_Admin_Google_Shopping();
            
            //version update
            new WooGool_Admin_Upgrade();
        }

        function scripts_multiple_products() {
            wp_enqueue_script( 'woogool-chosen', plugins_url( '/assets/js/chosen/chosen.jquery.min.js', __FILE__ ), array( 'jquery' ), time(), true );
            wp_enqueue_script( 'woogool-bootstrap', plugins_url( '/assets/js/bootstrap.js', __FILE__ ), array( 'jquery' ), time(), true );
            wp_enqueue_script( 'woogool-vue', plugins_url( '/assets/js/vue/vue.min.js', __FILE__ ), array( 'woogool-bootstrap' ), time(), true );
            wp_enqueue_script( 'woogool-vuex', plugins_url( '/assets/js/vue/vuex.min.js', __FILE__ ), array( 'woogool-vue' ), time(), true );
            wp_enqueue_script( 'woogool-vue-router', plugins_url( '/assets/js/vue/vue-router.min.js', __FILE__ ), array( 'woogool-vuex' ), time(), true );
            wp_enqueue_script( 'woogool-constant', plugins_url( '/assets/js/constant.js', __FILE__ ), array( 'woogool-vue-router' ), time(), true );
            wp_enqueue_script( 'woogool-multiselect', plugins_url( '/assets/js/vue-multiselect/vue-multiselect.min.js', __FILE__ ), array( 'woogool-constant' ), time(), true );
            wp_enqueue_script( 'woogool-library', plugins_url( '/assets/js/pro/library.js', __FILE__ ), array( 'woogool-multiselect' ), time(), true );
            wp_enqueue_script( 'woogool-pro', plugins_url( '/assets/js/pro/woogool_pro.js', __FILE__ ), array( 'woogool-library' ), time(), true );

            wp_localize_script( 'woogool-pro', 'woogool_multi_product_var', array(
                'product_categories'         => woogool_get_products_terms_dropdown_array(),
                'google_categories'          => get_option( 'woogool_google_product_type' ),
                'google_shopping_attributes' => woogool_shopping_attributes(),
                'woogool_product_attributes' => woogool_product_attributes(),
                'woogool_product_attribute_with_optgroups' => woogool_product_attribute_with_optgroups (),
                'google_extra_attr_fields'    => [],
                'request_amount' => WOOGOOL_REQUEST_AMOUNT,
                'feed_per_page' => WOOGOOL_FEED_PER_PAGE,
            ));

            wp_enqueue_style( 'woogool-chosen', plugins_url( '/assets/css/chosen/chosen.min.css', __FILE__ ), false, time(), 'all' );
            wp_enqueue_style( 'woogool-vue-multiselect', plugins_url( '/assets/css/vue-multiselect/vue-multiselect.min.css', __FILE__ ), false, time(), 'all' );
        }

        /**
         * Load script
         * @return  void
         */
        function scripts() {
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_media();
            wp_enqueue_script( 'woogool-chosen', plugins_url( '/assets/js/chosen/chosen.jquery.min.js', __FILE__ ), array( 'jquery' ), time(), true );
            wp_enqueue_script( 'woogool-script', plugins_url( 'assets/js/woogool.js', __FILE__ ), array( 'jquery' ), time(), true );
            wp_localize_script( 'woogool-script', 'woogool_var', array(
                'ajaxurl'            => admin_url( 'admin-ajax.php' ),
                'nonce'              => wp_create_nonce( 'woogool_nonce' ),
                'country_details'    => json_encode( woogool_country_details() ),
                'is_admin'           => is_admin() ? 'yes' : 'no',
                'dir_url'            => plugin_dir_url( __FILE__ ),
            ));
            wp_enqueue_style( 'woogool-chosen', plugins_url( '/assets/css/chosen/chosen.min.css', __FILE__ ), false, time(), 'all' );
            wp_enqueue_style( 'woogool-style', plugins_url( 'assets/css/woogool.css', __FILE__ ) );
            wp_enqueue_style( 'woogool-jquery-ui', plugins_url( '/assets/css/jquery-ui.css', __FILE__ ), false, time(), 'all' );
        }
        /**
         * Set woocommerce submenu
         * @return void
         */
        function admin_menu() {
            $woogool = add_menu_page( __( 'WooGool Feed', 'woogool' ), __( 'WooGool Feed', 'woogool' ), 'read', 'woogool', array( $this, 'woogool_page' ) );
            $woogool_single = add_submenu_page( 'woogool', __( 'Individual Product', 'woogool' ), __( 'Individual Product', 'woogool' ), 'read', 'woogool' , array( $this, 'woogool_page' ) );
            $woogool_multi = add_submenu_page( 'woogool', __( 'Multiple Products', 'woogool' ), __( 'Multiple Products', 'woogool' ), 'read', 'woogool_multiple', array( $this, 'woogool_page' ) );
            
            add_action( 'admin_print_styles-' . $woogool, array( $this, 'scripts' ) );
            add_action( 'admin_print_styles-' . $woogool_multi, array( $this, 'scripts_multiple_products' ) );
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

            $page = isset( $_GET['page'] ) ? $_GET['page'] : '';
            $page_path = '';

            if ( $page == 'woogool' ) {
                $page_path = WOOGOOL_VIEWS_PATH . '/single/single.php';
            } else if ( $page == 'woogool_multiple' ) {
                $page_path = WOOGOOL_VIEWS_PATH . '/multiple/multiple-product.php';
            }

            if ( ! file_exists( $page_path ) ) {
                _e('Page not found', 'woogool' );
                return;
            }
            
            echo '<div class="woogool wrap" id="woogool">';
                require_once $page_path;
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

        /**
         * Placeholder for activation function
         *
         * Nothing being called here yet.
         */
        static function notice() {

            if ( self::$woocommerce ) {
                echo '<div class="error">
                    <p><strong>WooCommerce</strong> plugin is not installed. Install the plugin first</p>
                </div>';
            }

            if ( self::$woogool_free ) {
                echo '<div class="error">
                    <p><strong>WooCommerce Google product feed</strong> plugin is installed. Uninstall the plugin first</p>
                </div>';
            }

        }
    }

    register_activation_hook( __FILE__, array( 'WP_WooGool', 'install' ) );

    add_action( 'plugins_loaded', 'WooGool' );

    function WooGool() {
        if ( ! class_exists( 'WooCommerce' ) ) {

            WP_WooGool::$woocommerce = true;
            add_action( 'admin_notices', array( 'WP_WooGool', 'notice' ) );
            return;
        }

        return new WP_WooGool();
    }
} else {
    add_action( 'admin_notices', 'woogool_notice' );
}

function woogool_notice() {
    $free_plugin = dirname( dirname(__FILE__) ) . '/woocommerce-to-google-merchant-center/wogol.php';
    
    if ( file_exists( $free_plugin ) ) {
        deactivate_plugins( $free_plugin );
        return;
    }
    
    echo '<div class="error">
        <p><strong>WooCommerce Google product feed</strong> plugin is installed. Uninstall the plugin first</p>
    </div>';
}

//add_action( 'woocommerce_product_options_general_product_data', 'woogool_custom_variable_fields', 10, 3 );

function woogool_custom_variable_fields( $loop, $variation_id, $variation ) {
        die('mishu custom asdfasdfasdfeawdsfawsdfzsdfzsdw');
        // Check if the option is enabled or not in the pluggin settings 
        //if( get_option('add_unique_identifiers') == "yes" ){

                // Variation Brand field
            woocommerce_wp_text_input(
                array (
                    'id'       => '_woogool_variable_brand['.$loop.']',
                    'label'       => __( '<br>Brand', 'woocommerce' ),
                    'placeholder' => 'Parent Brand',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the product Brand here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_brand', true),
                    'wrapper_class' => 'form-row-full',
                )
            );

            // Variation GTIN field
            woocommerce_wp_text_input(
                array (
                    'id'          => '_woogool_variable_gtin['.$loop.']',
                    'label'       => __( '<br>GTIN', 'woocommerce' ),
                    'placeholder' => 'GTIN',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the product GTIN here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_gtin', true),
                    'wrapper_class' => 'form-row-last',
                )
            );

            // Variation MPN field
            woocommerce_wp_text_input(
                array (
                    'id'          => '_woogool_variable_mpn['.$loop.']',
                    'label'       => __( '<br>MPN', 'woocommerce' ),
                    'placeholder' => 'Manufacturer Product Number',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the product UPC here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_mpn', true),
                    'wrapper_class' => 'form-row-first',
                )
            );

            // Variation UPC field
            woocommerce_wp_text_input(
                array(
                    'id'          => '_woogool_variable_upc['.$loop.']',
                    'label'       => __( '<br>UPC', 'woocommerce' ),
                    'placeholder' => 'UPC',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the product UPC here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_upc', true),
                    'wrapper_class' => 'form-row-last',
                )
            );

            // Variation EAN field
            woocommerce_wp_text_input(
                array(
                    'id'          => '_woogool_variable_ean['.$loop.']',
                    'label'       => __( '<br>EAN', 'woocommerce' ),
                    'placeholder' => 'EAN',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the product EAN here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_ean', true),
                    'wrapper_class' => 'form-row-first',
                )
            );

            // Variation Unit pricing measure field
            woocommerce_wp_text_input(
                array(
                    'id'          => '_woogool_variable_unit_pricing_measure['.$loop.']',
                    'label'       => __( '<br>Unit pricing measure', 'woocommerce' ),
                    'placeholder' => 'Unit pricing measure',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the product Unit pricing measure here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_unit_pricing_measure', true),
                    'wrapper_class' => 'form-row-first',
                )
            );

            // Variation Unit pricing base measure field
            woocommerce_wp_text_input(
                array(
                    'id'          => '_woogool_variable_unit_pricing_base_measure['.$loop.']',
                    'label'       => __( '<br>Unit pricing base measure', 'woocommerce' ),
                    'placeholder' => 'Unit pricing base measure',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the product Unit pricing base measure here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_unit_pricing_base_measure', true),
                    'wrapper_class' => 'form-row-first',
                )
            );

            // Variation optimized title field
            woocommerce_wp_text_input(
                array(
                    'id'          => '_woogool_optimized_title['.$loop.']',
                    'label'       => __( '<br>Optimized title', 'woocommerce' ),
                    'placeholder' => 'Optimized title',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter a optimized product title here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_optimized_title', true),
                    'wrapper_class' => 'form-row-last',
                )
            );

            // Installment month field
            woocommerce_wp_text_input(
                array (
                    'id'          => '_woogool_installment_months['.$loop.']',
                    'label'       => __( '<br>Installment months', 'woocommerce' ),
                    'placeholder' => 'Installment months',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the number of montly installments for the buyer here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_installment_months', true),
                    'wrapper_class' => 'form-row-last',
                )
            );

            // Installment amount field
            woocommerce_wp_text_input(
                array (
                    'id'          => '_woogool_installment_amount['.$loop.']',
                    'label'       => __( '<br>Installment amount', 'woocommerce' ),
                    'placeholder' => 'Installment amount',
                    'desc_tip'    => 'true',
                    'description' => __( 'Enter the installment amount here.', 'woocommerce' ),
                    'value'       => get_post_meta($variation->ID, '_woogool_installment_amount', true),
                    'wrapper_class' => 'form-row-last',
                )
            );

            // Add product condition drop-down
            woocommerce_wp_select(
                array(
                    'id'        => '_woogool_condition['.$loop.']',
                    'label'     => __( 'Product condition', 'woocommerce' ),
                    'placeholder'   => 'Product condition',
                    'desc_tip'  => 'true',
                    'description'   => __( 'Select the product condition.', 'woocommerce' ),
                                    'value'         => get_post_meta($variation->ID, '_woogool_condition', true),
                                    'wrapper_class' => 'form-row form-row-full',
                    'options'   => array (
                        ''      => __( '', 'woocommerce' ),
                        'new'       => __( 'new', 'woocommerce' ),
                        'refurbished'   => __( 'refurbished', 'woocommerce' ),
                        'used'      => __( 'used', 'woocommerce' ),
                        'damaged'   => __( 'damaged', 'woocommerce' ),
                    )
                )
            );

            // Exclude product from feed
            woocommerce_wp_checkbox(
                array(
                    'id'        => '_woogool_exclude_product['.$loop.']',
                    'label'     => __( '&nbsp;Exclude from feeds', 'woocommerce' ),
                    'placeholder'   => 'Exclude from feeds',
                    'desc_tip'  => 'true',
                    'description'   => __( 'Check this box if you want this product to be excluded from product feeds.', 'woocommerce' ),
                                    'value'         => get_post_meta($variation->ID, '_woogool_exclude_product', true),
                )
            );
        //}
    }

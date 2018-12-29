<?php

class WooGool_Admin_Google_Shopping {

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

    public function __construct() {
    	add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'custom_variable_fields' ), 10, 3 );
    	add_action( 'woocommerce_product_options_general_product_data', array( $this, 'custom_general_fields' ) );
    	add_action( 'woocommerce_process_product_meta', array( $this, 'save_custom_general_fields' ) );
    	add_action( 'woocommerce_save_product_variation', array( $this, 'save_custom_variable_fields' ), 10, 1 );
    }

    public static function get_attributes() {
        
        $google_attributes = array (
			"basic_product_data" => array (
				'label' => 'Basic product data',
				'attributes' => array (
					"product_id" => array (
						'label'       => 'Product ID',
						"name"        => "id",
						"feed_name"   => "g:id",
						"format"      => "required",
						"woo_suggest" => "id",
					),
	            	"product_title" => array (
	            		'label'       => 'Product title',
						"name"        => "title",
						"feed_name"   => "g:title",
						"format"      => "required",
						"woo_suggest" => "title",
					),
	            	"product_description" => array (
	            		'label'       => 'Product description',
						"name"        => "description",
						"feed_name"   => "g:description",
						"format"      => "required",
						"woo_suggest" => "description",
	            	),
					"product_url" => array (
						'label'       => 'Product URL',
						"name"        => "link",
						"feed_name"   => "g:link",
						"format"      => "required",
						"woo_suggest" => "link",
	            	),
	            	"main_image_url" => array (
	            		'label'       => 'Main image UR',
						"name"        => "image_link",
						"feed_name"   => "g:image_link",
						"format"      => "required",
						"woo_suggest" => "image",
					),
					"additional_image_url" => array (
						'label'     => 'Additional image URL',
						"name"      => "additional_image_link",
						"feed_name" => "g:additional_image_link",
						"format"    => "optional",
					),
					"product_url_mobile" => array (
						'label'     => 'Product URL mobile',
						"name"      => "mobile_link",
						"feed_name" => "g:mobile_link", 
						"format"    => "optional",
					),
				),
			),
			"price_&_availability" => array (
				'label'      => 'Price & availability',
				'attributes' => array (
					"stock_status" => array (
						'label'       => 'Stock status',
						"name"        => "availability",
						"feed_name"   => "g:availability", 
						"format"      => "required",
						"woo_suggest" => "availability",
	            	),
					"availability_date" => array (
						'label'     => 'Availability date',
						"name"      => "availability_date",
						"feed_name" => "g:availability_date",
						"format"    => "optional",
					),
					"expiration_date" => array (
						'label'     => 'Expiration date',
						"name"      => "expiration_date",
						"feed_name" => "g:expiration_date",
						"format"    => "optional",
					),
					"price" => array (
						'label'       => 'Price',
						"name"        => "Price",
						"feed_name"   => "g:price",
						"format"      => "required",
						"woo_suggest" => "regular_price",
					),
					"sale_price" => array (
						'label'       => 'Sale price',
						"name"        => "sale_price",
						"feed_name"   => "g:sale_price",
						"format"      => "optional",
						"woo_suggest" => "sale_price",
					),
					"sale_price_effective_date" => array (
						'label'       => 'Sale price effective date',
						"name"        => "sale_price_effective_date",
						"feed_name"   => "g:sale_price_effective_date",
						"format"      => "optional",
						"woo_suggest" => "sale_price_effective_date",
					),
					"unit_pricing_measure" => array (
						'label'     => 'Unit pricing measure',
						"name"      => "unit_pricing_measure",
						"feed_name" => "g:unit_pricing_measure",
						"format"    => "optional",
					),
					"unit_pricing_base_measure" => array (
						'label'     => 'Unit pricing base measure',
						"name"      => "unit_pricing_base_measure",
						"feed_name" => "g:unit_pricing_base_measure",
						"format"    => "optional",
					),
					"cost_of_goods_sold" => array (
						'label'     => 'Cost of goods sold',
						"name"      => "cost_of_goods_sold",
						"feed_name" => "g:cost_of_goods_sold",
						"format"    => "optional",
					),
					"installment" => array (
						'label'     => 'Installment',
						"name"      => "installment",
						"feed_name" => "g:installment",
						"format"    => "optional",
					),
					"loyalty_points" => array (
						'label'     => 'Loyalty points',
						"name"      => "loyalty_points",
						"feed_name" => "g:loyalty_points",
						"format"    => "optional",
					),
				)

			),
			"product_category" => array (
				'label'        => 'Product category',
				'attributes'   => array (
					"google_product_category" => array (
						'label'       => 'Google product category',
						"name"        => "google_product_category",
						"feed_name"   => "g:google_product_category",
						"format"      => "required",
						"woo_suggest" => "categories",
					),
					"product_type" => array (
						'label'       => 'Product type',
						"name"        => "product_type",
						"feed_name"   => "g:product_type",
						"format"      => "optional",
						"woo_suggest" => "product_type",
					),
				),

			),
			"product_identifiers" => array (
				'label'      => 'Price & availability',
				'attributes' => array (
					"brand" => array (
						'label'     => 'brand',
						"name"      => "brand",
						"feed_name" => "g:brand",
						"format"    => "required",
					),
					"gtin" => array (
						'label'     => 'Gtin',
						"name"      => "gtin",
						"feed_name" => "g:gtin",
						"format"    => "required",
					),
					"mpn" => array (
						'label'     => 'MPN',
						"name"      => "mpn",
						"feed_name" => "g:mpn",
						"format"    => "required",
					),
					"identifier_exists" => array (
						'label'       => 'Identifier exists',
						"name"        => "identifier_exists",
						"feed_name"   => "g:identifier_exists",
						"woo_suggest" => "calculated",
						"format"      => "required",
					),
				)
			),
			"detailed_product_description" => array(
				'label'      => 'Detailed product description',
				'attributes' => array (
					"condition" => array(
						'label'       => 'Condition',
						"name"        => "condition",
						"feed_name"   => "g:condition",
						"format"      => "required",
						"woo_suggest" => "condition",
					),
					"adult" => array(
						'label'     => 'Adult',
						"name"      => "adult",
						"feed_name" => "g:adult",
						"format"    => "optional",
					),
					"multipack" => array(
						'label'     => 'Multipack',
						"name"      => "multipack",
						"feed_name" => "g:multipack",
						"format"    => "optional",
					),
					"is_bundle" => array(
						'label'     => 'Is bundle',
						"name"      => "is_bundle",
						"feed_name" => "g:is_bundle",
						"format"    => "optional",
					),
					"energy_efficiencyclass" => array(
						'label'     => 'Energy efficiency class',
						"name"      => "energy_efficiency_class",
						"feed_name" => "g:energy_efficiency_class",
						"format"    => "optional",
					),
					"minimum_energy_efficiency_class" => array(
						'label'     => 'Minimum energy efficiency class',
						"name"      => "min_energy_efficiency_class",
						"feed_name" => "g:min_energy_efficiency_class",
						"format"    => "optional",
					),
					"maximum_energy_efficiency_class" => array(
						'label'     => 'Maximum energy efficiency class',
						"name"      => "max_energy_efficiency_class",
						"feed_name" => "g:max_energy_efficiency_class",
						"format"    => "optional",
					),
					"age_group" => array(
						'label'     => 'Age group',
						"name"      => "age_group",
						"feed_name" => "g:age_group",
						"format"    => "optional",
					),
					"color" => array(
						'label'     => 'Color',
						"name"      => "color",
						"feed_name" => "g:color",
						"format"    => "optional",
					),
					"gender" => array(
						'label'     => 'Gender',
						"name"      => "gender",
						"feed_name" => "g:gender",
						"format"    => "optional",
					),
					"material" => array(
						'label'     => 'Material',
						"name"      => "material",
						"feed_name" => "g:material",
						"format"    => "optional",
					),
					"pattern" => array(
						'label'     => 'Pattern',
						"name"      => "pattern",
						"feed_name" => "g:pattern",
						"format"    => "optional",
					),
					"size" => array(
						'label'     => 'Size',
						"name"      => "size",
						"feed_name" => "g:size",
						"format"    => "optional",
					),
					"size_type" => array(
						'label'     => 'Size type',
						"name"      => "size_type",
						"feed_name" => "g:size_type",
						"format"    => "optional",
					),
					"size_system" => array(
						'label'     => 'Size system',
						"name"      => "size_system",
						"feed_name" => "g:size_system",
						"format"    => "optional",
					),
					"item_group_id" => array(
						'label'     => 'Item group ID',
						"name"      => "item_group_id",
						"feed_name" => "g:item_group_id",
						"format"    => "optional",
					),
				)

			),
			"shopping_campaigns" => array(
				'label'      => 'Shopping campaigns',
				'attributes' => array (
					"adwords_redirect_old" => array(
						'label'     => 'Adwords redirect (old)',
						"name"      => "adwords_redirect",
						"feed_name" => "g:adwords_redirect",
						"format"    => "optional",
					),
					"ads_redirect_new" => array(
						'label'     => 'Ads redirect (new)',
						"name"      => "ads_redirect",
						"feed_name" => "g:ads_redirect",
						"format"    => "optional",
					),
					"excluded_destination" => array(
						'label'     => 'Excluded destination',
						"name"      => "excluded_destination",
						"feed_name" => "g:excluded_destination",
						"format"    => "optional",
					),
					"custom_label_0" => array(
						'label'     => 'Custom label 0',
						"name"      => "custom_label_0",
						"feed_name" => "g:custom_label_0",
						"format"    => "optional",
					),
					"custom_label_1" => array(
						'label'     => 'Custom label 1',
						"name"      => "custom_label_1",
						"feed_name" => "g:custom_label_1",
						"format"    => "optional",
					),
					"custom_label_2" => array(
						'label'     => 'Custom label 2',
						"name"      => "custom_label_2",
						"feed_name" => "g:custom_label_2",
						"format"    => "optional",
					),
					"custom_label_3" => array(
						'label'     => 'Custom label 3',
						"name"      => "custom_label_3",
						"feed_name" => "g:custom_label_3",
						"format"    => "optional",
					),
					"custom_label_4" => array(
						'label'     => 'Custom label 4',
						"name"      => "custom_label_4",
						"feed_name" => "g:custom_label_4",
						"format"    => "optional",
					),
					"promotion_id" => array(
						'label'     => 'Promotion ID',
						"name"      => "promotion_id",
						"feed_name" => "g:promotion_id",
						"format"    => "optional",
					),
					"included_destination" => array(
						'label'     => 'Included destination',
						"name"      => "included_destination",
						"feed_name" => "included_destination",
						"format"    => "optional",
					),
					"excluded_destination" => array(
						'label'     => 'Excluded destination',
						"name"      => "excluded_destination",
						"feed_name" => "g:excluded_destination",
						"format"    => "optional",
					),
				)

			),
			"shipping" => array(
				'label'      => 'Shipping',
				'attributes' => array (
					"shipping" => array(
						'label'     => 'Shipping',
						"name"      => "shipping",
						"feed_name" => "g:shipping",
						"format"    => "optional",
					),
					"shipping_label" => array(
						'label'     => 'Shipping label',
						"name"      => "shipping_label",
						"feed_name" => "g:shipping_label",
						"format"    => "optional",
					),
					"shipping_weight" => array(
						'label'     => 'Shipping weight',
						"name"      => "shipping_weight",
						"feed_name" => "g:shipping_weight",
						"format"    => "optional",
					),
					"shipping_length" => array(
						'label'     => 'Shipping length',
						"name"      => "shipping_length",
						"feed_name" => "g:shipping_length",
						"format"    => "optional",
					),
					"shipping_width" => array(
						'label'     => 'Shipping width',
						"name"      => "shipping_width",
						"feed_name" => "g:shipping_width",
						"format"    => "optional",
					),
					"shipping_height" => array(
						'label'     => 'Shipping height',
						"name"      => "shipping_height",
						"feed_name" => "g:shipping_height",
						"format"    => "optional",
					),
					"minimum_handling_time" => array(
						'label'     => 'Minimum handling time',
						"name"      => "min_handling_time",
						"feed_name" => "g:min_handling_time",
						"format"    => "optional",
					),
					"maximum_handling_time" => array(
						'label'     => 'Maximum handling time',
						"name"      => "max_handling_time",
						"feed_name" => "g:max_handling_time",
						"format"    => "optional",
					),
				)

			),
			"tax" => array(
				'label'      => 'Tax',
				'attributes' => array (
					"tax" => array(
						'label'     => 'Tax',
						"name"      => "tax",
						"feed_name" => "g:tax",
						"format"    => "optional",
					),
					"tax_category" => array(
						'label'     => 'Tax category',
						"name"      => "tax_category",
						"feed_name" => "g:tax_category",
						"format"    => "optional",
					),
				)

			),
		);
		
		return $google_attributes;
	}

	public function custom_variable_fields( $loop, $variation_id, $variation ) {
		
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
					'id'		=> '_woogool_condition['.$loop.']',
					'label'		=> __( 'Product condition', 'woocommerce' ),
					'placeholder'	=> 'Product condition',
					'desc_tip'	=> 'true',
					'description'	=> __( 'Select the product condition.', 'woocommerce' ),
	                                'value'       	=> get_post_meta($variation->ID, '_woogool_condition', true),
	                                'wrapper_class' => 'form-row form-row-full',
					'options'	=> array (
						''		=> __( '', 'woocommerce' ),
						'new'		=> __( 'new', 'woocommerce' ),
						'refurbished'	=> __( 'refurbished', 'woocommerce' ),
						'used'		=> __( 'used', 'woocommerce' ),
						'damaged'	=> __( 'damaged', 'woocommerce' ),
					)
				)
			);

			// Exclude product from feed
			woocommerce_wp_checkbox(
				array(
					'id'		=> '_woogool_exclude_product['.$loop.']',
					'label'		=> __( '&nbsp;Exclude from feeds', 'woocommerce' ),
					'placeholder'	=> 'Exclude from feeds',
					'desc_tip'	=> 'true',
					'description'	=> __( 'Check this box if you want this product to be excluded from product feeds.', 'woocommerce' ),
	                                'value'       	=> get_post_meta($variation->ID, '_woogool_exclude_product', true),
				)
			);
		//}
	}

	/**
	 * This function add the actual fields to the edit product page for single products 
	 * identifiers GTIN, MPN, EAN, UPC, Brand and Condition
	 */
	public function custom_general_fields() {
	        global $woocommerce, $post;

		// Check if the option is enabled or not in the pluggin settings 
		//if( get_option('add_unique_identifiers') == "yes" ){

		        echo '<div id="woogool_attr" class="options_group">';

		        // Brand field
	        	woocommerce_wp_text_input(
	                	array(
	                   		'id'          => '_woogool_brand',
	             	           	'label'       => __( 'Brand', 'woocommerce' ),
	               	        	'desc_tip'    => 'true',
	                        	'value'           =>  get_post_meta( $post->ID, '_woogool_brand', true ),
	                        	'description' => __( 'Enter the product Brand here.', 'woocommerce' )
	                	)
	        	);

	        	echo '</div>';
	        	echo '<div id="woogool_attr" class="options_group show_if_simple show_if_external">';

	        	// Global Trade Item Number (GTIN) Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_gtin',
	                        	'label'       => __( 'GTIN', 'woocommerce' ),
	                        	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter the product Global Trade Item Number (GTIN) here.', 'woocommerce' ),
	                	)
	        	);

	        	// MPN Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_mpn',
	                        	'label'       => __( 'MPN', 'woocommerce' ),
	                        	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter the manufacturer product number', 'woocommerce' ),
	                	)
	        	);

	        	// Universal Product Code (UPC) Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_upc',
	                        	'label'       => __( 'UPC', 'woocommerce' ),
	                        	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter the Universal Product Code (UPC) here.', 'woocommerce' ),
	                	)
	        	);

	        	// International Article Number (EAN) Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_ean',
	                        	'label'       => __( 'EAN', 'woocommerce' ),
	                        	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter the International Article Number (EAN) here.', 'woocommerce' ),
	                	)
	        	);

	        	// Optimized product custom title Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_optimized_title',
	                        	'label'       => __( 'Optimized title', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter a optimized product title.', 'woocommerce' ),
	                	)
	        	);

			// Add product condition drop-down
			woocommerce_wp_select(
				array(
					'id'		=> '_woogool_condition',
					'label'		=> __( 'Product condition', 'woocommerce' ),
					'desc_tip'	=> 'true',
					'description'	=> __( 'Select the product condition.', 'woocommerce' ),
					'options'	=> array (
						''		=> __( '', 'woocommerce' ),
						'new'		=> __( 'new', 'woocommerce' ),
						'refurbished'	=> __( 'refurbished', 'woocommerce' ),
						'used'		=> __( 'used', 'woocommerce' ),
						'damaged'	=> __( 'damaged', 'woocommerce' ),
					)
				)
			);

	        	// Unit pricing measure Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_unit_pricing_measure',
	                        	'label'       => __( 'Unit pricing measure', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter an unit pricing measure.', 'woocommerce' ),
	                	)
	        	);

	        	// Unit pricing base measure Field
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_unit_pricing_base_measure',
	                        	'label'       => __( 'Unit pricing base measure', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter an unit pricing base measure.', 'woocommerce' ),
	                	)
	        	);

	        	// Installment months
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_installment_months',
	                        	'label'       => __( 'Installment months', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter the number of monthly installments the buyer has to pay.', 'woocommerce' ),
	                	)
	        	);

	        	// Installment amount
	        	woocommerce_wp_text_input(
	                	array(
	                        	'id'          => '_woogool_installment_amount',
	                        	'label'       => __( 'Installment amount', 'woocommerce' ),
	                       	 	'desc_tip'    => 'true',
	                        	'description' => __( 'Enter the amount the nuyer has to pay per month.', 'woocommerce' ),
	                	)
	        	);

			// Exclude product from feed
			woocommerce_wp_checkbox(
				array(
					'id'		=> '_woogool_exclude_product',
					'label'		=> __( 'Exclude from feeds', 'woocommerce' ),
					'desc_tip'	=> 'true',
					'description'	=> __( 'Check this box if you want this product to be excluded from product feeds.', 'woocommerce' ),
				)
			);

	        	echo '</div>';
		//}
	}

	/**
	 * This function saves the input from the extra fields on the single product edit page
	 */
	function save_custom_general_fields( $post_id ) {

		$woocommerce_brand                     = sanitize_text_field( $_POST['_woogool_brand'] );
		$woocommerce_gtin                      = sanitize_text_field( $_POST['_woogool_gtin'] );
		$woocommerce_upc                       = sanitize_text_field( $_POST['_woogool_upc'] );
		$woocommerce_mpn                       = sanitize_text_field( $_POST['_woogool_mpn'] );
		$woocommerce_ean                       = sanitize_text_field( $_POST['_woogool_ean'] );
		$woocommerce_title                     = sanitize_text_field( $_POST['_woogool_optimized_title'] );
		$woocommerce_unit_pricing_measure      = sanitize_text_field( $_POST['_woogool_unit_pricing_measure'] );
		$woocommerce_unit_pricing_base_measure = sanitize_text_field( $_POST['_woogool_unit_pricing_base_measure'] );
		$woocommerce_installment_months        = sanitize_text_field( $_POST['_woogool_installment_months'] );
		$woocommerce_installment_amount        = sanitize_text_field( $_POST['_woogool_installment_amount'] );
		$woocommerce_condition                 = sanitize_text_field( $_POST['_woogool_condition'] );
		
		if( !empty( $_POST['_woogool_exclude_product'] ) ){
			$woocommerce_exclude_product = sanitize_text_field( $_POST['_woogool_exclude_product'] );
		} else {
			$woocommerce_exclude_product = "no";
		}

        if( isset( $woocommerce_brand ) )
            update_post_meta( $post_id, '_woogool_brand', $woocommerce_brand );

        if( isset( $woocommerce_mpn ) )
            update_post_meta( $post_id, '_woogool_mpn', esc_attr( $woocommerce_mpn ) );

        if( isset( $woocommerce_upc ) )
            update_post_meta( $post_id, '_woogool_upc', esc_attr( $woocommerce_upc ) );

        if( isset( $woocommerce_ean ) )
            update_post_meta( $post_id, '_woogool_ean', esc_attr( $woocommerce_ean ) );

        if( isset( $woocommerce_gtin ) )
            update_post_meta( $post_id, '_woogool_gtin', esc_attr( $woocommerce_gtin ) );

        if( isset( $woocommerce_title ) )
            update_post_meta( $post_id, '_woogool_optimized_title', $woocommerce_title );

        if( isset( $woocommerce_unit_pricing_measure ) )
            update_post_meta( $post_id, '_woogool_unit_pricing_measure', $woocommerce_unit_pricing_measure );
 
        if( isset( $woocommerce_unit_pricing_base_measure ) )
            update_post_meta( $post_id, '_woogool_unit_pricing_base_measure', $woocommerce_unit_pricing_base_measure );
	 
		if( isset( $woocommerce_condition ) )
	        update_post_meta( $post_id, '_woogool_condition', $woocommerce_condition );

		if( isset( $woocommerce_installment_months ) )
	        update_post_meta( $post_id, '_woogool_installment_months', esc_attr( $woocommerce_installment_months ) );

		if( isset( $woocommerce_installment_amount ) )
	        update_post_meta( $post_id, '_woogool_installment_amount', esc_attr( $woocommerce_installment_amount ) );

		if( isset( $woocommerce_exclude_product ) )
	        update_post_meta( $post_id, '_woogool_exclude_product', esc_attr( $woocommerce_exclude_product));
	}

	/**
	 * Save the unique identifier fields for variation products
	 */
	function save_custom_variable_fields( $post_id ) {

        if (isset( $_POST['variable_sku'] ) ) {

            $variable_sku          = $_POST['variable_sku'];
            $variable_post_id      = $_POST['variable_post_id'];

            $max_loop = max( array_keys( $_POST['variable_post_id'] ) );

            for ( $i = 0; $i <= $max_loop; $i++ ) {

                if ( ! isset( $variable_post_id[ $i ] ) ) {
                  continue;
                }

                // Brand Field
                $_brand = $_POST['_woogool_variable_brand'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_brand[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_brand', stripslashes( sanitize_text_field( $_brand[$i] )));
                }


                // MPN Field
                $_mpn = $_POST['_woogool_variable_mpn'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_mpn[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_mpn', stripslashes( sanitize_text_field( $_mpn[$i] )));
                }

                // UPC Field
                $_upc = $_POST['_woogool_variable_upc'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_upc[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_upc', stripslashes( sanitize_text_field( $_upc[$i] )));
                }

                // EAN Field
                $_ean = $_POST['_woogool_variable_ean'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_ean[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_ean', stripslashes( sanitize_text_field( $_ean[$i] )));
                }

                // GTIN Field
                $_gtin = $_POST['_woogool_variable_gtin'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_gtin[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_gtin', stripslashes( sanitize_text_field( $_gtin[$i] )));
                }

                // Unit pricing measure Field
                $_pricing_measure = $_POST['_woogool_variable_unit_pricing_measure'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_pricing_measure[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_unit_pricing_measure', stripslashes( sanitize_text_field( $_pricing_measure[$i] )));
                }

                // Unit pricing base measure Field
                $_pricing_base = $_POST['_woogool_variable_unit_pricing_base_measure'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_pricing_base[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_unit_pricing_base_measure', stripslashes( sanitize_text_field( $_pricing_base[$i] )));
                }

				// Optimized title Field
                $_opttitle = $_POST['_woogool_optimized_title'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_opttitle[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_optimized_title', stripslashes( sanitize_text_field( $_opttitle[$i] )));
                }

				// Installment months Field
                $_installment_months = $_POST['_woogool_installment_months'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_installment_months[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_installment_months', stripslashes( sanitize_text_field( $_installment_months[$i] )));
                }

				// Installment amount Field
                $_installment_amount = $_POST['_woogool_installment_amount'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_installment_amount[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_installment_amount', stripslashes( sanitize_text_field( $_installment_amount[$i] )));
                }

                // Product condition Field
                $_condition = $_POST['_woogool_condition'];
                $variation_id = (int) $variable_post_id[$i];
                if ( isset( $_condition[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_condition', stripslashes( sanitize_text_field( $_condition[$i] )));
                }

                // Exclude product from feed
				if(empty($_POST['_woogool_exclude_product'])){
					$_excludeproduct[$i] = "no";
				} else {
					$_excludeproduct = $_POST['_woogool_exclude_product'];
		        } 
				
				$variation_id = (int) $variable_post_id[$i];
                
                if ( isset( $_excludeproduct[$i] ) ) {
                    update_post_meta( $variation_id, '_woogool_exclude_product', stripslashes( $_excludeproduct[$i]));
        		}
			}	
		}
	}
}





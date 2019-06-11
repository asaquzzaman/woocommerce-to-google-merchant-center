<?php
/**
 * Settings for Custom product feeds
 */
function woogool_custom_feed () {

    $customfeed = array(
    	'basic_product_data' => array ( 
    		'label' => 'Basic product data',
    		'attributes' => array ( 
				"product_id" => array(
					'label'       => 'Product ID',
					"name"        => "id",
					"feed_name"   => "id",
					"format"      => "required",
					"woogool_suggest" => "id",
				),
            	"product_title" => array(
					'label'       => 'Product title',
					"name"        => "title",
					"feed_name"   => "title",
					"format"      => "required",
					"woogool_suggest" => "title",
				),
            	"product_description" => array(
					'label'       => 'Product description',
					"name"        => "description",
					"feed_name"   => "description",
					"format"      => "required",
					"woogool_suggest" => "description",
            	),
				"product_url" => array(
					'label'       => 'Product URL',
					"name"        => "link",
					"feed_name"   => "link",
					"format"      => "required",
					"woogool_suggest" => "link",
            	),
            	"main_image_url" => array(
					'label'       => 'Main image URL',
					"name"        => "image_link",
					"feed_name"   => "image_link",
					"format"      => "required",
					"woogool_suggest" => "image",
				),
				"additional_image_url" => array(
					'label'     => 'Additional image URL',
					"name"      => "additional_image_link",
					"feed_name" => "additional_image_link",
					"format"    => "optional",
				),
				"product_url_mobile" => array(
					'label'     => 'Product URL mobile',
					"name"      => "mobile_link",
					"feed_name" => "mobile_link", 
					"format"    => "optional",
				)
			)
		),
		"price_availability" => array(
			'label' => 'Price & availability',
			'attributes' => array(
            	"stock_status" => array(
					'label'       => 'Stock status',
					"name"        => "availability",
					"feed_name"   => "availability", 
					"format"      => "optional",
					"woogool_suggest" => "availability",
            	),
				"availability_date" => array(
					'label'     => 'Availability date',
					"name"      => "availability_date",
					"feed_name" => "availability_date",
					"format"    => "optional",
				),
				"expiration_date" => array(
					'label'     => 'Expiration date',
					"name"      => "expiration_date",
					"feed_name" => "expiration_date",
					"format"    => "optional",
				),
				"price" => array(
					'label'       => 'Price',
					"name"        => "Price",
					"feed_name"   => "price",
					"format"      => "required",
					"woogool_suggest" => "price",
				),
				"sale_price" => array(
					'label'       => 'Sale price',
					"name"        => "sale_price",
					"feed_name"   => "sale_price",
					"format"      => "optional",
					"woogool_suggest" => "sale_price",
				),
				"sale_price_effective_date" => array(
					'label'     => 'Sale price effective date',
					"name"      => "sale_price_effective_date",
					"feed_name" => "sale_price_effective_date",
					"format"    => "optional",
				),
				"unit_pricing_measure" => array(
					'label'     => 'Unit pricing measure',
					"name"      => "unit_pricing_measure",
					"feed_name" => "unit_pricing_measure",
					"format"    => "optional",
				),
				"unit_pricing_base_measure" => array(
					'label'     => 'Unit pricing base measure',
					"name"      => "unit_pricing_measure",
					"feed_name" => "unit_pricing_measure",
					"format"    => "optional",
				),
				"installment" => array(
					'label'     => 'Installment',
					"name"      => "installment",
					"feed_name" => "installment",
					"format"    => "optional",
				),
				"loyalty_points" => array(
					'label'     => 'Loyalty points',
					"name"      => "loyalty_points",
					"feed_name" => "loyalty_points",
					"format"    => "optional",
				)
			)
		),
		"product_category" => array(
			'label' => 'Product category',
			'attributes' => array(
				"categories" => array(
					'label'       => 'Categories',
					"name"        => "categories",
					"feed_name"   => "categories",
					"format"      => "required",
					"woogool_suggest" => "categories",
				),
				"product_type" => array(
					'label'       => 'Product type',
					"name"        => "product_type",
					"feed_name"   => "product_type",
					"format"      => "optional",
					"woogool_suggest" => "product_type",
				)
			)
		),
		"product_identifiers" => array(
			'label' => 'Product identifiers',
			'attributes' => array(
				"brand" => array(
					'label'     => 'Brand',
					"name"      => "brand",
					"feed_name" => "brand",
					"format"    => "required",
				),
				"gtin" => array(
					'label'     => 'Gtin',
					"name"      => "gtin",
					"feed_name" => "gtin",
					"format"    => "optional",
				),
				"mpn" => array(
					'label'     => 'MPN',
					"name"      => "mpn",
					"feed_name" => "mpn",
					"format"    => "optional",
				),
			),
		),
		"detailed_product_ddescription" => array(
			'label' => 'Detailed product description',
			'attributes' => array(
				"condition" => array(
					'label'       => 'Condition',
					"name"        => "condition",
					"feed_name"   => "condition",
					"format"      => "optional",
					"woogool_suggest" => "condition",
				),
				"adult" => array(
					'label'     => 'Adult',
					"name"      => "adult",
					"feed_name" => "adult",
					"format"    => "optional",
				),
				"multipack" => array(
					'label'     => 'Multipack',
					"name"      => "multipack",
					"feed_name" => "multipack",
					"format"    => "optional",
				),
				"is_bundle" => array(
					'label'     => 'Is bundle',
					"name"      => "is_bundle",
					"feed_name" => "is_bundle",
					"format"    => "optional",
				),
				"energy_efficiency_class" => array(
					'label'     => 'Energy efficiency class',
					"name"      => "energy_efficiency_class",
					"feed_name" => "energy_efficiency_class",
					"format"    => "optional",
				),
				"age_group" => array(
					'label'     => 'Age group',
					"name"      => "age_group",
					"feed_name" => "age_group",
					"format"    => "optional",
				),
				"color" => array(
					'label'     => 'Color',
					"name"      => "color",
					"feed_name" => "color",
					"format"    => "optional",
				),
				"gender" => array(
					'label'     => 'Gender',
					"name"      => "gender",
					"feed_name" => "gender",
					"format"    => "optional",
				),
				"material" => array(
					'label'     => 'Material',
					"name"      => "material",
					"feed_name" => "material",
					"format"    => "optional",
				),
				"pattern" => array(
					'label'     => 'Pattern',
					"name"      => "pattern",
					"feed_name" => "pattern",
					"format"    => "optional",
				),
				"size" => array(
					'label'     => 'Size',
					"name"      => "size",
					"feed_name" => "size",
					"format"    => "optional",
				),
				"size_type" => array(
					'label'     => 'Size type',
					"name"      => "size_type",
					"feed_name" => "size_type",
					"format"    => "optional",
				),
				"size_system" => array(
					'label'     => 'Size system',
					"name"      => "size_system",
					"feed_name" => "size_system",
					"format"    => "optional",
				),
				"item_group_id" => array(
					'label'     => 'Item group ID',
					"name"      => "item_group_id",
					"feed_name" => "item_group_id",
					"format"    => "optional",
				),
			),
		),
		"shipping" => array(
			'label' => 'Shipping',
			'attributes' => array(
				"shipping" => array(
					'label'     => 'Shipping',
					"name"      => "shipping",
					"feed_name" => "shipping",
					"format"    => "optional",
				),
				"shipping_label" => array(
					'label'     => 'Shipping label',
					"name"      => "shipping_label",
					"feed_name" => "shipping_label",
					"format"    => "optional",
				),
				"shipping_weight" => array(
					'label'     => 'Shipping weight',
					"name"      => "shipping_weight",
					"feed_name" => "shipping_weight",
					"format"    => "optional",
				),
				"shipping_length" => array(
					'label'     => 'Shipping length',
					"name"      => "shipping_length",
					"feed_name" => "shipping_length",
					"format"    => "optional",
				),
				"shipping_width" => array(
					'label'     => 'Shipping width',
					"name"      => "shipping_width",
					"feed_name" => "shipping_width",
					"format"    => "optional",
				),
				"shipping_height" => array(
					'label'     => 'Shipping height',
					"name"      => "shipping_height",
					"feed_name" => "shipping_height",
					"format"    => "optional",
				),
			),
		),
		"tax" => array(
			'label' => 'Tax',
			'attributes' => array(
				"tax" => array(
					'label'     => 'Tax',
					"name"      => "tax",
					"feed_name" => "tax",
					"format"    => "optional",
				),
			)
		),
	);

	return $customfeed;
	
}
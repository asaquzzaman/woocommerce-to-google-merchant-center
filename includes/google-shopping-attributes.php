<?php

function woogool_shopping_attributes () {
    $google_attributes = array (
		"basic_product_data" => array (
			'label' => 'Basic product data',
			'attributes' => array (
				"product_id" => array (
					'label'       => 'Product ID',
					"name"        => "id",
					"feed_name"   => "g:id",
					"format"      => "required",
					"woogool_suggest" => "id",
				),
            	"product_title" => array (
            		'label'       => 'Product title',
					"name"        => "title",
					"feed_name"   => "g:title",
					"format"      => "required",
					"woogool_suggest" => "title",
				),
            	"product_description" => array (
            		'label'       => 'Product description',
					"name"        => "description",
					"feed_name"   => "g:description",
					"format"      => "required",
					"woogool_suggest" => "description",
            	),
				"product_url" => array (
					'label'       => 'Product URL',
					"name"        => "link",
					"feed_name"   => "g:link",
					"format"      => "required",
					"woogool_suggest" => "link",
            	),
            	"main_image_url" => array (
            		'label'       => 'Main image UR',
					"name"        => "image_link",
					"feed_name"   => "g:image_link",
					"format"      => "required",
					"woogool_suggest" => "image",
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
					"woogool_suggest" => "availability",
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
					"woogool_suggest" => "regular_price",
				),
				"sale_price" => array (
					'label'       => 'Sale price',
					"name"        => "sale_price",
					"feed_name"   => "g:sale_price",
					"format"      => "optional",
					"woogool_suggest" => "sale_price",
				),
				"sale_price_effective_date" => array (
					'label'       => 'Sale price effective date',
					"name"        => "sale_price_effective_date",
					"feed_name"   => "g:sale_price_effective_date",
					"format"      => "optional",
					"woogool_suggest" => "sale_price_effective_date",
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
					"woogool_suggest" => "categories",
				),
				"product_type" => array (
					'label'       => 'Product type',
					"name"        => "product_type",
					"feed_name"   => "g:product_type",
					"format"      => "optional",
					"woogool_suggest" => "product_type",
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
					"woogool_suggest" => "_woogool_brand",
				),
				"gtin" => array (
					'label'     => 'Gtin',
					"name"      => "gtin",
					"feed_name" => "g:gtin",
					"format"    => "required",
					"woogool_suggest" => "_woogool_gtin",
				),
				"mpn" => array (
					'label'     => 'MPN',
					"name"      => "mpn",
					"feed_name" => "g:mpn",
					"format"    => "required",
					"woogool_suggest" => "_woogool_mpn",
				),
				"identifier_exists" => array (
					'label'       => 'Identifier exists',
					"name"        => "identifier_exists",
					"feed_name"   => "g:identifier_exists",
					"woogool_suggest" => "woogool_get_product_identifier_exists",
					"format"      => "optional",
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
					"woogool_suggest" => "_woogool_condition",
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
			'label'      => 'Shopping campaigns and other configurations',
			'attributes' => array (
				"ads_redirect_new" => array(
					'label'     => 'Ads redirect',
					"name"      => "ads_redirect",
					"feed_name" => "g:ads_redirect",
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
			)

		),
		"destinations" => array(
			'label'      => 'Destinations',
			'attributes' => array (
				"excluded_destination" => array(
					'label'     => 'Excluded destination',
					"name"      => "excluded_destination",
					"feed_name" => "g:excluded_destination",
					"format"    => "optional",
				),
				"included_destination" => array(
					'label'     => 'Included destination',
					"name"      => "included_destination",
					"feed_name" => "g:included_destination",
					"format"    => "optional",
				)
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
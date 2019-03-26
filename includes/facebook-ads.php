<?php
function woogool_get_facebook_ad_attributes() {

    $facebook_ad_attributes = array(
		"remarketing_fields" => array(
			'label' => "Remarketing fields",
			'attributes' => array(
				"id" => array(
					'label'  => 'Product ID',
					"name" => "id",
					"feed_name" => "g:id",
					"format" => "required",
					"woogool_suggest" => "id",
				),
				"override" => array(
					"name" => "override",
					"feed_name" => "g:override",
					"format" => "optional",
				),
				"availability" => array(
					'label'       => 'Stock status',
					"name" => "availability",
					"feed_name" => "g:availability",
					"format" => "required",
					"woogool_suggest" => "availability",
				),
				"condition" => array(
					'label'       => 'Condition',
					"name" => "condition",
					"feed_name" => "g:condition",
					"format" => "required",
					"woogool_suggest" => "_woogool_condition",
				),
				"description" => array(
					'label'       => 'Product description',
					"name" => "description",
					"feed_name" => "g:description",
					"format" => "required",
					"woogool_suggest" => "description",
				),
				"image_link" => array(
					'label'       => 'Main image UR',
					"name" => "image_link",
					"feed_name" => "g:image_link",
					"format" => "required",
					"woogool_suggest" => "image",
				),
				"link" => array(
					'label'       => 'Product URL',
					"name" => "link",
					"feed_name" => "g:link",
					"format" => "required",
					"woogool_suggest" => "link",
				),
				"title" => array(
					'label'       => 'Product title',
					"name" => "title",
					"feed_name" => "g:title",
					"format" => "required",
					"woogool_suggest" => "title",
				),
				"price" => array(
					'label'       => 'Price',
					"name" => "price",
					"feed_name" => "g:price",
					"format" => "required",
					"woogool_suggest" => "regular_price",
				),
				"gtin" => array(
					'label'     => 'Gtin',
					"name" => "gtin",
					"feed_name" => "g:gtin",
					"format" => "optional",
				),
				"mpn" => array(
					'label'     => 'MPN',
					"name" => "mpn",
					"feed_name" => "g:mpn",
					"format" => "optional",
				),
				"brand" => array(
					'label'     => 'brand',
					"name" => "brand",
					"feed_name" => "g:brand",
					"format" => "required",
				),
				"additional_image_link" => array(
					'label'     => 'Additional image URL',
					"name" => "additional_image_link",
					"feed_name" => "g:additional_image_link",
					"format" => "optional",
				),
				"age_group" => array(
					'label'     => 'Age group',
					"name" => "age_group",
					"feed_name" => "g:age_group",
					"format" => "optional",
				),
				"color" => array(
					'label'     => 'Color',
					"name" => "color",
					"feed_name" => "g:color",
					"format" => "optional",
				),
				"expiration_date" => array(
					'label'     => 'Expiration date',
					"name" => "expiration_date",
					"feed_name" => "g:expiration_date",
					"format" => "optional",
				),
				"gender" => array(
					'label'     => 'Gender',
					"name" => "gender",
					"feed_name" => "g:gender",
					"format" => "optional",
				),
				"item_group_id" => array(
					'label'     => 'Item group ID',
					"name" => "item_group_id",
					"feed_name" => "g:item_group_id",
					"format" => "optional",
					"woogool_suggest" => "item_group_id",
				),
				"google_product_category" => array(
					'label'       => 'Google product category',
					"name" => "google_product_category",
					"feed_name" => "g:google_product_category",
					"format" => "optional",
				),
				"material" => array(
					'label'     => 'Material',
					"name" => "material",
					"feed_name" => "g:material",
					"format" => "optional",
				),
				"pattern" => array(
					'label'     => 'Pattern',
					"name" => "pattern",
					"feed_name" => "g:pattern",
					"format" => "optional",
				),
				"product_type" => array(
					'label'       => 'Product type',
					"name" => "product_type",
					"feed_name" => "g:product_type",
					"format" => "optional",
					"woogool_suggest" => "categories",
				),
				"sale_price" => array(
					'label'       => 'Sale price',
					"name" => "sale_price",
					"feed_name" => "g:sale_price",
					"format" => "optional",
					"woogool_suggest" => "sale_price",
				),
				"sale_price_effective_date" => array(
					'label'       => 'Sale price effective date',
					"name" => "sale_price_effective_date",
					"feed_name" => "g:sale_price_effective_date",
					"format" => "optional",
				),
				"shipping" => array(
					'label'     => 'Shipping',
					"name" => "shipping",
					"feed_name" => "g:shipping",
					"format" => "optional",
				),
				"country" => array(
					"name" => "country",
					"feed_name" => "g:country",
					"format" => "optional",
				),
				"shipping_weight" => array(
					'label'     => 'Shipping weight',
					"name" => "shipping_weight",
					"feed_name" => "g:shipping_weight",
					"format" => "optional",
				),
				"size" => array(
					'label'     => 'Size',
					"name" => "size",
					"feed_name" => "g:size",
					"format" => "optional",
				),
				"shipping_size" => array(
					"name" => "shipping_size",
					"feed_name" => "g:shipping_size",
					"format" => "optional",
				),
				"custom_label_0" => array(
					'label'     => 'Custom label 0',
					"name" => "custom_label_0",
					"feed_name" => "g:custom_label_0",
					"format" => "optional",
				),
				"custom_label_1" => array(
					'label'     => 'Custom label 1',
					"name" => "custom_label_1",
					"feed_name" => "g:custom_label_1",
					"format" => "optional",
				),
				"custom_label_2" => array(
					'label'     => 'Custom label 2',
					"name" => "custom_label_2",
					"feed_name" => "g:custom_label_2",
					"format" => "optional",
				),

				"custom_label_3" => array(
					'label'     => 'Custom label 3',
					"name" => "custom_label_3",
					"feed_name" => "g:custom_label_3",
					"format" => "optional",
				),
				"custom_label_4" => array(
					'label'     => 'Custom label 4',
					"name" => "custom_label_4",
					"feed_name" => "g:custom_label_4",
					"format" => "optional",
				),
				"identifier_exists" => array (
					'label'       => 'Identifier exists',
					"name"        => "identifier_exists",
					"feed_name"   => "g:identifier_exists",
					"woogool_suggest" => "woogool_get_product_identifier_exists",
					"format"      => "optional",
				),
			),
		),
	);
	return $facebook_ad_attributes;
}


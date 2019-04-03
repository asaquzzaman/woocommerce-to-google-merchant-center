<?php
/**
 * Settings for Bing Shopping product feeds
 */

function woogool_bing_shopping_attributes() {

               
    return array(
		"required_fields" => array(
			'label' => 'Required fields',
			'attributes' => array(
				"id" => array(
					'label'       => 'id',
					"name"        => "id",
					"feed_name"   => "id",
					"format"      => "required",
					"woogool_suggest" => "id",
				),
	        	"title" => array(
	        		'label'       => 'Title',
					"name"        => "title",
					"feed_name"   => "title",
					"format"      => "required",
					"woogool_suggest" => "title",
				),
				"link" => array(
					'label'       => 'Link',
					"name"        => "link",
					"feed_name"   => "link",
					"format"      => "required",
					"woogool_suggest" => "link",
	        	),
	        	"price" => array(
	        		'label'       => 'Price',
					"name"        => "price",
					"feed_name"   => "price",
					"format"      => "required",
					"woogool_suggest" => "price",
				),
				"description" => array(
					'label'       => 'Description',
					"name"        => "description",
					"feed_name"   => "description",
					"format"      => "required",
					"woogool_suggest" => "description",
				),
				"image_link" => array(
					'label'       => 'Image Link',
					"name"        => "image_link",
					"feed_name"   => "image_link", 
					"format"      => "required",
					"woogool_suggest" => "image",
				),
				"shipping" => array(
					'label'     => 'Shipping',
					"name"      => "shipping",
					"feed_name" => "shipping", 
					"format"    => "required",
				)
			)
		),
		"item_identification" => array(
			'label' => "Item identification",
			'attributes' => array(
	        	"mpn" => array(
	        		'label'     => 'MPN',
					"name"      => "mpn",
					"feed_name" => "mpn", 
					"format"    => "optional",
					"woogool_suggest" => "title",
	        	),
				"gtin" => array(
					'label'     => 'GTIN',
					"name"      => "gtin",
					"feed_name" => "gtin",
					"format"    => "optional",
				),
				"brand" => array(
					'label'     => 'Brand',
					"name"      => "brand",
					"feed_name" => "brand",
					"format"    => "optional",
				)
			)
		),
		"apparal_products" => array(
			'label' => "Apparal products",
			'attributes' => array( 
				"gender" => array(
					'label'     => 'Gender',
					"name"      => "gender",
					"feed_name" => "gender",
					"format"    => "optional",
				),
				"age_group" => array(
					'label'     => 'Age Group',
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
				"size" => array(
					'label'     => 'Size',
					"name"      => "size",
					"feed_name" => "size",
					"format"    => "optional",
				)
			)
		),
		"product_variants" => array(
			'label' => "Product variants",
			'attributes' => array(
				"item_group_id" => array(
					'label'       => 'Item Group id',
					"name"        => "item_group_id",
					"feed_name"   => "item_group_id",
					"format"      => "optional",
					"woogool_suggest" => "item_group_id",
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
				)
			)
		),
		"other" => array(
			'label' => "Other",
			'attributes' => array(
				"adult" => array(
					'label'     => 'Adult',
					"name"      => "adult",
					"feed_name" => "adult",
					"format"    => "optional",
				),
				"availability" => array(
					'label'     => 'Availability',
					"name"      => "availability",
					"feed_name" => "availability",
					"format"    => "optional",
				),
				"product_category" => array(
					'label'     => 'Product Category',
					"name"      => "product_category",
					"feed_name" => "product_category",
					"format"    => "optional",
				),
				"condition" => array(
					'label'     => 'Condition',
					"name"      => "condition",
					"feed_name" => "condition",
					"format"    => "optional",
				),
				"expiration_date" => array(
					'label'     => 'Expiratrion Date',
					"name"      => "expiration_date",
					"feed_name" => "expiration_date",
					"format"    => "optional",
				),
				"multipack" => array(
					'label'     => 'Multipack',
					"name"      => "multipack",
					"feed_name" => "multipack",
					"format"    => "optional",
				),
				"product_type" => array(
					'label'     => 'Product Type',
					"name"      => "product_type",
					"feed_name" => "product_type",
					"format"    => "optional",
				),
				"mobile_link" => array(
					'label'     => 'Mobile Link',
					"name"      => "mobile_link",
					"feed_name" => "mobile_link",
					"format"    => "optional",
				)
			)
		),
		"bing_attributes" => array(
			'label' => "Bing attributes",
			'attributes' => array(
				"seller_name" => array(
					'label'     => 'Seller Name',
					"name"      => "seller_name",
					"feed_name" => "seller_name",
					"format"    => "optional",
				),
				"bingads_grouping" => array(
					'label'     => 'Bingads Grouping',
					"name"      => "bingads_grouping",
					"feed_name" => "bingads_grouping",
					"format"    => "optional",
				),
				"bingads_label" => array(
					'label'     => 'Bingads Label',
					"name"      => "bingads_label",
					"feed_name" => "bingads_label",
					"format"    => "optional",
				),
				"bingads_redirect" => array(
					'label'     => 'Bingads Redirect',
					"name"      => "bingads_redirect",
					"feed_name" => "bingads_redirect",
					"format"    => "optional",
				),
				"custom_label_0" => array(
					'label'     => 'Custom Label 0',
					"name"      => "custom_label_0",
					"feed_name" => "custom_label_0",
					"format"    => "optional",
				),
				"custom_label_1" => array(
					'label'     => 'Custom Label 1',
					"name"      => "custom_label_1",
					"feed_name" => "custom_label_1",
					"format"    => "optional",
				),
				"custom_label_2" => array(
					'label'     => 'Custom Label 2',
					"name"      => "custom_label_2",
					"feed_name" => "custom_label_2",
					"format"    => "optional",
				),
				"custom_label_3" => array(
					'label'     => 'Custom Label 3',
					"name"      => "custom_label_3",
					"feed_name" => "custom_label_3",
					"format"    => "optional",
				),
				"custom_label_4" => array(
					'label'     => 'Custom Label 4',
					"name"      => "custom_label_4",
					"feed_name" => "custom_label_4",
					"format"    => "optional",
				)
			)
		),
		"sales_and_promotions" => array(
			'label' => "Sales and promotions",
			'attributes' => array(
				"sale_price" => array(
					'label'     => 'Sale Price',
					"name"      => "sale_price",
					"feed_name" => "sale_price",
					"format"    => "optional",
				),
				"sale_price_effective_date" => array(
					'label'     => 'Sale Price Effective Date',
					"name"      => "sale_price_effective_date",
					"feed_name" => "sale_price_effective_date",
					"format"    => "optional",
				),
				"promotion_ID" => array(
					'label'     => 'Promotion ID',
					"name"      => "promotion_ID",
					"feed_name" => "promotion_ID",
					"format"    => "optional",
				)
			)
		),
	);
}

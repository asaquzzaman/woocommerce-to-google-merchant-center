<?php
/**
 * Settings for Daisycon huis & tuin feeds
 */

function woogool_daisyconhuisentuin_attributes() {
     
    $daisyconhuisentuin = array(
		"Feed_fields" => array(
			'label' => 'Feed fields',
			'attributes' => array(
				"description" => array(
					'label'           => 'Description',
					"name"            => "description",
					"feed_name"       => "description",
					"format"          => "required",
					"woogool_suggest" => "description",
				),
	            "link" => array(
					'label'           => 'Link',
					"name"            => "link",
					"feed_name"       => "link",
					"format"          => "required",
					"woogool_suggest" => "link",
	            ),	
				"price" => array(
					'label'           => 'Price',
					"name"            => "price",
					"feed_name"       => "price",
					"format"          => "required",
					"woogool_suggest" => "price",
				),
				"sku" => array(
					'label'           => 'SKU',
					"name"            => "sku",
					"feed_name"       => "sku",
					"format"          => "required",
					"woogool_suggest" => "sku",
				),
				"title" => array(
					'label'           => 'Title',
					"name"            => "title",
					"feed_name"       => "title",
					"format"          => "required",
					"woogool_suggest" => "title",
				),
				"additional_costs" => array(
					'label'     => 'Additional Costs',
					"name"      => "additional_costs",
					"feed_name" => "additional_costs",
					"format"    => "optional",
				),
				"brand" => array(
					'label'     => 'Brand',
					"name"      => "brand",
					"feed_name" => "brand",
					"format"    => "optional",
				),
				"brand_logo" => array(
					'label'     => 'Brand Logo',
					"name"      => "brand_logo",
					"feed_name" => "brand_log",
					"format"    => "optional",
				),
				"category" => array(
					'label'     => 'Category',
					"name"      => "category",
					"feed_name" => "category",
					"format"    => "optional",
				),
				"category_path" => array(
					'label'           => 'Category Path',
					"name"            => "category_path",
					"feed_name"       => "category_path",
					"format"          => "optional",
					"woogool_suggest" => "category_path",
				),
				"color_primary" => array(
					'label'     => 'Color Primary',
					"name"      => "color_primary",
					"feed_name" => "color_primary",
					"format"    => "optional",
				),
				"condition" => array(
					'label'           => 'Condition',
					"name"            => "condition",
					"feed_name"       => "condition",
					"format"          => "optional",
					"woogool_suggest" => "condition",
				),
				"delivery_description" => array(
					'label'     => 'Delivery Description',
					"name"      => "delivery_description",
					"feed_name" => "delivery_description",
					"format"    => "optional",
				),
				"delivery_time" => array(
					'label'     => 'Delivery Time',
					"name"      => "delivery_time",
					"feed_name" => "delivery_time",
					"format"    => "optional",
				),
				"designer" => array(
					'label'     => 'Designer',
					"name"      => "designer",
					"feed_name" => "designer",
					"format"    => "optional",
				),
				"ean" => array(
					'label'     => 'EAN',
					"name"      => "ean",
					"feed_name" => "ean",
					"format"    => "optional",
				),
				"gender_target" => array(
					'label'     => 'Gender Target',
					"name"      => "gender_target",
					"feed_name" => "gender_target",
					"format"    => "optional",
				),
				"google_category_id" => array(
					'label'           => 'Google Category ID',
					"name"            => "google_category_id",
					"feed_name"       => "google_category_id",
					"format"          => "optional",
					"woogool_suggest" => "category",
				),
				"in_stock" => array(
					'label'           => 'In Stock',
					"name"            => "in_stock",
					"feed_name"       => "in_stock",
					"format"          => "optional",
					"woogool_suggest" => "stock",
				),
				"in_stock_amount" => array(
					'label'     => 'In Stock Amount',
					"name"      => "in_stock_amount",
					"feed_name" => "in_stock_amount",
					"format"    => "optional",
				),
				"keywords" => array(
					'label'     => 'Keywords',
					"name"      => "keywords",
					"feed_name" => "keywords",
					"format"    => "optional",
				),
				"made_in_country" => array(
					'label'     => 'Made In Country',
					"name"      => "made_in_country",
					"feed_name" => "made_in_country",
					"format"    => "optional",
				),
				"material_1" => array(
					'label'     => 'Material 1',
					"name"      => "material_1",
					"feed_name" => "material_1",
					"format"    => "optional",
				),
				"material_2" => array(
					'label'     => 'Material 2',
					"name"      => "material_2",
					"feed_name" => "material_2",
					"format"    => "optional",
				),
				"material_3" => array(
					'label'     => 'Material 3',
					"name"      => "material_3",
					"feed_name" => "material_3",
					"format"    => "optional",
				),
				"model" => array(
					'label'     => 'Model',
					"name"      => "model",
					"feed_name" => "model",
					"format"    => "optional",
				),
				"price_old" => array(
					'label'     => 'Price Old',
					"name"      => "price_old",
					"feed_name" => "price_old",
					"format"    => "optional",
				),
				"price_shipping" => array(
					'label'     => 'Price Shipping',
					"name"      => "price_shipping",
					"feed_name" => "price_shipping",
					"format"    => "optional",
				),
				"priority" => array(
					'label'     => 'Priority',
					"name"      => "priority",
					"feed_name" => "priority",
					"format"    => "optional",
				),
				"size" => array(
					'label'     => 'Size',
					"name"      => "size",
					"feed_name" => "size",
					"format"    => "optional",
				),
				"size_description" => array(
					'label'     => 'Size Description',
					"name"      => "size_description",
					"feed_name" => "size_description",
					"format"    => "optional",
				),
				"size_length" => array(
					'label'     => 'Size Length',
					"name"      => "size_length",
					"feed_name" => "size_length",
					"format"    => "optional",
				),
				"size_width" => array(
					'label'     => 'Size Width',
					"name"      => "size_width",
					"feed_name" => "size_width",
					"format"    => "optional",
				),
				"terms_condition" => array(
					'label'     => 'Terms Condition',
					"name"      => "terms_condition",
					"feed_name" => "terms_condition",
					"format"    => "optional",
				),
				"weight" => array(
					'label'     => 'Weight',
					"name"      => "weight",
					"feed_name" => "weight",
					"format"    => "optional",
				),
				"image_link_1" => array(
					'label'     => 'Image Link 1',
					"name"      => "image_link_1",
					"feed_name" => "image_link_1",
					"format"    => "optional",
				),
				"image_link_2" => array(
					'label'     => 'Image Link 2',
					"name"      => "image_link_2",
					"feed_name" => "image_link_2",
					"format"    => "optional",
				),
				"image_link_3" => array(
					'label'     => 'Image Link 3',
					"name"      => "image_link_3",
					"feed_name" => "image_link_3",
					"format"    => "optional",
				),
				"image_link_4" => array(
					'label'     => 'Image Link 4',
					"name"      => "image_link_4",
					"feed_name" => "image_link_4",
					"format"    => "optional",
				),
				"image_link_5" => array(
					'label'     => 'Image Link 5',
					"name"      => "image_link_5",
					"feed_name" => "image_link_5",
					"format"    => "optional",
				),
				"image_link_6" => array(
					'label'     => 'Image Link 6',
					"name"      => "image_link_6",
					"feed_name" => "image_link_6",
					"format"    => "optional",
				),
				"image_link_7" => array(
					'label'     => 'Image Link 7',
					"name"      => "image_link_7",
					"feed_name" => "image_link_7",
					"format"    => "optional",
				),
				"image_link_8" => array(
					'label'     => 'Image Link 8',
					"name"      => "image_link_8",
					"feed_name" => "image_link_8",
					"format"    => "optional",
				),
				"image_link_9" => array(
					'label'     => 'Image Link 9',
					"name"      => "image_link_9",
					"feed_name" => "image_link_9",
					"format"    => "optional",
				),
			),
		),
	);
	return $daisyconhuisentuin;
}

?>

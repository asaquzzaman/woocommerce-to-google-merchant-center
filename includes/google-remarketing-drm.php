<?php

function woogool_google_remarketing_drm_attributes() {
    $google_drm = array(
    	"remarketing_fields" => array(
    		'label' => "Remarketing Fields",
    		'attributes' => array(
				"ID" => array(
					'label' => 'ID',
					"name" => "ID",
					"feed_name" => "ID",
					"format" => "required",
					"woogool_suggest" => "id",
				),
				"ID2" => array(
					'label' => 'ID2',
					"name" => "ID2",
					"feed_name" => "ID2",
					"format" => "optional",
				),
				"item_title" => array(
					'label' => 'Item title',
					"name" => "Item title",
					"feed_name" => "Item title",
					"format" => "required",
					"woogool_suggest" => "title",
				),
				"item_subtitle" => array(
					'label' => 'Item subtitle',
					"name" => "Item subtitle",
					"feed_name" => "Item subtitle",
					"format" => "optional",
				),
				"final_url" => array(
					'label' => 'Final URL',
					"name" => "Final URL",
					"feed_name" => "Final URL",
					"format" => "required",
					"woogool_suggest" => "link",
				),
				"image_url" => array(
					'label' => 'Image URL',
					"name" => "Image URL",
					"feed_name" => "Image URL",
					"format" => "optional",
					"woogool_suggest" => "image_link",
				),
				"item_description" => array(
					'label' => 'Item Description',
					"name" => "Item description",
					"feed_name" => "Item description",
					"format" => "optional",
					"woogool_suggest" => "description",
				),
				"item_category" => array(
					'label' => 'Item Category',
					"name" => "Item category",
					"feed_name" => "Item category",
					"format" => "optional",
					"woogool_suggest" => "categories",
				),
				"price" => array(
					'label' => 'Price',
					"name" => "Price",
					"feed_name" => "Price",
					"format" => "optional",
					"woogool_suggest" => "price",
				),
				"sale_price" => array(
					'label' => 'Sale price',
					"name" => "Sale price",
					"feed_name" => "Sale price",
					"format" => "optional",
					"woogool_suggest" => "sale_price",
				),
				"contextual_keywords" => array(
					'label' => 'Contextual Keywords',
					"name" => "Contextual keywords",
					"feed_name" => "Contextual keywords",
					"format" => "optional",
				),
				"item_address" => array(
					'label' => 'Item address',
					"name" => "Item address",
					"feed_name" => "Item address",
					"format" => "optional",
				),
				"tracking_template" => array(
					'label' => 'Tracking template',
					"name" => "Tracking template",
					"feed_name" => "Tracking template",
					"format" => "optional",
				),
				"custom_parameter" => array(
					'label' => 'Custom parameter',
					"name" => "Custom parameter",
					"feed_name" => "Custom parameter",
					"format" => "optional",
				),
                "item_group_id" => array(
                	'label' => 'Item group ID',
                    "name" => "item_group_id",
                    "feed_name" => "g:item_group_id",
                    "format" => "optional",
                ),
				
			)
		)
	);
	
	return $google_drm;
}
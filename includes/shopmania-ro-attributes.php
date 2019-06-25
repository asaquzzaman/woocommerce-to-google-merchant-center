<?php
/**
 * Settings for Shopmania Romania feeds
 */

function woogool_shopmania_attributes() {

	$shopmania_ro = array(
		"Feed_fields" => array(
			'label' => 'Feed fields',
			'attributes' => array(
			    "MPC" => array(
			    	'label' => 'MPC',
		            "name" => "MPC",
		            "feed_name" => "MPC",
		            "format" => "required",
		            "woogool_suggest" => "id",
			    ),
				"Category" => array(
					'label' => 'Category',
					"name" => "Category",
					"feed_name" => "Category",
					"format" => "required",
					"woogool_suggest" => "categories",
				),
				"Manufacturer" => array(
					'label' => 'Manufacturer',
					"name" => "Manufacturer",
					"feed_name" => "Manufacturer",
					"format" => "required",
				),
				"MPN" => array(
					'label' => 'MPN',
					"name" => "MPN",
					"feed_name" => "MPN",
					"format" => "required",
				),
				"Name" => array(
					'label' => 'Name',
					"name" => "Name",
					"feed_name" => "Name",
					"format" => "required",
					"woogool_suggest" => "title",
				),
			    "Description" => array(
			    	'label' => 'Description',
			            "name" => "Description",
			            "feed_name" => "Description",
			            "format" => "optional",
			            "woogool_suggest" => "description",
			    ),
				"URL" => array(
					'label' => 'URL',
					"name" => "URL",
					"feed_name" => "URL",
					"format" => "required",
					"woogool_suggest" => "link",
				),
				"Image" => array(
					'label' => 'Image',
					"name" => "Image",
					"feed_name" => "Image",
					"format" => "required",
					"woogool_suggest" => "image",
				),
				"Price" => array(
					'label' => 'Price',
					"name" => "Price",
					"feed_name" => "Price",
					"format" => "required",
					"woogool_suggest" => "price",
				),
				"Currency" => array(
					'label' => 'Currency',
					"name" => "Currency",
					"feed_name" => "Currency",
					"format" => "required",
				),
				"Shipping" => array(
					'label' => 'Shipping',
					"name" => "Shipping",
					"feed_name" => "Shipping",
					"format" => "required",
				),
				"Availability" => array(
					'label' => 'Availability',
					"name" => "Availability",
					"feed_name" => "Availability",
					"format" => "required",
			        "woogool_suggest" => "availability",
				),
				"GTIN" => array(
					'label' => 'GTIN',
					"name" => "GTIN",
					"feed_name" => "GTIN",
					"format" => "required",
				),

			),
		),
	);
	return $shopmania_ro;
}

?>

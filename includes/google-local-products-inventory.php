<?php
/**
 * Settings for Google Local Product Inventory feeds
 */

function woogool_google_local_product_inventory_attributes() {

	$google_local_inventory = array(
		"local_product_inventory_fields" => array(
			'label' => "Local product inventory fields",
			'attributes' => array(
				"store_code" => array(
					'label'     => 'Store code',
					"name"      => "Store code",
					"feed_name" => "store code",
					"format"    => "required",
				),
				"item_id" => array(
					'label'          => 'Item id',
					"name"           => "Itemid",
					"feed_name"      => "itemid",
					"format"         => "required",
					"woogoo_suggest" => "id",
				),
				"quantity" => array(
					'label'           => 'Quantity',
					"name"            => "Quantity",
					"feed_name"       => "quantity",
					"format"          => "required",
					"woogool_suggest" => "quantity",
				),
				"price" => array(
					'label'           => 'Price',
					"name"            => "Price",
					"feed_name"       => "price",
					"format"          => "required",
					"woogool_suggest" => "price",
				),
				"sale_price" => array(
					'label'           => 'Sale price',
					"name"            => "Sale price",
					"feed_name"       => "Sale price",
					"format"          => "optional",
					"woogool_suggest" => "sale_price",
				),
		        "sale_price_effective_date" => array(
					'label'           => 'Sale price effective date',
					"name"            => "Sale price effective date",
					"feed_name"       => "sale price effective date",
					"format"          => "optional",
					"woogool_suggest" => "sale_price_effective_date",
		        ),
		        "availability" => array(
					'label'           => 'Availability',
					"name"            => "Availability",
					"feed_name"       => "availability",
					"format"          => "optional",
					"woogool_suggest" => "availability",
		        ),
		        "weeks_of_supply" => array(
					'label'     => 'Weeks of supply',
					"name"      => "Weeks of supply",
					"feed_name" => "weeks of supply",
					"format"    => "optional",
		        ),
		        "pickup_method" => array(
					'label'     => 'Pickup method',
					"name"      => "Pickup method",
					"feed_name" => "pickup method",
					"format"    => "optional",
		        ),
		        "pickup_sla" => array(
					'label'     => 'Pickup sla',
					"name"      => "Pickup sla",
					"feed_name" => "pickup sla",
					"format"    => "optional",
		        ),
	    	),
	    ),
	);
	
	return $google_local_inventory;
}


<?php
/**
 * Settings for Compari Romania feeds
 */
function woogoo_compari_ro_attributes() {
 
    $compari_ro = array(
		"Feed_fields" => array(
		    'label' => "Feed fields",
		    'attributes' => array(
	            "productid" => array(
					'label'           => 'Productid',
					"name"            => "productid",
					"feed_name"       => "productid",
					"format"          => "required",
					"woogool_suggest" => "id",
	            ),
				"manufacturer" => array(
					'label'     => 'Manufacturer',
					"name"      => "manufacturer",
					"feed_name" => "manufacturer",
					"format"    => "required",
				),
				"name" => array(
					'label'           => 'Name',
					"name"            => "name",
					"feed_name"       => "name",
					"format"          => "required",
					"woogool_suggest" => "title",
				),
				"category" => array(
					'label'           => 'Category',
					"name"            => "category",
					"feed_name"       => "category",
					"format"          => "required",
					"woogool_suggest" => "categories",
				),
				"product_url" => array(
					'label'           => 'Product URL',
					"name"            => "product_url",
					"feed_name"       => "product_url",
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
				"identifier" => array(
					'label'     => 'Identifier',
					"name"      => "identifier",
					"feed_name" => "identifier",
					"format"    => "required",
				),
	    		"image_url" => array(
					'label'           => 'Image URL',
					"name"            => "image_url",
					"feed_name"       => "image_url",
					"format"          => "optional",
					"woogool_suggest" => "image",
				),
	    		"image_url_2" => array(
					'label'     => 'Image URL 2',
					"name"      => "image_url_2",
					"feed_name" => "image_url_2",
					"format"    => "optional",
				),
	    		"image_url_3" => array(
					'label'     => 'Image URL 3',
					"name"      => "image_url_3",
					"feed_name" => "image_url_3",
					"format"    => "optional",
				),
	            "description" => array(
					'label'           => 'Description',
					"name"            => "description",
					"feed_name"       => "description",
					"format"          => "optional",
					"woogool_suggest" => "description",
	            ),
	            "delivery_time" => array(
					'label'     => 'Delivery Time',
					"name"      => "delivery_time",
					"feed_name" => "delivery_time",
					"format"    => "optional",
	            ),
	            "delivery_cost" => array(
					'label'     => 'Delivery Cost',
					"name"      => "delivery_cost",
					"feed_name" => "delivery_cost",
					"format"    => "optional",
	            ),
	            "EAN_code" => array(
					'label'     => 'EAN Code',
					"name"      => "EAN_code",
					"feed_name" => "EAN_code",
					"format"    => "optional",
				),
	            "net_price" => array(
					'label'     => 'Net Price',
					"name"      => "net_price",
					"feed_name" => "net_price",
					"format"    => "optional",
	            ),
	            "color" => array(
					'label'     => 'Color',
					"name"      => "color",
					"feed_name" => "color",
					"format"    => "optional",
	            ),
	            "size" => array(
					'label'     => 'size',
					"name"      => "size",
					"feed_name" => "size",
					"format"    => "optional",
	            ),
	            "GroupId" => array(
					'label'           => 'Group Id',
					"name"            => "GroupId",
					"feed_name"       => "GroupId",
					"format"          => "optional",
					"woogool_suggest" => "item_group_id",
	            ),
        	),
		),
	);
	return $compari_ro;
}

?>

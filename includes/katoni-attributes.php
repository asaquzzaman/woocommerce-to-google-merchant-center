<?php
/**
 * Settings for Katoni feeds
 */

function woogool_katoni_attributes() {

    $katoni = array(
		"Feed fields" => array(
            'label' => 'Feed_fields',
            'attributes' => array(
				"GTIN" => array(
                    'label' => 'GTIN',
					"name" => "gtin",
					"feed_name" => "gtin",
					"format" => "required",
				),
				"Item_Group_ID" => array(
                    'label' => 'Item Group ID',
					"name" => "item_group_id",
					"feed_name" => "item_group_id",
					"format" => "required",
					"woogool_suggest" => "item_group_id",
				),
                "Product_ID" => array(
                    'label' => 'Product ID',
                        "name" => "id",
                        "feed_name" => "g:id",
                        "format" => "required",
                        "woogool_suggest" => "id",
                ),
				"Brand" => array(
                    'label' => 'Brand',
					"name" => "brand",
					"feed_name" => "brand",
					"format" => "required",
				),
				"Title" => array(
                    'label' => 'Title',
					"name" => "title",
					"feed_name" => "title",
					"format" => "required",
					"woogool_suggest" => "title",
				),
				"Product_Type" => array(
                    'label' => 'Product Type',
					"name" => "product_type",
					"feed_name" => "product_type",
					"format" => "required",
				),
				"Gender" => array(
                    'label' => 'Gender',
					"name" => "gender",
					"feed_name" => "gender",
					"format" => "required",
				),
				"Size" => array(
                    'label' => 'Size',
					"name" => "size",
					"feed_name" => "size",
					"format" => "required",
				),
        		"Image_link" => array(
                    'label' => 'Image link',
					"name" => "image_link",
					"feed_name" => "image_link",
					"format" => "required",
					"woogool_suggest" => "image",
				),
                "Additional_image_link" => array(
                    'label' => 'Additional image link',
                        "name" => "additional_image_link",
                        "feed_name" => "additional_image_link",
                        "format" => "optional",
                ),
                "Availability" => array(
                    'label' => 'Availability',
                        "name" => "availability",
                        "feed_name" => "availability",
                        "format" => "optional",
					"woogool_suggest" => "availability",
				),
                "Stock_level" => array(
                    'label' => 'Stock level',
                        "name" => "stock_level",
                        "feed_name" => "stock_level",
                        "format" => "optional",
                ),
                "Season" => array(
                    'label' => 'Season',
                        "name" => "season",
                        "feed_name" => "season",
                        "format" => "optional",
                ),
                "Description" => array(
                    'label' => 'Description',
                        "name" => "description",
                        "feed_name" => "description",
                        "format" => "required",
	                   "woogool_suggest" => "description",
                ),
                "Material" => array(
                    'label' => 'Material',
                        "name" => "material",
                        "feed_name" => "material",
                        "format" => "optional",
                ),
                "Washing" => array(
                    'label' => 'Washing',
                        "name" => "washing",
                        "feed_name" => "washing",
                        "format" => "optional",
                ),
           	    "Discount_retail_price" => array(
                    'label' => 'Discount retail price',
                        "name" => "discount_retail_price",
                        "feed_name" => "discount_retail_price",
                        "format" => "optional",
                ),
                "Retail_price" => array(
                    'label' => 'Retail price',
                        "name" => "retail_price",
                        "feed_name" => "retail_price",
                        "format" => "required",
	                   "woogool_suggest" => "price",
                ),
                "Wholsesale_price" => array(
                    'label' => 'Wholsesale price',
                        "name" => "wholesale_price",
                        "feed_name" => "wholesale_price",
                        "format" => "optional",
                ),
            ),
		),
	);
	return $katoni;
}

?>

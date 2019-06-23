<?php
/**
 * Settings for Miinto Denmark feeds
 */

function woogool_miinto_attributes() {

                
    $miinto_dk = array(
		"Feed fields" => array(
            'label' => 'Feed_fields',
            'attributes' => array(
    			"GTIN" => array(
                    'label'  => 'GTIN',
    				"name" => "gtin",
    				"feed_name" => "gtin",
    				"format" => "required",
    			),
    			"item_group_id" => array(
                    'label'  => 'Item Group ID',
    				"name" => "item_group_id",
    				"feed_name" => "item_group_id",
    				"format" => "required",
    				"woogool_suggest" => "item_group_id",
    			),
    			"C:style_id:string" => array(
                    'label'  => 'c:style_id:string',
    				"name" => "c:style_id:string",
    				"feed_name" => "c:style_id:string",
    				"format" => "required",
    			),
    			"Brand" => array(
                    'label'  => 'Brand',
    				"name" => "brand",
    				"feed_name" => "brand",
    				"format" => "required",
    			),
    			"Title" => array(
                    'label'  => 'Title',
    				"name" => "title",
    				"feed_name" => "title",
    				"format" => "required",
    				"woogool_suggest" => "title",
    			),
    			"C:title_PL:string" => array(
                    'label'  => 'C:title_PL:string',
    				"name" => "c:title_PL:string",
    				"feed_name" => "c:title_PL:string",
    				"format" => "optional",
    			),
    			"C:title_DK:string" => array(
                    'label'  => 'C:title_DK:string',
    				"name" => "c:title_DK:string",
    				"feed_name" => "c:title_DK:string",
    				"format" => "optional",
    			),
    			"C:title_NL:string" => array(
                    'label'  => 'C:title_NL:string',
    				"name" => "c:title_NL:string",
    				"feed_name" => "c:title_NL:string",
    				"format" => "optional",
    			),
    			"product_type" => array(
                    'label'  => 'Product Type',
    				"name" => "product_type",
    				"feed_name" => "product_type",
    				"format" => "required",
    			),
    			"Gender" => array(
                    'label'  => 'Gender',
    				"name" => "gender",
    				"feed_name" => "gender",
    				"format" => "required",
    			),
    			"Size" => array(
                    'label'  => 'Size',
    				"name" => "size",
    				"feed_name" => "size",
    				"format" => "required",
    			),
        		"image_link" => array(
                    'label'  => 'Image link',
    				"name" => "image_link",
    				"feed_name" => "image_link",
    				"format" => "required",
    				"woogool_suggest" => "image",
    			),
                "additional_image_link" => array(
                    'label'  => 'Additional image link',
                        "name" => "additional_image_link",
                        "feed_name" => "additional_image_link",
                        "format" => "optional",
                ),
                "Availability" => array(
                    'label'  => 'Availability',
                        "name" => "availability",
                        "feed_name" => "availability",
                        "format" => "optional",
    				    "woogool_suggest" => "availability",
    			),
                "C:stock_level:integer" => array(
                    'label'  => 'C:stock_level:integer',
                        "name" => "c:stock_level:integer",
                        "feed_name" => "c:stock_level:integer",
                        "format" => "required",
                ),
                "C:season_tag:string" => array(
                    'label'  => 'C:season_tag:string',
                        "name" => "c:season_tag:string",
                        "feed_name" => "c:season_tag:string",
                        "format" => "required",
                ),
                "Description" => array(
                    'label'  => 'Description',
                        "name" => "description",
                        "feed_name" => "description",
                        "format" => "required",
                        "woogool_suggest" => "description",
                ),
                "C:description_PL:string" => array(
                    'label'  => 'C:description_PL:string',
                        "name" => "c:description_PL:string",
                        "feed_name" => "c:description_PL:string",
                        "format" => "optional",
                ),
                "C:description_NL:string" => array(
                    'label'  => 'C:description_NL:string',
                        "name" => "c:description_NL:string",
                        "feed_name" => "c:description_NL:string",
                        "format" => "optional",
                ),
                "C:description_DK:string" => array(
                    'label'  => 'C:description_DK:string',
                        "name" => "c:description_DK:string",
                        "feed_name" => "c:description_DK:string",
                        "format" => "optional",
                ),
                "Material" => array(
                    'label'  => 'Material',
                        "name" => "material",
                        "feed_name" => "material",
                        "format" => "optional",
                ),
                "Washing" => array(
                    'label'  => 'Washing',
                        "name" => "washing",
                        "feed_name" => "washing",
                        "format" => "optional",
                ),
                "C:discount_retail_price_PLN:integer" => array(
                    'label'  => 'C:discount_retail_price_PLN:integer',
                        "name" => "c:discount_retail_price_PLN:integer",
                        "feed_name" => "c:discount_retail_price_PLN:integer",
                        "format" => "optional",
                ),
           	    "C:discount_retail_price_DKK:integer" => array(
                    'label'  => 'C:discount_retail_price_DKK:integer',
                        "name" => "c:discount_retail_price_DKK:integer",
                        "feed_name" => "c:discount_retail_price_DKK:integer",
                        "format" => "optional",
                ),
           	    "C:discount_retail_price_EUR:integer" => array(
                    'label'  => 'C:discount_retail_price_EUR:integer',
                        "name" => "c:discount_retail_price_EUR:integer",
                        "feed_name" => "c:discount_retail_price_EUR:integer",
                        "format" => "optional",
                ),
                "C:retail_price_PLN:integer" => array(
                    'label'  => 'C:retail_price_PLN:integer',
                        "name" => "c:retail_price_PLN:integer",
                        "feed_name" => "c:retail_price_PLN:integer",
                        "format" => "required",
                        "woogool_suggest" => "price",
                ),
                "C:retail_price_DKK:integer" => array(
                    'label'  => 'C:retail_price_DKK:integer',
                        "name" => "c:retail_price_DKK:integer",
                        "feed_name" => "c:retail_price_DKK:integer",
                        "format" => "required",
                        "woogool_suggest" => "price",
                ),
                "C:retail_price_EUR:integer" => array(
                    'label'  => 'C:retail_price_EUR:integer',
                        "name" => "c:retail_price_EUR:integer",
                        "feed_name" => "c:retail_price_EUR:integer",
                        "format" => "required",
                        "woogool_suggest" => "price",
                ),
                "C:wholsesale_price_PLN:integer" => array(
                    'label'  => 'C:wholsesale_price_PLN:integer',
                        "name" => "c:wholesale_price_PLN:integer",
                        "feed_name" => "c:wholesale_price_PLN:integer",
                        "format" => "optional",
                ),
                "C:wholsesale_price_DKK:integer" => array(
                    'label'  => 'C:wholsesale_price_DKK:integer',
                        "name" => "c:wholesale_price_DKK:integer",
                        "feed_name" => "c:wholesale_price_DKK:integer",
                        "format" => "optional",
                ),
                "C:wholsesale_price_EUR:integer" => array(
                    'label'  => 'C:wholsesale_price_EUR:integer',
                        "name" => "c:wholesale_price_EUR:integer",
                        "feed_name" => "c:wholesale_price_EUR:integer",
                        "format" => "optional",
                ),
            ),
		),
	);
	return $miinto_dk;
}

?>

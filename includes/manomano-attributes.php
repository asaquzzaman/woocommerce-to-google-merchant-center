<?php
/**
 * Settings for ManoMano.co.uk feeds
 */
function woogool_manomano_attributes() {
     
    $manomano = array(
		"Feed fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
				"SKU" => array(
                    'label'           => 'SKU',
                    "name"            => "sku",
                    "feed_name"       => "sku",
                    "format"          => "required",
                    "woogool_suggest" => "id",
				),
				"SKU Manufacturer" => array(
                    'label'     => 'SKU Manufacturer',
                    "name"      => "sku manufacturer",
                    "feed_name" => "sku_manufacturer",
                    "format"    => "required",
				),
				"EAN" => array(
                    'label'     => 'EAN',
                    "name"      => "ean",
                    "feed_name" => "ean",
                    "format"    => "required",
				),
				"title" => array(
                    'label'           => 'title',
                    "name"            => "title",
                    "feed_name"       => "title",
                    "format"          => "required",
                    "woogool_suggest" => "mother_title",
				),
				"description" => array(
                    'label'           => 'Description',
                    "name"            => "description",
                    "feed_name"       => "description",
                    "format"          => "required",
                    "woogool_suggest" => "description",
				),
				"Product price vat inc" => array(
                    'label'           => 'Product price vat inc',
                    "name"            => "product price vat inc",
                    "feed_name"       => "product_price_vat_inc",
                    "format"          => "required",
                    "woogool_suggest" => "price",
				),
				"Shipping price vat inc" => array(
                    'label'     => 'Shipping price vat inc',
                    "name"      => "shipping price vat inc",
                    "feed_name" => "shipping_price_vat_inc",
                    "format"    => "required",
				),
				"Quantity" => array(
                    'label'     => 'Quantity',
                    "name"      => "quantity",
                    "feed_name" => "quantity",
                    "format"    => "required",
				),
				"Brand" => array(
                    'label'     => 'Brand',
                    "name"      => "brand",
                    "feed_name" => "brand",
                    "format"    => "required",
				),
				"Merchant category" => array(
                    'label'     => 'Merchant category',
                    "name"      => "merchant category",
                    "feed_name" => "merchant_category",
                    "format"    => "required",
				),
				"Product URL" => array(
                    'label'           => 'Product URL',
                    "name"            => "product url",
                    "feed_name"       => "product_url",
                    "format"          => "required",
                    "woogool_suggest" => "link",
				),
				"Image 1" => array(
                    'label'           => 'Image 1',
                    "name"            => "image 1",
                    "feed_name"       => "image_1",
                    "format"          => "required",
                    "woogool_suggest" => "image",
				),
				"Image 2" => array(
                    'label'     => 'Image 2',
                    "name"      => "image 2",
                    "feed_name" => "image_2",
                    "format"    => "optional",
				),
				"Image 3" => array(
                    'label'     => 'Image 3',
                    "name"      => "image 3",
                    "feed_name" => "image_3",
                    "format"    => "optional",
				),
				"Image 4" => array(
                    'label'     => 'Image 4',
                    "name"      => "image 4",
                    "feed_name" => "image_4",
                    "format"    => "optional",
				),
				"Image 5" => array(
                    'label'     => 'Image 5',
                    "name"      => "image 5",
                    "feed_name" => "image_5",
                    "format"    => "optional",
				),
				"Retail price vat inc" => array(
                    'label'     => 'Retail price vat inc',
                    "name"      => "retail price vat inc",
                    "feed_name" => "retail_price_vat_inc",
                    "format"    => "optional",
				),
				"Product vat rate" => array(
                    'label'     => 'Product vat rate',
                    "name"      => "product vat rate",
                    "feed_name" => "product_vat_rate",
                    "format"    => "optional",
				),
				"Shipping vat rate" => array(
                    'label'     => 'Shipping vat rate',
                    "name"      => "shipping vat rate",
                    "feed_name" => "shipping_vat_rate",
                    "format"    => "optional",
				),
				"Manufacturer PDF" => array(
                    'label'     => 'Manufacturer PDF',
                    "name"      => "manufacturer pdf",
                    "feed_name" => "manufacturer_pdf",
                    "format"    => "optional",
				),
        		"ParentSKU" => array(
                    'label'     => 'ParentSKU',
                    "name"      => "parentSKU",
                    "feed_name" => "ParentSKU",
                    "format"    => "optional",
				),
                "Cross Sell SKU" => array(
                    'label'     => 'Cross Sell SKU',
                    "name"      => "Cross Sell SKU",
                    "feed_name" => "Cross_Sell_SKU",
                    "format"    => "optional",
                ),
                "ManufacturerWarrantyTime" => array(
                    'label'     => 'Manufacturer Warranty Time',
                    "name"      => "ManufacturerWarrantyTime",
                    "feed_name" => "ManufacturerWarrantyTime",
                    "format"    => "optional",
                ),
                "Carrier" => array(
                    'label'     => 'Carrier',
                    "name"      => "Carrier",
                    "feed_name" => "carrier",
                    "format"    => "required",
                ),
                "Shipping Time" => array(
                    'label'     => 'Shipping Time',
                    "name"      => "Shipping Time",
                    "feed_name" => "shipping_time",
                    "format"    => "required",
                ),
                "Use Grid" => array(
                    'label'     => 'Use Grid',
                    "name"      => "Use Grid",
                    "feed_name" => "use_grid",
                    "format"    => "required",
                ),
                "Carrier Grid 1" => array(
                    'label'     => 'Carrier Grid 1',
                    "name"      => "Carrier Grid 1",
                    "feed_name" => "carrier_grid_1",
                    "format"    => "required",
                ),
                "Shipping time carrier grid 1" => array(
                    'label'     => 'Shipping time carrier grid 1',
                    "name"      => "Shipping time carrier grid 1",
                    "feed_name" => "shipping_time_carrier_grid_1",
                    "format"    => "required",
                ),
                "DisplayWeight" => array(
                    'label'     => 'Display Weight',
                    "name"      => "DisplayWeight",
                    "feed_name" => "DisplayWeight",
                    "format"    => "required",
                ),
                "Carrier Grid 2" => array(
                    'label'     => 'Carrier Grid 2',
                    "name"      => "Carrier Grid 2",
                    "feed_name" => "carrier_grid_2",
                    "format"    => "optional",
                ),
                "Shipping time carrier grid 2" => array(
                    'label'     => 'Shipping time carrier grid 2',
                    "name"      => "Shipping time carrier grid 2",
                    "feed_name" => "shipping_time_carrier_grid_2",
                    "format"    => "optional",
                ),
                "Carrier Grid 3" => array(
                    'label'     => 'Carrier Grid 3',
                    "name"      => "Carrier Grid 3",
                    "feed_name" => "carrier_grid_3",
                    "format"    => "optional",
                ),
                "Shipping time carrier grid 3" => array(
                    'label'     => 'Shipping time carrier grid 3',
                    "name"      => "Shipping time carrier grid 3",
                    "feed_name" => "shipping_time_carrier_grid_3",
                    "format"    => "optional",
                ),
                "Carrier Grid 4" => array(
                    'label'     => 'Carrier Grid 4',
                    "name"      => "Carrier Grid 4",
                    "feed_name" => "carrier_grid_4",
                    "format"    => "optional",
                ),
                "Shipping time carrier grid 4" => array(
                    'label'     => 'Shipping time carrier grid 4',
                    "name"      => "Shipping time carrier grid 4",
                    "feed_name" => "shipping_time_carrier_grid_4",
                    "format"    => "optional",
                ),
                "Free Return" => array(
                    'label'     => 'Free Return',
                    "name"      => "Free Return",
                    "feed_name" => "free_return",
                    "format"    => "optional",
                ),
                "Min quantity" => array(
                    'label'     => 'Min quantity',
                    "name"      => "Min quantity",
                    "feed_name" => "min_quantity",
                    "format"    => "optional",
                ),
                "Increment" => array(
                    'label'     => 'Increment',
                    "name"      => "Increment",
                    "feed_name" => "increment",
                    "format"    => "optional",
                ),
                "Sales" => array(
                    'label'     => 'Sales',
                    "name"      => "Sales",
                    "feed_name" => "sales",
                    "format"    => "optional",
                ),
                "Eco participation" => array(
                    'label'     => 'Eco participation',
                    "name"      => "Eco participation",
                    "feed_name" => "eco_participation",
                    "format"    => "optional",
                ),
                "Price per m2 vat inc" => array(
                    'label'     => 'Price per m2 vat inc',
                    "name"      => "Price per m2 vat inc",
                    "feed_name" => "Price_per_m2_vat_inc",
                    "format"    => "optional",
                ),
                "Shipping price supplement vat inc" => array(
                    'label'     => 'Shipping price supplement vat inc',
                    "name"      => "Shipping price supplement vat inc",
                    "feed_name" => "shipping_price_supplement_vat_inc",
                    "format"    => "optional",
                ),
                "Feature1" => array(
                    'label'     => 'Feature 1',
                    "name"      => "Feature1",
                    "feed_name" => "feature1",
                    "format"    => "optional",
                ),
                "Color" => array(
                    'label'     => 'Color',
                    "name"      => "Color",
                    "feed_name" => "Color",
                    "format"    => "optional",
                ),
                "Special price type" => array(
                    'label'     => 'Special price type',
                    "name"      => "Special price type",
                    "feed_name" => "special_price_type",
                    "format"    => "optional",
                ),
                "Sample SKU" => array(
                    'label'     => 'Sample SKU',
                    "name"      => "Sample SKU",
                    "feed_name" => "Sample_SKU",
                    "format"    => "optional",
                ),
                "Style" => array(
                    'label'     => 'Style',
                    "name"      => "Style",
                    "feed_name" => "Style",
                    "format"    => "optional",
                ),
                "Unit count" => array(
                    'label'     => 'Unit count',
                    "name"      => "Unit count",
                    "feed_name" => "unit_count",
                    "format"    => "optional",
                ),
			    "Unit count type" => array(
                    'label'     => 'Unit count type',
                    "name"      => "Unit count type",
                    "feed_name" => "unit_count_type",
                    "format"    => "optional",
                ),
            )
		),
	);
	return $manomano;
}


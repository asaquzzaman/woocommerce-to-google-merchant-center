<?php
/**
 * Settings for Fruugo.us feeds
 */

function woogool_fruugous_feed() {

    $fruugous = array(
		"feed_fields" => array(
			'label' => 'Feed fields',
			'attributes' => array(
				"product_id" => array(
					'label'       => 'Product Id',
					"name"        => "ProductId",
					"feed_name"   => "ProductId",
					"format"      => "required",
					"woogool_suggest" => "id",
				),
				"sku_id" => array(
					'label'       => 'Sku Id',
					"name"        => "SkuId",
					"feed_name"   => "SkuId",
					"format"      => "required",
					"woogool_suggest" => "sku",
				),
				"gtin" => array(
					'label'     => 'GTIN',
					"name"      => "EAN",
					"feed_name" => "EAN",
					"format"    => "required",
				),
				"brand" => array(
					'label'     => 'Brand',
					"name"      => "Brand",
					"feed_name" => "Brand",
					"format"    => "required",
				),
				"category" => array(
					'label'       => 'Category',
					"name"        => "Category",
					"feed_name"   => "Category",
					"format"      => "required",
					"woogool_suggest" => "category",
				),
				"image_url_1" => array(
					'label'       => 'Image URL',
					"name"        => "Imageurl1",
					"feed_name"   => "Imageurl1",
					"format"      => "required",
					"woogool_suggest" => "image",
				),
				"stock_status" => array(
					'label'       => 'Stock Status',
					"name"        => "StockStatus",
					"feed_name"   => "StockStatus",
					"format"      => "required",
					"woogool_suggest" => "availability",
				),
				"quantity_in_stock" => array(
					'label'     => 'Quantity in Stock',
					"name"      => "StockQuantity",
					"feed_name" => "StockQuantity",
					"format"    => "required",
				),
				"title" => array(
					'label'       => 'Title',
					"name"        => "Title",
					"feed_name"   => "Title",
					"format"      => "required",
					"woogool_suggest" => "title",
				),
				"description" => array(
					'label'       => 'Description',
					"name"        => "Description",
					"feed_name"   => "Description",
					"format"      => "required",
					"woogool_suggest" => "description",
				),
				"product_url" => array (
					'label'       => 'Product URL',
					"name"        => "link",
					"feed_name"   => "Link",
					"format"      => "required",
					"woogool_suggest" => "link",
            	),
				"normal_price_with_vat" => array(
					'label'       => 'Normal Price With VAT',
					"name"        => "NormalPriceWithVat",
					"feed_name"   => "NormalPriceWithVat",
					"format"      => "required",
					"woogool_suggest" => "price",
				),
				"normal_price_without_vat" => array(
					'label'     => 'Normal Price Without VAT',
					"name"      => "NormalPriceWithoutVat",
					"feed_name" => "NormalPriceWithoutVat",
					"format"    => "optional",
				),
				"vat_rate" => array(
					'label'     => 'VAT Rate',
					"name"      => "VatRate",
					"feed_name" => "VatRate",
					"format"    => "required",
				),
				"image_url_2" => array(
					'label'     => 'Image URL 2',
					"name"      => "Imageurl2",
					"feed_name" => "Imageurl2",
					"format"    => "optional",
				),
				"image_url_3" => array(
					'label'     => 'Image URL 3',
					"name"      => "Imageurl3",
					"feed_name" => "Imageurl3",
					"format"    => "optional",
				),
				"image_url_4" => array(
					'label'     => 'Image URL 4',
					"name"      => "Imageurl4",
					"feed_name" => "Imageurl4",
					"format"    => "optional",
				),
				"image_url_5" => array(
					'label'     => 'Image URL 5',
					"name"      => "Imageurl5",
					"feed_name" => "Imageurl5",
					"format"    => "optional",
				),
				"language" => array(
					'label'     => 'Language',
					"name"      => "Language",
					"feed_name" => "Language",
					"format"    => "optional",
				),
				"attribute_size" => array(
					'label'     => 'Attribute Size',
					"name"      => "AttributeSize",
					"feed_name" => "AttributeSize",
					"format"    => "optional",
				),
				"attribute_color" => array(
					'label'     => 'Attribute Color',
					"name"      => "AttributeColor",
					"feed_name" => "AttributeColor",
					"format"    => "optional",
				),
				"currency" => array(
					'label'     => 'Currency',
					"name"      => "Currency",
					"feed_name" => "Currency",
					"format"    => "optional",
				),
				"discount_price_without_vat" => array(
					'label'     => 'Discount Price Without VAT',
					"name"      => "DiscountPriceWithoutVAT",
					"feed_name" => "DiscountPriceWithoutVAT",
					"format"    => "optional",
				),
				"discount_price_with_vat" => array(
					'label'     => 'Discount Price With VAT',
					"name"      => "DiscountPriceWithVAT",
					"feed_name" => "DiscountPriceWithVAT",
					"format"    => "optional",
				),
				"isbn" => array(
					'label'     => 'ISBN',
					"name"      => "ISBN",
					"feed_name" => "ISBN",
					"format"    => "optional",
				),
				"manufacturer" => array(
					'label'     => 'Manufacturer',
					"name"      => "Manufacturer",
					"feed_name" => "Manufacturer",
					"format"    => "optional",
				),
				"restock_date" => array(
					'label'     => 'Restock Date',
					"name"      => "RestockDate",
					"feed_name" => "RestockDate",
					"format"    => "optional",
				),
				"lead_time" => array(
					'label'     => 'Lead Time',
					"name"      => "LeadTime",
					"feed_name" => "LeadTime",
					"format"    => "optional",
				),
				"package_weight" => array(
					'label'     => 'Package Weight',
					"name"      => "PackageWeight",
					"feed_name" => "PackageWeight",
					"format"    => "optional",
				),
				"attribute_1" => array(
					'label'     => 'Attribute 1',
					"name"      => "Attribute1",
					"feed_name" => "Attribute1",
					"format"    => "optional",
				),
				"attribute_2" => array(
					'label'     => 'Attribute 2',
					"name"      => "Attribute2",
					"feed_name" => "Attribute2",
					"format"    => "optional",
				),
				"attribute_3" => array(
					'label'     => 'Attribute 3',
					"name"      => "Attribute3",
					"feed_name" => "Attribute3",
					"format"    => "optional",
				),
				"attribute_4" => array(
					'label'     => 'Attribute 4',
					"name"      => "Attribute4",
					"feed_name" => "Attribute4",
					"format"    => "optional",
				),
				"attribute_5" => array(
					'label'     => 'Attribute 5',
					"name"      => "Attribute5",
					"feed_name" => "Attribute5",
					"format"    => "optional",
				),
				"attribute_6" => array(
					'label'     => 'Attribute 6',
					"name"      => "Attribute6",
					"feed_name" => "Attribute6",
					"format"    => "optional",
				),
				"attribute_7" => array(
					'label'     => 'Attribute 7',
					"name"      => "Attribute7",
					"feed_name" => "Attribute7",
					"format"    => "optional",
				),
				"attribute_8" => array(
					'label'     => 'Attribute 8',
					"name"      => "Attribute8",
					"feed_name" => "Attribute8",
					"format"    => "optional",
				),
				"attribute_9" => array(
					'label'     => 'Attribute 9',
					"name"      => "Attribute9",
					"feed_name" => "Attribute9",
					"format"    => "optional",
				),
				"attribute_10" => array(
					'label'     => 'Attribute 10',
					"name"      => "Attribute10",
					"feed_name" => "Attribute10",
					"format"    => "optional",
				),
				"country" => array(
					'label'     => 'Country',
					"name"      => "Country",
					"feed_name" => "Country",
					"format"    => "optional",
				),
				"discount_price_start_date" => array(
					'label'     => 'Discount Price Start Date',
					"name"      => "DiscountPriceStartDate",
					"feed_name" => "DiscountPriceStartDate",
					"format"    => "optional",
				),
				"discount_price_end_date" => array(
					'label'     => 'Discount Price End Date',
					"name"      => "DiscountPriceEndDate",
					"feed_name" => "DiscountPriceEndDate",
					"format"    => "optional",
				)
			)
		)
	);
	return $fruugous;
}


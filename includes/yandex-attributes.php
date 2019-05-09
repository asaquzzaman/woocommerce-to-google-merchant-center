<?php
/**
 * Settings for Yandex feeds
 */

function woogool_yandex_feed() {

	$yandex = array(
    	"feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
        		"id" => array(
                    'label'       => 'id',
                    "name"        => "id",
                    "feed_name"   => "id",
                    "format"      => "required",
                    "woogool_suggest" => "id",
        		),
        		"type" => array(
                    'label'     => 'type',
                    "name"      => "type",
                    "feed_name" => "type",
                    "format"    => "optional",
        		),
        		"available" => array(
                    'label'       => 'Available',
                    "name"        => "available",
                    "feed_name"   => "available",
                    "format"      => "required",
                    "woogool_suggest" => "availability",
        		),
        		"bid" => array(
                    'label'     => 'Bid',
                    "name"      => "bid",
                    "feed_name" => "bid",
                    "format"    => "optional",
        		),
        		"cbid" => array(
                    'label'     => 'Cbid',
                    "name"      => "cbid",
                    "feed_name" => "cbid",
                    "format"    => "optional",
        		),
        		"url" => array(
                    'label'       => 'URL',
                    "name"        => "url",
                    "feed_name"   => "url",
                    "format"      => "required",
                    "woogool_suggest" => "link",
        		),
        		"price" => array(
                    'label'       => 'price',
                    "name"        => "price",
                    "feed_name"   => "price",
                    "format"      => "required",
                    "woogool_suggest" => "price",
        		),
        		"currency_Id" => array(
                    'label'     => 'Currency Id',
                    "name"      => "currencyId",
                    "feed_name" => "currencyId",
                    "format"    => "required",
        		),
        		"category_Id" => array(
                    'label'       => 'Category Id',
                    "name"        => "categoryId",
                    "feed_name"   => "categoryId",
                    "format"      => "required",
                    "woogool_suggest" => "categories",
        		),
                "picture" => array(
                    'label'       => 'Picture',
                    "name"        => "picture",
                    "feed_name"   => "picture",
                    "format"      => "optional",
                    "woogool_suggest" => "image",
                ),
                "typePrefix" => array(
                    'label'     => 'Type Prefix',
                    "name"      => "typePrefix",
                    "feed_name" => "typePrefix",
                    "format"    => "optional",
                ),
                "store" => array(
                    'label'     => 'store',
                    "name"      => "store",
                    "feed_name" => "store",
                    "format"    => "optional",
                ),
                "pickup" => array(
                    'label'     => 'Pickup',
                    "name"      => "pickup",
                    "feed_name" => "pickup",
                    "format"    => "optional",
                ),
                "delivery" => array(
                    'label'     => 'Delivery',
                    "name"      => "delivery",
                    "feed_name" => "delivery",
                    "format"    => "optional",
                ),
                "name" => array(
                    'label'       => 'Name',
                    "name"        => "name",
                    "feed_name"   => "name",
                    "format"      => "required",
                    "woogool_suggest" => "title",
                ),
                "model" => array(
                    'label'     => 'Model',
                    "name"      => "model",
                    "feed_name" => "model",
                    "format"    => "required",
                ),
                "description" => array(
                     'label'       => 'Description',
                     "name"        => "description",
                     "feed_name"   => "description",
                     "format"      => "optional",
                     "woogool_suggest" => "description",
                ),
                "vendor" => array(
                    'label'     => 'Vendor',
                    "name"      => "vendor",
                    "feed_name" => "vendor",
                    "format"    => "optional",
                ),
                "vendor_code" => array(
                    'label'     => 'Vendor Code',
                    "name"      => "vendorCode",
                    "feed_name" => "vendorCode",
                    "format"    => "optional",
                ),
                "local_delivery_cost" => array(
                    'label'     => 'Local Delivery Cost',
                    "name"      => "local_delivery_cost",
                    "feed_name" => "local_delivery_cost",
                    "format"    => "optional",
                ),
                "sales_notes" => array(
                    'label'     => 'Sales Notes',
                    "name"      => "sales_notes",
                    "feed_name" => "sales_notes",
                    "format"    => "optional",
                ),
                "manufacturer_warranty" => array(
                    'label'     => 'Manufacturer Warranty',
                    "name"      => "manufacturer_warranty",
                    "feed_name" => "manufacturer_warranty",
                    "format"    => "optional",
                ),
                "country_of_origin" => array(
                    'label'     => 'Country of Origin',
                    "name"      => "country_of_origin",
                    "feed_name" => "country_of_origin",
                    "format"    => "optional",
                ),
                "downloadable" => array(
                    'label'     => 'Downloadable',
                    "name"      => "downloadable",
                    "feed_name" => "downloadable",
                    "format"    => "optional",
                ),
                "adult" => array(
                    'label'     => 'Adult',
                    "name"      => "adult",
                    "feed_name" => "adult",
                    "format"    => "optional",
                ),
                "age" => array(
                    'label'     => 'Age',
                    "name"      => "age",
                    "feed_name" => "age",
                    "format"    => "optional",
                ),
                "barcode" => array(
                    'label'     => 'Barcode',
                    "name"      => "barcode",
                    "feed_name" => "barcode",
                    "format"    => "optional",
                ),
                "author" => array(
                    'label'     => 'Author',
                    "name"      => "author",
                    "feed_name" => "author",
                    "format"    => "optional",
                ),
                "artist" => array(
                    'label'     => 'Artist',
                    "name"      => "artist",
                    "feed_name" => "artist",
                    "format"    => "optional",
                ),
                "publisher" => array(
                    'label'     => 'Publisher',
                    "name"      => "publisher",
                    "feed_name" => "publisher",
                    "format"    => "optional",
                ),
                "series" => array(
                    'label'     => 'Series',
                    "name"      => "series",
                    "feed_name" => "series",
                    "format"    => "optional",
                ),
                "year" => array(
                    'label'     => 'Year',
                    "name"      => "year",
                    "feed_name" => "year",
                    "format"    => "optional",
                ),
                "isbn" => array(
                    'label'     => 'ISBN',
                    "name"      => "ISBN",
                    "feed_name" => "ISBN",
                    "format"    => "optional",
                ),
                "volume" => array(
                    'label'     => 'Volume',
                    "name"      => "volume",
                    "feed_name" => "volume",
                    "format"    => "optional",
                ),
                "part" => array(
                    'label'     => 'Part',
                    "name"      => "part",
                    "feed_name" => "part",
                    "format"    => "optional",
                ),
                "language" => array(
                    'label'     => 'Language',
                    "name"      => "language",
                    "feed_name" => "language",
                    "format"    => "optional",
                ),
                "binding" => array(
                    'label'     => 'Binding',
                    "name"      => "binding",
                    "feed_name" => "binding",
                    "format"    => "optional",
                ),
                "page_extent" => array(
                    'label'     => 'Page Extent',
                    "name"      => "page_extent",
                    "feed_name" => "page_extent",
                    "format"    => "optional",
                ),
                "table_of_contents" => array(
                    'label'     => 'Table of contents',
                    "name"      => "table_of_contents",
                    "feed_name" => "table_of_contents",
                    "format"    => "optional",
                ),
                "performed_by" => array(
                    'label'     => 'Performed by',
                    "name"      => "performed_by",
                    "feed_name" => "performed_by",
                    "format"    => "optional",
                ),
                "performance_type" => array(
                    'label'     => 'Performance type',
                    "name"      => "performance_type",
                    "feed_name" => "performance_type",
                    "format"    => "optional",
                ),
                "format" => array(
                    'label'     => 'Format',
                    "name"      => "format",
                    "feed_name" => "format",
                    "format"    => "optional",
                ),
                "storage" => array(
                    'label'     => 'Storage',
                    "name"      => "storage",
                    "feed_name" => "storage",
                    "format"    => "optional",
                ),
                "recording_length" => array(
                    'label'     => 'Recording Length',
                    "name"      => "recording_length",
                    "feed_name" => "recording_length",
                    "format"    => "optional",
                ),
                "media" => array(
                    'label'     => 'Media',
                    "name"      => "media",
                    "feed_name" => "media",
                    "format"    => "optional",
                ),
                "starring" => array(
                    'label'     => 'Starring',
                    "name"      => "starring",
                    "feed_name" => "starring",
                    "format"    => "optional",
                ),
                "director" => array(
                    'label'     => 'Director',
                    "name"      => "director",
                    "feed_name" => "director",
                    "format"    => "optional",
                ),
                "original_name" => array(
                    'label'     => 'Original Name',
                    "name"      => "originalName",
                    "feed_name" => "originalName",
                    "format"    => "optional",
                ),
                "world_region" => array(
                    'label'     => 'type',
                    "name"      => "worldRegion",
                    "feed_name" => "worldRegion",
                    "format"    => "optional",
                ),
        		"country" => array(
                    'label'     => 'Country',
                    "name"      => "country",
                    "feed_name" => "country",
                    "format"    => "optional",
                ),
        		"region" => array(
                    'label'     => 'Region',
                    "name"      => "region",
                    "feed_name" => "region",
                    "format"    => "optional",
                ),
        		"days" => array(
                    'label'     => 'Days',
                    "name"      => "days",
                    "feed_name" => "days",
                    "format"    => "optional",
                ),
        		"data_tour" => array(
                    'label'     => 'Data tour',
                    "name"      => "dataTour",
                    "feed_name" => "dataTour",
                    "format"    => "optional",
                ),
        		"hotel_stars" => array(
                    'label'     => 'Hotel stars',
                    "name"      => "hotel_stars",
                    "feed_name" => "hotel_stars",
                    "format"    => "optional",
                ),
        		"room" => array(
                    'label'     => 'Room',
                    "name"      => "room",
                    "feed_name" => "room",
                    "format"    => "optional",
                ),
        		"meal" => array(
                    'label'     => 'Meal',
                    "name"      => "meal",
                    "feed_name" => "meal",
                    "format"    => "optional",
                ),
        		"included" => array(
                    'label'     => 'Included',
                    "name"      => "included",
                    "feed_name" => "included",
                    "format"    => "optional",
                ),
        		"transport" => array(
                    'label'     => 'Transport',
                    "name"      => "transport",
                    "feed_name" => "transport",
                    "format"    => "optional",
                ),
        		"place" => array(
                    'label'     => 'Place',
                    "name"      => "place",
                    "feed_name" => "place",
                    "format"    => "optional",
                ),
        		"hall_plan" => array(
                    'label'     => 'Hall plan',
                    "name"      => "hall_plan",
                    "feed_name" => "hall_plan",
                    "format"    => "optional",
                ),
        		"date" => array(
                    'label'     => 'Date',
                    "name"      => "date",
                    "feed_name" => "date",
                    "format"    => "optional",
                ),
        		"is_premiere" => array(
                    'label'     => 'Is premiere',
                    "name"      => "is_premiere",
                    "feed_name" => "is_premiere",
                    "format"    => "optional",
                ),
        		"is_kids" => array(
                    'label'     => 'Is kids',
                    "name"      => "is_kids",
                    "feed_name" => "is_kids",
                    "format"    => "optional",
                ),
                "item_group_id" => array(
                    'label'     => 'Item group ID',
                    "name"      => "item_group_id",
                    "feed_name" => "item_group_id",
                    "format"    => "optional",
                )
            )
    	)
    );

    return $yandex;
}

?>

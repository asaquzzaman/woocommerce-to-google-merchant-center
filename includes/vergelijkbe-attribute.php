<?php
/**
 * Settings for Vergelijk.be feeds
 */

function woogool_vergelijkbe_attributes() {

	$vergelijkbe = array(
		"Feed fields" => array(
			'label' => 'Feed fields',
			'attributes' => array(
				"shopReference" => array(
					'label'     => 'Shop reference',
					"name"      => "Shop reference",
					"feed_name" => "shopReference",
					"format"    => "required",
				),
				"shopOfferId" => array(
					'label'     => 'Shop offer id',
					"name"      => "Shop offer id",
					"feed_name" => "shopOfferId",
					"format"    => "optional",
				),
				"shopCategory" => array(
					'label'           => 'Shop category',
					"name"            => "Shop category",
					"feed_name"       => "shopCategory",
					"format"          => "required",
					"woogool_suggest" => "categories",
				),
				"Brand" => array(
					'label'     => 'Brand',
					"name"      => "Brand",
					"feed_name" => "brand",
					"format"    => "required",
				),
				"Description" => array(
					'label'           => 'Description',
					"name"            => "Description",
					"feed_name"       => "description",
					"format"          => "optional",
					"woogool_suggest" => "description",
				),
				"Name" => array(
					'label'           => 'Name',
					"name"            => "Product name",
					"feed_name"       => "name",
					"format"          => "required",
					"woogool_suggest" => "name",
				),
				"IdentifierType" => array(
					'label'     => 'Identifier Type',
					"name"      => "Identifier type",
					"feed_name" => "type",
					"format"    => "optional",
				),
				"IdentifierValue" => array(
					'label'     => 'Identifier Value',
					"name"      => "Identifier value",
					"feed_name" => "value",
					"format"    => "optional",
				),
				"FeatureName" => array(
					'label'     => 'Feature Name',
					"name"      => "Feature name",
					"feed_name" => "name",
					"format"    => "optional",
				),
				"FeatureValue" => array(
					'label'     => 'Feature value',
					"name"      => "Feature value",
					"feed_name" => "value",
					"format"    => "optional",
				),
				"basePrice" => array(
					'label'     => 'Selling price',
					"name"      => "Selling price",
					"feed_name" => "basePrice",
					"format"    => "required",
				),
				"promotionText" => array(
					'label'     => 'Promotional text',
					"name"      => "Promotional text",
					"feed_name" => "promotionText",
					"format"    => "optional",
				),
				"Price" => array(
					'label'           => 'Delivery price',
					"name"            => "Delivery price",
					"feed_name"       => "price",
					"format"          => "required",
					"woogool_suggest" => "price",
				),
				"Deeplink" => array(
					'label'           => 'Deeplink',
					"name"            => "Deeplink",
					"feed_name"       => "deepLink",
					"format"          => "required",
					"woogool_suggest" => "link",
				),
				"mediaType" => array(
					'label'     => 'Media type',
					"name"      => "Media type",
					"feed_name" => "type",
					"format"    => "optional",
				),
				"mediaURL" => array(
					'label'     => 'Media url',
					"name"      => "Media url",
					"feed_name" => "url",
					"format"    => "optional",
				),
				"stockStatus" => array(
					'label'     => 'Stock status',
					"name"      => "Stock status",
					"feed_name" => "inStock",
					"format"    => "optional",
				),
				"nrInStock" => array(
					'label'     => 'Nr. products on stock',
					"name"      => "Nr. products on stock",
					"feed_name" => "nrInStock",
					"format"    => "optional",
				),
				"countryCode" => array(
					'label'     => 'Shipping country code',
					"name"      => "Shipping country code",
					"feed_name" => "countryCode",
					"format"    => "optional",
				),
				"deliveryTime" => array(
					'label'     => 'Delivery time',
					"name"      => "Delivery time",
					"feed_name" => "deliveryTime",
					"format"    => "required",
				),
				"shippingDescription" => array(
					'label'     => 'Shipping description',
					"name"      => "Shipping description",
					"feed_name" => "method",
					"format"    => "optional",
				),
				"method" => array(
					'label'     => 'Shipping method',
					"name"      => "Shipping method",
					"feed_name" => "method",
					"format"    => "required",
				),
				"ServicecountryCode" => array(
					'label'     => 'Service country code',
					"name"      => "Service country code",
					"feed_name" => "countryCode",
					"format"    => "required",
				),
				"ServiceName" => array(
					'label'     => 'Service name',
					"name"      => "Service name",
					"feed_name" => "name",
					"format"    => "optional",
				),
				"ServicePrice" => array(
					'label'     => 'Service price',
					"name"      => "Service price",
					"feed_name" => "price",
					"format"    => "optional",
				),
				"ServiceType" => array(
					'label'     => 'Service type',
					"name"      => "Service type",
					"feed_name" => "type",
					"format"    => "optional",
				),
			),
		),
	);
	return $vergelijkbe;
}

?>

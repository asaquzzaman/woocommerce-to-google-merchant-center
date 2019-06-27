<?php
/**
 * Settings for Vertaa.fi feeds
 */

function woogool_vertaafi_attributes() {

    $vertaafi = array(
        "Feed fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
                "shopReference" => array(
                    'label' => 'Shop reference',
                    "name" => "Shop_reference",
                    "feed_name" => "shopReference",
                    "format" => "required",
                ),
                "shopOfferId" => array(
                    'label' => 'Shop offer id',
                    "name" => "Shop_offer_id",
                    "feed_name" => "shopOfferId",
                    "format" => "optional",
                ),
                "shopCategory" => array(
                    'label' => 'Shop category',
                    "name" => "Shop_category",
                    "feed_name" => "shopCategory",
                    "format" => "required",
                    "woo_suggest" => "categories",
                ),
                "Brand" => array(
                    'label' => 'Brand',
                    "name" => "Brand",
                    "feed_name" => "brand",
                    "format" => "required",
                ),
                "Description" => array(
                    'label' => 'Description',
                    "name" => "Description",
                    "feed_name" => "description",
                    "format" => "optional",
                    "woo_suggest" => "description",
                ),
                "Name" => array(
                    'label' => 'Product name',
                    "name" => "Product_name",
                    "feed_name" => "name",
                    "format" => "required",
                    "woo_suggest" => "name",
                ),
                "IdentifierType" => array(
                    'label' => 'Identifier type',
                    "name" => "Identifier_type",
                    "feed_name" => "type",
                    "format" => "optional",
                ),
                "IdentifierValue" => array(
                    'label' => 'Identifier value',
                    "name" => "Identifier_value",
                    "feed_name" => "value",
                    "format" => "optional",
                ),
                "FeatureName" => array(
                    'label' => 'Feature name',
                    "name" => "Feature_name",
                    "feed_name" => "name",
                    "format" => "optional",
                ),
                "FeatureValue" => array(
                    'label' => 'Feature value',
                    "name" => "Feature_value",
                    "feed_name" => "value",
                    "format" => "optional",
                ),
                "basePrice" => array(
                    'label' => 'Selling price',
                    "name" => "Selling_price",
                    "feed_name" => "basePrice",
                    "format" => "required",
                ),
                "promotionText" => array(
                    'label' => 'Promotional text',
                    "name" => "Promotional_text",
                    "feed_name" => "promotionText",
                    "format" => "optional",
                ),
                "Price" => array(
                    'label' => 'Delivery price',
                    "name" => "Delivery_price",
                    "feed_name" => "price",
                    "format" => "required",
                    "woo_suggest" => "price",
                ),
                "Deeplink" => array(
                    'label' => 'Deep link',
                    "name" => "Deeplink",
                    "feed_name" => "deepLink",
                    "format" => "required",
                    "woo_suggest" => "link",
                ),
                "mediaType" => array(
                    'label' => 'Media type',
                    "name" => "Media_type",
                    "feed_name" => "type",
                    "format" => "optional",
                ),
                "mediaURL" => array(
                    'label' => 'Media url',
                    "name" => "Media_url",
                    "feed_name" => "url",
                    "format" => "optional",
                ),
                "stockStatus" => array(
                    'label' => 'Stock status',
                    "name" => "Stock_status",
                    "feed_name" => "inStock",
                    "format" => "optional",
                ),
                "nrInStock" => array(
                    'label' => 'Nr. products on stock',
                    "name" => "Nr._products_on_stock",
                    "feed_name" => "nrInStock",
                    "format" => "optional",
                ),
                "countryCode" => array(
                    'label' => 'Shipping country code',
                    "name" => "Shipping_country_code",
                    "feed_name" => "countryCode",
                    "format" => "optional",
                ),
                "deliveryTime" => array(
                    'label' => 'Delivery time',
                    "name" => "Delivery_time",
                    "feed_name" => "deliveryTime",
                    "format" => "required",
                ),
                "shippingDescription" => array(
                    'label' => 'Shipping description',
                    "name" => "Shipping_description",
                    "feed_name" => "method",
                    "format" => "optional",
                ),
                "method" => array(
                    'label' => 'Shipping method',
                    "name" => "Shipping_method",
                    "feed_name" => "method",
                    "format" => "required",
                ),
                "ServicecountryCode" => array(
                    'label' => 'Servicecountry Code',
                    "name" => "Service_country_code",
                    "feed_name" => "countryCode",
                    "format" => "required",
                ),
                "ServiceName" => array(
                    'label' => 'Service Name',
                    "name" => "Service_name",
                    "feed_name" => "name",
                    "format" => "optional",
                ),
                "ServicePrice" => array(
                    'label' => 'Service Price',
                    "name" => "Service_price",
                    "feed_name" => "price",
                    "format" => "optional",
                ),
                "ServiceType" => array(
                    'label' => 'Service Type',
                    "name" => "Service_type",
                    "feed_name" => "type",
                    "format" => "optional",
                ),
            ),
        ),
    );
    return $vertaafi;
}


<?php
/**
 * Settings for ZAP israel feeds
 */

function woogool_zap_attributes() {

    $zap = array(
        "Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
                "Product_URL" => array(
                    'label' => 'Product URL',
                    "name" => "PRODUCT_URL",
                    "feed_name" => "PRODUCT_URL",
                    "format" => "required",
                    "woo_suggest" => "link",
                ),
                "Product_Name" => array(
                    'label' => 'Product Name',
                    "name" => "PRODUCT_NAME",
                    "feed_name" => "PRODUCT_NAME",
                    "format" => "required",
                    "woo_suggest" => "title",
                ),
                "Product_Type" => array(
                    'label' => 'Product Type',
                    "name" => "PRODUCT_TYPE",
                    "feed_name" => "PRODUCT_TYPE",
                    "format" => "optional",
                ),
                "Model" => array(
                    'label' => 'Model',
                    "name" => "MODEL",
                    "feed_name" => "MODEL",
                    "format" => "optional",
                ),
                "Details" => array(
                    'label' => 'Details',
                    "name" => "DETAILS",
                    "feed_name" => "DETAILS",
                    "format" => "required",
                    "woo_suggest" => "description",
                ),
                "Catalog_Number" => array(
                    'label' => 'Catalog Number',
                    "name" => "CATALOG_NUMBER",
                    "feed_name" => "CATALOG_NUMBER",
                    "format" => "optional",
                ),
                "Productcode" => array(
                    'label' => 'Productcode',
                        "name" => "PRODUCTCODE",
                        "feed_name" => "PRODUCTCODE",
                        "format" => "required",
                        "woo_suggest" => "id",
                ),
                "Currency" => array(
                    'label' => 'Currency',
                        "name" => "CURRENCY",
                        "feed_name" => "CURRENCY",
                        "format" => "required",
                ),
                "Price" => array(
                    'label' => 'Price',
                        "name" => "PRICE",
                        "feed_name" => "PRICE",
                        "format" => "required",
                        "woo_suggest" => "price",
                ),
                "Open_Price" => array(
                    'label' => 'Open Price',
                        "name" => "OPEN_PRICE",
                        "feed_name" => "OPEN_PRICE",
                        "format" => "optional",
                ),
                "Shipment_Cost" => array(
                    'label' => 'Shipment Cost',
                        "name" => "SHIPMENT_COST",
                        "feed_name" => "SHIPMENT_COST",
                        "format" => "required",
                ),
                "Delivery_Time" => array(
                    'label' => 'Delivery Time',
                        "name" => "DELIVERY_TIME",
                        "feed_name" => "DELIVERY_TIME",
                        "format" => "required",
                ),
                "Manufacturer" => array(
                    'label' => 'Manufacturer',
                        "name" => "MANUFACTURER",
                        "feed_name" => "MANUFACTURER",
                        "format" => "optional",
                ),
                "Warrenty" => array(
                    'label' => 'Warrenty',
                        "name" => "WARRENTY",
                        "feed_name" => "WARRENTY",
                        "format" => "optional",
                ),
                "Image" => array(
                    'label' => 'Image',
                        "name" => "IMAGE",
                        "feed_name" => "IMAGE",
                        "format" => "required",
                        "woo_suggest" => "image",
                ),
                "Tax" => array(
                    'label' => 'Tax',
                        "name" => "TAX",
                        "feed_name" => "TAX",
                        "format" => "optional",
                ),
            ),
        ),
    );
    return $zap;
}


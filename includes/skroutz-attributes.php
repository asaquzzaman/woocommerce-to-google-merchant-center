<?php
/**
 * Settings for Skroutz feeds
 */

function woogool_skroutz_attributes() {

    $skroutz = array(
        "Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
                "ID" => array(
                    'label' => 'ID',
                    "name" => "id",
                    "feed_name" => "id",
                    "format" => "required",
                    "woogool_suggest" => "id",
                ),
                "Name" => array(
                    'label' => 'Name',
                    "name" => "name",
                    "feed_name" => "name",
                    "format" => "required",
                    "woogool_suggest" => "title",
                ),
                "Link" => array(
                    'label' => 'Link',
                    "name" => "link",
                    "feed_name" => "link",
                    "format" => "required",
                    "woogool_suggest" => "link",
                ),
                "Image" => array(
                    'label' => 'Image',
                    "name" => "image",
                    "feed_name" => "image",
                    "format" => "required",
                    "woogool_suggest" => "image",
                ),
                "Additional_Image" => array(
                    'label' => 'Additional Image',
                    "name" => "additionalimage",
                    "feed_name" => "additionalimage",
                    "format" => "optional",
                ),
                "Category_Name" => array(
                    'label' => 'Category Name',
                    "name" => "category name",
                    "feed_name" => "category",
                    "format" => "required",
                    "woogool_suggest" => "categories",
                ),
                "Price_with_VAT" => array(
                    'label' => 'Price with VAT',
                    "name" => "price with vat",
                    "feed_name" => "price_with_vat",
                    "format" => "required",
                    "woogool_suggest" => "price",
                ),
                "Manufacturer" => array(
                    'label' => 'Manufacturer',
                    "name" => "manufacturer",
                    "feed_name" => "manufacturer",
                    "format" => "required",
                ),
                    "MPN" => array(
                        'label' => 'MPN',
                    "name" => "mpn/ isbn",
                    "feed_name" => "mpn",
                    "format" => "required",
                ),
                "EAN" => array(
                    'label' => 'EAN',
                        "name" => "ean",
                        "feed_name" => "ean",
                        "format" => "optional",
                ),
                "instock" => array(
                    'label' => 'Instock',
                        "name" => "instock",
                        "feed_name" => "instock",
                        "format" => "optional",
                ),
                "shipping_costs" => array(
                    'label' => 'shipping costs',
                        "name" => "shipping costs",
                        "feed_name" => "shipping_costs",
                        "format" => "optional",
                ),
                "availability" => array(
                    'label' => 'Availability',
                        "name" => "availability",
                        "feed_name" => "availability",
                        "format" => "required",
                        "woogool_suggest" => "availability",
                ),
                "size" => array(
                    'label' => 'Size',
                        "name" => "size",
                        "feed_name" => "size",
                        "format" => "optional",
                ),
                "weight" => array(
                    'label' => 'Weight',
                        "name" => "weight",
                        "feed_name" => "weight",
                        "format" => "optional",
                ),
                "color" => array(
                    'label' => 'Color',
                        "name" => "color",
                        "feed_name" => "color",
                        "format" => "optional",
                ),
            ),
        ),
    );
    return $skroutz;
}


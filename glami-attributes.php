<?php
/**
 * Settings for Glami feeds
 */

function woogool_glami_attributes() {
    $glami = array(
        "Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
                "ITEM_ID" => array(
                    'label' => 'Item ID',
                    "name" => "ITEM_ID",
                    "feed_name" => "ITEM_ID",
                    "format" => "required",
                    "woo_suggest" => "id",
                ),
                "ITEMGROUP_ID" => array(
                    'label' => 'Item Group ID',
                    "name" => "ITEMGROUP_ID",
                    "feed_name" => "ITEMGROUP_ID",
                    "format" => "optional",
                    "woo_suggest" => "item_group_id",
                ),
                "PRODUCTNAME" => array(
                    'label' => 'Product Name',
                    "name" => "PRODUCTNAME",
                    "feed_name" => "PRODUCTNAME",
                    "format" => "required",
                    "woo_suggest" => "title",
                ),
                "DESCRIPTION" => array(
                    'label' => 'Description',
                    "name" => "DESCRIPTION",
                    "feed_name" => "DESCRIPTION",
                    "format" => "required",
                    "woo_suggest" => "description",
                ),
                "URL" => array(
                    'label' => 'URL',
                    "name" => "URL",
                    "feed_name" => "URL",
                    "format" => "required",
                    "woo_suggest" => "link",
                ),
                "URL_SIZE" => array(
                    'label' => 'URL Size',
                    "name" => "URL_SIZE",
                    "feed_name" => "URL_SIZE",
                    "format" => "optional",
                ),
                "IMGURL" => array(
                    'label' => 'Image URL',
                    "name" => "IMGURL",
                    "feed_name" => "IMGURL",
                    "format" => "required",
                    "woo_suggest" => "image",
                ),
                "IMGURL_ALTERNATIVE" => array(
                    'label' => 'Image URL Alternative',
                    "name" => "IMGURL_ALTERNATIVE",
                    "feed_name" => "IMGURL_ALTERNATIVE",
                    "format" => "optional",
                ),
                "PRICE_VAT" => array(
                    'label' => 'Price Vat',
                    "name" => "PRICE_VAT",
                    "feed_name" => "PRICE_VAT",
                    "format" => "required",
                    "woo_suggest" => "price",
                ),
                "MANUFACTURER" => array(
                    'label' => 'Manufacturer',
                    "name" => "MANUFACTURER",
                    "feed_name" => "MANUFACTURER",
                    "format" => "required",
                ),
                "CATEGORYTEXT" => array(
                    'label' => 'Category Text',
                    "name" => "CATEGORYTEXT",
                    "feed_name" => "CATEGORYTEXT",
                    "format" => "required",
                    "woo_suggest" => "categories",
                ),
                "CATEGORY_ID" => array(
                    'label' => 'Category ID',
                    "name" => "CATEGORY_ID",
                    "feed_name" => "CATEGORY_ID",
                    "format" => "optional",
                ),
                "GLAMI_CPC" => array(
                    'label' => 'Glami CPC',
                    "name" => "GLAMI_CPC",
                    "feed_name" => "GLAMI_CPC",
                    "format" => "optional",
                ),
                "PROMOTION_ID" => array(
                    'label' => 'Promotion ID',
                    "name" => "PROMOTION_ID",
                    "feed_name" => "PROMOTION_ID",
                    "format" => "optional",
                ),
                "DELIVERY_DATE" => array(
                    'label' => 'Delivery Date',
                        "name" => "DELIVERY_DATE",
                        "feed_name" => "DELIVERY_DATE",
                        "format" => "required",
                ),
                "DELIVERY" => array(
                    'label' => 'Delivery',
                        "name" => "DELIVERY",
                        "feed_name" => "DELIVERY",
                        "format" => "optional",
                ),
            ),
        ),
    );
    return $glami;
}



<?php
/**
 * Settings for Zbozi feeds
 */

function woogool_zbozi_attributes() {

    $zbozi = array(
        "Feed fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
                "ITEM_ID" => array(
                    'label' => 'Item ID',
                    "name" => "ITEM_ID",
                    "feed_name" => "ITEM_ID",
                    "format" => "required",
                    "woogool_suggest" => "id",
                ),
                "PRODUCTNAME" => array(
                    'label' => 'Product Name',
                    "name" => "PRODUCTNAME",
                    "feed_name" => "PRODUCTNAME",
                    "format" => "required",
                    "woogool_suggest" => "title",
                ),
                "PRODUCT" => array(
                    'label' => 'Product',
                    "name" => "PRODUCT",
                    "feed_name" => "PRODUCT",
                    "format" => "optional",
                ),
                "DESCRIPTION" => array(
                    'label' => 'Description',
                    "name" => "DESCRIPTION",
                    "feed_name" => "DESCRIPTION",
                    "format" => "required",
                    "woogool_suggest" => "description",
                ),
                "CATEGORYTEXT" => array(
                    'label' => 'Category Text',
                    "name" => "CATEGORYTEXT",
                    "feed_name" => "CATEGORYTEXT",
                    "format" => "required",
                    "woogool_suggest" => "description",
                ),
                "EAN" => array(
                    'label' => 'EAN',
                    "name" => "EAN",
                    "feed_name" => "EAN",
                    "format" => "optional",
                ),
                "ISBN" => array(
                    'label' => 'ISBN',
                    "name" => "ISBN",
                    "feed_name" => "ISBN",
                    "format" => "optional",
                ),
                "PRODUCTNO" => array(
                    'label' => 'Product No.',
                    "name" => "PRODUCTNO",
                    "feed_name" => "PRODUCTNO",
                    "format" => "optional",
                ),
                "MANUFACTURER" => array(
                    'label' => 'Manufaturer',
                    "name" => "MANUFACTURER",
                    "feed_name" => "MANUFACTURER",
                    "format" => "optional",
                ),
                "BRAND" => array(
                    'label' => 'Brand',
                    "name" => "BRAND",
                    "feed_name" => "BRAND",
                    "format" => "optional",
                ),
                "URL" => array(
                    'label' => 'URL',
                    "name" => "URL",
                    "feed_name" => "URL",
                    "format" => "required",
                    "woogool_suggest" => "link",
                ),
                "PRICE_VAT" => array(
                    'label' => 'Price VAT',
                        "name" => "PRICE_VAT",
                        "feed_name" => "PRICE_VAT",
                        "format" => "required",
                        "woogool_suggest" => "price",
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
                        "format" => "required",
                        "woogool_suggest" => "shipping",
                ),
                "SHOP_DEPOTS" => array(
                    'label' => 'Shop Depots',
                        "name" => "SHOP_DEPOTS",
                        "feed_name" => "SHOP_DEPOTS",
                        "format" => "optional",
                ),
                "CATEGORYTEXT" => array(
                    'label' => 'Category Text',
                        "name" => "CATEGORYTEXT",
                        "feed_name" => "CATEGORYTEXT",
                        "format" => "optional",
                        "woogool_suggest" => "categories",
                ),
                "IMGURL" => array(
                    'label' => 'Image URL',
                    "name" => "IMGURL",
                    "feed_name" => "IMGURL",
                    "format" => "optional",
                    "woogool_suggest" => "image",
                ),
                "EXTRA_MESSAGE" => array(
                    'label' => 'Extra Message',
                        "name" => "EXTRA_MESSAGE",
                        "feed_name" => "EXTRA_MESSAGE",
                        "format" => "optional",
                ),
                "FREE_GIFT_TEXT" => array(
                    'label' => 'Free Gift Text',
                        "name" => "FREE_GIFT_TEXT",
                        "feed_name" => "FREE_GIFT_TEXT",
                        "format" => "optional",
                ),
                "MAX_CPC" => array(
                    'label' => 'Max CPC',
                        "name" => "MAX_CPC",
                        "feed_name" => "MAX_CPC",
                        "format" => "optional",
                ),
                "MAX_CPC_SEARCH" => array(
                    'label' => 'Max CPC Search',
                        "name" => "MAX_CPC_SEARCH",
                        "feed_name" => "MAX_CPC_SEARCH",
                        "format" => "optional",
                ),
                "EROTIC" => array(
                    'label' => 'Erotic',
                        "name" => "EROTIC",
                        "feed_name" => "EROTIC",
                        "format" => "optional",
                ),
                "ITEMGROUP_ID" => array(
                    'label' => 'Item Group ID',
                        "name" => "ITEMGROUP_ID",
                        "feed_name" => "ITEMGROUP_ID",
                        "format" => "optional",
                        "woogool_suggest" => "item_group_id",
                ),
                "VISIBILITY" => array(
                    'label' => 'Visiblity',
                        "name" => "VISIBILITY",
                        "feed_name" => "VISIBILITY",
                        "format" => "optional",
                ),
                "CUSTOM_LABEL_0" => array(
                    'label' => 'Custom Label 0',
                        "name" => "CUSTOM_LABEL_0",
                        "feed_name" => "CUSTOM_LABEL_0",
                        "format" => "optional",
                ),
                "CUSTOM_LABEL_1" => array(
                    'label' => 'Custom Label 1',
                        "name" => "CUSTOM_LABEL_1",
                        "feed_name" => "CUSTOM_LABEL_1",
                        "format" => "optional",
                ),
                "CUSTOM_LABEL_2" => array(
                    'label' => 'Custom Label 2',
                        "name" => "CUSTOM_LABEL_2",
                        "feed_name" => "CUSTOM_LABEL_2",
                        "format" => "optional",
                ),
                "CUSTOM_LABEL_3" => array(
                    'label' => 'Custom Label 3',
                        "name" => "CUSTOM_LABEL_3",
                        "feed_name" => "CUSTOM_LABEL_3",
                        "format" => "optional",
                ),
                "CUSTOM_LABEL_4" => array(
                    'label' => 'Custom Label 4',
                        "name" => "CUSTOM_LABEL_4",
                        "feed_name" => "CUSTOM_LABEL_4",
                        "format" => "optional",
                ),
                "PRODUCT_LINE" => array(
                    'label' => 'Product Line',
                        "name" => "PRODUCT_LINE",
                        "feed_name" => "PRODUCT_LINE",
                        "format" => "optional",
                ),
                "LIST_PRICE" => array(
                    'label' => 'List Price',
                        "name" => "LIST_PRICE",
                        "feed_name" => "LIST_PRICE",
                        "format" => "optional",
                ),
                "RELEASE_DATE" => array(
                    'label' => 'Release Date',
                        "name" => "RELEASE_DATE",
                        "feed_name" => "RELEASE_DATE",
                        "format" => "optional",
                ),
                "LENGTH" => array(
                    'label' => 'Length',
                        "name" => "LENGTH",
                        "feed_name" => "LENGTH",
                        "format" => "optional",
                ),
                "VOLUME" => array(
                    'label' => 'Volume',
                        "name" => "VOLUME",
                        "feed_name" => "VOLUME",
                        "format" => "optional",
                ),
                "SIZE" => array(
                    'label' => 'Size',
                        "name" => "SIZE",
                        "feed_name" => "SIZE",
                        "format" => "optional",
                ),
                "COLOR" => array(
                    'label' => 'Color',
                        "name" => "COLOR",
                        "feed_name" => "COLOR",
                        "format" => "optional",
                ),
                "PURPOSE" => array(
                    'label' => 'Purpose',
                        "name" => "PURPOSE",
                        "feed_name" => "PURPOSE",
                        "format" => "optional",
                ),
            ),
        ),
    );
    return $zbozi;
}

?>

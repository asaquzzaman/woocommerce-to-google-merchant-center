<?php
/**
 * Settings for Trovaprezzi feeds
 */
function woogool_trovaprezzi_attributes() {

    $trovaprezzi = array(
        "Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
                "Product_ID" => array(
                    'label' => 'Product ID',
                    "name" => "Code",
                    "feed_name" => "Code",
                    "format" => "required",
                    "woo_suggest" => "id",
                ),
                "Product_SKU" => array(
                    'label' => 'Product SKU',
                    "name" => "SKU",
                    "feed_name" => "SKU",
                    "format" => "optional",
                ),
                "Product_name" => array(
                    'label' => 'Product name',
                    "name" => "Name",
                    "feed_name" => "Name",
                    "format" => "required",
                    "woo_suggest" => "title",
                ),
                "Product_brand" => array(
                    'label' => 'Product brand',
                    "name" => "Brand",
                    "feed_name" => "Brand",
                    "format" => "optional",
                ),
                "Product_URL" => array(
                    'label' => 'Product URL',
                    "name" => "Link",
                    "feed_name" => "Link",
                    "format" => "required",
                    "woo_suggest" => "link",
                ),
                "Product_price" => array(
                    'label' => 'Product price',
                        "name" => "Price",
                        "feed_name" => "Price",
                        "format" => "required",
                        "woo_suggest" => "price",
                ),
                "Product_category" => array(
                    'label' => 'Product category',
                        "name" => "Categories",
                        "feed_name" => "Categories",
                        "format" => "required",
                        "woo_suggest" => "categories",
                ),
                "Product_description" => array(
                    'label' => 'Product description',
                    "name" => "Product description",
                    "feed_name" => "Description",
                    "format" => "optional",
                    "woo_suggest" => "description",
                ),
                "Product_image_1" => array(
                    'label' => 'Product image 1',
                        "name" => "Image1",
                        "feed_name" => "Image",
                        "format" => "required",
                       "woo_suggest" => "image"
                ),
                "Product_image_2" => array(
                    'label' => 'Product image 2',
                        "name" => "Image2",
                        "feed_name" => "Image2",
                        "format" => "optional",
               ),
                "Product_image_3" => array(
                    'label' => 'Product image 3',
                        "name" => "Image3",
                        "feed_name" => "Image3",
                        "format" => "optional",
               ),
                "Product_image_4" => array(
                    'label' => 'Product image 4',
                        "name" => "Image4",
                        "feed_name" => "Image4",
                        "format" => "optional",
               ),
                "Product_image_5" => array(
                    'label' => 'Product image 5',
                        "name" => "Image5",
                        "feed_name" => "Image5",
                        "format" => "optional",
               ),
                "Stock" => array(
                    'label' => 'Stock',
                        "name" => "Stock",
                        "feed_name" => "Stock",
                        "format" => "optional",
               ),
               "EAN" => array(
                'label' => 'EAN',
                        "name" => "EanCode",
                        "feed_name" => "EanCode",
                        "format" => "optional",
                ),
                "MPN" => array(
                    'label' => 'MPN',
                        "name" => "MpnCode",
                        "feed_name" => "MpnCode",
                        "format" => "optional",
                ),
                "Shipping_Cost" => array(
                    'label' => 'Shipping Cost',
                        "name" => "ShippingCost",
                        "feed_name" => "ShippingCost",
                        "format" => "required",
                ),
            ),
        ),
    );
    return $trovaprezzi;
}


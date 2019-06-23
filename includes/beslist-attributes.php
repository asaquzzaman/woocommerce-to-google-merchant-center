<?php
/**
* Settings for Beslist feeds
*/
function woogool_beslist_attributes() {

    $beslist = array(
    	"Feed fields" => array(
            'label' => "Feed fields",
            'attributes' => array(
        		"Title" => array(
                    'lable'           => 'Title',
                    "name"            => "title",
                    "feed_name"       => "title",
                    "format"          => "required",
                    "woogool_suggest" => "title",
        		),
        		"Price" => array(
                    'lable'           => 'Price',
                    "name"            => "price",
                    "feed_name"       => "price",
                    "format"          => "required",
                    "woogool_suggest" => "price",
        		),
        		"Unique_code" => array(
                    'lable'          => 'Unique code',
                    "name"            => "unique_code",
                    "feed_name"       => "unique_code",
                    "format"          => "required",
                    "woogool_suggest" => "id",
        		),
                "Product_URL" => array(
                    'lable'           => 'Product URL',
                    "name"            => "product_url",
                    "feed_name"       => "product_url",
                    "format"          => "required",
                    "woogool_suggest" => "link",
                ),
        		"Image_URL" => array(
                    'lable'           => 'Image URL',
                    "name"            => "image_url",
                    "feed_name"       => "image_url",
                    "format"          => "required",
                    "woogool_suggest" => "image",
        		),
        		"Extra_image_1" => array(
                    'lable'     => 'Extra image 1',
                    "name"      => "extra_image_1",
                    "feed_name" => "extra_image_1",
                    "format"    => "optional",
        		),
        		"Extra_image_2" => array(
                    'lable'     => 'Extra image 2',
                    "name"      => "extra_image_2",
                    "feed_name" => "extra_image_2",
                    "format"    => "optional",
        		),
        		"Extra_image_3" => array(
                    'lable'     => 'Extra image 3',
                    "name"      => "extra_image_3",
                    "feed_name" => "extra_image_3",
                    "format"    => "optional",
        		),
                "Category" => array(
                    'lable'           => 'Category',
                    "name"            => "category",
                    "feed_name"       => "category",
                    "format"          => "required",
                    "woogool_suggest" => "category_path",
                ),
                "Delivery_period" => array(
                    'lable'           => 'Delivery period',
                    "name"            => "delivery_period",
                    "feed_name"       => "delivery_period",
                    "format"          => "required",
                    "woogool_suggest" => "",
                ),
                "Delivery_charges" => array(
                    'lable'     => 'Delivery charges',
                    "name"      => "delivery_charges",
                    "feed_name" => "delivery_charges",
                    "format"    => "required",
                ),
                "EAN" => array(
                    'lable'     => 'EAN',
                    "name"      => "EAN",
                    "feed_name" => "EAN",
                    "format"    => "required",
                ),
                "Product_description" => array(
                    'lable'           => 'Product description',
                    "name"            => "description",
                    "feed_name"       => "description",
                    "format"          => "required",
                    "woogool_suggest" => "description",
                ),
                "Display" => array(
                    'lable'     => 'Display',
                    "name"      => "display",
                    "feed_name" => "display",
                    "format"    => "optional",
                ),
                "SKU" => array(
                    'lable'     => 'SKU',
                    "name"      => "SKU",
                    "feed_name" => "SKU",
                    "format"    => "optional",
                ),
                "Brand" => array(
                    'lable'     => 'Brand',
                    "name"      => "Brand",
                    "feed_name" => "brand",
                    "format"    => "optional",
                ),
                "Size" => array(
                    'lable'     => 'Size',
                    "name"      => "size",
                    "feed_name" => "size",
                    "format"    => "optional",
                ),
                "Condition" => array(
                    'lable'           => 'Condition',
                    "name"            => "condition",
                    "feed_name"       => "condition",
                    "format"          => "optional",
                    "woogool_suggest" => "condition",
                ),
                "Variant_code" => array(
                    'lable'     => 'Variant code',
                    "name"      => "variant_code",
                    "feed_name" => "variant_code",
                    "format"    => "optional",
                ),
                "Model_code" => array(
                    'lable'     => 'Model code',
                    "name"      => "model_code",
                    "feed_name" => "model_code",
                    "format"    => "optional",
                ),
                "Old_price" => array(
                    'lable'     => 'Old price',
                    "name"      => "old_price",
                    "feed_name" => "old_price",
                    "format"    => "optional",
                ),
            ),
    	),
    );
    return $beslist;
}

?>

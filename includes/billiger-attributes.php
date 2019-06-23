<?php
/**
 * Settings for Billiger feeds
 */

function woogool_billiger_attributes() {

    $billiger = array(
		"Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
    			"AID" => array(
                    'label'           => 'aid / sku',
                    "name"            => "aid / sku",
                    "feed_name"       => "aid",
                    "format"          => "required",
                    "woogool_suggest" => "id",
    			),
    			"Name" => array(
                    'label'           => 'Name',
                    "name"            => "name",
                    "feed_name"       => "name",
                    "format"          => "required",
                    "woogool_suggest" => "title",
    			),
    			"Brand" => array(
                    'label'     => 'Brand',
                    "name"      => "brand",
                    "feed_name" => "brand",
                    "format"    => "required",
    			),
    			"Link" => array(
                    'label'           => 'Link',
                    "name"            => "link",
                    "feed_name"       => "link",
                    "format"          => "required",
                    "woogool_suggest" => "link",
    			),
    			"Image" => array(
                    'label'           => 'Image',
                    "name"            => "image",
                    "feed_name"       => "image",
                    "format"          => "required",
                    "woogool_suggest" => "image",
    			),
    			"Product_description" => array(
                    'label'           => 'Product description',
                    "name"            => "desc",
                    "feed_name"       => "desc",
                    "format"          => "required",
                    "woogool_suggest" => "description",
    			),
    			"Shop_category" => array(
                    'label'           => 'Shop category',
                    "name"            => "shop_cat",
                    "feed_name"       => "shop_cat",
                    "format"          => "required",
                    "woogool_suggest" => "categories",
    			),
    			"Price" => array(
                    'label'           => 'Price',
                    "name"            => "price",
                    "feed_name"       => "price",
                    "format"          => "required",
                    "woogool_suggest" => "price",
    			),
    			"Base_price" => array(
                    'label'     => 'Base price',
                    "name"      => "base_price",
                    "feed_name" => "base_price",
                    "format"    => "optional",
    			),
        		"Old_price" => array(
                    'label'     => 'Old price',
                    "name"      => "old_price",
                    "feed_name" => "old_price",
                    "format"    => "optional",
    			),
                "EAN" => array(
                    'label'     => 'EAN / GTIN',
                    "name"      => "ean / gtin",
                    "feed_name" => "ean",
                    "format"    => "required",
                ),
                "MPNR" => array(
                    'label'     => 'MPN(r)',
                    "name"      => "mpn(r)",
                    "feed_name" => "mpnr",
                    "format"    => "required",
                ),
                "Delivery_time" => array(
                    'label'     => 'Delivery time',
                    "name"      => "dlv_time",
                    "feed_name" => "dlv_time",
                    "format"    => "required",
                ),
                "Delivery_cost" => array(
                    'label'     => 'Delivery cost',
                    "name"      => "dlv_cost",
                    "feed_name" => "dlv_cost",
                    "format"    => "required",
                ),
                "Delivery_cost_Austria" => array(
                    'label'     => 'Delivery cost Austria',
                    "name"      => "dlv_cost_at",
                    "feed_name" => "dlv_cost_at",
                    "format"    => "optional",
                ),
                "Promotional_text" => array(
                    'label'     => 'Promotional text',
                    "name"      => "promo_text",
                    "feed_name" => "promo_text",
                    "format"    => "optional",
                ),
                "Voucher_text" => array(
                    'label'     => 'Voucher text',
                    "name"      => "voucher_text",
                    "feed_name" => "voucher_text",
                    "format"    => "optional",
                ),
                "Size" => array(
                    'label'     => 'Size',
                    "name"      => "size",
                    "feed_name" => "size",
                    "format"    => "optional",
                ),
                "Color" => array(
                    'label'     => 'Color',
                    "name"      => "color",
                    "feed_name" => "color",
                    "format"    => "optional",
                ),
                "Gender" => array(
                    'label'     => 'Gender',
                    "name"      => "gender",
                    "feed_name" => "gender",
                    "format"    => "optional",
                ),
                "Material" => array(
                    'label'     => 'Material',
                    "name"      => "material",
                    "feed_name" => "material",
                    "format"    => "optional",
                ),
                "Class" => array(
                    'label'     => 'Class',
                    "name"      => "class",
                    "feed_name" => "class",
                    "format"    => "optional",
                ),
                "Features" => array(
                    'label'     => 'Features',
                    "name"      => "features",
                    "feed_name" => "features",
                    "format"    => "optional",
                ),
                "Style" => array(
                    'label'     => 'Style',
                    "name"      => "style",
                    "feed_name" => "style",
                    "format"    => "optional",
                ),
                "EEK" => array(
                    'label'     => 'EEK',
                    "name"      => "eek",
                    "feed_name" => "eek",
                    "format"    => "optional",
                ),
                "Light_socket" => array(
                    'label'     => 'Light socket',
                    "name"      => "light_socket",
                    "feed_name" => "light_socket",
                    "format"    => "optional",
                ),
                "Wet_adhesion" => array(
                    'label'     => 'Wet adhesion',
                    "name"      => "wet_adhesion",
                    "feed_name" => "wet_adhesion",
                    "format"    => "optional",
                ),
                "Fuel" => array(
                    'label'     => 'Fuel',
                    "name"      => "fuel",
                    "feed_name" => "fuel",
                    "format"    => "optional",
                ),
                "External_rolling_noise" => array(
                    'label'     => 'External rolling noise',
                    "name"      => "rollgeraeusch",
                    "feed_name" => "rollgeraeusch",
                    "format"    => "optional",
                ),
                "HSN_and_TSN" => array(
                    'label'     => 'HSN and TSN',
                    "name"      => "hsn_tsn",
                    "feed_name" => "hsn_tsn",
                    "format"    => "optional",
                ),
                "Slide" => array(
                    'label'     => 'Slide',
                    "name"      => "diameter",
                    "feed_name" => "slide",
                    "format"    => "optional",
                ),
                "Base_Curve" => array(
                    'label'     => 'Base Curve',
                    "name"      => "bc",
                    "feed_name" => "bc",
                    "format"    => "optional",
                ),
                "Diopters" => array(
                    'label'     => 'Diopters',
                    "name"      => "sph_pwr",
                    "feed_name" => "sph_pwr",
                    "format"    => "optional",
                ),
                "Cylinder" => array(
                    'label'     => 'Cylinder',
                    "name"      => "cyl",
                    "feed_name" => "cyl",
                    "format"    => "optional",
                ),
                "Axis" => array(
                    'label'     => 'Axis',
                    "name"      => "axis",
                    "feed_name" => "axis",
                    "format"    => "optional",
                ),
            ),
		),
	);
	return $billiger;
}

?>

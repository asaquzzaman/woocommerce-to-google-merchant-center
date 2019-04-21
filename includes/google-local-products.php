<?php

function woogool_google_local_product_attributes() {


    $google_local_products = array(

		"local_products_fields" => array(
			'label' => 'Local products fields',
			'attributes' => array(
				"itemid" => array(
					'label'           => 'Item id',
					"name"            => "Itemid",
					"feed_name"       => "g:itemid",
					"format"          => "required",
					"woogool_suggest" => "id",
				),
				"title" => array(
					'label'           => 'Title',
					"name"            => "Title",
					"feed_name"       => "g:title",
					"format"          => "required",
					"woogool_suggest" => "title",
				),
				"description" => array(
					'label'           => 'Description',
					"name"            => "Description",
					"feed_name"       => "g:description",
					"format"          => "optional",
					"woogool_suggest" => "description",
				),
                "image_link" => array(
					'label'           => 'Image link',
					"name"            => "image_link",
					"feed_name"       => "g:image_link",
					"format"          => "optional",
					"woogool_suggest" => "image",
                ),
                "condition" => array(
					'label'           => 'Condition',
					"name"            => "condition",
					"feed_name"       => "g:condition",
					"format"          => "optional",
					"woogool_suggest" => "condition",
                ),
                "gtin" => array(
					'label'     => 'Gtin',
					"name"      => "gtin",
					"feed_name" => "g:gtin",
					"format"    => "optional",
                ),
                "mpn" => array(
					'label'     => 'MPN',
					"name"      => "MPN",
					"feed_name" => "g:mpn",
					"format"    => "optional",
                ),
                "brand" => array(
					'label'     => 'Brand',
					"name"      => "brand",
					"feed_name" => "g:brand",
					"format"    => "optional",
                ),
                "google_product_category" => array(
					'label'           => 'Google product category',
					"name"            => "google_product_category",
					"feed_name"       => "g:google_product_category",
					"format"          => "optional",
					"woogool_suggest" => "categories",
                ),
                "energy_efficiency_class" => array(
					'label'     => 'Energy efficiency class',
					"name"      => "energy_efficiency_class",
					"feed_name" => "g:energy_efficiency_class",
					"format"    => "optional",
                ),
                "energy_efficiency_class_min" => array(
					'label'     => 'Energy efficiency class min',
					"name"      => "energy_efficiency_class_min",
					"feed_name" => "g:energy_efficiency_class_min",
					"format"    => "optional",
                ),
                "energy_efficiency_class_max" => array(
					'label'     => 'Energy efficiency class max',
					"name"      => "energy_efficiency_class_max",
					"feed_name" => "g:energy_efficiency_class_max",
					"format"    => "optional",
                ),
                "web_item_id" => array(
					'label'     => 'Web item id',
					"name"      => "webitemid",
					"feed_name" => "g:webitemid",
					"format"    => "optional",
                ),
				"price" => array(
					'label'           => 'Price',
					"name"            => "Price",
					"feed_name"       => "g:price",
					"format"          => "optional",
					"woogool_suggest" => "price",
				),
				"sale_price" => array(
					'label'           => 'Sale price',
					"name"            => "Sale price",
					"feed_name"       => "g:sale_price",
					"format"          => "optional",
					"woogool_suggest" => "sale_price",
				),
                "sale_price_effective_date" => array(
					'label'           => 'Sale price effective date',
					"name"            => "Sale price effective date",
					"feed_name"       => "g:sale_price_effective_date",
					"format"          => "optional",
					"woogool_suggest" => "sale_price_effective_date",
                ),
                "unit_pricing_measure" => array(
					'label'     => 'Unit pricing measure',
					"name"      => "unit_pricing_measure",
					"feed_name" => "g:unit_pricing_measure",
					"format"    => "optional",
                ),
                "unit_pricing_base_measure" => array(
					'label'     => 'Unit pricing base measure',
					"name"      => "unit_pricing_base_measure",
					"feed_name" => "g:unit_pricing_base_measure",
					"format"    => "optional",
                ),
                "pickup_method" => array(
					'label'     => 'Pickup method',
					"name"      => "Pickup method",
					"feed_name" => "g:pickup_method",
					"format"    => "optional",
                ),
                "pickup_sla" => array(
					'label'     => 'Pickup SLA',
					"name"      => "Pickup SLA",
					"feed_name" => "g:pickup_sla",
					"format"    => "optional",
                ),
                "pickup_link_template" => array(
					'label'     => 'Pickup link template',
					"name"      => "Pickup link template",
					"feed_name" => "g:pickup_link_template",
					"format"    => "optional",
                ),
                "mobile_pickup_link_template" => array(
					'label'     => 'Mobile pickup link template',
					"name"      => "Mobile pickup link template",
					"feed_name" => "g:mobile_pickup_link_template",
					"format"    => "optional",
                ),
                "link_template" => array(
					'label'     => 'Link template',
					"name"      => "Link template",
					"feed_name" => "g:link_template",
					"format"    => "optional",
                ),
                "mobile_link_template" => array(
					'label'     => 'Mobile link template',
					"name"      => "Mobile link template",
					"feed_name" => "g:mobile_link_template",
					"format"    => "optional",
                ),
                "ads_redirect" => array(
					'label'     => 'Ads redirect',
					"name"      => "Ads redirect",
					"feed_name" => "g:ads_redirect",
					"format"    => "optional",
                ),
               "age_group" => array(
					'label'     => 'Age group',
					"name"      => "age_group",
					"feed_name" => "g:age_group",
					"format"    => "optional",
                ),
                "color" => array(
					'label'     => 'Color',
					"name"      => "color",
					"feed_name" => "g:color",
					"format"    => "optional",
                ),
                "gender" => array(
					'label'     => 'Gender',
					"name"      => "gender",
					"feed_name" => "g:gender",
					"format"    => "optional",
                ),
                "size" => array(
					'label'     => 'Size',
					"name"      => "size",
					"feed_name" => "g:size",
					"format"    => "optional",
                ),
                "item_group_id" => array(
					'label'     => 'Item group ID',
					"name"      => "item_group_id",
					"feed_name" => "g:item_group_id",
					"format"    => "optional",
                ),
        	),
		),
	);
	return $google_local_products;
	
}
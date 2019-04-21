<?php
function woogool_shopping_promotion_attributes () {
	$google_promotion_attributes = array (
		"feed_fields" => array(
			'label' => 'Feed fields',
			'attributes' => array(
				"promotion_id" => array(
					'label'     => 'Promotion id',
					"name"      => "promotion_id",
					"feed_name" => "promotion_id",
					"format"    => "required",
				),
            	"product_applicability" => array(
					'label'     => 'Product Applicability',
					"name"      => "product_applicability",
					"feed_name" => "product_applicability",
					"format"    => "required",
				),
            	"offer_type" => array(
					'label'     => 'Offer Type',
					"name"      => "offer_type",
					"feed_name" => "offer_type",
					"format"    => "required",
            	),
				"long_title" => array(
					'label'     => 'Long Title',
					"name"      => "long_title",
					"feed_name" => "long_title",
					"format"    => "required",
            	),
            	"promotion_effective_dates" => array(
					'label'     => 'Promotion Effective Dates',
					"name"      => "promotion_effective_dates",
					"feed_name" => "promotion_effective_dates",
					"format"    => "required",
				),
				"redemption_channel" => array(
					'label'     => 'Redemption Channel',
					"name"      => "redemption_channel",
					"feed_name" => "redemption_channel",
					"format"    => "required",
				),
				"promotional_display_dates" => array(
					'label'     => 'Promotional Display Dates',
					"name"      => "promotional_display_dates",
					"feed_name" => "promotional_display_dates", 
					"format"    => "optional",
				),
				"minimum_purchase_amount" => array(
					'label'     => 'Minimum Purchase Amount',
					"name"      => "minimum_purchase_amount",
					"feed_name" => "minimum_purchase_amount", 
					"format"    => "optional",
				),
				"generic_redemption_code" => array(
					'label'     => 'Generic Redemption Code',
					"name"      => "generic_redemption_code",
					"feed_name" => "generic_redemption_code", 
					"format"    => "optional",
				),
			),
		),
		"structured_data_attributes" => array(
			'label' => "Structured data attributes",
			'attributes' => array(
	   		    "percent_off" => array(
					'label'     => 'Percent Off',
					"name"      => "percent_off",
					"feed_name" => "percent_off",
					"format"    => "optional",
	            ),
	            "money_off_amount" => array(
					'label'     => 'Percent Off Amount',
					"name"      => "percent_off_amount",
					"feed_name" => "percent_off_amount",
					"format"    => "optional",
	            ),
	          	"buy_this_quantity" => array(
					'label'     => 'Buy This Quantity',
					"name"      => "buy_this_quantity",
					"feed_name" => "buy_this_quantity",
					"format"    => "optional",
	            ),
	           	"get_this_quantity_discounted" => array(
					'label'     => 'Get This Quantity Discounted',
					"name"      => "get_this_quantity_discounted",
					"feed_name" => "get_this_quantity_discounted",
					"format"    => "optional",
	            ),
	           	"free_shipping" => array(
					'label'     => 'Free Shipping',
					"name"      => "free_shipping",
					"feed_name" => "free_shipping",
					"format"    => "optional",
	            ),
	           	"free_gift_value" => array(
					'label'     => 'Free Gift Value',
					"name"      => "free_gift_value",
					"feed_name" => "free_gift_value",
					"format"    => "optional",
	            ),
	           	"free_gift_description" => array(
					'label'     => 'Free Gift Description',
					"name"      => "free_gift_description",
					"feed_name" => "free_gift_description",
					"format"    => "optional",
	            ),
	           	"free_gift_item_id" => array(
					'label'     => 'Free Gift Item id',
					"name"      => "free_gift_item_id",
					"feed_name" => "free_gift_item_id",
					"format"    => "optional",
	            ),
	        ),
		),
	);

	return $google_promotion_attributes;
    
}
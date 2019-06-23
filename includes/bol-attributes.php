<?php
/**
 * Settings for Bol.com product feeds
 */

 function woogool_bol_attributes() {

	$bol = array(
		"Feed_fields" => array(
			'label' => 'Feed fields',
			'attributes' => array(
				"Reference" => array(
					'label'           => 'Reference',
					"name"            => "Reference",
					"feed_name"       => "Reference",
					"format"          => "required",
					"woogool_suggest" => "id",
				),
				"EAN" => array(
					'label'     => 'EAN',
					"name"      => "EAN",
					"feed_name" => "EAN",
					"format"    => "required",
				),
				"Condition" => array(
					'label'           => 'Condition',
					"name"            => "Condition",
					"feed_name"       => "Condition",
					"format"          => "required",
					"woogool_suggest" => "condition",
				),
				"Stock" => array(
					'label'           => 'Stock',
					"name"            => "Stock",
					"feed_name"       => "Stock",
					"format"          => "required",
					"woogool_suggest" => "availability",
				),
				"Price" => array(
					'label'           => 'Price',
					"name"            => "Price",
					"feed_name"       => "Price",
					"format"          => "required",
					"woogool_suggest" => "price",
				),
				"Fullfillment_by" => array(
					'label'     => 'Fullfillment by',
					"name"      => "Fullfillment by",
					"feed_name" => "Fullfillment by",
					"format"    => "required",
				),
				"Offer_description" => array(
					'label'           => 'Offer description',
					"name"            => "Offer description",
					"feed_name"       => "Offer description",
					"format"          => "required",
					"woogool_suggest" => "description",
				),
				"For_sale" => array(
					'label'     => 'For sale',
					"name"      => "For sale",
					"feed_name" => "For sale",
					"format"    => "required",
				),
				"Title" => array(
					'label'           => 'Title',
					"name"            => "Title",
					"feed_name"       => "Title",
					"format"          => "required",
					"woogool_suggest" => "title",
				),
			),
		),
	);
	return $bol;
}
?>

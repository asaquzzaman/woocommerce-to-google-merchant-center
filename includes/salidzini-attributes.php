<?php
/**
 * Settings for Salidzini.lv Latvia feeds
 */

function woogool_salidzini_attributes() {

    $salidzini = array(
        "Feed_fields" => array(
            'label' => 'Feed fields',
            'attributes' => array(
                "Manufacturer" => array(
                    'label' => 'Manufacturer',
                    "name" => "Manufacturer",
                    "feed_name" => "manufacturer",
                    "format" => "required",
                ),
                "Model" => array(
                    'label' => 'Model',
                    "name" => "Model",
                    "feed_name" => "model",
                    "format" => "required",
                ),
                "Color" => array(
                    'label' => 'Color',
                    "name" => "Color",
                    "feed_name" => "color",
                    "format" => "required",
                ),
                "Name" => array(
                    'label' => 'Name',
                    "name" => "Name",
                    "feed_name" => "name",
                    "format" => "required",
                    "woogool_suggest" => "title",
                ),
                "Link" => array(
                    'label' => 'Link',
                    "name" => "Link",
                    "feed_name" => "link",
                    "format" => "required",
                    "woogool_suggest" => "link",
                ),
                "Price" => array(
                    'label' => 'Price',
                    "name" => "Price",
                    "feed_name" => "price",
                    "format" => "required",
                    "woogool_suggest" => "price",
                ),
                "Image" => array(
                    'label' => 'Image',
                    "name" => "Image",
                    "feed_name" => "image",
                    "format" => "required",
                    "woogool_suggest" => "image",
                ),
                "category_full" => array(
                    'label' => 'Category full',
                    "name" => "Category full",
                    "feed_name" => "category_full",
                    "format" => "required",
                    "woogool_suggest" => "categories",
                ),
                "category_link" => array(
                    'label' => 'Category link',
                    "name" => "Category link",
                    "feed_name" => "category_link",
                    "format" => "required",
                    "woogool_suggest" => "category_link",
                ),
                "in_stock" => array(
                    'label' => 'In Stock',
                    "name" => "In Stock",
                    "feed_name" => "in_stock",
                    "format" => "required",
                ),
                "delivery_cost_riga" => array(
                    'label' => 'Delivery cost Riga',
                    "name" => "Delivery cost Riga",
                    "feed_name" => "delivery_cost_riga",
                    "format" => "required",
                ),
                "delivery_latvija" => array(
                    'label' => 'Delivery latvija',
                    "name" => "Delivery latvija",
                    "feed_name" => "delivery_latvija",
                    "format" => "required",
                ),
                "delivery_dpd_paku_bode" => array(
                    'label' => 'Delivery latvijas pasts',
                    "name" => "Delivery latvijas pasts",
                    "feed_name" => "delivery_latvijas_pasts",
                    "format" => "required",
                ),
                "Delivery dpd paku bode" => array(
                    'label' => 'Delivery dpd paku bode',
                    "name" => "Delivery dpd paku bode",
                    "feed_name" => "delivery_dpd_paku_bode",
                    "format" => "required",
                ),
                "delivery_pasta_stacija" => array(
                    'label' => 'Delivery pasta stacija',
                    "name" => "Delivery pasta stacija",
                    "feed_name" => "delivery_pasta_stacija",
                    "format" => "required",
                ),
                "delivery_omniva" => array(
                    'label' => 'Delivery omniva',
                    "name" => "Delivery omniva",
                    "feed_name" => "delivery_omniva",
                    "format" => "required",
                ),
                "delivery_circlek" => array(
                    'label' => 'Delivery circlek',
                    "name" => "Delivery circlek",
                    "feed_name" => "delivery_circlek",
                    "format" => "required",
                ),
                "delivery_venipak" => array(
                    'label' => 'Delivery venipak',
                    "name" => "Delivery venipak",
                    "feed_name" => "delivery_venipak",
                    "format" => "required",
                ),
                "delivery_days_riga" => array(
                    'label' => 'Delivery days riga',
                    "name" => "Delivery days riga",
                    "feed_name" => "delivery_days_riga",
                    "format" => "required",
                ),
                "delivery_days_latvija" => array(
                    'label' => 'Delivery days latvija',
                    "name" => "Delivery days latvija",
                    "feed_name" => "delivery_days_latvija",
                    "format" => "required",
                ),
                "Used" => array(
                    'label' => 'Used',
                    "name" => "Used",
                    "feed_name" => "used",
                    "format" => "required",
                ),
            ),
        ),
    );
    return $salidzini;
}

?>

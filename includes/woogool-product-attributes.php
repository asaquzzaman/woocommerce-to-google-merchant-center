<?php

function woogool_product_attributes() {
    $attributes = array(
		"id"                        => "Product Id",
		"sku"                       => "SKU", 
		"title"                     => "Product name",
		"mother_title"              => "Product name mother product",
		"description"               => "Product description",
		"short_description"         => "Product short description",
		"price"                     => "Price",
		"regular_price"             => "Regular price",
		"sale_price"                => "Sale price",
		"net_price"                 => "Price excl. VAT",
		"net_regular_price"         => "Regular price excl. VAT",
		"net_sale_price"            => "Sale price excl. VAT",
		"price_forced"              => "Price incl. VAT front end",
		"regular_price_forced"      => "Regular price incl. VAT front end",
		"sale_price_forced"         => "Sale price incl. VAT front end",
		"sale_price_start_date"     => "Sale start date",
		"sale_price_end_date"       => "Sale end date",
		"sale_price_effective_date" => "Sale price effective date",
		"link"                      => "Link",
		"currency"                  => "Currency",
		"categories"                => "Category",
		"category_link"             => "Category link",
		"category_path"             => "Category path",
		"condition"                 => "Condition",
		"availability"              => "Availability",
		"quantity"                  => "Quantity [Stock]",
		"product_type"              => "Product Type",
		"content_type"              => "Content Type",
		"exclude_from_catalog"      => "Excluded from catalog",
		"exclude_from_search"       => "Excluded from search",
		"exclude_from_all"          => "Excluded from all (hidden)",
		"publication_date"          => "Publication date",
		"item_group_id"             => "Item group ID",
		"weight"                    => "Weight",
		"width"                     => "Width",
		"height"                    => "Height",
		"length"                    => "Length",
		"shipping"                  => "Shipping",
		"visibility"                => "Visibility",
		"rating_total"              => "Total rating",
		"rating_average"            => "Average rating",
	);

	$images = array(
			"image"         => "Main image",
			"feature_image" => "Featured image",
			"image_1"       => "Additional image 1",
			"image_2"       => "Additional image 2",
			"image_3"       => "Additional image 3",
			"image_4"       => "Additional image 4",
			"image_5"       => "Additional image 5",
			"image_6"       => "Additional image 6",
			"image_7"       => "Additional image 7",
			"image_8"       => "Additional image 8",
			"image_9"       => "Additional image 9",
			"image_10"      => "Additional image 10",
	);

	$attributes = array_merge( $attributes, $images );

	if ( is_array( woogool_get_dynamic_attributes() ) ) {
    	$dynamic_attributes = woogool_get_dynamic_attributes();
		
		array_walk (
			$dynamic_attributes, 
			function( &$value, $key ) { 
				$value .= ' (Dynamic attribute)'; 
			} 
		);
		
		$attributes = array_merge($attributes, $dynamic_attributes);
	}

    if( is_array( woogool_get_custom_attributes() ) ) {
		$custom_attributes = woogool_get_custom_attributes();
		
		array_walk (
			$custom_attributes, 
			function( &$value, $key ) { 
				$value .= ' (Custom attribute)';
			}
		);
		
		$attributes = array_merge($attributes, $custom_attributes);
    }

	$static = array(
		"installment"  => "Installment",
		"static_value" => "Static value",
		"calculated"   => "Plugin calculation",
		"product_tag"  => "Product tags",
	);

	$attributes = array_merge($attributes, $static);

	return $attributes;
}

function woogool_product_attributes_maping_func() {
	return array(
		'id'                        => 'get_id',
		'sku'                       => 'get_sku', 
		'title'                     => 'get_title',
		'mother_title'              => 'get_title',
		'description'               => 'get_description',
		'short_description'         => 'get_short_description',
		'price'                     => 'get_price',
		'regular_price'             => 'get_regular_price',
		'sale_price'                => 'get_sale_price',
		// 'net_price'                 => 'Price excl. VAT',
		// 'net_regular_price'         => 'Regular price excl. VAT',
		// 'net_sale_price'            => 'Sale price excl. VAT',
		// 'price_forced'              => 'Price incl. VAT front end',
		// 'regular_price_forced'      => 'Regular price incl. VAT front end',
		// 'sale_price_forced'         => 'Sale price incl. VAT front end',
		// 'sale_price_start_date'     => 'Sale start date',
		// 'sale_price_end_date'       => 'Sale end date',
		// 'sale_price_effective_date' => 'Sale price effective date',
		// 'link'                      => 'Link',
		// 'currency'                  => 'Currency',
		// 'categories'                => 'Category',
		// 'category_link'             => 'Category link',
		// 'category_path'             => 'Category path',
		// 'condition'                 => 'Condition',
		// 'availability'              => 'Availability',
		// 'quantity'                  => 'Quantity [Stock]',
		// 'product_type'              => 'Product Type',
		// 'content_type'              => 'Content Type',
		// 'exclude_from_catalog'      => 'Excluded from catalog',
		// 'exclude_from_search'       => 'Excluded from search',
		// 'exclude_from_all'          => 'Excluded from all (hidden)',
		// 'publication_date'          => 'Publication date',
		// 'item_group_id'             => 'Item group ID',
		// 'weight'                    => 'Weight',
		// 'width'                     => 'Width',
		// 'height'                    => 'Height',
		// 'length'                    => 'Length',
		// 'shipping'                  => 'Shipping',
		// 'visibility'                => 'Visibility',
		// 'rating_total'              => 'Total rating',
		// 'rating_average'            => 'Average rating',
	);
}

function woogool_product_variable_maping_func() {
	return array(

		'id'                => 'woogool_get_variable_product_id',
		'sku'               => 'woogool_get_variable_product_sku', 
		'title'             => 'get_title',
		'mother_title'      => 'get_title',
		'description'       => 'woogool_get_variable_product_description',
		'short_description' => 'get_short_description',
		'price'             => 'woogool_get_variable_product_price',
		'regular_price'     => 'woogool_get_variable_product_regular_price',
		// 'sale_price'                => 'get_sale_price',
		// 'net_price'                 => 'Price excl. VAT',
		// 'net_regular_price'         => 'Regular price excl. VAT',
		// 'net_sale_price'            => 'Sale price excl. VAT',
		// 'price_forced'              => 'Price incl. VAT front end',
		// 'regular_price_forced'      => 'Regular price incl. VAT front end',
		// 'sale_price_forced'         => 'Sale price incl. VAT front end',
		// 'sale_price_start_date'     => 'Sale start date',
		// 'sale_price_end_date'       => 'Sale end date',
		// 'sale_price_effective_date' => 'Sale price effective date',
		// 'link'                      => 'Link',
		// 'currency'                  => 'Currency',
		// 'categories'                => 'Category',
		// 'category_link'             => 'Category link',
		// 'category_path'             => 'Category path',
		// 'condition'                 => 'Condition',
		// 'availability'              => 'Availability',
		// 'quantity'                  => 'Quantity [Stock]',
		// 'product_type'              => 'Product Type',
		// 'content_type'              => 'Content Type',
		// 'exclude_from_catalog'      => 'Excluded from catalog',
		// 'exclude_from_search'       => 'Excluded from search',
		// 'exclude_from_all'          => 'Excluded from all (hidden)',
		// 'publication_date'          => 'Publication date',
		// 'item_group_id'             => 'Item group ID',
		// 'weight'                    => 'Weight',
		// 'width'                     => 'Width',
		// 'height'                    => 'Height',
		// 'length'                    => 'Length',
		// 'shipping'                  => 'Shipping',
		// 'visibility'                => 'Visibility',
		// 'rating_total'              => 'Total rating',
		// 'rating_average'            => 'Average rating',
	);
}

function woogool_get_variable_product_id( $variable ) {
	return $variable['variation_id'];
}

function woogool_get_variable_product_sku( $variable ) {
	return $variable['sku'];
}

function woogool_get_variable_product_price( $variable ) {
	if ( empty( $variable['display_price'] ) ) {
		return false;
	}
	return wc_format_localized_price( $variable['display_price'] ) .' '. get_woocommerce_currency();
}

function woogool_get_variable_product_description( $variable ) {
	if ( empty( $variable['variation_description'] ) ) {
		return false;
	}
	return wp_strip_all_tags( $variable['variation_description'] );
}

function woogool_get_variable_product_regular_price( $variable ) {
	if ( empty( $variable['display_regular_price'] ) ) {
		return false;
	}
	return wc_format_localized_price( $variable['display_regular_price'] ) .' '. get_woocommerce_currency();
}



function woogool_product_attribute_with_optgroups() {

	$dynamic_attributes = [];
	$custom_attributes = [];

	if ( is_array( woogool_get_dynamic_attributes() ) ) {
    	$dynamic_attributes = woogool_get_dynamic_attributes();
	}

	if( is_array( woogool_get_custom_attributes() ) ) {
		$custom_attributes = woogool_get_custom_attributes();
    }

    $attributes = array (
    	'main_attributes' => array (
    		'label' => 'Main attributes',
    		'attributes' => array (
				"id"                        => "Product Id",
				"sku"                       => "SKU", 
				"sku_id"                    => "SKU_ID",
				"title"                     => "Product name",
				"mother_title"              => "Product name mother product",
				"description"               => "Product description",
				"short_description"         => "Product short description",
				"price"                     => "Price",
				"regular_price"             => "Regular price",
				"sale_price"                => "Sale price",
				"net_price"                 => "Price excl. VAT",
				"net_regular_price"         => "Regular price excl. VAT",
				"net_sale_price"            => "Sale price excl. VAT",
				"price_forced"              => "Price incl. VAT front end",
				"regular_price_forced"      => "Regular price incl. VAT front end",
				"sale_price_forced"         => "Sale price incl. VAT front end",
				"sale_price_start_date"     => "Sale start date",
				"sale_price_end_date"       => "Sale end date",
				"sale_price_effective_date" => "Sale price effective date",
				"link"                      => "Link",
				"currency"                  => "Currency",
				"categories"                => "Category",
				"category_link"             => "Category link",
				"category_path"             => "Category path",
				"condition"                 => "Condition",
				"availability"              => "Availability",
				"quantity"                  => "Quantity [Stock]",
				"product_type"              => "Product Type",
				"content_type"              => "Content Type",
				"exclude_from_catalog"      => "Excluded from catalog",
				"exclude_from_search"       => "Excluded from search",
				"exclude_from_all"          => "Excluded from all (hidden)",
				"publication_date"          => "Publication date",
				"item_group_id"             => "Item group ID",
				"weight"                    => "Weight",
				"width"                     => "Width",
				"height"                    => "Height",
				"length"                    => "Length",
				"shipping"                  => "Shipping",
				"visibility"                => "Visibility",
				"rating_total"              => "Total rating",
				"rating_average"            => "Average rating",
			)
    	),

    	'image_attributes' => array (

    		'label' => 'Image attributes',
    		'attributes' => array(
				"image"         => "Main image",
				"feature_image" => "Featured image",
				"image_1"       => "Additional image 1",
				"image_2"       => "Additional image 2",
				"image_3"       => "Additional image 3",
				"image_4"       => "Additional image 4",
				"image_5"       => "Additional image 5",
				"image_6"       => "Additional image 6",
				"image_7"       => "Additional image 7",
				"image_8"       => "Additional image 8",
				"image_9"       => "Additional image 9",
				"image_10"      => "Additional image 10",
			)
    	),

    	'dynamic_attributes' => array (
    		'label' => 'Dynamic attributes',
    		'attributes' => $dynamic_attributes,
    	),

    	'google_category_taxonomy' => array (
    		'label' => 'Google category taxonomy',
    		'attributes' => array (
    			'google_category' => 'Google category',
    		)
    	),

    	'custom_field_attributes' => array (
    		'label' => 'Custom field attributes',
    		'attributes' => $custom_attributes
    	),

    	'other_fields' => array (
    		'label' => 'Other fields',
    		'attributes' => array (
    			'product_tag' => 'Product tags'
    		)
    	)
    );


	return $attributes;
}

function woogool_get_dynamic_attributes() {
	global $wpdb;
	$list = array();

        $no_taxonomies = array("portfolio_category","portfolio_skills","portfolio_tags","nav_menu","post_format","slide-page","element_category","template_category","portfolio_category","portfolio_skills","portfolio_tags","faq_category","slide-page","yst_prominent_words","category","post_tag","nav_menu","link_category","post_format","product_type","product_visibility","product_cat","product_shipping_class","product_tag");
     	$taxonomies = get_taxonomies();
 
     	$diff_taxonomies = array_diff($taxonomies, $no_taxonomies);

    	# get custom taxonomy values for a product
    	foreach($diff_taxonomies as $tax_diff){
		$taxonomy_details = get_taxonomy( $tax_diff );

		foreach($taxonomy_details as $kk => $vv){
			if($kk == "name"){
				$pa_short = $vv;
			}
			if($kk == "labels"){
				foreach($vv as $kw => $kv){
					if($kw == "singular_name"){
						$attr_name = $pa_short;
						$attr_name_clean = ucfirst($kv);
					}
				}
			}
		}
               	$list["$attr_name"] = $attr_name_clean;
	}
	return $list;
}

function woogool_get_custom_attributes() {
	global $wpdb;
     	$list = array();
     	$sql = "SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type FROM " . $wpdb->prefix . "postmeta" . " AS meta, " . $wpdb->prefix . "posts" . " AS posts WHERE meta.post_id = posts.id AND posts.post_type LIKE '%product%'
AND meta.meta_key NOT LIKE 'pyre%' AND meta.meta_key NOT LIKE 'sbg_%' AND meta.meta_key NOT LIKE 'wccaf_%' AND meta.meta_key NOT LIKE 'rp_%' AND (meta.meta_key NOT LIKE '\_%' OR meta.meta_key LIKE '\_woogool%' OR meta.meta_key LIKE '\_yoast%' OR meta.meta_key='_product_attributes') GROUP BY meta.meta_key ORDER BY meta.meta_key ASC;";
	$data = $wpdb->get_results($sql);

      	if (count($data)) {
     		foreach ($data as $key => $value) {

			if (!preg_match("/_product_attributes/i",$value->name)){
				$value_display = str_replace("_", " ",$value->name);
                    		$list["custom_attributes_" . $value->name] = ucfirst($value_display);
            		} else {
				$sql = "SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type FROM " . $wpdb->prefix . "postmeta" . " AS meta, " . $wpdb->prefix . "posts" . " AS posts WHERE meta.post_id = posts.id AND posts.post_type LIKE '%product%' AND meta.meta_key='_product_attributes';";
				$data = $wpdb->get_results($sql);
      				if (count($data)) {
     					foreach ($data as $key => $value) {
						$product_attr = unserialize($value->type);
						if(!empty($product_attr)){
							foreach ($product_attr as $key => $arr_value) {
								$value_display = str_replace("_", " ",$arr_value['name']);
               	     						$list["custom_attributes_" . $key] = ucfirst($value_display);
							}
						}
					}
				}
			}
             	}
              	return $list;
     	}
     	return false;
}

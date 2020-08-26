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
		"availability"              => "Stock Availability",
		"quantity"                  => "Quantity [Stock]",
		"product_type"              => "Product Type",
		//"content_type"              => "Content Type",
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
		'_woogool_brand'                     =>  'woogool brand (Custom attribute)',
		'_woogool_condition'                 =>  'woogool condition (Custom attribute)',
		'_woogool_ean'                       =>  'woogool ean (Custom attribute)',
		'_woogool_exclude_product'           =>  'woogool exclude product (Custom attribute)',
		'_woogool_gtin'                      =>  'woogool gtin (Custom attribute)',
		'_woogool_installment_amount'        =>  'woogool installment amount (Custom attribute)',
		'_woogool_installment_months'        =>  'woogool installment months (Custom attribute)',
		'_woogool_mpn'                       =>  'woogool mpn (Custom attribute)',
		'_woogool_optimized_title'           =>  'woogool optimized title (Custom attribute)',
		'_woogool_unit_pricing_base_measure' =>  'woogool unit pricing base measure (Custom attribute)',
		'_woogool_unit_pricing_measure'      =>  'woogool unit pricing measure (Custom attribute)',
		'_woogool_upc'                       =>  'woogool upc (Custom attribute)'
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

function woogool_get_product_id( $wc_product ) {
	if(!$wc_product) {
		return 0;
	}
	return $wc_product->get_id();
}
function woogool_get_product_compare_id( $wc_product, $settings, $feed_content ) {
	$id  = woogool_get_product_id( $wc_product, $settings );
	$id = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $id );
	return $id;
}

function woogool_get_product_sku( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_sku();
}
function woogool_get_product_compare_sku( $wc_product, $settings, $feed_content ) {
	$sku  = woogool_get_product_sku( $wc_product, $settings );
	$sku = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $sku );
	
	return $sku;
}

function woogool_get_product_title( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_title();
}
function woogool_get_product_compare_title( $wc_product, $settings, $feed_content ) {
	$title = woogool_get_product_title( $wc_product, $settings );
	$title = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $title );
	
	return $title;
}

function woogool_get_product_mother_title( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_title();
}
function woogool_get_product_compare_mother_title( $wc_product, $settings, $feed_content ) {
	$mother_title = woogool_get_product_mother_title( $wc_product, $settings );
	$mother_title = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $mother_title );
	
	return $mother_title;
}

function woogool_get_product_description( $wc_product ) {
	if(!$wc_product) {
		return '';
	}

	$description  = $wc_product->get_description();

	if ( empty( $description ) && ($wc_product->get_type() == 'variation' || $wc_product->get_type() == 'variable' ) ) {
		$parent_id      = $wc_product->get_parent_id();
		$parent_product = wc_get_product( $parent_id );
		$description    = $parent_product->get_description();

	}

	// $description = html_entity_decode( ( str_replace( "\r", "", $description ) ), ENT_QUOTES | ENT_XML1, 'UTF-8');
	// $description = woogool_rip_tags( $description );
	// $description = preg_replace( '/\[(.*?)\]/', ' ', $description );
	// $description = str_replace("&#xa0;", "", $description );
	// $description = trim( woogool_utf8_for_xml( $description ) );


	return woogool_filter_descriptin( $description );
}

function woogool_filter_descriptin( $description ) {

    $description = html_entity_decode((str_replace("\r", "", $description)), ENT_QUOTES | ENT_XML1, 'UTF-8');
    
    // Strip HTML from (short) description
    $description = woogool_rip_tags($description);
    

    // Strip out Visual Composer short codes, including the Visual Composer Raw HTML
    $description = preg_replace('/\[vc_raw_html.*\[\/vc_raw_html\]/', '', $description);
    $description = preg_replace( '/\[(.*?)\]/', ' ', $description );


    // Strip out the non-line-brake character
    $description = str_replace("&#xa0;", "", $description);
    
    // Strip strange UTF chars
    $description = trim(woogool_utf8_for_xml($description));
    
    $description = str_replace("<", "&lt;", $description);
    $description = str_replace(">", "&gt;", $description);
    $description = str_replace("&", "&amp;", $description);

    return $description;
}

function woogool_get_product_compare_description( $wc_product, $settings, $feed_content ) {
	$description = woogool_get_product_description( $wc_product, $settings );
	$description = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $description );
	
	return $description;
}

function woogool_get_product_short_description( $wc_product ) {
	if(!$wc_product) {
		return '';
	}

	$short_description = $wc_product->get_short_description();
	// $short_description = html_entity_decode( ( str_replace( "\r", "", $short_description ) ), ENT_QUOTES | ENT_XML1, 'UTF-8');
	// $short_description = woogool_rip_tags( $short_description );
	// $short_description = preg_replace( '/\[(.*?)\]/', ' ', $short_description );
	// $short_description = str_replace("&#xa0;", "", $short_description );
	// $short_description = trim( woogool_utf8_for_xml( $short_description ) );

	return woogool_filter_short_description( $short_description );
}

function woogool_filter_short_description( $short_description ) {

	$short_description = html_entity_decode((str_replace("\r", "", $post->post_excerpt)), ENT_QUOTES | ENT_XML1, 'UTF-8');

	// Strip HTML from (short) description
	$short_description = woogool_rip_tags($short_description);

	// Strip out Visual Composer short codes, including the Visual Composer Raw HTML
	$short_description = preg_replace('/\[vc_raw_html.*\[\/vc_raw_html\]/', '', $short_description);
	$short_description = preg_replace( '/\[(.*?)\]/', ' ', $short_description );

	// Strip out the non-line-brake character
	$short_description = str_replace("&#xa0;", "", $short_description);

	// Strip strange UTF chars
	$short_description = trim(woogool_utf8_for_xml($short_description));

	$description = str_replace("<", "&lt;", $description);
    $description = str_replace(">", "&gt;", $description);
    $description = str_replace("&", "&amp;", $description);

	return $short_description;
}

function woogool_get_product_compare_short_description( $wc_product, $settings, $feed_content ) {
	$short_description = woogool_get_product_short_description( $wc_product, $settings );
	$short_description = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $short_description );
	
	return $short_description;
}

function woogool_get_product_price( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_price();
}
function woogool_get_product_compare_price( $wc_product, $settings, $feed_content ) {
	$price = woogool_get_product_price( $wc_product, $settings );
	$price = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $price );
	if ( empty( $price ) ) {
		return '';
	}
	return wc_format_localized_price( $price ) .' '. get_woocommerce_currency();
}

function woogool_get_product_regular_price( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_regular_price();
}
function woogool_get_product_compare_regular_price( $wc_product, $settings, $feed_content ) {
	$regular_price = woogool_get_product_regular_price( $wc_product, $settings );
	$regular_price = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $regular_price );
	if ( empty( $regular_price ) ) {
		return '';
	}
	return wc_format_localized_price( $regular_price ) .' '. get_woocommerce_currency();
}

function woogool_get_product_sale_price( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_sale_price();
}
function woogool_get_product_compare_sale_price( $wc_product, $settings, $feed_content ) {
	$sale_price = woogool_get_product_sale_price( $wc_product, $settings );
	$sale_price = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $sale_price );
	if ( empty( $sale_price ) ) {
		return '';
	}
	return wc_format_localized_price( $sale_price ) .' '. get_woocommerce_currency();
}

function woogool_get_product_net_price( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return wc_get_price_excluding_tax( $wc_product, array( 'price'=> $wc_product->get_price() ) );
}
function woogool_get_product_compare_net_price( $wc_product, $settings, $feed_content ) {
	$net_price = woogool_get_product_net_price( $wc_product, $settings );
	$net_price = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $net_price );
	if ( empty( $net_price ) ) {
		return '';
	}
	return wc_format_localized_price( $net_price ) .' '. get_woocommerce_currency();
}

function woogool_get_product_net_regular_price( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return wc_get_price_excluding_tax( $wc_product, array( 'price'=> $wc_product->get_regular_price() ) );
}
function woogool_get_product_compare_net_regular_price( $wc_product, $settings, $feed_content ) {
	$net_regular_price = woogool_get_product_net_regular_price( $wc_product, $settings );
	$net_regular_price = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $net_regular_price );
	if ( empty( $net_regular_price ) ) {
		return '';
	}
	return wc_format_localized_price( $net_regular_price ) .' '. get_woocommerce_currency();
}

function woogool_get_product_net_sale_price( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return wc_get_price_excluding_tax( $wc_product, array( 'price'=> $wc_product->get_sale_price() ) );
}
function woogool_get_product_compare_net_sale_price( $wc_product, $settings, $feed_content ) {
	$net_sale_price = woogool_get_product_net_sale_price( $wc_product, $settings );
	$net_sale_price = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $net_sale_price );
	if ( empty( $net_sale_price ) ) {
		return '';
	}
	return wc_format_localized_price( $net_sale_price ) .' '. get_woocommerce_currency();
}

function woogool_get_product_price_forced( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return wc_get_price_including_tax( $wc_product, array( 'price'=> $wc_product->get_price() ) );
}
function woogool_get_product_compare_price_forced( $wc_product, $settings, $feed_content ) {
	$price_forced = woogool_get_product_price_forced( $wc_product, $settings );
	$price_forced = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $price_forced );
	if ( empty( $price_forced ) ) {
		return '';
	}
	return wc_format_localized_price( $price_forced ) .' '. get_woocommerce_currency();
}

function woogool_get_product_regular_price_forced( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return wc_get_price_including_tax( $wc_product, array( 'price'=> $wc_product->get_regular_price() ) );
}
function woogool_get_product_compare_regular_price_forced( $wc_product, $settings, $feed_content ) {
	$regular_price_forced = woogool_get_product_regular_price_forced( $wc_product, $settings );
	$regular_price_forced = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $regular_price_forced );
	if ( empty( $regular_price_forced ) ) {
		return '';
	}
	return wc_format_localized_price( $regular_price_forced ) .' '. get_woocommerce_currency();
}

function woogool_get_product_sale_price_forced( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return wc_get_price_including_tax( $wc_product, array( 'price'=> $wc_product->get_sale_price() ) );
}
function woogool_get_product_compare_sale_price_forced( $wc_product, $settings, $feed_content ) {
	$sale_price_forced = woogool_get_product_sale_price_forced( $wc_product, $settings );
	$sale_price_forced = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $sale_price_forced );
	if ( empty( $sale_price_forced ) ) {
		return '';
	}
	return wc_format_localized_price( $sale_price_forced ) .' '. get_woocommerce_currency();
}

function woogool_get_product_sale_date_from( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$date = $wc_product->get_date_on_sale_from();
	if ( empty( $date ) ) {
		return '';
	}
	return $date->date('Y-m-d H:i:s');
}
function woogool_get_product_compare_sale_date_from( $wc_product, $settings, $feed_content ) {
	$date = woogool_get_product_sale_date_from( $wc_product, $settings );

	if ( empty( $date ) ) {
		return false;
	}
	
	if( is_object( $date ) ) {
		$date = $date->date('Y-m-d');
	} else {
		$date = date( 'Y-m-d', strtotime( $date ) );
	}
	
	$date = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $date );
	return $date;
}

function woogool_get_product_sale_date_to( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$date = $wc_product->get_date_on_sale_to();
	if ( empty( $date ) ) {
		return '';
	}
	return $date->date('Y-m-d H:i:s');
}
function woogool_get_product_compare_sale_date_to( $wc_product, $settings, $feed_content ) {
	$date = woogool_get_product_sale_date_to( $wc_product, $settings );

	if ( empty( $date ) ) {
		return false;
	}
	
	$date = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $date );
	return $date;
}

function woogool_get_product_sale_price_effective_date( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$start = $wc_product->get_date_on_sale_from();
	$end   = $wc_product->get_date_on_sale_to();

	if ( ! empty( $start ) && ! empty( $end ) ) {
		return $start->date( 'Y-m-d' ) .'/'. $end->date( 'Y-m-d' );
	}
	
	if ( ! empty( $start ) ) {
		return $start->date( 'Y-m-d' );
	}

	if ( ! empty( $end ) ) {
		return $end->date( 'Y-m-d' );
	}
	
	return false;
}
function woogool_get_product_compare_sale_price_effective_date( $wc_product, $settings ) {
	return woogool_get_product_sale_price_effective_date( $wc_product, $settings );
}

function woogool_get_product_link( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return esc_url( $wc_product->get_permalink() );
}
function woogool_get_product_compare_link( $wc_product ) {
	return woogool_get_product_link( $wc_product );
}

function woogool_get_product_currency( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_woocommerce_currency();
}
function woogool_get_product_compare_currency( $wc_product, $settings ) {
	return woogool_get_product_currency( $wc_product, $settings );
}

function woogool_get_product_category_slugs( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$product_cats = $wc_product->get_category_ids();
	$cat_slug = [];
	foreach ( $product_cats as $key => $cat_id ) {
		$cat = get_term_by( 'id', $cat_id, 'product_cat' );
		$cat_slug[] = $cat->slug;
	}

	return $cat_slug;
}
function woogool_get_product_category_ids( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_category_ids();
}
function woogool_get_product_compare_categories( $wc_product, $settings ) {
	$google_cats  = maybe_unserialize( reset( $settings['google_categories'] ) );
	$product_cats = woogool_get_product_category_ids( $wc_product, $settings );
	$maps         = array();
	$filter_maps  = array();

	foreach ( $google_cats as $key => $google_cat ) {
		if ( in_array( $google_cat['catId'], $product_cats ) ) {
			$maps[] = $google_cat['googleCat']['id'];
		}
	}
	
	foreach ( $maps as $key => $map ) {
		$gcat = explode( '-', preg_replace('/\s+/', '', $map ) );
		$filter_maps[] = reset( $gcat );
	}

	return implode( '||', $filter_maps );
}

function woogool_get_product_categorie_links( $wc_product ) {
	if(!$wc_product) {
		return '';
	}

	$product_cats = $wc_product->get_category_ids();
	$cat_links = [];
	foreach ( $product_cats as $key => $cat_id ) {
		$cat = get_term_by( 'id', $cat_id, 'product_cat' );
		$cat_links[] = esc_url( get_category_link( $cat->term_id ) );
	}

	return $cat_links;
}

function woogool_get_product_compare_categorie_links( $wc_product, $settings ) {
	$google_cats  = maybe_unserialize( reset( $settings['google_categories'] ) );
	$product_cats = $wc_product->get_category_ids();
	$maps         = array();

	foreach ( $google_cats as $key => $google_cat ) {
		if ( in_array( $google_cat['catId'], $product_cats ) ) {
			$maps[] = esc_url( get_category_link( $google_cat['catId'] ) );
		}
	}

	return implode( '||', $maps );
}

function woogool_get_product_static_value( $feed_content ) {
	if ( $feed_content['woogool_suggest'] != 'static_value' ) {
		return '';
	}

	return $feed_content['static_value'];
}

function woogool_get_product_compare_static_value( $wc_product, $settings, $feed_content ) {
	$static_value = woogool_get_product_static_value( $feed_content );
	$static_value = woogool_compare_with_logical_value( $wc_product, $settings, $feed_content['name'], $static_value );

	return $static_value;
}

function woogool_get_product_condition( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_condition', true );
}
function woogool_get_product_compare_condition( $wc_product, $settings ) {
	$condition = ucfirst( woogool_get_product_condition( $wc_product, $settings ) );
	return empty( $condition ) ? false : $condition;
}

function woogool_get_product_availability( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_stock_status();
}
function woogool_get_product_compare_availability( $wc_product, $settings ) {
	$stock_status = woogool_get_product_availability( $wc_product, $settings );

	if ( $stock_status == 'instock' ) {
		return 'in stock';
	} 
	return 'out of stock';
}

function woogool_get_product_stock_quantity( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_stock_quantity();
}
function woogool_get_product_compare_stock_quantity( $wc_product, $settings ) {
	$quantity = woogool_get_product_stock_quantity( $wc_product, $settings );

	return $quantity ? $quantity : '00';
}

function woogool_get_product_exclude_from_catalog( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$catalog = 'no';
	
	$visibility_list = wp_get_post_terms( $wc_product->get_id(), 'product_visibility', array( 'fields' => 'all' ) );
	
	foreach( $visibility_list as $visibility_single ) {
		if( $visibility_single->slug == 'exclude-from-catalog' ) {
			$catalog = 'yes';
		}
	}

	return $catalog;
}

function woogool_get_product_exclude_from_search( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$search = 'no';
	
	$visibility_list = wp_get_post_terms( $wc_product->get_id(), 'product_visibility', array( 'fields' => 'all' ) );
	
	foreach( $visibility_list as $visibility_single ) {
		if( $visibility_single->slug == 'exclude-from-search' ) {
			$search = 'yes';
		}
	}

	return $search;
}

function woogool_get_product_exclude_from_all( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$search = 'no';
	$catalog = 'no';
	$all    = 'no';
	
	$visibility_list = wp_get_post_terms( $wc_product->get_id(), 'product_visibility', array( 'fields' => 'all' ) );
	
	foreach( $visibility_list as $visibility_single ) {
		if( $visibility_single->slug == 'exclude-from-catalog' ) {
			$catalog = 'yes';
		}

		if( $visibility_single->slug == 'exclude-from-search' ) {
			$search = 'yes';
		}
	}

	if ( $search == 'yes' && $catalog == 'yes' ) {
		$all = 'yes';
	}

	return $all;
}

function woogool_get_product_group_id( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_parent_id();
}

function woogool_get_product_publication_date( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_the_date( 'd-m-y G:i:s', $wc_product->get_id() );
}
function woogool_get_product_compare_publication_date( $wc_product, $settings ) {
	return woogool_get_product_publication_date( $wc_product );
}

function woogool_get_product_weight( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_weight();
}
function woogool_get_product_compare_weight( $wc_product, $settings ) {
	$weight = woogool_get_product_weight( $wc_product );
	if ( empty( $weight ) ) {
		return '';
	}
	return $weight .' '. strtolower( get_option( 'woocommerce_weight_unit', 'kg' ) );
}

function woogool_get_product_width( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_width();
}
function woogool_get_product_compare_width( $wc_product, $settings ) {
	$width = woogool_get_product_width( $wc_product );
	if ( empty( $width ) ) {
		return '';
	}

	return woogool_get_product_width( $wc_product ) .' '. strtolower( get_option( 'woocommerce_dimension_unit', 'm' ) );
}

function woogool_get_product_height( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_height();
}
function woogool_get_product_compare_height( $wc_product, $settings ) {
	$height = woogool_get_product_height( $wc_product );
	if ( empty( $height ) ) {
		return '';
	}

	return woogool_get_product_height( $wc_product ) .' '. strtolower( get_option( 'woocommerce_dimension_unit', 'm' ) );
}

function woogool_get_product_length( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_length();
}
function woogool_get_product_compare_length( $wc_product, $settings ) {
	$length = woogool_get_product_length( $wc_product );
	if ( empty( $length ) ) {
		return '';
	}
	return woogool_get_product_length( $wc_product ) .' '. strtolower( get_option( 'woocommerce_dimension_unit', 'm' ) );
}

function woogool_get_product_custom_attributes__woogool_ean( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_ean', true );
}
function woogool_get_product_compare_custom_attributes__woogool_ean( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_ean( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_mpn( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_mpn', true );
}
function woogool_get_product_compare_custom_attributes__woogool_mpn( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_mpn( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_gtin( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_gtin', true );
}
function woogool_get_product_compare_custom_attributes__woogool_gtin( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_gtin( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_upc( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_upc', true );
}
function woogool_get_product_compare_custom_attributes__woogool_upc( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_upc( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_brand( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_brand', true );
}
function woogool_get_product_compare_custom_attributes__woogool_brand( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_brand( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_condition($wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_condition', true );
}
function woogool_get_product_compare_custom_attributes__woogool_condition($wc_product, $settings) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_condition($wc_product, $settings) );
}

function woogool_get_product_custom_attributes__woogool_optimized_title( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_optimized_title', true );
}
function woogool_get_product_compare_custom_attributes__woogool_optimized_title( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_optimized_title( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_unit_pricing_measure( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_unit_pricing_measure', true );
}
function woogool_get_product_compare_custom_attributes__woogool_unit_pricing_measure( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_unit_pricing_measure( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_unit_pricing_base_measure( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_unit_pricing_base_measure', true );
}
function woogool_get_product_compare_custom_attributes__woogool_unit_pricing_base_measure( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_unit_pricing_base_measure( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_installment_months( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_installment_months', true );
}
function woogool_get_product_compare_custom_attributes__woogool_installment_months( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_installment_months( $wc_product, $settings ) );
}

function woogool_get_product_custom_attributes__woogool_installment_amount( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return get_post_meta( $wc_product->get_id(), '_woogool_installment_amount', true );
}
function woogool_get_product_compare_custom_attributes__woogool_installment_amount( $wc_product, $settings ) {
	return ucfirst( woogool_get_product_custom_attributes__woogool_installment_amount( $wc_product, $settings ) );
}

function woogool_get_product_is_visible( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->is_visible();
}
function woogool_get_product_compare_is_visible( $wc_product, $settings ) {
	return $wc_product->is_visible();
}

function woogool_get_product_image( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	return wp_get_attachment_url( $wc_product->get_image_id() );
}

function woogool_get_product_feature_image( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$feature_image = 0;

	if ( has_post_thumbnail( $wc_product->get_id() ) ) {
     	$image = wp_get_attachment_image_src(get_post_thumbnail_id( $wc_product->get_id() ), 'single-post-thumbnail');
        $feature_image = woogool_get_image_url( $image[0] );
    } else {
       	$feature_image = woogool_get_image_url( wp_get_attachment_url( $wc_product->get_image_id() ) );
    }

    return $feature_image;
}

function woogool_get_product_image_url( $wc_product ){
	if ( has_post_thumbnail( $wc_product->get_id() ) ) {
        $attachment_id = get_post_thumbnail_id( $wc_product->get_id() );
        $url = wp_get_attachment_image_src( $attachment_id, 'full' );   

        if(!empty($url)) {
        	return $url[0];
        }
    } 

    return '';
}

function woogool_get_product_image_1( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[0] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[0] );
}
function woogool_get_product_image_2( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[1] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[1] );
}
function woogool_get_product_image_3( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[2] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[2] );
}
function woogool_get_product_image_4( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[3] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[3] );
}
function woogool_get_product_image_5( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[4] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[4] );
}
function woogool_get_product_image_6( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[5] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[5] );
}
function woogool_get_product_image_7( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[6] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[6] );
}
function woogool_get_product_image_8( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[7] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[7] );
}
function woogool_get_product_image_9( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[8] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[8] );
}
function woogool_get_product_image_10( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[9] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[9] );
}

function woogool_get_product_dynamic_value( $wc_product, $attr ) {
	if(!$wc_product) {
		return '';
	}

	$attr_value = '';
	
	$extract = explode( 'custom_attributes_', $attr );

	if ( isset( $extract[1] ) && ! empty( $extract[1] )  ) {
		$attr = $extract[1];
		$attr_value = $wc_product->get_attribute( $attr );
	}
	
	return $attr_value;
}

// function woogool_get_product_dynamic_value( $wc_product, $attr ) {
// 	if(!$wc_product) {
// 		return '';
// 	}
// 	$attr_value = '';

// 	if ( strpos( $attr, 'pa_' ) !== false ) {
// 		$attr_value = $wc_product->get_attribute( $attr );
// 	}

// 	if ( strpos( $attr, 'attribute_' ) !== false ) {
// 		$attr_value = get_post_meta( $wc_product->get_id(), $attr, true );

// 	}

// 	return $attr_value;
// }

function woogool_get_product_compare_dynamic_value( $wc_product, $settings, $attr ) {

	$attr_value = woogool_get_product_dynamic_value( $wc_product, $attr );

	$attr_value = woogool_compare_with_logical_value( $wc_product, $settings, $attr, $attr_value );

	return $attr_value;
}

function woogool_get_product_tags( $wc_product ) {
	if(!$wc_product) {
		return '';
	}
	$tags = [];

	$product_tags = get_the_terms( $wc_product->get_id(), 'product_tag' );
	if ( is_array( $product_tags ) ) {

		foreach( $product_tags as $term ) {
			$tags[] = $term->name;
		}
	}

	if ( ! empty( $tags ) ) {
		return implode( ',', $tags );
	}

	return false;
}

function woogool_get_product_installment( $wc_product, $settings ) {
	$installment = "";
    $currency = get_woocommerce_currency();
    
	$installment_months = woogool_get_product_custom_attributes__woogool_installment_months( $wc_product, $settings );
	$installment_amount = woogool_get_product_custom_attributes__woogool_installment_amount( $wc_product, $settings );

	if ( ! empty( $installment_amount ) ) {
		$installment = $installment_months.":".$installment_amount." ".$currency;
	}
	return $installment;
}

function woogool_compare_with_logical_value( $wc_product, $settings, $key, $product_val ) {
	$logic     = maybe_unserialize( reset( $settings['logic'] ) );
	$sign      = woogool_condition_maping_func();
	$value_map = woogool_product_value_maping_func();
	
	foreach ( $logic as $log_key => $logic_attr ) {
		$if_cond = $logic_attr['if_cond'];

		if ( 
			isset( $logic_attr['type'] ) 
				&&  
			$logic_attr['type'] == 'filter' 
		) 
		{
			continue;
		}

		if ( 
			$logic_attr['if_cond'] == $key
				||
			$logic_attr['then'] == $key
		) {
			$call = empty( $value_map[$if_cond] ) ? '' : $value_map[$if_cond];
			
			if ( function_exists( $call ) ) {
            	$if_product_val = $call( $wc_product );
        	} else if ( $key == 'static_value' ) {
        		$if_product_val = $product_val;
        	} else {
        		$if_product_val = woogool_get_product_dynamic_value( $wc_product, $key );
        	}

			$logic_val = $logic_attr['value'];
			
			if ( $sign[$logic_attr['condition']]( $if_product_val, $logic_val ) ) {
				$product_val = $logic_attr['is'];
			}
		}
	}
	
	return $product_val;
}

function woogool_get_product_type($wc_product) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_type();
}
function woogool_get_product_compare_type($wc_product, $settings) {
	return woogool_get_product_type( $wc_product );
}

function woogool_get_product_rating_count($wc_product) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_rating_count();
}

function woogool_get_product_average_rating($wc_product) {
	if(!$wc_product) {
		return '';
	}
	return $wc_product->get_average_rating();
}

function woogool_get_product_identifier_exists() {
	return 'no';
}

function woogool_product_attributes_maping_func() {
	$attributes =  array(
		'id'                        => 'woogool_get_product_compare_id',
		'sku'                       => 'woogool_get_product_compare_sku', 
		'title'                     => 'woogool_get_product_compare_title',
		'mother_title'              => 'woogool_get_product_compare_mother_title',
		'description'               => 'woogool_get_product_compare_description',
		'short_description'         => 'woogool_get_product_compare_short_description',
		'price'                     => 'woogool_get_product_compare_price',
		'regular_price'             => 'woogool_get_product_compare_regular_price',
		'sale_price'                => 'woogool_get_product_compare_sale_price',
		'net_price'                 => 'woogool_get_product_compare_net_price',
		'net_regular_price'         => 'woogool_get_product_compare_net_regular_price',
		'net_sale_price'            => 'woogool_get_product_compare_net_sale_price',
		'price_forced'              => 'woogool_get_product_compare_price_forced',
		'regular_price_forced'      => 'woogool_get_product_compare_regular_price_forced',
		'sale_price_forced'         => 'woogool_get_product_compare_sale_price_forced',
		'sale_price_start_date'     => 'woogool_get_product_compare_sale_date_from',
		'sale_price_end_date'       => 'woogool_get_product_compare_sale_date_to',
		'sale_price_effective_date' => 'woogool_get_product_compare_sale_price_effective_date',
		'link'                      => 'woogool_get_product_compare_link',
		'currency'                  => 'woogool_get_product_compare_currency',
		'categories'                => 'woogool_get_product_compare_categories',
		'category_link'             => 'woogool_get_product_compare_categorie_links',
		'condition'                 => 'woogool_get_product_compare_condition',
		'availability'              => 'woogool_get_product_compare_availability',
		'quantity'                  => 'woogool_get_product_compare_stock_quantity',
		'product_type'              => 'woogool_get_product_compare_type',
		'exclude_from_catalog'      => 'woogool_get_product_exclude_from_catalog',
		'exclude_from_search'       => 'woogool_get_product_exclude_from_search',
		'exclude_from_all'          => 'woogool_get_product_exclude_from_all',
		'publication_date'          => 'woogool_get_product_compare_publication_date',
		'weight'                    => 'woogool_get_product_compare_weight',
		'width'                     => 'woogool_get_product_compare_width',
		'height'                    => 'woogool_get_product_compare_height',
		'length'                    => 'woogool_get_product_compare_length',
		"product_tag"               => "woogool_get_product_tags",
		"installment"               => "woogool_get_product_installment",
		'visibility'                => 'woogool_get_product_compare_is_visible',
		'rating_total'              => 'woogool_get_product_rating_count',
		'rating_average'            => 'woogool_get_product_average_rating',
		'_woogool_brand'                     => 'woogool_get_product_compare_custom_attributes__woogool_brand',
		'_woogool_ean'                       => 'woogool_get_product_compare_custom_attributes__woogool_ean',
		'_woogool_gtin'                      => 'woogool_get_product_compare_custom_attributes__woogool_gtin',
		'_woogool_mpn'                       => 'woogool_get_product_compare_custom_attributes__woogool_mpn',
		'_woogool_upc'                       => 'woogool_get_product_compare_custom_attributes__woogool_upc',
		'_woogool_optimized_title'           => 'woogool_get_product_compare_custom_attributes__woogool_optimized_title',
		'_woogool_condition'                 => 'woogool_get_product_compare_custom_attributes__woogool_condition',
		'_woogool_unit_pricing_measure'      => 'woogool_get_product_compare_custom_attributes__woogool_unit_pricing_measure',
		'_woogool_unit_pricing_base_measure' => 'woogool_get_product_compare_custom_attributes__woogool_unit_pricing_base_measure',
		'_woogool_installment_amount'        => 'woogool_get_product_compare_custom_attributes__woogool_installment_amount', 
		'_woogool_installment_months'        => 'woogool_get_product_compare_custom_attributes__woogool_installment_months',
		'woogool_get_identifier_exists'      => 'woogool_get_product_identifier_exists',
		//'static_value'                       => 'woogool_get_product_compare_static_value'
	);

	$images = array(
		"image"         => "woogool_get_product_image",
		"feature_image" => "woogool_get_product_image_url",
		"image_1"       => "woogool_get_product_image_1",
		"image_2"       => "woogool_get_product_image_2",
		"image_3"       => "woogool_get_product_image_3",
		"image_4"       => "woogool_get_product_image_4",
		"image_5"       => "woogool_get_product_image_5",
		"image_6"       => "woogool_get_product_image_6",
		"image_7"       => "woogool_get_product_image_7",
		"image_8"       => "woogool_get_product_image_8",
		"image_9"       => "woogool_get_product_image_9",
		"image_10"      => "woogool_get_product_image_10",
	);

	$attributes = array_merge( $attributes, $images );

	return $attributes;
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
    
    if( isset( $custom_attributes['custom_attributes__woogool_exclude_product'] ) ) {
    	unset( $custom_attributes['custom_attributes__woogool_exclude_product'] );
    }

    $attributes = array (
    	'main_attributes' => array (
    		'label' => 'Main attributes',
    		'attributes' => array (
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
				//"sale_price_effective_date" => "Sale price effective date",
				"link"                      => "Link",
				"currency"                  => "Currency",
				"categories"                => "Category (Slug)",
				"category_link"             => "Category link",
				//"category_path"             => "Category path",
				"condition"                 => "Condition",
				"availability"              => "Stock Availability",
				"quantity"                  => "Quantity [Stock]",
				"product_type"              => "Product Type",
				//"content_type"              => "Content Type",
				"exclude_from_catalog"      => "Excluded from catalog",
				"exclude_from_search"       => "Excluded from search",
				"exclude_from_all"          => "Excluded from all (hidden)",
				"publication_date"          => "Publication date",
				"item_group_id"             => "Item group ID",
				"weight"                    => "Weight",
				"width"                     => "Width",
				"height"                    => "Height",
				"length"                    => "Length",
				//"shipping"                  => "Shipping",
				"visibility"                => "Visibility",
				"rating_total"              => "Total rating",
				"rating_average"            => "Average rating",
			)
    	),

   //  	'image_attributes' => array (

   //  		'label' => 'Image attributes',
   //  		'attributes' => array(
			// 	"image"         => "Main image",
			// 	"feature_image" => "Featured image",
			// 	"image_1"       => "Additional image 1",
			// 	"image_2"       => "Additional image 2",
			// 	"image_3"       => "Additional image 3",
			// 	"image_4"       => "Additional image 4",
			// 	"image_5"       => "Additional image 5",
			// 	"image_6"       => "Additional image 6",
			// 	"image_7"       => "Additional image 7",
			// 	"image_8"       => "Additional image 8",
			// 	"image_9"       => "Additional image 9",
			// 	"image_10"      => "Additional image 10",
			// )
   //  	),

    	'dynamic_attributes' => array (
    		'label' => 'Dynamic attributes',
    		'attributes' => $dynamic_attributes,
    	),

    	// 'google_category_taxonomy' => array (
    	// 	'label' => 'Google category taxonomy',
    	// 	'attributes' => array (
    	// 		'google_category' => 'Google category',
    	// 	)
    	// ),

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

        $no_taxonomies = array("action-group","portfolio_category","portfolio_skills","portfolio_tags","nav_menu","post_format","slide-page","element_category","template_category","portfolio_category","portfolio_skills","portfolio_tags","faq_category","slide-page","yst_prominent_words","category","post_tag","nav_menu","link_category","post_format","product_type","product_visibility","product_cat","product_shipping_class","product_tag");
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
     	$sql = "SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type 
     			FROM " . $wpdb->prefix . "postmeta" . " AS meta, " . $wpdb->prefix . "posts" . " AS posts 
     			WHERE meta.post_id = posts.id AND posts.post_type LIKE '%product%'
				AND meta.meta_key NOT LIKE 'pyre%' 
				AND meta.meta_key NOT LIKE 'sbg_%' 
				AND meta.meta_key NOT LIKE 'wccaf_%' 
				AND meta.meta_key NOT LIKE 'rp_%' 
				AND (meta.meta_key NOT LIKE '\_%' 
				OR meta.meta_key LIKE '\_woogool%' 
				OR meta.meta_key LIKE '\_yoast%' 
				OR meta.meta_key='_product_attributes') 
				GROUP BY meta.meta_key ORDER BY meta.meta_key ASC;";
		
		$data = $wpdb->get_results($sql);

      	if ( count( $data ) ) {
     		foreach ( $data as $key => $value ) {

				if ( !preg_match( "/_product_attributes/i", $value->name ) ) {
					$value_display = str_replace("_", " ",$value->name);
	                $list[$value->name] = ucfirst($value_display);
	            } else {
					$sql = "SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type FROM " . $wpdb->prefix . "postmeta" . " AS meta, " . $wpdb->prefix . "posts" . " AS posts WHERE meta.post_id = posts.id AND posts.post_type LIKE '%product%' AND meta.meta_key='_product_attributes';";
					$data = $wpdb->get_results( $sql );
					
	      			if ( count( $data ) ) {
	     				foreach ( $data as $key => $value ) {
							$product_attr = unserialize( $value->type );
							
							if( !empty( $product_attr ) ){
								foreach ( $product_attr as $key => $arr_value ) {
									$value_display = str_replace( "_", " ", $arr_value['name'] );
	               	     			$list["custom_attributes_" . $key] = ucfirst( $value_display );
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

function woogool_product_value_maping_func() {
	$attributes =  array(
		'id'                          => 'woogool_get_product_id',
		'sku'                         => 'woogool_get_product_sku', 
		'title'                       => 'woogool_get_product_title',
		'mother_title'                => 'woogool_get_product_mother_title',
		'description'                 => 'woogool_get_product_description',
		'short_description'           => 'woogool_get_product_short_description',
		'price'                       => 'woogool_get_product_price',
		'regular_price'               => 'woogool_get_product_regular_price',
		'sale_price'                  => 'woogool_get_product_sale_price',
		'net_price'                   => 'woogool_get_product_net_price',
		'net_regular_price'           => 'woogool_get_product_net_regular_price',
		'net_sale_price'              => 'woogool_get_product_net_sale_price',
		'price_forced'                => 'woogool_get_product_price_forced',
		'regular_price_forced'        => 'woogool_get_product_regular_price_forced',
		'sale_price_forced'           => 'woogool_get_product_sale_price_forced',
		'sale_price_start_date'       => 'woogool_get_product_sale_date_from',
		'sale_price_end_date'         => 'woogool_get_product_sale_date_to',
		//'sale_price_effective_date' => 'woogool_get_product_sale_price_effective_date',
		'link'                        => 'woogool_get_product_link',
		'currency'                    => 'woogool_get_product_currency',
		'categories'                  => 'woogool_get_product_category_slugs',
		'category_link'               => 'woogool_get_product_categorie_links',
		// 'category_path'            => 'Category path',
		'condition'                   => 'woogool_get_product_condition',
		'availability'                => 'woogool_get_product_availability',
		'quantity'                    => 'woogool_get_product_stock_quantity',
		'product_type'                => 'woogool_get_product_type',
		
		'exclude_from_catalog'        => 'woogool_get_product_exclude_from_catalog',
		'exclude_from_search'         => 'woogool_get_product_exclude_from_search',
		'exclude_from_all'            => 'woogool_get_product_exclude_from_all',
		'publication_date'            => 'woogool_get_product_publication_date',
		'item_group_id'            	  => 'woogool_get_product_group_id',
		'weight'                      => 'woogool_get_product_weight',
		'width'                       => 'woogool_get_product_width',
		'height'                      => 'woogool_get_product_height',
		'length'                      => 'woogool_get_product_length',
		"product_tag"                 => "woogool_get_product_tags",
		"installment"                 => "woogool_get_product_installment",
		// 'shipping'                 => 'Shipping',
		'visibility'                  => 'woogool_get_product_is_visible',
		'rating_total'                => 'woogool_get_product_rating_count',
		'rating_average'              => 'woogool_get_product_average_rating',
		'_woogool_brand'                     => 'woogool_get_product_custom_attributes__woogool_brand',
		'_woogool_ean'                       => 'woogool_get_product_custom_attributes__woogool_ean',
		'_woogool_gtin'                      => 'woogool_get_product_custom_attributes__woogool_gtin',
		'_woogool_mpn'                       => 'woogool_get_product_custom_attributes__woogool_mpn',
		'_woogool_upc'                       => 'woogool_get_product_custom_attributes__woogool_upc',
		'_woogool_optimized_title'           => 'woogool_get_product_custom_attributes__woogool_optimized_title',
		'_woogool_condition'                 => 'woogool_get_product_custom_attributes__woogool_condition',
		'_woogool_unit_pricing_measure'      => 'woogool_get_product_custom_attributes__woogool_unit_pricing_measure',
		'_woogool_unit_pricing_base_measure' => 'woogool_get_product_custom_attributes__woogool_unit_pricing_base_measure',
		'_woogool_installment_amount'        => 'woogool_get_product_custom_attributes__woogool_installment_amount', 
		'_woogool_installment_months'        => 'woogool_get_product_custom_attributes__woogool_installment_months' 
	);

	$images = array(
		"image"         => "woogool_get_product_image",
		"feature_image" => "woogool_get_product_image_url",
		"image_1"       => "woogool_get_product_image_1",
		"image_2"       => "woogool_get_product_image_2",
		"image_3"       => "woogool_get_product_image_3",
		"image_4"       => "woogool_get_product_image_4",
		"image_5"       => "woogool_get_product_image_5",
		"image_6"       => "woogool_get_product_image_6",
		"image_7"       => "woogool_get_product_image_7",
		"image_8"       => "woogool_get_product_image_8",
		"image_9"       => "woogool_get_product_image_9",
		"image_10"      => "woogool_get_product_image_10",
	);

	$attributes = array_merge( $attributes, $images );

	return $attributes;
}


function woogool_condition_maping_func() {
	return array(
		'contains'               => 'woogool_contains',
		'does_not_contain'       => 'woogool_does_not_contain',
		'is_equal_to'            => 'woogool_is_equal',
		'is_not_equal_to'        => 'woogool_is_not_equal',
		'is_greater_than'        => 'woogool_is_greater_than',
		'is_greater_or_equal_to' => 'woogool_is_greater_or_equal',
		'is_less_than'           => 'woogool_is_less_than',
		'is_less_or_equal_to'    => 'woogool_is_less_or_equal',
		'is_empty'               => 'woogool_is_empty',
		// 'multiply'               => 'woogool_multiply',
		// 'divide'                 => 'woogool_divide',
		// 'plus'                   => 'woogool_plus',
		// 'minus'                  => 'woogool_minus',
		// 'replace'                => 'woogool_replace'

	);
}

function woogool_divide( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return $product_value;
	return $product_value / $cond_value;
}
function woogool_plus( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return $product_value;
	return $product_value + $cond_value;
}
function woogool_minus( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return $product_value;
	return $product_value - $cond_value;
}
function woogool_replace( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return $product_value;

	return $cond_value;
}
function woogool_multiply( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return $product_value;
	return $product_value * $cond_value;
}

function woogool_is_empty( $product_value ) {
	return empty( $product_value ) ? true : false;
}

function woogool_is_greater_than( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return false;

	return $product_value > $cond_value ? true : false;
}

function woogool_is_greater_or_equal( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return false;

	return $product_value >= $cond_value ? true : false;
}

function woogool_is_less_than( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return false;

	return $product_value < $cond_value ? true : false;
}

function woogool_is_less_or_equal( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return false;

	return $product_value <= $cond_value ? true : false;
}

function woogool_is_need_condition_value_convert_array( $value, $key ) {
	$default_key = ['categories'];

	if ( in_array( $key, $default_key ) ) {
		return explode( '|', preg_replace('/\s+/', '', $value ) );
	}

	return $value;
}

function woogool_contains( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) return false;

	if( ! is_array( $product_value ) ) {
		$product_value = array( $product_value );
	} 

	$cond_value = explode( '|', $cond_value ); //preg_replace('/\s+/', '', $cond_value )
	
 	if( is_array( $product_value ) && is_array( $cond_value ) ) {
		$result = array_intersect( $product_value, $cond_value );

		return ! empty( $result ) ? true : false;
	} 
	
	return false;
}

function woogool_does_not_contain( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) {
		return false;
	}
	
	if( ! is_array( $product_value ) ) {
		$product_value = array( $product_value );
	} 

	$cond_value = explode( '|', $cond_value ); //preg_replace('/\s+/', '', $cond_value ) 
	
	if( is_array( $product_value ) && is_array( $cond_value ) ) {
		$result = array_intersect( $product_value, $cond_value );

		return empty( $result ) ? true : false;
	} 
	
	return false;
}

function woogool_is_not_equal( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) {
		return false;
	}

	if ( is_array( $product_value ) ) {
		$product_value = implode( '|', $product_value );
	} 
	
	return $product_value != $cond_value ? true : false;
}

function woogool_is_equal( $product_value, $cond_value ) {
	if ( empty( $cond_value ) ) {
		return false;
	}

	if ( is_array( $product_value ) ) {
		$product_value = implode( '|', $product_value );
	} 
	
	return $product_value == $cond_value ? true : false;
}

/**
 * An improved function for the strip_tags
 * Removing tags but replacing them with spaces instead of just removing them
 */
function woogool_rip_tags( $string ) { 
	// ----- remove HTML TAGs ----- 
	$string = preg_replace ('/<[^>]*>/', ' ', $string); 

	// ----- remove control characters ----- 
	$string = str_replace("\r", '', $string);    // --- replace with empty space
	$string = str_replace("\n", ' ', $string);   // --- replace with space
	$string = str_replace("\t", ' ', $string);   // --- replace with space

	// ----- remove multiple spaces ----- 
	$string = trim(preg_replace('/ {2,}/', ' ', $string));

	return $string; 
}

/**
 * Strip unwanted UTF chars from string
 */
function woogool_utf8_for_xml( $string ){
	$string = html_entity_decode($string);
	return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
}












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

	// if ( is_array( woogool_get_dynamic_attributes() ) ) {
 //    	$dynamic_attributes = woogool_get_dynamic_attributes();
		
	// 	array_walk (
	// 		$dynamic_attributes, 
	// 		function( &$value, $key ) { 
	// 			$value .= ' (Dynamic attribute)'; 
	// 		} 
	// 	);
		
	// 	$attributes = array_merge($attributes, $dynamic_attributes);
	// }

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


function woogool_get_product_price( $wc_product, $settings ) {
	if ( empty( $wc_product->get_price() ) ) {
		return false;
	}
	return wc_format_localized_price( $wc_product->get_price() ) .' '. get_woocommerce_currency();
}

function woogool_get_product_regular_price( $wc_product, $settings ) {
	if ( empty( $wc_product->get_regular_price() ) ) {
		return false;
	}
	return wc_format_localized_price( $wc_product->get_regular_price() ) .' '. get_woocommerce_currency();
}

function woogool_get_product_sale_price( $wc_product, $settings ) {
	if ( empty( $wc_product->get_sale_price() ) ) {
		return false;
	}
	return wc_format_localized_price( $wc_product->get_sale_price() ) .' '. get_woocommerce_currency();
}



function woogool_get_product_net_price( $wc_product, $settings ) {
	if ( empty( $wc_product->get_price() ) ) {
		return false;
	}
	return wc_format_localized_price( wc_get_price_excluding_tax( $wc_product, array( 'price'=> $wc_product->get_price() ) ) ) .' '. get_woocommerce_currency();
}

function woogool_get_product_net_regular_price( $wc_product, $settings ) {
	if ( empty( $wc_product->get_regular_price() ) ) {
		return false;
	}
	return wc_format_localized_price( wc_get_price_excluding_tax( $wc_product, array( 'price'=> $wc_product->get_regular_price() ) ) ) .' '. get_woocommerce_currency();
}

function woogool_get_product_net_sale_price( $wc_product, $settings ) {
	if ( empty( $wc_product->get_sale_price() ) ) {
		return false;
	}
	return wc_format_localized_price( wc_get_price_excluding_tax( $wc_product, array( 'price'=> $wc_product->get_sale_price() ) ) ) .' '. get_woocommerce_currency();
}



function woogool_get_product_price_forced( $wc_product, $settings ) {
	if ( empty( $wc_product->get_price() ) ) {
		return false;
	}
	return wc_format_localized_price( wc_get_price_including_tax( $wc_product, array( 'price'=> $wc_product->get_price() ) ) ) .' '. get_woocommerce_currency();
}

function woogool_get_product_regular_price_forced( $wc_product, $settings ) {
	if ( empty( $wc_product->get_regular_price() ) ) {
		return false;
	}
	return wc_format_localized_price( wc_get_price_including_tax( $wc_product, array( 'price'=> $wc_product->get_regular_price() ) ) ) .' '. get_woocommerce_currency();
}

function woogool_get_product_sale_price_forced( $wc_product, $settings ) {
	if ( empty( $wc_product->get_sale_price() ) ) {
		return false;
	}
	return wc_format_localized_price( wc_get_price_including_tax( $wc_product, array( 'price'=> $wc_product->get_sale_price() ) ) ) .' '. get_woocommerce_currency();
}

function woogool_get_sale_date_from( $wc_product, $settings ) {
	$date = $wc_product->get_date_on_sale_from();

	if ( empty( $date ) ) {
		return false;
	}

	return $date->date('Y-m-d');
}
function woogool_get_sale_date_to( $wc_product, $settings ) {
	$date = $wc_product->get_date_on_sale_to();

	if ( empty( $date ) ) {
		return false;
	}
	
	return $date->date('Y-m-d');
}

function woogool_get_sale_price_effective_date( $wc_product, $settings ) {
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

function woogool_get_link( $wc_product, $settings ) {
	return $wc_product->get_permalink();
}

function woogool_get_product_currency( $wc_product, $settings ) {
	return get_woocommerce_currency();
}

function woogool_get_categories( $wc_product, $settings ) {
	$google_cats  = maybe_unserialize( reset( $settings['google_categories'] ) );
	$product_cats = $wc_product->get_category_ids();
	$maps         = array();
	$filter_maps  = array();

	foreach ( $google_cats as $key => $google_cat ) {
		if ( in_array( $google_cat['catId'], $product_cats ) ) {
			$maps[] = $google_cat['googleCat'];
		}
	}
	
	foreach ( $maps as $key => $map ) {
		$gcat = explode( '-', preg_replace('/\s+/', '', $map ) );
		$filter_maps[] = reset( $gcat );
	}

	return implode( '||', $filter_maps );
}

function woogool_get_categorie_links( $wc_product, $settings ) {
	$google_cats  = maybe_unserialize( reset( $settings['google_categories'] ) );
	$product_cats = $wc_product->get_category_ids();
	$maps         = array();

	foreach ( $google_cats as $key => $google_cat ) {
		if ( in_array( $google_cat['catId'], $product_cats ) ) {
			$maps[] = get_category_link( $google_cat['catId'] );
		}
	}

	return implode( '||', $maps );
}

function woogool_get_condition( $wc_product, $settings ) {
	$condition = ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_condition', true ) );

	return empty( $condition ) ? false : $condition;
}

function woogool_get_availability( $wc_product, $settings ) {
	$stock_status = $wc_product->get_stock_status();

	if ( $stock_status == 'instock' ) {
		return 'in stock';
	} 
	return 'out of stock';
}

function woogool_get_stock_quantity( $wc_product, $settings ) {
	$quantity = $wc_product->get_stock_quantity();

	return $quantity ? $quantity : '00';
}

function woogool_get_exclude_from_catalog( $wc_product, $settings ) {
	$catalog = 'no';
	
	$visibility_list = wp_get_post_terms( $wc_product->get_id(), 'product_visibility', array( 'fields' => 'all' ) );
	
	foreach( $visibility_list as $visibility_single ){
		if( $visibility_single->slug == 'exclude-from-catalog' ) {
			$catalog = 'yes';
		}
	}

	return $catalog;
}

function woogool_get_exclude_exclude_from_search( $wc_product, $settings ) {
	$search = 'no';
	
	$visibility_list = wp_get_post_terms( $wc_product->get_id(), 'product_visibility', array( 'fields' => 'all' ) );
	
	foreach( $visibility_list as $visibility_single ) {
		if( $visibility_single->slug == 'exclude-from-search' ) {
			$search = 'yes';
		}
	}

	return $search;
}

function woogool_get_exclude_from_all( $wc_product, $settings ) {
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

function woogool_get_publication_date( $wc_product, $settings ) {
	return get_the_date( 'd-m-y G:i:s', $wc_product->get_id() );
}

function woogool_get_weight( $wc_product, $settings ) {
	return $wc_product->get_weight() .' '. strtolower( get_option( 'woocommerce_weight_unit', 'kg' ) );
}
function woogool_get_width( $wc_product, $settings ) {
	return $wc_product->get_width() .' '. strtolower( get_option( 'woocommerce_dimension_unit', 'm' ) );
}
function woogool_get_height( $wc_product, $settings ) {
	return $wc_product->get_height() .' '. strtolower( get_option( 'woocommerce_dimension_unit', 'm' ) );
}
function woogool_get_length( $wc_product, $settings ) {
	return $wc_product->get_length() .' '. strtolower( get_option( 'woocommerce_dimension_unit', 'm' ) );
}

function custom_attributes__woogool_ean( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_ean', true ) );
}
function custom_attributes__woogool_mpn( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_mpn', true ) );
}
function custom_attributes__woogool_gtin( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_gtin', true ) );
}
function custom_attributes__woogool_upc( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_upc', true ) );
}
function custom_attributes__woogool_brand( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_brand', true ) );
}
function custom_attributes__woogool_condition($wc_product, $settings) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_condition', true ) );
}
function custom_attributes__woogool_optimized_title( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_optimized_title', true ) );
}
function custom_attributes__woogool_unit_pricing_measure( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_unit_pricing_measure', true ) );
}
function custom_attributes__woogool_unit_pricing_base_measure( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_unit_pricing_base_measure', true ) );
}
function custom_attributes__woogool_installment_months( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_installment_months', true ) );
}
function custom_attributes__woogool_installment_amount( $wc_product, $settings ) {
	return ucfirst( get_post_meta( $wc_product->get_id(), '_woogool_installment_amount', true ) );
}
function woogool_get_is_visible( $wc_product, $settings ) {
	return $wc_product->is_visible();
}
function woogool_get_image( $wc_product, $settings ) {
	return wp_get_attachment_url( $wc_product->get_image_id() );
}
function woogool_get_feature_image( $wc_product, $settings ) {
	$feature_image = 0;

	if ( has_post_thumbnail( $wc_product->get_id() ) ) {
     	$image = wp_get_attachment_image_src(get_post_thumbnail_id( $wc_product->get_id() ), 'single-post-thumbnail');
        $feature_image = woogool_get_image_url( $image[0] );
    } else {
       	$feature_image = woogool_get_image_url( wp_get_attachment_url( $wc_product->get_image_id() ) );
    }

    return $feature_image;
}

function woogool_get_image_url($image_url = ""){
	if ( ! empty( $image_url ) ) {
		if (substr(trim($image_url), 0, 4) === "http" || substr(trim($image_url), 0,5) === "https" || substr(trim($image_url), 0, 3) === "ftp" || substr(trim($image_url), 0, 4) === "sftp") {
    		return rtrim($image_url, "/");
		} else {
    		$base = get_site_url();
    		$image_url = $base . $image_url;
    		return rtrim($image_url, "/");
		}
	}
	return $image_url;
}

function woogool_get_image_1( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[0] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[0] );
}
function woogool_get_image_2( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[1] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[1] );
}
function woogool_get_image_3( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[2] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[2] );
}
function woogool_get_image_4( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[3] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[3] );
}
function woogool_get_image_5( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[4] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[4] );
}
function woogool_get_image_6( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[5] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[5] );
}
function woogool_get_image_7( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[6] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[6] );
}
function woogool_get_image_8( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[7] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[7] );
}
function woogool_get_image_9( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[8] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[8] );
}
function woogool_get_image_10( $wc_product, $settings ) {
	$images = $wc_product->get_gallery_image_ids();
	if ( empty( $images[9] ) ) {
		return false;
	}

	return wp_get_attachment_url( $images[9] );
}

function woogool_get_custom_value( $feed_content, $wc_product, $settings ) {
	$attributes = $wc_product->get_attributes();

	if ( empty( $attributes ) ) {
		return false;
	}

	if ( strpos( $feed_content['woogool_suggest'], 'custom_attributes_attribute_' ) !== false ) {
		$attr = explode( 'custom_attributes_attribute_', $feed_content['woogool_suggest'] );
		$attr_name = $attr[1];
		
		if ( is_array( $attributes ) ) {
			return empty( $attributes[$attr_name] ) ? false : $attributes[$attr_name]; 
		}
	}
	
	return false;
}

function woogool_get_tags( $wc_product, $settings ) {
	$tags = [];

	$product_tags = get_the_terms( $wc_product->get_id(), 'product_tag' );
	if ( is_array( $product_tags ) ) {

		foreach( $product_tags as $term ) {

			if( ! array_key_exists( 'product_tag', $product_data ) ) {
				$tags[] = $term->name;
			} else {
	            $tags[] = $term->name;
			}
		}
	}

	if ( ! empty( $tags ) ) {
		return implode( ',', $tags );
	}

	return false;
}

function woogool_get_installment( $wc_product, $settings ) {
	$installment = "";
    $currency = get_woocommerce_currency();
    
	$installment_months = custom_attributes__woogool_installment_months( $wc_product, $settings );
	$installment_amount = custom_attributes__woogool_installment_amount( $wc_product, $settings );

	if ( ! empty($installment_amount ) ){
		$installment = $installment_months.":".$installment_amount." ".$currency;
	}
	return $installment;
}


function woogool_product_attributes_maping_func() {
	$attributes =  array(
		'id'                        => 'get_id',
		'sku'                       => 'get_sku', 
		'title'                     => 'get_title',
		'mother_title'              => 'get_title',
		'description'               => 'get_description',
		'short_description'         => 'get_short_description',
		'price'                     => 'woogool_get_product_price',
		'regular_price'             => 'woogool_get_product_regular_price',
		'sale_price'                => 'woogool_get_product_sale_price',
		'net_price'                 => 'woogool_get_product_net_price',
		'net_regular_price'         => 'woogool_get_product_net_regular_price',
		'net_sale_price'            => 'woogool_get_product_net_sale_price',
		'price_forced'              => 'woogool_get_product_price_forced',
		'regular_price_forced'      => 'woogool_get_product_regular_price_forced',
		'sale_price_forced'         => 'woogool_get_product_sale_price_forced',
		'sale_price_start_date'     => 'woogool_get_sale_date_from',
		'sale_price_end_date'       => 'woogool_get_sale_date_to',
		'sale_price_effective_date' => 'woogool_get_sale_price_effective_date',
		'link'                      => 'woogool_get_link',
		'currency'                  => 'woogool_get_product_currency',
		'categories'                => 'woogool_get_categories',
		'category_link'             => 'woogool_get_categorie_links',
		// 'category_path'             => 'Category path',
		'condition'                 => 'woogool_get_condition',
		'availability'              => 'woogool_get_availability',
		'quantity'                  => 'woogool_get_stock_quantity',
		'product_type'              => 'get_type',
		// 'content_type'              => 'Content Type',
		'exclude_from_catalog'      => 'woogool_get_exclude_from_catalog',
		'exclude_from_search'       => 'woogool_get_exclude_exclude_from_search',
		'exclude_from_all'          => 'woogool_get_exclude_from_all',
		'publication_date'          => 'woogool_get_publication_date',
		// 'item_group_id'             => 'Item group ID',
		'weight'                    => 'woogool_get_weight',
		'width'                     => 'woogool_get_width',
		'height'                    => 'woogool_get_height',
		'length'                    => 'woogool_get_length',
		"product_tag"  => "woogool_get_tags",
		"installment"  => "woogool_get_installment",
		// 'shipping'                  => 'Shipping',
		'visibility'                => 'woogool_get_is_visible',
		'rating_total'              => 'get_rating_count',
		'rating_average'            => 'get_average_rating',
		'custom_attributes__woogool_brand' => 'custom_attributes__woogool_brand',
		'custom_attributes__woogool_ean' => 'custom_attributes__woogool_ean',
		'custom_attributes__woogool_gtin' => 'custom_attributes__woogool_gtin',
		'custom_attributes__woogool_mpn' => 'custom_attributes__woogool_mpn',
		'custom_attributes__woogool_upc' => 'custom_attributes__woogool_upc',
		'custom_attributes__woogool_optimized_title' => 'custom_attributes__woogool_optimized_title',
		'custom_attributes__woogool_condition' => 'custom_attributes__woogool_condition',
		'custom_attributes__woogool_unit_pricing_measure' => 'custom_attributes__woogool_unit_pricing_measure',
		'custom_attributes__woogool_unit_pricing_base_measure' => 'custom_attributes__woogool_unit_pricing_base_measure',
		'custom_attributes__woogool_installment_amount' => 'custom_attributes__woogool_installment_amount', 
		'custom_attributes__woogool_installment_months' => 'custom_attributes__woogool_installment_months' 
	);

	$images = array(
			"image"         => "woogool_get_image",
			"feature_image" => "woogool_get_image_url",
			"image_1"       => "woogool_get_image_1",
			"image_2"       => "woogool_get_image_2",
			"image_3"       => "woogool_get_image_3",
			"image_4"       => "woogool_get_image_4",
			"image_5"       => "woogool_get_image_5",
			"image_6"       => "woogool_get_image_6",
			"image_7"       => "woogool_get_image_7",
			"image_8"       => "woogool_get_image_8",
			"image_9"       => "woogool_get_image_9",
			"image_10"      => "woogool_get_image_10",
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
	                $list["custom_attributes_" . $value->name] = ucfirst($value_display);
	            } else {
					// $sql = "SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type FROM " . $wpdb->prefix . "postmeta" . " AS meta, " . $wpdb->prefix . "posts" . " AS posts WHERE meta.post_id = posts.id AND posts.post_type LIKE '%product%' AND meta.meta_key='_product_attributes';";
					// $data = $wpdb->get_results( $sql );
					
	    //   			if ( count( $data ) ) {
	    //  				foreach ( $data as $key => $value ) {
					// 		$product_attr = unserialize( $value->type );
							
					// 		if( !empty( $product_attr ) ){
					// 			foreach ( $product_attr as $key => $arr_value ) {
					// 				$value_display = str_replace( "_", " ", $arr_value['name'] );
	    //            	     			$list["custom_attributes_" . $key] = ucfirst( $value_display );
					// 			}
					// 		}
					// 	}
					// }
				}
            } 
            return $list;
     	}
     	return false;
}

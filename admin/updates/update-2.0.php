<?php
function woogool_old_posts() {
	global $wpdb;
	$post = $wpdb->prefix . 'posts';
	$postmeta = $wpdb->prefix . 'postmeta';

	$sql = $wpdb->prepare("SELECT pt.post_title, pt.ID, mt.* 
		FROM  $post as pt
		LEFT JOIN $postmeta as mt ON pt.ID=mt.post_id
		WHERE pt.post_status=%s 
			AND pt.post_type=%s",
			'publish', 'woogool_feed'
		);

	$results = $wpdb->get_results( $sql );
	$returns = [];

	foreach ( $results as $key => $result ) {
		$returns[$result->ID][$result->meta_key] = $result;
	}

	return $returns;
}

function woogool_update_meta() {

	$posts = woogool_old_posts();
	
	foreach ( $posts as $post_id => $post ) {
		$title = reset( $post );
		$title = $title->post_title;

		$metas = [
			'feed_by_category'   => woogool_feed_by_category( $post ),
			'active_variation'   => woogool_active_variation( $post ),
			'refresh'            => 2,
			'categories'         => woogool_categories( $post ),
			'google_categories'  => woogool_google_categories( $post ),
			'content_attributes' => woogool_content_attributes( $post ),
			'logic'              => [],
			'feed_file_name'     => woogool_feed_file_name( $post_id, $title )
		];

		foreach ( $metas as $meta_key => $meta_value) {
			update_post_meta( $post_id, $meta_key, $meta_value );
		}
	}

}

 //woogool_update_meta();

function woogool_feed_by_category( $post ) {
	$cats = empty( $post['_products_cat']->meta_value ) ? false : maybe_unserialize( $post['_products_cat']->meta_value ); 

	return ! empty( $cats ) ? true : false;
}

function woogool_active_variation( $post ) {
	return $post['_woogool_include_variable_products']->meta_value == 'yes' ? true : false;
}

function woogool_categories( $post ) {
	$cats = empty( $post['_products_cat']->meta_value ) ? false : maybe_unserialize( $post['_products_cat']->meta_value );

	if ( empty( $cats ) ) {
		return [];
	}

	$migrate_cats = [];
	
	foreach ( $cats as $key => $cat ) {
		$pro_cat = get_term_by('id', $cat, 'product_cat');

		$migrate_cats[] = [
			'catId' => $cat,
			'catName' => $pro_cat->name
		];
	}
	
	return $migrate_cats;
}

function woogool_google_categories( $post ) {
	
	$cats = empty( $post['_cat_map']->meta_value ) ? false : maybe_unserialize( $post['_cat_map']->meta_value );

	if ( empty( $cats ) ) {
		return [];
	}

	$google_cats = get_option( 'woogool_google_product_type' );
	$returns = [];

	foreach ( $cats as $cat_id => $gcat ) {
		$pro_cat = get_term_by('id', $cat_id, 'product_cat');

		$returns[] = [
			'catId'     => $cat_id,
			'catName'   => $pro_cat->name,
			'googleCat' => $google_cats[$gcat]
		];
	}

	return $returns;
}

function woogool_content_attributes( $post ) {
	return [
		[
			'label'           => 'Product ID',
			'name'            => 'id',
			'feed_name'       => 'g:id',
			'format'          => 'required',
			'woogool_suggest' => 'id',
			'type'            => 'default',
		],
		[
			'label'           => 'Product title',
			"name"            => "title",
			"feed_name"       => "g:title",
			"format"          => "required",
			"woogool_suggest" => "title",
			'type'            => 'default',
		],
		[
			'label'           => 'Product description',
			"name"            => "description",
			"feed_name"       => "g:description",
			"format"          => "required",
			"woogool_suggest" => "description",
			'type'            => 'default',
		],
		[
			'label'           => 'Product URL',
			"name"            => "link",
			"feed_name"       => "g:link",
			"format"          => "required",
			"woogool_suggest" => "link",
			'type'            => 'default',
		],
		[
			'label'           => 'Main image UR',
			"name"            => "image_link",
			"feed_name"       => "g:image_link",
			"format"          => "required",
			"woogool_suggest" => "image",
			'type'            => 'default',
		],
		[
			'label'       => 'Stock status',
			"name"        => "availability",
			"feed_name"   => "g:availability", 
			"format"      => "required",
			"woogool_suggest" => "availability",
			'type'            => 'default',
		],
		[
			'label'           => 'Price',
			"name"            => "Price",
			"feed_name"       => "g:price",
			"format"          => "required",
			"woogool_suggest" => "regular_price",
			'type'            => 'default',
		],
		[
			'label'           => 'Google product category',
			"name"            => "google_product_category",
			"feed_name"       => "g:google_product_category",
			"format"          => "required",
			"woogool_suggest" => "categories",
			'type'            => 'default',
		],
		[
			'label'     => 'brand',
			"name"      => "brand",
			"feed_name" => "g:brand",
			"format"    => "required",
			'type'      => 'default',
		],
		[
			'label'     => 'Gtin',
			"name"      => "gtin",
			"feed_name" => "g:gtin",
			"format"    => "required",
			'type'      => 'default',
		],
		[
			'label'     => 'MPN',
			"name"      => "mpn",
			"feed_name" => "g:mpn",
			"format"    => "required",
			'type'      => 'default',
		],
		[
			'label'           => 'Condition',
			"name"            => "condition",
			"feed_name"       => "g:condition",
			"format"          => "required",
			"woogool_suggest" => "condition",
			'type'            => 'default',
		],
		[
			'label'     => 'Adult',
			"name"      => "adult",
			"feed_name" => "g:adult",
			"format"    => "optional",
			'type'      => 'default',
		]
	];
}



function woogool_feed_file_name( $post_id, $title ) {
	$upload_dir = wp_upload_dir();
	$base      = $upload_dir['basedir'];
    $dir_path  = $base . '/woogool-product-feed/';
	$file_name = md5( 'woogool' . $post_id );
    $file_path = woogool_get_feed_file_path( $post_id ); 
    
    if( ! is_dir( $dir_path ) ) {
        wp_mkdir_p( $dir_path );
    }
    
    // Check if directory in uploads exists, if not create one  
    if ( ! file_exists( $file_path ) ) {

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss xmlns:g="http://base.google.com/ns/1.0"></rss>');
        $xml->addAttribute( 'version', '2.0' );
        $xml->addChild( 'channel' );
        $xml->channel->addChild( 'title', htmlspecialchars( $title ) );
        $xml->channel->addChild( 'link', site_url() );
        $xml->channel->addChild( 'description', 'WooCommerce Product Feed for google shopping' );
        $xml->asXML( $file_path );
    }

    return $file_name;
}


woogool_update_meta();






















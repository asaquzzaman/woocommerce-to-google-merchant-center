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
	
	foreach ( $posts as $key => $post ) {
		$metas = [
			'feed_by_category'   => woogool_feed_by_category( $post ),
			'active_variation'   => woogool_active_variation( $post ),
			'refresh'            => 2,
			'categories'         => woogool_categories( $post ),
			'google_categories'  => woogool_google_categories( $post ),
			'content_attributes' => woogool_content_attributes( $post ),
			'logic'              => [],
			'feed_file_name'     => woogool_feed_file_name( $post )
		];
	}

	die();
}

 woogool_update_meta();

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

}



function woogool_feed_file_name( $post ) {

}
























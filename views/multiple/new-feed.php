<?php
$taxonomies       = get_option( 'woogool_google_product_type' );
$get_products_cat = woogool_get_products_terms_dropdown_array();
//$offset           = 20;
// $products = woogool_get_products( 20 );

// while( count( $products ) ) {
//     $new_some_products = woogool_get_products( 20, $offset );
//     $products          = array_merge( $products, $new_some_products );
//     if ( ! count( $new_some_products ) ) {
//         break;
//     }
//     $offset            = $offset + 20;
// }
// $product_log = array();
// foreach ( $products as $key => $product) {
//     $product_log[$product->ID] = $product->post_title;
// }

$feed_fields = array();
$feed_id 	 = isset( $_GET['feed_id'] ) ? intval( $_GET['feed_id'] ) : 0;

if ( $feed_id ) {
	$post = get_post( $feed_id );
}


$feed_fields['feed_id'] = array(
	'type'     => 'hidden',
	'value'    => $feed_id
);

$feed_fields['post_title'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'value'    => isset( $post->post_title ) ? $post->post_title : '',
	'label'    => __( 'Name', 'woogool' ),
	'desc'     => __( 'Feed Name', 'woogool' ),
	'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
        'required' => 'required'
    )
);

$feed_fields['xml_count'] = array(
	'type'     => 'select',
	'label'    => __( 'Count', 'woogool' ),
	'option'   => woogool_xml_count(),
	'selected' => get_post_meta( $feed_id, '_xml_count', true ),
	'desc'     => __( 'How many products you want to generate at a time', 'woogool' ),
	'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
        'required' => 'required'
    )
);

$all_products = get_post_meta( $feed_id, '_all_products', true );

// $feed_fields['all_products'] = array(
//     'label' => __( 'Product', 'woogool' ),
//     'type' => 'select',
//     'class' => 'woogool-all-product-checkbox-feed',
//     'selected' => ! empty( $all_products ) ? $all_products : 'all',
//     'desc' => __( 'What kinds of product feed you want to generate', 'woogool' ),
//     'option' => array(
//     	'all' => __( 'All', 'woogool' ),
//     	//'individual' => __( 'Individual', 'woogool' ),
//     	'category' => __( 'Category', 'woogool' ),
//     ),

// );

$selected_products     = get_post_meta( $feed_id, '_products', true );
$selected_products_cat = get_post_meta( $feed_id, '_products_cat', true );
 
$feed_fields['html1'] = array(
	'type'       => 'html',
	'html'       => '<ul class="woogool-google-cat-ul"></ul>',
	'wrap_start' => true,
	'wrap_attr' => array(
		'class' => 'woogool-category-map-wrap',
		'style' => 'display: none;'
	),
	'wrap_close' => true,
);

if ( $feed_id ) {
	$feed_fields['html1'] = array(
		'type'       => 'html',
		'html'       => woogool_generte_save_cat( $feed_id, $taxonomies, $get_products_cat ),
		'wrap_start' => true,
		'wrap_attr' => array(
			'class' => 'woogool-category-map-wrap',
			//'style' => 'display: none;'
		),
		'wrap_close' => true,
	);
}



$feed_fields['products_cat[]'] = array(
	'type'     => 'multiple',
	'label'    => __( 'Category', 'woogool' ),
	'option'   => isset( $get_products_cat ) ? $get_products_cat : array(), //$taxonomies,
	'class'    => 'woogool-chosen woogool-google-cat', //Do not change the "woogool-google-cat" class 
	'selected' => empty( $selected_products_cat ) ? array() : $selected_products_cat,
	'desc'     => __( 'Categories of the product', 'woogool' )
);

// $feed_fields['products_cat[]'] = array(
// 	'type'     => 'multiple',
// 	'label'    => __( 'Category', 'woogool' ),
// 	'option'   => isset( $get_products_cat ) ? $get_products_cat : array(),
// 	'class'    => 'woogool-chosen woogool-google-cat',
// 	'selected' => empty( $selected_products_cat ) ? array() : $selected_products_cat,
// 	'desc'     => __( 'Non empty categories', 'woogool' ),
// 	'wrap_start' => true,
// 	'wrap_attr' => array(
// 		'class' => 'woogool-product-category-chosen-field-wrap',
// 		'style' => 'display: none;'
// 	),
// 	'wrap_close' => true,
// );

$feed_fields['woogool_description'] = array(
	'type'     => 'select',
	'label'    => __( 'Description', 'woogool' ),
	'option'   => array( 
		'description'       => __( 'Description', 'woogool' ),
		'short_description' => __( 'Short Description', 'woogool' )
	),
	'selected' => get_post_meta( $feed_id, '_woogool_description', true ),
	'desc'     => __( 'Product description type. <a href="https://support.google.com/merchants/answer/6324468" target="_blank">More Details</a>', 'woogool' ),
	'info'   => ''
);

$feed_fields['variable_products'] = array(
    'label' => __( 'Variable product', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Include variable product', 'woogool' ),
    'fields' => array(
        array(
            'label' => __( 'Variable product', 'woogool' ),
            'value' => 'yes',
            'checked' => get_post_meta( $feed_id, '_woogool_include_variable_products', true ),
            'class' => 'woogool-field',
        ),
    ),
);


// $feed_fields['google_product_category'] = array(
// 	'type'     => 'multiple',
// 	'label'    => __( 'Category Maping', 'woogool' ),
// 	'option'   => isset( $get_products_cat ) ? $get_products_cat : array(), //$taxonomies,
// 	'class'    => 'woogool-chosen woogool-google-cat', //Do not change the "woogool-google-cat" class 
// 	'selected' => array(),//get_post_meta( $feed_id, '_google_product_category', true ),
// 	'desc'     => __( 'Google\'s category of the item', 'woogool' )
// );

// $feed_fields['product_type'] = array(
// 	'type'     => 'select',
// 	'label'    => __( 'Product Type', 'woogool' ),
// 	'option'   => $taxonomies,
// 	'class'    => 'woogool-chosen',
// 	'selected' => get_post_meta( $feed_id, '_product_type', true ),
// 	'desc'     => __( 'Your category of the item', 'woogool' )
// );

$feed_fields['woogool_price'] = array(
	'type'     => 'select',
	'label'    => __( 'Price', 'woogool' ),
	'option'   => array( 
		'regular' => __( 'Regular Price', 'woogool' ),
		'sale' => __( 'Sale Price', 'woogool' )
	),
	'selected' => get_post_meta( $feed_id, '_woogool_price', true ),
	'desc'     => __( 'Your product’s price. <a href="https://support.google.com/merchants/answer/6324371" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['woogool_adult'] = array(
	'type'     => 'select',
	'label'    => __( 'Adult', 'woogool' ),
	'option'   => array( 
		'-1'   => __( '-Select-', 'woogool' ),
		'yes' => __( 'Yes', 'woogool' ),
		'no' => __( 'No', 'woogool' )
	),
	'selected' => get_post_meta( $feed_id, '_woogool_adult', true ),
	'desc'     => __( 'Indicate a product includes sexually suggestive content. <a href="https://support.google.com/merchants/answer/6324508" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['woogool_is_bundle'] = array(
	'type'     => 'select',
	'label'    => __( 'Is Bundle', 'woogool' ),
	'option'   => array( 
		'-1'   => __( '-Select-', 'woogool' ),
		'yes' => __( 'Yes', 'woogool' ),
		'no' => __( 'No', 'woogool' )
	),
	'selected' => get_post_meta( $feed_id, '_woogool_is_bundle', true ),
	'desc'     => __( 'Indicates a product is a merchant-defined custom group of different products featuring one main product. <a href="https://support.google.com/merchants/answer/6324449" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['woogool_multipack'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_woogool_multipack', true ),
 	'label'    => __( 'Multipack', 'woogool' ),
	'desc'     => __( 'The number of identical products sold within a merchant-defined multipack. <a href="https://support.google.com/merchants/answer/6324488" target="_blank">More Details</a>', 'woogool' ),
);

$feed_fields['woogool_material'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_woogool_material', true ),
 	'label'    => __( 'Material', 'woogool' ),
	'desc'     => __( 'Your product’s fabric or material. <a href="https://support.google.com/merchants/answer/6324410" target="_blank">More Details</a>', 'woogool' ),
);

$feed_fields['woogool_pattern'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_woogool_pattern', true ),
 	'label'    => __( 'Pattern', 'woogool' ),
	'desc'     => __( 'Your product’s pattern or graphic print. <a href="https://support.google.com/merchants/answer/6324483" target="_blank">More Details</a>', 'woogool' ),
);


$feed_fields['availability'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $feed_id, '_availability', true ),
	'label'    => __( 'Availability', 'woogool' ),
	'option'   => array( 'in stock' => 'in stock', 'out of stock' => 'out of stock', 'preorder' => 'preorder' ),
	'desc'     => __( 'Your product\'s availability. <a href="https://support.google.com/merchants/answer/6324448" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['availability_date'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'class'    => 'woogool-date-picker',
	'value'    => get_post_meta( $feed_id, '_availability_date', true ),
 	'label'    => __( 'Availability date', 'woogool' ),
	'desc'     => __( 'The date a pre-ordered product becomes available for delivery. <a href="https://support.google.com/merchants/answer/6324470" target="_blank">More Details</a>', 'woogool' ),
);

$feed_fields['condition'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $feed_id, '_condition', true ),
	'label'    => __( 'Condition', 'woogool' ),
	'option'   => array( 'new' => 'New', 'used' => 'Used', 'refurbished' => 'refurbished' ),
	'desc'     => __( 'Your product\'s condition. <a href="https://support.google.com/merchants/answer/6324469" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['brand'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_brand', true ),
	'label'    => __( 'Brand', 'woogool' ),
	'desc'     => __( 'Your product\'s brand name. <a href="https://support.google.com/merchants/answer/6324351" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['mpn'] = array(
	'type'     => 'checkbox',
	'label'    => __( 'MPN (SKU)', 'woogool' ),
	'desc'     => __( 'Your product\'s Manufacturer Part Number (mpn). <a href="https://support.google.com/merchants/answer/6324482" target="_blank">More Details</a>', 'woogool' ),
	'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'on',
            'checked' => get_post_meta( $feed_id, '_mpn', true ),
            'class'    => 'woogool-field',
        ),
    ),
);

$feed_fields['gtin'] = array(
	'type'     => 'checkbox',
	'label'    => __( 'GTIN', 'woogool' ),
	'desc'     => __( '<a href="http://mishubd.com/wordpress/gtin-for-woocommerce-to-google-merchant-center/" target="_blank">How to generate.</a> Your product\'s Global Trade Item Number (GTIN).  <a href="https://support.google.com/merchants/answer/6324461" target="_blank">More Details</a>', 'woogool' ),
	'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'on',
            'checked' => get_post_meta( $feed_id, '_gtin', true ),
            'class'    => 'woogool-field',
        ),
    ),
);

$feed_fields['gender'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'label'    => __( 'Gender', 'woogool' ),
	'selected' => get_post_meta( $feed_id, '_gender', true ),
	'option'   => array( '-1' => '--Select--', 'male' => 'male', 'female' => 'female', 'unisex' => 'unisex' ),
	'desc'     => __( 'Your product\'s targeted gender. <a href="https://support.google.com/merchants/answer/6324479" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['age_group'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $feed_id, '_age_group', true ),
	'label'    => __( 'Age Group', 'woogool' ),
	'option'   => array( '-1' => '--Select--', 'newborn' => 'newborn', 'infant' => 'infant', 'toddler' => 'toddler', 'kids' => 'kids', 'adult' => 'adult' ),
	'desc'     => __( 'Your product’s targeted demographic. <a href="https://support.google.com/merchants/answer/6324463" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['color'] = array(
	'type'     => 'checkbox',
	'label'    => __( 'Color', 'woogool' ),
	'desc'     => __( 'Your product\'s color(s). This color get from individual product color attributes value. Remember color attribute spell must be color. <a href="https://support.google.com/merchants/answer/6324487" target="_blank">More Details</a>', 'woogool' ),
	'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'on',
            'checked' => get_post_meta( $feed_id, '_color', true ),
            'class'    => 'woogool-field',
        ),
    ),
);

$feed_fields['size'] = array(
	'type'     => 'checkbox',
	'label'    => __( 'Size', 'woogool' ),
	'desc'     => __( 'Size of the item. This size get from individual product size attributes value. Remember size attribute spell must be size. <a href="https://support.google.com/merchants/answer/6324492" target="_blank">More Details</a>', 'woogool' ),
	'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'on',
            'checked' => get_post_meta( $feed_id, '_size', true ),
            'class'    => 'woogool-field',
        ),
    ),
);

$feed_fields['size_type'] = array(
	'type'     => 'select',
	'label'    => __( 'Size Type', 'woogool' ),
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $feed_id, '_size_type', true ),
	'option'   => array( '-1' => '--Select--', 'regular' => 'regular', 'petite' => 'petite', 'plus' => 'plus', 'big and tall' => 'big and tall', 'maternity' => 'maternity' ),
	'desc'     => __( 'Your apparel product\'s cut. <a href="https://support.google.com/merchants/answer/6324497" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['size_system'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'label'    => __( 'Size System', 'woogool' ),
	'selected' => get_post_meta( $feed_id, '_size_system', true ),
	'option'   => array(
		'-1'  => '--Select--',
		'US'  => 'US',
		'UK'  => 'UK',
		'EU'  => 'EU',
		'DE'  => 'DE',
		'FR'  => 'FR',
		'JP'  => 'JP',
		'CN'  => 'CN',
		'IT'  => 'IT',
		'BR'  => 'BR',
		'MEX' => 'MEX',
		'AU'  => 'AU'
	),
	'desc'     => __( 'The country of the size system used by your product. <a href="https://support.google.com/merchants/answer/6324502" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['identifier_exists'] = array(

	'type'     => 'checkbox',
	'label'    => __( 'Identifier Exists', 'woogool' ),
	'desc' => __( 'Required when unique product identifiers (mpn, brand, gtin) do not exist. Refer to the <a href="https://support.google.com/merchants/answer/6324478" target="_blank">Unique Product Identifier Rules.</a>', 'woogool' ),
	'fields' => array(
        array(
			'label'   => __( 'No', 'woogool' ),
			'value'   => 'on',
			'checked' => get_post_meta( $feed_id, '_identifier_exists', true ),
			'class'   => 'woogool-field',

        ),
    ),
);

$feed_fields['expiration_date'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'class'    => 'woogool-date-picker',
	'value'    => get_post_meta( $feed_id, '_expiration_date', true ),
 	'label'    => __( 'Expiration Date', 'woogool' ),
	'desc'     => __( 'The date that your product should stop showing. <a href="https://support.google.com/merchants/answer/6324499" target="_blank">More Details</a>', 'woogool' ),
);

// $feed_fields['sale_price'] = array(
// 	'label' => __( 'Sale Price', 'woogool' ),
// 	'type'  => 'checkbox',
// 	'desc'  => __( 'Include sale price', 'woogool' ),
//     'fields' => array(
//         array(
// 			'label'   => __( 'Sale Price', 'woogool' ),
// 			'value'   => 'yes',
// 			'checked' => get_post_meta( $feed_id, '_sale_price', true ),
// 			'class'   => 'woogool-field',
//         ),
//     ),
// );

$feed_fields['sale_price_effective_date'] = array(
	'label' => __( 'Effective Date', 'woogool' ),
	'type'  => 'checkbox',
	'desc'  => __( 'The date range during which the product\'s sale_​price applies. <a href="https://support.google.com/merchants/answer/6324460" target="_blank">More Details</a>', 'woogool' ),
    'fields' => array(
        array(
			'label'   => __( 'Date', 'woogool' ),
			'value'   => 'yes',
			'checked' => get_post_meta( $feed_id, '_sale_price_effective_date', true ),
			'class'   => 'woogool-field',
        ),
    ),
);

$feed_fields['html2'] = array(
	'type'       => 'html',
	'html'       => woogool_shipping_html(),
);

$feed_fields['html3'] = array(
	'type'       => 'html',
	'html'       => woogool_tax_html(),
);

$feed_fields['promotion_id'] = array(
	'type'     => 'text',
	'label'    => __( 'Promotion ID', 'woogool' ),
	'class'    => 'woogool-field',
	'value' => get_post_meta( $feed_id, '_promotion_id', true ),
	'desc'     => __( 'An identifier that allows to you match products to Merchant promotions. <a href="https://support.google.com/merchants/answer/7050148" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['custom_label_0'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 0', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_0', true ),
	'desc'     => __( 'Label that you assign to a product to help organize bidding and reporting in Shopping campaigns. <a href="https://support.google.com/merchants/answer/6324473" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['custom_label_1'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 1', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_1', true ),
	'desc'     => __( 'Label that you assign to a product to help organize bidding and reporting in Shopping campaigns. <a href="https://support.google.com/merchants/answer/6324473" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['custom_label_2'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 2', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_2', true ),
	'desc'     => __( 'Label that you assign to a product to help organize bidding and reporting in Shopping campaigns. <a href="https://support.google.com/merchants/answer/6324473" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['custom_label_3'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 3', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_3', true ),
	'desc'     => __( 'Label that you assign to a product to help organize bidding and reporting in Shopping campaigns. <a href="https://support.google.com/merchants/answer/6324473" target="_blank">More Details</a>', 'woogool' )
);

$feed_fields['custom_label_4'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 4', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_4', true ),
	'desc'     => __( 'Label that you assign to a product to help organize bidding and reporting in Shopping campaigns. <a href="https://support.google.com/merchants/answer/6324473" target="_blank">More Details</a>', 'woogool' )
);

?>
<div class="wrap">

	<?php woogool_merchan_configure_warning(); ?>
	<div class="metabox-holder">
		<div class="postbox">

				<h2 class="hndle"><?php _e( 'Generate Products Feed', 'woogool' ); ?></h2>
				<div class="woogool-feed-form-content">
					<form method="post" class="woogool-feed-form" action="">
					<?php
						wp_nonce_field( 'woogool_feed_nonce', 'feed_nonce' );
						foreach( $feed_fields as $name => $field_obj ) {

						    if( ! isset( $field_obj['type'] ) || empty( $field_obj['type'] ) ) {
						        continue;
						    }

						    switch ( $field_obj['type'] ) {
						        case 'text':
						            echo WooGool_Admin_Settings::getInstance()->text_field( $name, $field_obj );
						            break;
						        case 'select':
						            echo WooGool_Admin_Settings::getInstance()->select_field( $name, $field_obj );
						            break;
						        case 'textarea':
						            echo WooGool_Admin_Settings::getInstance()->textarea_field( $name, $field_obj );
						            break;
						        case 'radio':
						            echo WooGool_Admin_Settings::getInstance()->radio_field( $name, $field_obj );
						            break;
						        case 'checkbox':
						            echo WooGool_Admin_Settings::getInstance()->checkbox_field( $name, $field_obj );
						            break;
						        case 'hidden':
						            echo WooGool_Admin_Settings::getInstance()->hidden_field( $name, $field_obj );
						            break;
						        case 'multiple':
						            echo WooGool_Admin_Settings::getInstance()->multiple_select_field( $name, $field_obj );
						            break;
						        case 'html':
						            echo WooGool_Admin_Settings::getInstance()->html_field( $name, $field_obj );
						            break;
						    }
						}
						?>
						<div class="woogool-clear"></div>
						
						<?php
						if( woogool_is_pro() ) {
							?>
							<input type="submit" class="button button-primary woogool-new-feed-btn" value="<?php _e( 'Create Feed', 'woogool'); ?>" name="woogool_submit_feed">
							<?php
						} else {

							?>
							<a class="button button-primary" href="http://wpspear.com/product-feed/" target="_blank"><?php _e('This feature is available for pro version', 'woogool'); ?></a>
							<?php
						}
						?>
						
						<div class="woogool-spinner" style="display: none;"><?php _e( 'Please wait processing ', 'woogool' ); ?><span class="woogool-count"><?php echo WOOGOOL_FEED_PER_PAGE; ?></span><?php _e( ' products', 'woogool' ); ?></div>
					</form>
				</div>
				<div class="woogool-clear"></div>

				<div id="woogool-hidden-field" style="display: none;">
					<li class="woogool-cat-map-li woogool-clearfix">
						<input class="woogool-cat-map-field" type="hidden" name="cat_map[]" value="">
						<span class="woogool-cat-title"></span>
						<div class="woogool-cat-dropdown">
						<?php
						$google_cat = array(
							'type'     => 'select',
							//'label'    => __( 'Category Maping', 'woogool' ),
							'option'   => $taxonomies,
							'class'    => 'woogool-cat-select', //Do not change the "woogool-google-cat" class 
							'selected' => '',//get_post_meta( $feed_id, '_google_product_category', true ),
							'desc'     => __( 'Google product ​​category. <a href="https://support.google.com/merchants/answer/6324436" target="_blank">More Details</a>' , 'woogool' )
						);
						echo WooGool_Admin_Settings::getInstance()->select_field( 'google_cat', $google_cat );
						?>
						</div>
					</li>
				</div>
		</div>
	</div>
</div>



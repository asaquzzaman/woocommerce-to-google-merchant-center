<?php
$taxonomies = get_option( 'woogool_google_product_type' );

$offset = 20;
$products = woogool_get_products( 20 );

while( count( $products ) ) {
    $new_some_products = woogool_get_products( 20, $offset );
    $products          = array_merge( $products, $new_some_products );
    if ( ! count( $new_some_products ) ) {
        break;
    }
    $offset            = $offset + 20;
}
$product_log = array();
foreach ( $products as $key => $product) {
    $product_log[$product->ID] = $product->post_title;
}

$feed_fields = array();
$feed_id = isset( $_GET['feed_id'] ) ? intval( $_GET['feed_id'] ) : 0;

if ( $feed_id ) {
	$post = get_post( $feed_id );
}

$feed_fields['id'] = array(
	'type'     => 'hidden',
	'value'    => $feed_id
);
$feed_fields['post_title'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'value'    => isset( $post->post_title ) ? $post->post_title : '',
	'label'    => __( 'Name', 'woogool' ),
	'desc'     => __( 'The file genera', 'woogool' ),
	'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
        'required' => 'required'
    )
);

$feed_fields['all_products'] = array(
    'label' => __( 'Products', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Enable all products feed', 'woogool' ),
    'fields' => array(
        array(
            'label' => __( 'All', 'woogool' ),
            'value' => 'on',
            'checked' => get_post_meta( $feed_id, '_all_products', true ),
            'class' => 'woogool-all-product-checkbox-feed woogool-field',
        ),
    ),
);

$selected_products = get_post_meta( $feed_id, '_products', true );

$feed_fields['products[]'] = array(
	'type'     => 'multiple',
	'label'    => __( 'Some Individual Products', 'woogool' ),
	'option'   => isset( $product_log ) ? $product_log : array(),
	'class'    => 'woogool-chosen',
	'selected' => empty( $selected_products ) ? array() : $selected_products,
	'desc'     => 'Chose products',
	'wrap_start' => true,
	'wrap_attr' => array(
		'class' => 'woogool-product-chosen-field-wrap'
	),
	'wrap_close' => true,
);

$feed_fields['variable_products'] = array(
    'label' => __( 'With Variable product', 'woogool' ),
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


$feed_fields['google_product_category'] = array(
	'type'     => 'select',
	'label'    => __( 'Category', 'woogool' ),
	'option'   => $taxonomies,
	'class'    => 'woogool-chosen',
	'selected' => get_post_meta( $feed_id, '_google_product_category', true ),
	'desc'     => __( 'Google\'s category of the item', 'woogool' )
);

$feed_fields['product_type'] = array(
	'type'     => 'select',
	'label'    => __( 'Product Type', 'woogool' ),
	'option'   => $taxonomies,
	'class'    => 'woogool-chosen',
	'selected' => get_post_meta( $feed_id, '_product_type', true ),
	'desc'     => __( 'Your category of the item', 'woogool' )
);

$feed_fields['availability'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $feed_id, '_availability', true ),
	'label'    => __( 'Availability', 'woogool' ),
	'option'   => array( 'in stock' => 'in stock', 'out of stock' => 'out of stock', 'preorder' => 'preorder' ),
	'desc'     => __( 'Availability status of the item', 'woogool' )
);

$feed_fields['availability_date'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'class'    => 'woogool-date-picker',
	'value'    => get_post_meta( $feed_id, '_availability_date', true ),
 	'label'    => __( 'Availability date', 'woogool' ),
	'desc'     => __( 'The day a pre-ordered product becomes available for delivery', 'woogool' ),
);

$feed_fields['condition'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $feed_id, '_condition', true ),
	'label'    => __( 'Condition', 'woogool' ),
	'option'   => array( 'new' => 'New', 'used' => 'Used', 'refurbished' => 'refurbished' ),
	'desc'     => __( 'Availability status of the item', 'woogool' )
);

$feed_fields['brand'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_brand', true ),
	'label'    => __( 'Brand', 'woogool' ),
	'desc'     => __( 'Brand of the item', 'woogool' )
);

$feed_fields['mpn'] = array(
	'type'     => 'checkbox',
	'label'    => __( 'MPN (SKU)', 'woogool' ),
	'desc'     => __( 'Manufacturer Part Number (MPN) of the item', 'woogool' ),
	'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'on',
            'checked' => get_post_meta( $feed_id, '_mpn', true ),
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
	'desc'     => __( 'Gender of the item', 'woogool' )
);

$feed_fields['age_group'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $feed_id, '_age_group', true ),
	'label'    => __( 'Age Group', 'woogool' ),
	'option'   => array( '-1' => '--Select--', 'newborn' => 'newborn', 'infant' => 'infant', 'toddler' => 'toddler', 'kids' => 'kids', 'adult' => 'adult' ),
	'desc'     => __( 'Availability status of the item', 'woogool' )
);

$feed_fields['color'] = array(
	'type'     => 'checkbox',
	'label'    => __( 'Color', 'woogool' ),
	'desc'     => __( 'Color of the item. This color get from individual product color attributes value. Remember color attribute spell must be color', 'woogool' ),
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
	'desc'     => __( 'Size of the item. This size get from individual product size attributes value. Remember size attribute spell must be size', 'woogool' ),
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
	'desc'     => __( 'Size type of the item', 'woogool' )
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
	'desc'     => __( 'Size system of the item', 'woogool' )
);

$feed_fields['identifier_exists'] = array(

	'type'     => 'checkbox',
	'label'    => __( 'Identifier Exists', 'woogool' ),
	'desc' => __( 'Required when unique product identifiers (mpn, brand, gtin) do not exist. Refer to the <a href="https://support.google.com/merchants/answer/188494?vid=1-635757674855999234-105250998#upi_rules" target="_blank">Unique Product Identifier Rules.</a>', 'woogool' ),
	'fields' => array(
        array(
            'label' => __( 'False', 'woogool' ),
            'value' => 'on',
            'checked' => get_post_meta( $feed_id, '_identifier_exists', true ),
            'class'    => 'woogool-field',

        ),
    ),
);

$feed_fields['expiration_date'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'class'    => 'woogool-date-picker',
	'value'    => get_post_meta( $feed_id, '_expiration_date', true ),
 	'label'    => __( 'Expiration Date', 'woogool' ),
	'desc'     => __( 'Date that an item will expire', 'woogool' ),
);

$feed_fields['custom_label_0'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 0', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_0', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);

$feed_fields['custom_label_1'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 1', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_1', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);

$feed_fields['custom_label_2'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 2', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_2', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);

$feed_fields['custom_label_3'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 3', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_3', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);

$feed_fields['custom_label_4'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 4', 'woogool' ),
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $feed_id, '_custom_label_4', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);

$feed_fields['promotion_id'] = array(
	'type'     => 'text',
	'label'    => __( 'Promotion ID', 'woogool' ),
	'class'    => 'woogool-field',
	'value' => get_post_meta( $feed_id, '_promotion_id', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);

?>

<div class="postbox">

		<h3 class="postbox-title"><?php _e( 'Generate Products Feed', 'woogool' ); ?></h3>
		<div class="woogool-warning">
			<?php _e( 'If you did not cofigure your shipping and tax information correctly according 
			to your targeted coutnry and did not verify your website then please do all these things 
			from your google merchant account before submitting the form', 'woogool' ); ?>
		</div>
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
				<a style="font-weight: 800; font-size: 14px;" href="http://mishubd.com/product/woogoo/" target="_blank"><?php _e( 'To get this feature you have to purchcase this plugin from this link', 'woogool' ); ?></a>
			</form>
		</div>
		<div class="woogool-clear"></div>
</div>
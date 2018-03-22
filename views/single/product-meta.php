<?php
$taxonomies = get_option( 'woogool_google_product_type' );

if ( $taxonomies && isset( $taxonomies[0] ) ) {
	unset($taxonomies[0]);
} else {
	$taxonomies = array();
}

$taxonomies = array_merge( array( '-1' => __( '-Select-', 'woogool' ) ), array( 'default' => __('Default', 'woogool') ), $taxonomies );

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
foreach ( $products as $key => $product) {
    $product_log[$product->ID] = $product->post_title;
}

$feed_fields = array();

$feed_fields['woogool_sinlge_product_feed'] = array(
	'type'     => 'hidden',
	'value' => 'single_product_feed'
);

$feed_fields['disabled_feed'] = array(
	'label' => __( 'Feed', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Disabled Feed', 'woogool' ),
    'fields' => array(
        array(
            'label' => __( 'Disabled', 'woogool' ),
            'value' => 'disabled',
            'checked' => get_post_meta( $post_id, '_disabled_feed', true ),
        ),
    ),
);

$feed_fields['google_product_category'] = array(
	'type'     => 'select',
	'label'    => __( 'Category', 'woogool' ),
	'option'   => $taxonomies,
	'class'    => 'woogool-chosen',
	'selected' => get_post_meta( $post_id, '_google_product_category', true ),
	'desc'     => __( 'Google\'s category of the item', 'woogool' )
);

$feed_fields['product_type'] = array(
	'type'     => 'select',
	'label'    => __( 'Product Type', 'woogool' ),
	'option'   => $taxonomies,
	'class'    => 'woogool-chosen',
	'selected' => get_post_meta( $post_id, '_product_type', true ),
	'desc'     => __( 'Your category of the item', 'woogool' )
);


$feed_fields['availability'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'label'    => __( 'Availability', 'woogool' ),
	'selected' => get_post_meta( $post_id, '_availability', true ),
	'option'   => array( 'default' => __( 'Default', 'woogool' ), 'in stock' => 'in stock', 'out of stock' => 'out of stock', 'preorder' => 'preorder' ),
	'desc'     => __( 'Availability status of the item', 'woogool' ),
);

$feed_fields['availability_date_default'] = array(
	'label'      => __( 'Availability date default', 'woogool' ),
	'type'       => 'checkbox',
	'desc'       => __( 'Default value get form woogool product feed section', 'woogool' ),
	'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
			'label'   => __( 'Enable', 'woogool' ),
			'value'   => 'default',
			'checked' => get_post_meta( $post_id, '_availability_date_default', true ),
			'class'   => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);

$feed_fields['availability_date'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'class'    => 'woogool-date-picker',
	'value'    => get_post_meta( $post_id, '_availability_date', true ),
	'label'    => __( 'Availability date', 'woogool' ),
	'desc'     => __( 'The day a pre-ordered product becomes available for delivery', 'woogool' ),
	'wrap_close' => true,
);

$feed_fields['condition'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'label'    => __( 'Condition', 'woogool' ),
	'selected' => get_post_meta( $post_id, '_condition', true ),
	'option'   => array( '-1' => __( 'Default', 'woogool' ), 'new' => 'New', 'used' => 'Used', 'refurbished' => 'refurbished' ),
	'desc'     => __( 'Availability status of the item', 'woogool' )
);

$feed_fields['brand_default'] = array(
	'label' => __( 'Brand default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_brand_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['brand'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'value'    => get_post_meta( $post_id, '_brand', true ),
	'label'    => __( 'Brand', 'woogool' ),
	'desc'     => __( 'Brand of the item', 'woogool' ),
	'wrap_close' => true,
);


$feed_fields['mpn_default'] = array(
	'label' => __( 'MPN default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_mpn_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['mpn'] = array(
	'type'     => 'text',
	'label'    => __( 'MPN', 'woogool' ),
	'value'    => get_post_meta( $post_id, '_mpn', true ),
	'desc'     => __( 'Manufacturer Part Number (MPN) of the item', 'woogool' ),
	'wrap_close' => true,
);

$feed_fields['gender'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $post_id, '_gender', true ),
	'label'    => __( 'Gender', 'woogool' ),
	'option'   => array( '-1' => __( '--Select--', 'woogool' ), 'default' => __( 'Default', 'woogool' ), 'male' => 'male', 'female' => 'female', 'unisex' => 'unisex' ),
	'desc'     => __( 'Gender of the item', 'woogool' )
);

$feed_fields['age_group'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $post_id, '_age_group', true ),
	'label'    => __( 'Age Group', 'woogool' ),
	'option'   => array( '-1' => __( '--Select--', 'woogool' ), 'default' => __( 'Default', 'woogool' ), 'newborn' => 'newborn', 'infant' => 'infant', 'toddler' => 'toddler', 'kids' => 'kids', 'adult' => 'adult' ),
	'desc'     => __( 'Availability status of the item', 'woogool' )
);

$feed_fields['color_default'] = array(
	'label' => __( 'Color default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_color_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);

$feed_fields['color'] = array(
	'type'     => 'text',
	'label'    => __( 'Color', 'woogool' ),
	'value'    => get_post_meta( $post_id, '_color', true ),
	'desc'     => __( 'Seperate with comma(,)', 'woogool' ),
	'wrap_close' => true,
);

$feed_fields['size_default'] = array(
	'label' => __( 'Size default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_size_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['size'] = array(
	'type'     => 'text',
	'label'    => __( 'Size', 'woogool' ),
	'value'    => get_post_meta( $post_id, '_size', true ),
	'desc'     => __( 'Seperate with comma(,)', 'woogool' ),
	'wrap_close' => true,
);

$feed_fields['size_type'] = array(
	'type'     => 'select',
	'label'    => __( 'Size Type', 'woogool' ),
	'class'    => 'woogool-field',
	'selected' => get_post_meta( $post_id, '_size_type', true ),
	'option'   => array( '-1' => __( '--Select--', 'woogool' ), 'default' => __( 'Default', 'woogool' ), 'regular' => 'regular', 'petite' => 'petite', 'plus' => 'plus', 'big and tall' => 'big and tall', 'maternity' => 'maternity' ),
	'desc'     => __( 'Size type of the item', 'woogool' )
);

$feed_fields['size_system'] = array(
	'type'     => 'select',
	'class'    => 'woogool-field',
	'label'    => __( 'Size System', 'woogool' ),
	'selected' => get_post_meta( $post_id, '_size_system', true ),
	'option'   => array(
		'-1'  => '--Select--',
		'default' => __( 'Default', 'woogool' ),
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

$feed_fields['expiration_date_default'] = array(
	'label'      => __( 'Expiration Date default', 'woogool' ),
	'type'       => 'checkbox',
	'desc'       => __( 'Default value get form woogool product feed section', 'woogool' ),
	'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
			'label'   => __( 'Enable', 'woogool' ),
			'value'   => 'default',
			'checked' => get_post_meta( $post_id, '_expiration_date_default', true ),
			'class'   => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);

$feed_fields['expiration_date'] = array(
	'type'     => 'text',
	'class'    => 'woogool-field',
	'class'    => 'woogool-date-picker',
	'value'    => get_post_meta( $post_id, '_expiration_date', true ),
	'label'    => __( 'Expiration Date', 'woogool' ),
	'desc'     => __( 'Date that an item will expire', 'woogool' ),
	'wrap_close' => true,
);

$feed_fields['custom_label_0_default'] = array(
	'label' => __( 'Custom Label 0 default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_custom_label_0_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['custom_label_0'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 0', 'woogool' ),
	'class'    => 'woogool-field',
	'wrap_close' => true,
	'value'  => get_post_meta( $post_id, '_custom_label_0', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);

$feed_fields['custom_label_1_default'] = array(
	'label' => __( 'Custom Label 1 default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_custom_label_1_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['custom_label_1'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 1', 'woogool' ),
	'class'    => 'woogool-field',
	'wrap_close' => true,
	'value'  => get_post_meta( $post_id, '_custom_label_1', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);


$feed_fields['custom_label_2_default'] = array(
	'label' => __( 'Custom Label 2 default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_custom_label_2_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['custom_label_2'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 2', 'woogool' ),
	'class'    => 'woogool-field',
	'wrap_close' => true,
	'value'  => get_post_meta( $post_id, '_custom_label_2', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);


$feed_fields['custom_label_3_default'] = array(
	'label' => __( 'Custom Label 3 default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' =>  get_post_meta( $post_id, '_custom_label_3_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['custom_label_3'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 3', 'woogool' ),
	'class'    => 'woogool-field',
	'wrap_close' => true,
	'value'  => get_post_meta( $post_id, '_custom_label_3', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);


$feed_fields['custom_label_4_default'] = array(
	'label' => __( 'Custom Label 4 default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_custom_label_4_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['custom_label_4'] = array(
	'type'     => 'text',
	'label'    => __( 'Custom Label 4', 'woogool' ),
	'class'    => 'woogool-field',
	'wrap_close' => true,
	'value'  => get_post_meta( $post_id, '_custom_label_4', true ),
	//'desc'     => __( 'Brand of the item', 'woogool' )
);


$feed_fields['promotion_id_default'] = array(
	'label' => __( 'Promotion id default', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Default value get form woogool product feed section', 'woogool' ),
    'wrap_start' => true,
    'wrap_attr' => array(
		'class' => 'woogool-default-feed-field-wrap'
	),
    'fields' => array(
        array(
            'label' => __( 'Enable', 'woogool' ),
            'value' => 'default',
            'checked' => get_post_meta( $post_id, '_promotion_id_default', true ),
            'class' => 'woogool-all-product-checkbox woogool-field',
        ),
    ),
);
$feed_fields['promotion_id'] = array(
	'type'     => 'text',
	'label'    => __( 'Promotion ID', 'woogool' ),
	'class'    => 'woogool-field',
	'wrap_close' => true,
	'value'  => get_post_meta( $post_id, '_promotion_id', true )
	//'desc'     => __( 'Brand of the item', 'woogool' )
);

?>


		<div id="woogool" class="woogool-feed-form-content">
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
		</div>
		<div class="woogool-clear"></div>
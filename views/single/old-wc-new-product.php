<?php
$is_access_premission = WooGool()->individual->check_authenticate();

if ( ! $is_access_premission ) {
    WooGool()->individual->authentication_process();
    //return;
}
?>

<div class="">

    <div class="woogool-submit-notification">

        <div class="woogool-error-code"></div>
        <div class="error-message"></div>
    </div>

<?php

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

if ( isset( $_GET['product_id'] ) && intval( $_GET['product_id'] ) ) {
    $product_id    = $_GET['product_id']; 
} else {
    $product_id    = get_user_meta( get_current_user_id(), 'woogool_product_id', true  );    
}

$product       = get_post_meta( $product_id, 'woogool_product', true );
$product       = empty( $product ) ? array() : $product;
$wc_product    = wc_get_product( $product_id );

$product_price = $wc_product->get_price();
$sku           = $wc_product->get_sku();
$link          = $wc_product->get_permalink();
$stock         = $wc_product->is_in_stock() ? 'in stock' : 'out of stock';

if ( woogool_is_wc_new() ) {
    $content       = $wc_product->get_description();
    $product_id    = $wc_product->get_id();
} else {
    $content       = isset( $wc_product->post ) ? $wc_product->post->post_content : '';
    $product_id    = isset( $wc_product->id ) ? $wc_product->id : '';
}

$image_url     =  wp_get_attachment_url( $wc_product->get_image_id() );
$currency      = get_woocommerce_currency();
$shop_field    = array();
$additional_images = array();

foreach ( $wc_product->get_gallery_attachment_ids( ) as $key => $link_id ) {
    $additional_images[] =  wp_get_attachment_url( $link_id ); 
    if ( count( $additional_images ) > 9 ) {
        break;
    }
}

$shop_field['action'] = array(
    'type'  => 'hidden',
    'value' => 'woogool_merchant_form',
);

$shop_field['product_id'] =  array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-part',
    ),
    'label'    => __( 'Product', 'hrm' ),
    'type'     => 'select',
    'option'   => isset( $product_log ) ? $product_log : array(),
    'selected' => $product_id,
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    )
);

$shop_field['title'] = array(
    'type'  => 'text',
    'label' => __( 'Title', 'woogool' ),
    'value' => get_the_title( $product_id ),
    'desc'  => ' Title of the item.',
    'class' => 'woogool-product_title',
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
);

$shop_field['description'] = array(
    'type'  => 'textarea',
    'desc'  => __( 'Description of the item.', 'woogool' ),
    'class' => 'woogool-description',
    'label' => __( 'Description', 'woogool' ),
    'value' => $content ? esc_attr( $content ) : '',
);

$shop_field['channel'] = array(
    'type'  => 'text',
    'label' => __( 'Channel', 'woogool' ),
    'desc'  => 'The item\'s channel (online or local). Acceptable values are: "b2b" or "local" or "online"',
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'value' => isset( $product['channel'] ) ? $product['channel'] : 'online',
);

$targetCountry = isset( $product['targetCountry'] ) ? $product['targetCountry'] : '-1';
$country_details = woogool_country_details();

if ( $targetCountry != '-1' ) {
    $contentLanguage = $country_details[$targetCountry]['language_code'];
    $currency        = $country_details[$targetCountry]['currency_code'];
} else {
    $contentLanguage = '-1';
    $currency       = '';
}

$shop_field['targetCountry'] = array(
    'type'  => 'select',
    'label' => __( 'Target Country', 'woogool' ),
    'class'    => 'woogool-target-country-drop',
    'desc'  => 'The two-letter ISO 3166 country code for the item.
    <a href="http://en.wikipedia.org/wiki/ISO_3166-1" target="_blank">More Details..</a>',
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'option' => woogool_target_country(), //woogool_countrys(),
    'selected' => $targetCountry,
);

$shop_field['contentLanguage'] = array(
    'type'  => 'select',
    'label' => __( 'Content Language', 'woogool' ),
    'class' => 'woogool-content-language',
    'desc'  => 'The two-letter ISO 639-1 language code for the item.
    <a href="http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank">More Details..</a>',
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'option'    => woogool_content_language(),
    'selected'  => $contentLanguage,
    'wrap_attr' => array(
        'class' => $targetCountry == '-1' ? 'woogool-hidden' : '',
    ),
    'wrap_close_tag' => 'div',
    'wrap_start' => true,
    'wrap_close' => true,
);

$shop_field['price[currency]'] = array(
    'type'  => 'text',
    'desc'  => __( 'The currency of the price.', 'woogool' ),
    'class' => 'woogool-currency-field',
    'label' => __( 'Price Currency', 'woogool' ),
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'value' => $currency,
    'wrap_attr' => array(
        'class' => $targetCountry == '-1' ? 'woogool-hidden' : '',
    ),
    'wrap_close_tag' => 'div',
    'wrap_start' => true,
    'wrap_close' => true,
);

$shop_field['offerId'] = array(
    'type'  => 'text',
    'label' => __( 'Offer Id', 'woogool' ),
    'desc'  => 'An identifier of the item.',
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'value' => $product_id ? $product_id : '',
);

$shop_field['condition'] = array(
    'type'  => 'text',
    'label' => __( 'Condition', 'woogool' ),
    'desc'  => __( 'Acceptable values are: "new" "refurbished" "used"', 'woogool' ),
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'value' => isset( $product['condition'] ) ? $product['condition'] : 'new',
);

$shop_field['price[value]'] = array(
    'type' => 'text',
    'desc' => __( 'The price represented as a number.', 'woogool' ),
    'label' => __( 'Price', 'woogool' ),
    'extra' => array(
        'data-woogool_validation' => true,
        'data-woogool_required' => true,
        'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
    ),
    'value' => $product_price,
);

$shop_field['brand'] = array(
    'type'  => 'text',
    'label' => __( 'Brand', 'woogool' ),
    'desc'  => __( 'Brand of the item.', 'woogool' ),
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'value' => isset( $product['brand'] ) ? $product['brand'] : '',
);

$shop_field['mpn'] = array(
    'type'  => 'text',
    'label' => __( 'MPN (SKU)', 'woogool' ),
    'desc'  => __( 'Manufacturer Part Number (MPN) of the item.', 'woogool' ),
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'value' => $sku ? $sku : '',
);

$shop_field['availability'] = array(
    'type'  => 'text',
    'label' => __( 'Availability', 'woogool' ),
    'desc'  => __( 'Acceptable values are: "available for order" "in stock" "limited availability" "on display to order" "out of stock" "preorder"', 'woogool' ),
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
    'value' => $stock ? $stock : '',
);

$shop_field['link'] = array(
    'type'       => 'text',
    'desc'       => __( 'URL directly linking to your item\'s page on your website.', 'woogool' ),
    'label'      => __( 'Link', 'woogool' ),
    'wrap_close' => true,
    'value'      => $link ? $link : '',
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),

    ),

);

$shop_field[] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-field woogool-html woogool-customattributes-wrap',
    ),
    'type' => 'html',
    'html' => '<h1 class="woogool-customattributes-head">' .
    __( 'Shipping rules.' , 'woogool' ) . '</h1>',
);

if ( isset( $product['shipping'] ) && count( $product['shipping'] ) ) {
    foreach ( $product['shipping'] as $key => $shipping ) {
        $shop_field['shipping['.$key.'][country]'] = array(
            'wrap_start' => true,
            'type'       => 'text',
            'desc'       => __( 'The two-letter ISO 3166 country code for the country to which an item will ship.', 'woogool' ),
            'label'      => __( 'Shipping Country', 'woogool' ),
            'value'      => isset( $shipping['country'] ) ? $shipping['country'] : '',
            'wrap_attr' => array(
                'class' => 'woogool-form-field woogool-html woogool-product-field-child-wrap',
            ),
           /* 'extra' => array(
                'data-woogool_validation' => true,
                'data-woogool_required' => true,
                'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
            ),*/

        );

        $shop_field['shipping['.$key.'][region]'] = array(
            'type' => 'text',
            'desc' => __( 'The geographic region to which a shipping rate applies (e.g. zip code).', 'woogool' ),
            'label' => __( 'Shipping Region', 'woogool' ),
            /*'extra' => array(
                'data-woogool_validation' => true,
                'data-woogool_required' => true,
                'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
            ),*/
            'value' => isset( $shipping['region'] ) ? $shipping['region'] : '',
        );


        $shop_field['shipping['.$key.'][price][currency]'] = array(
            'type' => 'text',
            'desc' => __( 'The currency of the price.', 'woogool' ),
            'label' => __( 'Shipping Price Currency', 'woogool' ),
            /*'extra' => array(
                'data-woogool_validation' => true,
                'data-woogool_required' => true,
                'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
            ),*/
            'value' => $currency,
        );

        $shop_field['shipping['.$key.'][price][value]'] = array(
            'type' => 'text',
            'desc' => __( 'The price represented as a number.', 'woogool' ),
            'label' => __( 'Shipping Price', 'woogool' ),
            /*'extra' => array(
                'data-woogool_validation' => true,
                'data-woogool_required' => true,
                'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
            ),*/
            'value' => isset( $shipping['price']['value'] ) ? $shipping['price']['value'] : '',
        );

        $shop_field['shipping['.$key.'][service]'] = array(
            'type' => 'text',
            'desc' => __( 'A free-form description of the service class or delivery speed.', 'woogool' ),
            'label' => __( 'Shipping Service', 'woogool' ),
            /*'extra' => array(
                'data-woogool_validation' => true,
                'data-woogool_required' => true,
                'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
            ),*/
            'value' => isset( $shipping['service'] ) ? $shipping['service'] : '',
        );

        $shop_field['shipping['.$key.'][locationGroupName]'] = array(
            'type' => 'text',
            'desc' => __( 'The location where the shipping is applicable, represented by a location group name.', 'woogool' ),
            'label' => __( 'Shipping location Group Name', 'woogool' ),
            'value' => isset( $shipping['locationGroupName'] ) ? $shipping['locationGroupName'] : '',
        );

        $shop_field['shipping['.$key.'][locationId]'] = array(
            'type' => 'text',
            'desc' => __( 'The numeric id of a location that the shipping rate applies to as defined in the <a href="https://developers.google.com/adwords/api/docs/appendix/geotargeting" target="_blank">AdWords API.</a>', 'woogool' ),
            'label' => __( 'Shipping Location Id', 'woogool' ),
            'value' => isset( $shipping['locationId'] ) ? $shipping['locationId'] : '',
        );

        $shop_field['shipping['.$key.'][postalCode]'] = array(
            'type' => 'text',
            'desc' => __( '     The postal code range that the shipping rate applies to, represented by a postal code, a postal code prefix using * wildcard, a range between two postal codes or two postal code prefixes of equal length.', 'woogool' ),
            'label' => __( 'Shipping Postal Code', 'woogool' ),
            'wrap_close' => true,
            'value' => isset( $shipping['postalCode'] ) ? $shipping['postalCode'] : '',
        );
    }

} else {
    $shop_field['shipping[0][country]'] = array(
        'wrap_start' => true,
        'type'       => 'text',
        'desc'       => __( 'The two-letter ISO 3166 country code for the country to which an item will ship.', 'woogool' ),
        'label'      => __( 'Shipping Country', 'woogool' ),
        'wrap_attr' => array(
            'class' => 'woogool-form-field woogool-html woogool-product-field-child-wrap',
        ),
        /*'extra' => array(
            'data-woogool_validation' => true,
            'data-woogool_required' => true,
            'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
        ),*/

    );

    $shop_field['shipping[0][region]'] = array(
        'type' => 'text',
        'desc' => __( 'The geographic region to which a shipping rate applies (e.g. zip code).', 'woogool' ),
        'label' => __( 'Shipping Region', 'woogool' ),
        /*'extra' => array(
            'data-woogool_validation' => true,
            'data-woogool_required' => true,
            'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
        ),*/
    );


    $shop_field['shipping[0][price][currency]'] = array(
        'type' => 'text',
        'desc' => __( 'The currency of the price.', 'woogool' ),
        'label' => __( 'Shipping Price Currency', 'woogool' ),
        /*'extra' => array(
            'data-woogool_validation' => true,
            'data-woogool_required' => true,
            'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
        ),*/
    );

    $shop_field['shipping[0][price][value]'] = array(
        'type' => 'text',
        'desc' => __( 'The price represented as a number.', 'woogool' ),
        'label' => __( 'Shipping Price', 'woogool' ),
        /*'extra' => array(
            'data-woogool_validation' => true,
            'data-woogool_required' => true,
            'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
        ),*/
    );

    $shop_field['shipping[0][service]'] = array(
        'type' => 'text',
        'desc' => __( 'A free-form description of the service class or delivery speed.', 'woogool' ),
        'label' => __( 'Shipping Service', 'woogool' ),
        /*'extra' => array(
            'data-woogool_validation' => true,
            'data-woogool_required' => true,
            'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
        ),*/
    );

    $shop_field['shipping[0][locationGroupName]'] = array(
        'type' => 'text',
        'desc' => __( 'The location where the shipping is applicable, represented by a location group name.', 'woogool' ),
        'label' => __( 'Shipping location Group Name', 'woogool' ),
    );

    $shop_field['shipping[0][locationId]'] = array(
        'type' => 'text',
        'desc' => __( 'The numeric id of a location that the shipping rate applies to as defined in the <a href="https://developers.google.com/adwords/api/docs/appendix/geotargeting" target="_blank">AdWords API.</a>', 'woogool' ),
        'label' => __( 'Shipping Location Id', 'woogool' ),
    );

    $shop_field['shipping[0][postalCode]'] = array(
        'type' => 'text',
        'desc' => __( '     The postal code range that the shipping rate applies to, represented by a postal code, a postal code prefix using * wildcard, a range between two postal codes or two postal code prefixes of equal length.', 'woogool' ),
        'label' => __( 'Shipping Postal Code', 'woogool' ),
        'wrap_close' => true,
    );
}

 $shop_field[] = array(
    'wrap_close' => true,
    'type' => 'html',
    'html' => '<a href="#" class="button-primary woogool-product-field-addMore">' .__( 'Add More', 'woogool' ) . '</a>
        <a class="button-secondary woogool-product-field-remove" href="#">' . __( 'Cancle', 'woogool' ) . '</a>',
);
//close shippin


$shop_field[] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-field woogool-html woogool-customattributes-wrap',
    ),
    'type' => 'html',
    'html' => '<h1 class="woogool-customattributes-head">' .
    __( 'Tax information.' , 'woogool' ) . '</h1>',
);

if ( isset( $product['taxes'] ) && count( $product['taxes'] ) ) {
    foreach ( $product['taxes'] as $key => $taxes ) {
        $shop_field['taxes['.$key.'][country]'] = array(
            'wrap_start' => true,
            'wrap_attr' => array(
                'class' => 'woogool-form-field woogool-html woogool-product-field-child-wrap',
            ),
            'type' => 'text',
            'desc' => __( 'The country within which the item is taxed, specified with a two-letter ISO 3166 country code.', 'woogool' ),
            'label' => __( 'Tax Country', 'woogool' ),
            /*'extra' => array(
                'data-woogool_validation' => true,
                'data-woogool_required' => true,
                'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
            ),*/
            'value' => isset( $taxes['country'] ) ? $taxes['country'] : '',
        );

        $shop_field['taxes['.$key.'][region]'] = array(
            'type' => 'text',
            'desc' => __( 'The geographic region to which the tax rate applies.', 'woogool' ),
            'label' => __( 'Tax Region', 'woogool' ),
            /*'extra' => array(
                'data-woogool_validation' => true,
                'data-woogool_required' => true,
                'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
            ),*/
            'value' => isset( $taxes['region'] ) ? $taxes['region'] : '',
        );

        $shop_field['taxes['.$key.'][rate]'] = array(
            'type' => 'text',
            'desc' => __( 'The percentage of tax rate that applies to the item price.', 'woogool' ),
            'label' => __( 'Tax Rate', 'woogool' ),
            /*'extra' => array(
                'data-woogool_validation' => true,
                'data-woogool_required' => true,
                'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
            ),*/
            'value' => isset( $taxes['rate'] ) ? $taxes['rate'] : '',
        );

        $shop_field['taxes['.$key.'][taxShip]'] = array(
            'label' => __( 'Tax Ship', 'woogool' ),
            'type' => 'checkbox',
            'required' => 'required',
            'desc' => 'Set to true if tax is charged on shipping.',
            'fields' => array(
                array(
                    'label' => __( 'Tax Ship', 'woogool' ),
                    'value' => 'on',
                    'checked' => isset( $taxes['taxShip'] ) ? $taxes['taxShip'] : '',
                ),
            ),
        );

        $shop_field['taxes['.$key.'][locationId]'] = array(
            'label' => __( 'Tax Location Id', 'woogool' ),
            'type' => 'text',
            'desc' => __( 'The numeric id of a location that the tax rate applies to as defined in the Adwords API (https://developers.google.com/adwords/api/docs/appendix/geotargeting).', 'woogool' ),
            'value' => isset( $taxes['locationId'] ) ? $taxes['locationId'] : '',
        );

        $shop_field['taxes['.$key.'][postalCode]'] = array(
            'label' => __( 'Tax Postal Code', 'woogool' ),
            'type' => 'text',
            'desc' => __( 'The postal code range that the tax rate applies to, represented by a ZIP code, a ZIP code prefix using * wildcard, a range between two ZIP codes or two ZIP code prefixes of equal length. Examples: 94114, 94*, 94002-95460, 94*-95*.', 'woogool' ),
            'wrap_close' => true,
            'value' => isset( $taxes['postalCode'] ) ? $taxes['postalCode'] : '',
        );
    }
} else {
    $shop_field['taxes[0][country]'] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'woogool-form-field woogool-html woogool-product-field-child-wrap',
        ),
        'type' => 'text',
        'desc' => __( 'The country within which the item is taxed, specified with a two-letter ISO 3166 country code.', 'woogool' ),
        'label' => __( 'Tax Country', 'woogool' ),
        /*'extra' => array(
            'data-woogool_validation' => true,
            'data-woogool_required' => true,
            'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
        ),*/
    );

    $shop_field['taxes[0][region]'] = array(
        'type' => 'text',
        'desc' => __( 'The geographic region to which the tax rate applies.', 'woogool' ),
        'label' => __( 'Tax Region', 'woogool' ),
        /*'extra' => array(
            'data-woogool_validation' => true,
            'data-woogool_required' => true,
            'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
        ),*/
    );

    $shop_field['taxes[0][rate]'] = array(
        'type' => 'text',
        'desc' => __( 'The percentage of tax rate that applies to the item price.', 'woogool' ),
        'label' => __( 'Tax Rate', 'woogool' ),
        /*'extra' => array(
            'data-woogool_validation' => true,
            'data-woogool_required' => true,
            'data-woogool_required_error_msg'=> __( 'This field is required', 'woogool' ),
        ),*/
    );

    $shop_field['taxes[0][taxShip]'] = array(
        'label' => __( 'Tax Ship', 'woogool' ),
        'type' => 'checkbox',
       // 'required' => 'required',
        'desc' => 'Set to true if tax is charged on shipping.',
        'fields' => array(
            array(
                'label' => __( 'Tax Ship', 'woogool' ),
                'value' => 'on',
            ),
        ),
    );

    $shop_field['taxes[0][locationId]'] = array(
        'label' => __( 'Tax Location Id', 'woogool' ),
        'type' => 'text',
        'desc' => __( 'The numeric id of a location that the tax rate applies to as defined in the Adwords API (https://developers.google.com/adwords/api/docs/appendix/geotargeting).', 'woogool' ),
    );

    $shop_field['taxes[0][postalCode]'] = array(
        'label' => __( 'Tax Postal Code', 'woogool' ),
        'type' => 'text',
        'desc' => __( 'The postal code range that the tax rate applies to, represented by a ZIP code, a ZIP code prefix using * wildcard, a range between two ZIP codes or two ZIP code prefixes of equal length. Examples: 94114, 94*, 94002-95460, 94*-95*.', 'woogool' ),
        'wrap_close' => true,
    );
}

$shop_field[] = array(
    'wrap_close' => true,
    'type' => 'html',
    'html' => '<a href="#" class="button-primary woogool-product-field-addMore">' .__( 'Add More', 'woogool' ) . '</a>
        <a class="button-secondary woogool-product-field-remove" href="#">' . __( 'Cancle', 'woogool' ) . '</a>',
);

//close taxes

$shop_field['availabilityDate'] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-part',
    ),
    'type' => 'text',
    'desc' => __( 'The day a pre-ordered product becomes available for delivery.', 'woogool' ),
    'label' => __( 'Availability Date', 'woogool' ),
    'wrap_close' => true,
    'value' => isset( $product['availabilityDate'] ) ? $product['availabilityDate'] : '',
);

$shop_field[] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-field woogool-html woogool-customattributes-wrap',
    ),
    'type' => 'html',
    'html' => '<h1 class="woogool-customattributes-head">A list of custom (merchant-provided) attributes.</h1>',
);

if ( isset( $product['customAttributes'] ) && count( $product['customAttributes'] ) ) {
    foreach ( $product['customAttributes'] as $key => $customAttributes ) {
        $shop_field['customAttributes['.$key.'][name]'] = array(
            'wrap_start' => true,
            'wrap_attr' => array(
                'class' => 'woogool-form-field woogool-product-field-child-wrap',
            ),
            'type' => 'text',
            'desc' => __( 'The name of the attribute.', 'woogool' ),
            'label' => __( 'Custom Attributes Name', 'woogool' ),
            'value' => isset( $customAttributes['name'] ) ? $customAttributes['name'] : '',
        );

        $shop_field['customAttributes['.$key.'][type]'] = array(
            'type' => 'text',
            'desc' => __( 'Acceptable values are: "boolean" "datetimerange" "float" "group" "int" "price" "text" "time" "url"', 'woogool' ),
            'label' => __( 'Custom Attributes Type', 'woogool' ),
            'value' => isset( $customAttributes['type'] ) ? $customAttributes['type'] : '',
        );

        $shop_field['customAttributes['.$key.'][unit]'] = array(
            'type' => 'text',
            'desc' => __( 'Free-form unit of the attribute. Unit can only be used for values of type INT or FLOAT.', 'woogool' ),
            'label' => __( 'Custom Attributes Unit', 'woogool' ),
            'value' => isset( $customAttributes['unit'] ) ? $customAttributes['unit'] : '',
        );

        $shop_field['customAttributes['.$key.'][value]'] = array(
            'type' => 'text',
            'desc' => __( 'The value of the attribute.', 'woogool' ),
            'label' => __( 'Custom Attributes Value.', 'woogool' ),
            'wrap_close' => true,
            'value' => isset( $customAttributes['value'] ) ? $customAttributes['value'] : '',
        );
    }
} else {
    $shop_field['customAttributes[0][name]'] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'woogool-form-field woogool-product-field-child-wrap',
        ),
        'type' => 'text',
        'desc' => __( 'The name of the attribute.', 'woogool' ),
        'label' => __( 'Custom Attributes Name', 'woogool' ),

    );

    $shop_field['customAttributes[0][type]'] = array(
        'type' => 'text',
        'desc' => __( 'Acceptable values are: "boolean" "datetimerange" "float" "group" "int" "price" "text" "time" "url"', 'woogool' ),
        'label' => __( 'Custom Attributes Type', 'woogool' ),

    );

    $shop_field['customAttributes[0][unit]'] = array(
        'type' => 'text',
        'desc' => __( 'Free-form unit of the attribute. Unit can only be used for values of type INT or FLOAT.', 'woogool' ),
        'label' => __( 'Custom Attributes Unit', 'woogool' ),

    );

    $shop_field['customAttributes[0][value]'] = array(
        'type' => 'text',
        'desc' => __( 'The value of the attribute.', 'woogool' ),
        'label' => __( 'Custom Attributes Value.', 'woogool' ),
        'wrap_close' => true,
    );
}

$shop_field[] = array(
    'wrap_close' => true,
    'type' => 'html',
    'html' => '<a href="#" class="button-primary woogool-product-field-addMore">' .__( 'Add More', 'woogool' ) . '</a>
        <a class="button-secondary woogool-product-field-remove" href="#">' . __( 'Cancle', 'woogool' ) . '</a>',
);
//close customAttributes

$shop_field[] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-field woogool-html woogool-customattributes-wrap',
    ),
    'type' => 'html',
    'html' => '<h1 class="woogool-customattributes-head">A list of custom group (merchant-provided) attributes.</h1>',
);

if ( isset( $product['customGroups'] ) && count( $product['customGroups'] ) ) {
    foreach ( $product['customGroups'] as $key => $customGroups ) {
        $shop_field['customGroups['.$key.'][name]'] = array(
            'wrap_start' => true,
            'wrap_attr' => array(
                'class' => 'woogool-form-field woogool-product-field-child-wrap',
            ),
            'type' => 'text',
            'desc' => __( 'The name of the group.', 'woogool' ),
            'label' => __( 'Custom Groups Name', 'woogool' ),
            'value' => isset( $customGroups['name'] ) ? $customGroups['name'] : '',
        );

        $shop_field['customGroups['.$key.'][attributes][name]'] = array(
            'type' => 'text',
            'desc' => __( 'The name of the attribute.', 'woogool' ),
            'label' => __( 'Custom Groups Attributes Name', 'woogool' ),
            'value' => isset( $customGroups['attributes']['name'] ) ? $customGroups['attributes']['name'] : '',
        );

        $shop_field['customGroups['.$key.'][attributes][type]'] = array(
            'type' => 'text',
            'desc' => __( 'Acceptable values are:
                        "boolean"
                        "datetimerange"
                        "float"
                        "group"
                        "int"
                        "price"
                        "text"
                        "time"
                        "url"', 'woogool'
                    ),
            'label' => __( 'Custom Groups Attributes Type', 'woogool' ),
            'value' => isset( $customGroups['attributes']['type'] ) ? $customGroups['attributes']['type'] : '',
        );

        $shop_field['customGroups['.$key.'][attributes][unit]'] = array(
            'type' => 'text',
            'desc' => __( 'Free-form unit of the attribute. Unit can only be used for values of type INT or FLOAT.', 'woogool' ),
            'label' => __( 'Custom Groups Attributes Unit', 'woogool' ),
            'value' => isset( $customGroups['attributes']['unit'] ) ? $customGroups['attributes']['unit'] : '',
        );

        $shop_field['customGroups['.$key.'][attributes][value]'] = array(
            'type' => 'text',
            'desc' => __( 'The value of the attribute.', 'woogool' ),
            'label' => __( 'Custom Groups Attributes Value', 'woogool' ),
            'wrap_close' => true,
            'value' => isset( $customGroups['attributes']['value'] ) ? $customGroups['attributes']['value'] : '',
        );
    }
} else {
    $shop_field['customGroups[0][name]'] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'woogool-form-field woogool-product-field-child-wrap',
        ),
        'type' => 'text',
        'desc' => __( 'The name of the group.', 'woogool' ),
        'label' => __( 'Custom Groups Name', 'woogool' ),
    );

    $shop_field['customGroups[0][attributes][name]'] = array(
        'type' => 'text',
        'desc' => __( 'The name of the attribute.', 'woogool' ),
        'label' => __( 'Custom Groups Attributes Name', 'woogool' ),
    );

    $shop_field['customGroups[0][attributes][type]'] = array(
        'type' => 'text',
        'desc' => __( 'Acceptable values are:
                    "boolean"
                    "datetimerange"
                    "float"
                    "group"
                    "int"
                    "price"
                    "text"
                    "time"
                    "url"', 'woogool'
                ),
        'label' => __( 'Custom Groups Attributes Type', 'woogool' ),
    );

    $shop_field['customGroups[0][attributes][unit]'] = array(
        'type' => 'text',
        'desc' => __( 'Free-form unit of the attribute. Unit can only be used for values of type INT or FLOAT.', 'woogool' ),
        'label' => __( 'Custom Groups Attributes Unit', 'woogool' ),
    );

    $shop_field['customGroups[0][attributes][value]'] = array(
        'type' => 'text',
        'desc' => __( 'The value of the attribute.', 'woogool' ),
        'label' => __( 'Custom Groups Attributes Value', 'woogool' ),
        'wrap_close' => true,
    );
}

$shop_field[] = array(
    'wrap_close' => true,
    'type' => 'html',
    'html' => '<a href="#" class="button-primary woogool-product-field-addMore">' .__( 'Add More', 'woogool' ) . '</a>
        <a class="button-secondary woogool-product-field-remove" href="#">' . __( 'Cancle', 'woogool' ) . '</a>',
);

//close customGroups

$shop_field['customLabel0'] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-part',
    ),
    'type' => 'text',
    'desc' => __( 'Custom label 0 for custom grouping of items in a Shopping campaign.', 'woogool' ),
    'label' => __( 'CustomLabel0', 'woogool' ),
    'value' => isset( $product['customLabel0'] ) ? $product['customLabel0'] : '',
);

$shop_field['customLabel1'] = array(
    'type' => 'text',
    'desc' => __( 'Custom label 1 for custom grouping of items in a Shopping campaign.', 'woogool' ),
    'label' => __( 'CustomLabel1', 'woogool' ),
    'value' => isset( $product['customLabel1'] ) ? $product['customLabel1'] : '',
);

$shop_field['customLabel2'] = array(
    'type' => 'text',
    'desc' => __( 'Custom label 2 for custom grouping of items in a Shopping campaign.', 'woogool' ),
    'label' => __( 'CustomLabel2', 'woogool' ),
    'value' => isset( $product['customLabel2'] ) ? $product['customLabel2'] : '',
);

$shop_field['customLabel3'] = array(
    'type' => 'text',
    'desc' => __( 'Custom label 3 for custom grouping of items in a Shopping campaign.', 'woogool' ),
    'label' => __( 'CustomLabel3', 'woogool' ),
    'value' => isset( $product['customLabel3'] ) ? $product['customLabel3'] : '',
);

$shop_field['customLabel4'] = array(
    'type' => 'text',
    'desc' => __( 'Custom label 4 for custom grouping of items in a Shopping campaign.', 'woogool' ),
    'label' => __( 'CustomLabel4', 'woogool' ),
    'wrap_close' => true,
    'value' => isset( $product['customLabel4'] ) ? $product['customLabel4'] : '',
);

$shop_field[] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-field woogool-html woogool-customattributes-wrap',
    ),
    'type' => 'html',
    'html' => '<h1 class="woogool-customattributes-head">' .
    __( 'Specifies the intended destinations for the product.' , 'woogool' ) . '</h1>',
);

if ( isset( $product['destinations'] ) && count( $product['destinations'] ) ) {
    foreach ( $product['destinations'] as $key => $destinations ) {

        $shop_field['destinations['.$key.'][destinationName]'] = array(
            'wrap_start' => true,
            'wrap_attr' => array(
                'class' => 'woogool-form-field woogool-html woogool-product-field-child-wrap',
            ),
            'type' => 'text',
            'desc' => __( 'The name of the destination.', 'woogool' ),
            'label' => __( 'Destinations Name', 'woogool' ),
            'value' => isset( $destinations['destinationName'] ) ? $destinations['destinationName'] : '',
        );

        $shop_field['destinations['.$key.'][intention]'] = array(
            'type' => 'text',
            'desc' => __( 'Acceptable values are:
                    "default"
                    "excluded"
                    "optional"
                    "required"
                ', 'woogool' ),
            'label' => __( 'Destinations Intention', 'woogool' ),
            'wrap_close' => true,
            'value' => isset( $destinations['intention'] ) ? $destinations['intention'] : '',
        );
    }
} else {

    $shop_field['destinations[0][destinationName]'] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'woogool-form-field woogool-html woogool-product-field-child-wrap',
        ),
        'type' => 'text',
        'desc' => __( 'The name of the destination.', 'woogool' ),
        'label' => __( 'Destinations Name', 'woogool' ),
    );

    $shop_field['destinations[0][intention]'] = array(
        'type' => 'text',
        'desc' => __( 'Acceptable values are:
                "default"
                "excluded"
                "optional"
                "required"
            ', 'woogool' ),
        'label' => __( 'Destinations Intention', 'woogool' ),
        'wrap_close' => true,
    );
}

$shop_field[] = array(
    'wrap_close' => true,
    'type' => 'html',
    'html' => '<a href="#" class="button-primary woogool-product-field-addMore">' .__( 'Add More', 'woogool' ) . '</a>
        <a class="button-secondary woogool-product-field-remove" href="#">' . __( 'Cancle', 'woogool' ) . '</a>',
);

$shop_field['energyEfficiencyClass'] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-part',
    ),
    'type' => 'text',
    'desc' => __( 'The energy efficiency class as defined in EU directive 2010/30/EU.  Acceptable values are:

                "A"
                "A+"
                "A++"
                "A+++"
                "B"
                "C"
                "D"
                "E"
                "F"
                "G"
            ', 'woogool' ),
    'label' => __( 'Energy Efficiency Class', 'woogool' ),
    'value' => isset( $product['energyEfficiencyClass'] ) ? $product['energyEfficiencyClass'] : '',
);

$shop_field['expirationDate'] = array(
    'type' => 'text',
    'desc' => __( 'Date that an item will expire.', 'woogool' ),
    'label' => __( 'Expiration Date', 'woogool' ),
    'value' => isset( $product['expirationDate'] ) ? $product['expirationDate'] : '',
);

$shop_field['identifierExists'] = array(
    'label' => __( 'Identifier Exists', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'False when the item does not have unique product identifiers appropriate to its category, such as GTIN, MPN, and brand. Required according to the Unique Product Identifier Rules for all target countries except for Canada.', 'woogool' ),
    'fields' => array(
        array(
            'label' => __( 'Identifier Exists', 'woogool' ),
            'value' => 'on',
            'checked' => isset( $product['identifierExists'] ) ? $product['identifierExists'] : ''
        ),
    ),
);

$shop_field['installment[amount][currency]'] = array(
    'type' => 'text',
    'desc' => __( 'Brazil only.     The currency of the price.', 'woogool' ),
    'label' => __( 'Installment Amount Currency', 'woogool' ),
    'value' => isset( $product['installment']['amount']['currency'] ) ? $product['installment']['amount']['currency'] : '',
);
$shop_field['installment[amount][value]'] = array(
    'type' => 'text',
    'desc' => __( 'Brazil only. The amount the buyer has to pay per month.', 'woogool' ),
    'label' => __( 'Installment Amount Value', 'woogool' ),
    'value' => isset( $product['installment']['amount']['value'] ) ? $product['installment']['amount']['value'] : '',
);

$shop_field['installment[months]'] = array(
    'type' => 'text',
    'desc' => __( 'Brazil only. The currency of the price.', 'woogool' ),
    'label' => __( 'Installment Months', 'woogool' ),
    'value' => isset( $product['installment']['months'] ) ? $product['installment']['months'] : '',
);

$shop_field['isBundle'] = array(
    'label' => __( 'Is Bundle', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Whether the item is a merchant-defined bundle. A bundle is a custom grouping of different products sold by a merchant for a single price.', 'woogool' ),
    'fields' => array(
        array(
            'label' => __( 'Is Bundle', 'woogool' ),
            'value' => 'on',
            'checked' => isset( $product['isBundle'] ) ? $product['isBundle'] : '',
        ),
    ),
);

$shop_field['kind'] = array(
    'type' => 'text',
    'value' => 'content#product',
    'label' => __( 'Kind', 'woogool' ),
    'desc' => __( '', 'woogool' ),
    'value' => isset( $product['kind'] ) ? $product['kind'] : '',
);

$shop_field['loyaltyPoints[name]'] = array(
    'type' => 'text',
    'desc' => __( 'Japan only. Name of loyalty points program. It is recommended to limit the name to 12 full-width characters or 24 Roman characters.', 'woogool' ),
    'label' => __( 'LoyaltyPoints Name', 'woogool' ),
    'value' => isset( $product['loyaltyPoints']['name'] ) ? $product['loyaltyPoints']['name'] : '',
);

$shop_field['loyaltyPoints[pointsValue]'] = array(
    'type' => 'text',
    'desc' => __( 'Japan only. The retailer\'s loyalty points in absolute value.', 'woogool' ),
    'label' => __( 'LoyaltyPoints Points Value', 'woogool' ),
    'value' => isset( $product['loyaltyPoints']['pointsValue'] ) ? $product['loyaltyPoints']['pointsValue'] : '',
);

$shop_field['loyaltyPoints[ratio]'] = array(
    'type' => 'text',
    'desc' => __( 'Japan only. The ratio of a point when converted to currency. Google assumes currency based on Merchant Center settings. If ratio is left out, it defaults to 1.0.', 'woogool' ),
    'label' => __( 'LoyaltyPoints Ratio', 'woogool' ),
    'value' => isset( $product['loyaltyPoints']['ratio'] ) ? $product['loyaltyPoints']['ratio'] : '',
);

$shop_field['merchantMultipackQuantity'] = array(
    'type' => 'text',
    'desc' => __( 'The number of identical products in a merchant-defined multipack.', 'woogool' ),
    'label' => __( 'Merchant Multipack Quantity', 'woogool' ),
    'value' => isset( $product['merchantMultipackQuantity'] ) ? $product['merchantMultipackQuantity'] : '',
);

$shop_field['mobileLink'] = array(
    'type' => 'text',
    'desc' => __( 'Link to a mobile-optimized version of the landing page.', 'woogool' ),
    'label' => __( 'Mobile Link', 'woogool' ),
    'value' => isset( $product['mobileLink'] ) ? $product['mobileLink'] : '',
);

$shop_field['onlineOnly'] = array(
    'label' => __( 'On Line Only', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Whether an item is available for purchase only online.', 'woogool' ),
    'fields' => array(
        array(
            'label' => __( 'On Line Only', 'woogool' ),
            'value' => 'on',
            'checked' => isset( $product['onlineOnly'] ) ? $product['onlineOnly'] : '',
        ),
    ),
);

$shop_field['salePrice[currency]'] = array(
    'type' => 'text',
    'desc' => __( 'The currency of the price.', 'woogool' ),
    'label' => __( 'Sale Price Currency', 'woogool' ),
    'value' => isset( $product['salePrice']['currency'] ) ? $product['salePrice']['currency'] : '',
);

$shop_field['salePrice[value]'] = array(
    'type' => 'text',
    'desc' => __( 'The price represented as a number.', 'woogool' ),
    'label' => __( 'Sale Price Value', 'woogool' ),
    'value' => isset( $product['salePrice']['value'] ) ? $product['salePrice']['value'] : '',
);

$shop_field['salePriceEffectiveDate'] = array(
    'type' => 'text',
    'desc' => __( 'Date range during which the item is on sale.', 'woogool' ),
    'label' => __( 'Sale Price Effective Date', 'woogool' ),
    'value' => isset( $product['salePriceEffectiveDate'] ) ? $product['salePriceEffectiveDate'] : '',
);

$shop_field['shippingLabel'] = array(
    'type' => 'text',
    'desc' => __( 'The shipping label of the product, used to group product in account-level shipping rules.', 'woogool' ),
    'label' => __( 'Shipping Label', 'woogool' ),
    'value' => isset( $product['shippingLabel'] ) ? $product['shippingLabel'] : '',
);

$shop_field['sizeSystem'] = array(
    'type' => 'text',
    'desc' => __( 'Acceptable values are:

            "at"
            "br"
            "cn"
            "de"
            "eu"
            "fr"
            "it"
            "jp"
            "mex"
            "uk"
            "us"
        ', 'woogool' ),
    'label' => __( 'Size System', 'woogool' ),
    'value' => isset( $product['sizeSystem'] ) ? $product['sizeSystem'] : '',
);

$shop_field['sizeType'] = array(
    'type' => 'text',
    'desc' => __( 'Acceptable values are:

            "maternity"
            "oversize"
            "petite"
            "regular"
        ', 'woogool' ),
    'label' => __( 'Size Type', 'woogool' ),
    'value' => isset( $product['sizeType'] ) ? $product['sizeType'] : '',
);

$shop_field['unitPricingBaseMeasure'] = array(
    'type' => 'text',
    'desc' => __( 'The preference of the denominator of the unit price.', 'woogool' ),
    'label' => __( 'Unit Pricing Base Measure', 'woogool' ),
    'value' => isset( $product['unitPricingBaseMeasure'] ) ? $product['unitPricingBaseMeasure'] : '',
);

$shop_field['unitPricingMeasure'] = array(
    'type' => 'text',
    'desc' => __( 'The measure and dimension of an item.', 'woogool' ),
    'label' => __( 'Unit Pricing Measure', 'woogool' ),
    'value' => isset( $product['unitPricingMeasure'] ) ? $product['unitPricingMeasure'] : '',
);

/*$shop_field['validatedDestinations[]'] = array(
    'type' => 'text',
    'desc' => __( '', 'woogool' ),
    'label' => __( 'Validated Destinations', 'woogool' ),
);*/

/*$shop_field[] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-field woogool-html woogool-customattributes-wrap',
    ),
    'type' => 'html',
    'html' => '<h1 class="woogool-customattributes-head">' .
    __( 'Warning.' , 'woogool' ) . '</h1>',
);

$shop_field['warnings[domain][]'] = array(
    'wrap_start' => true,
    'wrap_attr' => array(
        'class' => 'woogool-form-field woogool-html woogool-product-field-child-wrap',
    ),
    'type' => 'text',
    'desc' => __( '', 'woogool' ),
    'label' => __( 'Warnings Destinations', 'woogool' ),
);

$shop_field['warnings[message][]'] = array(
    'type' => 'text',
    'desc' => __( '', 'woogool' ),
    'label' => __( 'Warnings Message', 'woogool' ),
);

$shop_field['warnings[reason][]'] = array(
    'type' => 'text',
    'desc' => __( '', 'woogool' ),
    'label' => __( 'Warnings Reason', 'woogool' ),
    'wrap_close' => true,
);

$shop_field[] = array(
    'wrap_close' => true,
    'type' => 'html',
    'html' => '<a href="#" class="woogool-product-field-addMore">' .__( 'Add More', 'woogool' ) . '</a>
        <a class="woogool-product-field-remove" href="#">' . __( 'Cancle', 'woogool' ) . '</a>',
);*/




$shop_field['id'] = array(
    'type' => 'text',
    'desc' => __( '', 'woogool' ),
    'label' => __( 'ID', 'woogool' ),
    'value' => isset( $product['id'] ) ? $product['id'] : '',
);

$shop_field['googleProductCategory'] = array(
    'type' => 'text',
    'desc' => __( 'Google\'s category of the item.', 'woogool' ),
    'label' => __( 'Google Product Category', 'woogool' ),
    'value' => isset( $product['googleProductCategory'] ) ? $product['googleProductCategory'] : '',
);

if ( isset( $additional_images ) && count( $additional_images ) ) {
    foreach ( $additional_images as $key => $additionalImageLinks ) {
        $remove =  ( $key > 0 ) ? true : false;
        $shop_field['additionalImageLinks['.$key.']'] = array(
            'type' => 'text',
            'desc' => '(list)    Additional URLs of images of the item.',
            'label' => __( 'Additional image link', 'woogool' ),
            'value' => isset( $additionalImageLinks ) ? $additionalImageLinks : '',
            'extra' => array(
                'data-add_more' => true,
                'data-remove_more' => $remove,
                'data-field_name' => 'additionalImageLinks[]'
            )
        );
    }
} else {
    $shop_field['additionalImageLinks[]'] = array(
        'type' => 'text',
        'desc' => '(list)    Additional URLs of images of the item.',
        'label' => __( 'Additional image link', 'woogool' ),
        'extra' => array(
            'data-add_more' => true,
            'data-field_name' => 'additionalImageLinks[]'
        )
    );
}

$shop_field['imageLink'] = array(
    'type' => 'text',
    'desc' => __( 'URL of an image of the item.', 'woogool' ),
    'label' => __( 'Image Link', 'woogool' ),
    'value' => $image_url ? $image_url : '',
);

$shop_field['adult'] = array(
    'label' => __( 'Adult', 'woogool' ),
    'type' => 'checkbox',
    'desc' => __( 'Set to true if the item is targeted towards adults.', 'woogool' ),
    'fields' => array(
        array(
            'label' => __( 'Enable Adult Content', 'woogool' ),
            'value' => 'on',
            'checked' => isset( $product['adult'] ) ? $product['adult'] : '',
        ),
    ),
);

$shop_field['adwordsGrouping'] = array(
    'type' => 'text',
    'desc' => ' Used to group items in an arbitrary way. Only for CPA%, discouraged otherwise.',
    'label' => __( 'Adwords Grouping', 'woogool' ),
    'value' => isset( $product['adwordsGrouping'] ) ? $product['adwordsGrouping'] : '',
);

if ( isset( $product['adwordsLabels'] ) && count( $product['adwordsLabels'] ) ) {
    foreach ( $product['adwordsLabels'] as $key => $adwordsLabels ) {
        $remove = ( $key > 0 ) ? true : false;
        $shop_field['adwordsLabels['.$key.']'] = array(
            'type' => 'text',
            'desc' => '(list)    Similar to adwords_grouping, but only works on CPC.',
            'label' => __( 'Adwords Label', 'woogool' ),
            'value' => isset( $adwordsLabels ) ? $adwordsLabels : '',
            'extra' => array(
                'data-add_more' => true,
                'data-remove_more' => $remove,
                'data-field_name' => 'adwordsLabels[]'
            )
        );
    }
} else {
    $shop_field['adwordsLabels[]'] = array(
        'type' => 'text',
        'desc' => '(list)    Similar to adwords_grouping, but only works on CPC.',
        'label' => __( 'Adwords Label', 'woogool' ),
        'extra' => array(
            'data-add_more' => true,
            'data-field_name' => 'adwordsLabels[]'
        )
    );
}

/*$shop_field['adwords_qu_param'] = array(
    'type' => 'text',
    'label' => __( 'Adwords query param', 'woogool' ),
);*/

$shop_field['adwordsRedirect'] = array(
    'type' => 'text',
    'desc' => 'Allows advertisers to override the item URL when the product is shown within the context of Product Ads.     Target age group of the item.',
    'label' => __( 'Adwords Redirect', 'woogool' ),
    'value' => isset( $product['adwordsRedirect'] ) ? $product['adwordsRedirect'] : '',
);

$shop_field['ageGroup'] = array(
    'type' => 'text',
    'label' => __( 'Age group', 'woogool' ),
    'desc' => __( 'Acceptable values are: "adult" "infant" "kids" "newborn" "toddler"', 'woogool' ),
    'value' => isset( $product['ageGroup'] ) ? $product['ageGroup'] : '',
);

$shop_field['color'] = array(
    'type' => 'text',
    'desc' => __( '  Color of the item.', 'woogool' ),
    'label' => __( 'Color', 'woogool' ),
    'value' => isset( $product['color'] ) ? $product['color'] : '',
);

$shop_field['expirationDate'] = array(
    'type' => 'text',
    'desc' => __( '', 'woogool' ),
    'label' => __( 'Expiration date', 'woogool' ),
    'value' => isset( $product['expirationDate'] ) ? $product['expirationDate'] : '',
);

$shop_field['gender'] = array(
    'type' => 'text',
    'desc' => __( 'Acceptable values are:
            "female"
            "male"
            "unisex"
        ', 'woogool' ),
    'label' => __( 'Age group', 'woogool' ),
    'value' => isset( $product['gender'] ) ? $product['gender'] : '',
);

$shop_field['gtin'] = array(
    'type' => 'text',
    'desc' => __( 'Global Trade Item Number (GTIN) of the item.', 'woogool' ),
    'label' => __( 'Gtin', 'woogool' ),
    'value' => isset( $product['gtin'] ) ? $product['gtin'] : '',
);

$shop_field['itemGroupId'] = array(
    'type' => 'text',
    'desc' => __( 'Shared identifier for all variants of the same product.', 'woogool' ),
    'label' => __( 'Item Group ID', 'woogool' ),
    'value' => isset( $product['itemGroupId'] ) ? $product['itemGroupId'] : '',
);

$shop_field['material'] = array(
    'type' => 'text',
    'desc' => __( 'The material of which the item is made.', 'woogool' ),
    'label' => __( 'Material', 'woogool' ),
    'value' => isset( $product['material'] ) ? $product['material'] : '',
);

$shop_field['pattern'] = array(
    'type' => 'text',
    'desc' => __( 'The item\'s pattern (e.g. polka dots).', 'woogool' ),
    'label' => __( 'Pattern', 'woogool' ),
    'value' => isset( $product['pattern'] ) ? $product['pattern'] : '',
);

$shop_field['productType'] = array(
    'type' => 'text',
    'desc' => __( 'Your category of the item.', 'woogool' ),
    'label' => __( 'Product Type', 'woogool' ),
    'value' => isset( $product['productType'] ) ? $product['productType'] : '',
);

$shop_field['shippingWeight[unit]'] = array(
    'type' => 'text',
    'desc' => __( 'The unit of value.', 'woogool' ),
    'label' => __( 'Shipping Weight Unit', 'woogool' ),
    'value' => isset( $product['shippingWeight']['unit'] ) ? $product['shippingWeight']['unit'] : '',
);

$shop_field['shippingWeight[value]'] = array(
    'type' => 'text',
    'desc' => __( 'The weight of the product used to calculate the shipping cost of the item. System in which the size is specified. Recommended for apparel items. ', 'woogool' ),
    'label' => __( 'Shipping Weight value', 'woogool' ),
    'value' => isset( $product['shippingWeight']['value'] ) ? $product['shippingWeight']['value'] : '',
);
if ( isset( $product['sizes'] ) && count( $product['sizes'] ) ) {
    foreach ( $product['sizes'] as $key => $sizes ) {
        $remove = ( $key > 0 ) ? true : false;
        $shop_field['sizes['.$key.']'] = array(
            'type' => 'text',
            'desc' => __( 'Size of the item.', 'woogool' ),
            'label' => __( 'Sizes', 'woogool' ),
            'value' => isset( $sizes ) ? $sizes : '',
            'extra' => array(
                'data-add_more' => true,
                'data-remove_more' => $remove,
                'data-field_name' => 'sizes[]'
            )
        );
    }
} else {
    $shop_field['sizes[]'] = array(
        'type' => 'text',
        'desc' => __( 'Size of the item.', 'woogool' ),
        'label' => __( 'Sizes', 'woogool' ),
        'extra' => array(
            'data-add_more' => true,
            'data-field_name' => 'sizes[]'
        )
    );
}

$shop_field[] = array(
    'wrap_close' => true,
    'type' => 'html',
    'html' => ''
);


/*$shop_field['year'] = array(
    'type' => 'text',
    'desc' => __( '', 'woogool' ),
    'label' => __( 'Year', 'woogool' ),
);*/
echo '<div class="woogool-form-wrap">';
echo '<form method="post" class="woogool-form woogool-form-product" action="">';
?>
<h1 class="woogool-product-info"><?php _e( 'Product Information', 'woogool' ); ?></h1>
<div class="woogool-warning">
    <?php _e( 'If you did not cofigure your shipping and tax information correctly according 
    to your targeted coutnry and did not verify your website then please do all these things 
    from your google merchant account before submitting the form', 'woogool' ); ?>
</div>

<?php

foreach( $shop_field as $name => $field_obj ) {

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
<input type="submit" class="button button-primary" value="<?php _e( 'Send', 'woogool'); ?>" name="woogool_submit">
<div class="woogool-spinner-wrap"></div>
<?php
echo '</form>';
echo '</div>';
?>
</div>

<div class="wrap">

    <div class="wogo-submit-notification">

        <div class="wogo-error-code"></div>
        <div class="error-message"></div>
    </div>

<?php

$products = $this->get_products();
foreach ( $products as $key => $product) {
    $product_log[$product->ID] = $product->post_title;
}
$product_id = get_user_meta( get_current_user_id(), 'wogo_product_id', true  );
$product = get_post_meta( $product_id, 'wogo_product', true );

$wc_product = new WC_Product( $product_id );
$product_price = $wc_product->get_price();
$currency = get_woocommerce_currency();
//var_dump( get_woocommerce_currency() ); die();
$shop_field = array();

    $shop_field['action'] = array(
        'type'  => 'hidden',
        'value' => 'wogo_merchant_form',
    );

    $shop_field['product_id'] =  array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-part',
        ),
        'label'    => __( 'Product', 'hrm' ),
        'type'     => 'select',
        'option'   => isset( $product_log ) ? $product_log : array(),
        'selected' => $product_id,
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        )
    );

    $shop_field['title'] = array(
        'type'  => 'text',
        'label' => __( 'Title', 'wogo' ),
        'value' => get_the_title( $product_id ),
        'desc'  => ' Title of the item.',
        'class' => 'wogo-product_title',
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
    );

    $shop_field['description'] = array(
        'type'  => 'text',
        'desc'  => __( 'Description of the item.', 'wogo' ),
        'class' => 'wogo-description',
        'label' => __( 'Description', 'wogo' ),
        'value' => isset( $product['description'] ) ? $product['description'] : '',
    );

    $shop_field['channel'] = array(
        'type'  => 'text',
        'label' => __( 'Channel', 'wogo' ),
        'desc'  => 'The item\'s channel (online or local). Acceptable values are: "b2b" or "local" or "online"',
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => isset( $product['channel'] ) ? $product['channel'] : '',
    );

    $shop_field['contentLanguage'] = array(
        'type'  => 'text',
        'label' => __( 'Content Language', 'wogo' ),
        'desc'  => 'The two-letter ISO 639-1 language code for the item.
        <a href="http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank">More Details..</a>',
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => isset( $product['contentLanguage'] ) ? $product['contentLanguage'] : '',
    );

    $shop_field['offerId'] = array(
        'type'  => 'text',
        'label' => __( 'Offer Id', 'wogo' ),
        'desc'  => 'An identifier of the item.',
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => isset( $product['offerId'] ) ? $product['offerId'] : '',
    );

    $shop_field['targetCountry'] = array(
        'type'  => 'text',
        'label' => __( 'TargetCountry', 'wogo' ),
        'desc'  => 'The two-letter ISO 3166 country code for the item.
        <a href="http://en.wikipedia.org/wiki/ISO_3166-1" target="_blank">More Details..</a>',
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => isset( $product['targetCountry'] ) ? $product['targetCountry'] : '',
    );

    $shop_field['condition'] = array(
        'type'  => 'text',
        'label' => __( 'Condition', 'wogo' ),
        'desc'  => __( 'Acceptable values are: "new" "refurbished" "used"', 'wogo' ),
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => isset( $product['condition'] ) ? $product['condition'] : '',
    );

    $shop_field['price[currency]'] = array(
        'type'  => 'text',
        'desc'  => __( 'The currency of the price.', 'wogo' ),
        'label' => __( 'Price Currency', 'wogo' ),
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => $currency,
    );

    $shop_field['price[value]'] = array(
        'type' => 'text',
        'desc' => __( 'The price represented as a number.', 'wogo' ),
        'label' => __( 'Price', 'wogo' ),
        'extra' => array(
            'data-wogo_validation' => true,
            'data-wogo_required' => true,
            'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
        ),
        'value' => $product_price,
    );

    $shop_field['brand'] = array(
        'type'  => 'text',
        'label' => __( 'Brand', 'wogo' ),
        'desc'  => __( 'Brand of the item.', 'wogo' ),
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => isset( $product['brand'] ) ? $product['brand'] : '',
    );

    $shop_field['mpn'] = array(
        'type'  => 'text',
        'label' => __( 'Mpn', 'wogo' ),
        'desc'  => __( 'Manufacturer Part Number (MPN) of the item.', 'wogo' ),
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => isset( $product['mpn'] ) ? $product['mpn'] : '',
    );

    $shop_field['availability'] = array(
        'type'  => 'text',
        'label' => __( 'Availability', 'wogo' ),
        'desc'  => __( 'Acceptable values are: "available for order" "in stock" "limited availability" "on display to order" "out of stock" "preorder"', 'wogo' ),
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
        ),
        'value' => isset( $product['availability'] ) ? $product['availability'] : '',
    );

    $shop_field['link'] = array(
        'type'       => 'text',
        'desc'       => __( 'URL directly linking to your item\'s page on your website.', 'wogo' ),
        'label'      => __( 'Link', 'wogo' ),
        'wrap_close' => true,
        'value'      => isset( $product['link'] ) ? $product['link'] : '',
        'extra' => array(
            'data-wogo_validation'         => true,
            'data-wogo_required'           => true,
            'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),

        ),

    );

    $shop_field[] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-field wogo-html wogo-customattributes-wrap',
        ),
        'type' => 'html',
        'html' => '<h1 class="wogo-customattributes-head">' .
        __( 'Shipping rules.' , 'wogo' ) . '</h1>',
    );

    if ( isset( $product['shipping'] ) && count( $product['shipping'] ) ) {
        foreach ( $product['shipping'] as $key => $shipping ) {
            $shop_field['shipping['.$key.'][country]'] = array(
                'wrap_start' => true,
                'type'       => 'text',
                'desc'       => __( 'The two-letter ISO 3166 country code for the country to which an item will ship.', 'wogo' ),
                'label'      => __( 'Shipping Country', 'wogo' ),
                'value'      => isset( $shipping['country'] ) ? $shipping['country'] : '',
                'wrap_attr' => array(
                    'class' => 'wogo-form-field wogo-html wogo-product-field-child-wrap',
                ),
                'extra' => array(
                    'data-wogo_validation' => true,
                    'data-wogo_required' => true,
                    'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
                ),

            );

            $shop_field['shipping['.$key.'][region]'] = array(
                'type' => 'text',
                'desc' => __( 'The geographic region to which a shipping rate applies (e.g. zip code).', 'wogo' ),
                'label' => __( 'Shipping Region', 'wogo' ),
                'extra' => array(
                    'data-wogo_validation' => true,
                    'data-wogo_required' => true,
                    'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
                ),
                'value' => isset( $shipping['region'] ) ? $shipping['region'] : '',
            );


            $shop_field['shipping['.$key.'][price][currency]'] = array(
                'type' => 'text',
                'desc' => __( 'The currency of the price.', 'wogo' ),
                'label' => __( 'Shipping Price Currency', 'wogo' ),
                'extra' => array(
                    'data-wogo_validation' => true,
                    'data-wogo_required' => true,
                    'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
                ),
                'value' => $currency,
            );

            $shop_field['shipping['.$key.'][price][value]'] = array(
                'type' => 'text',
                'desc' => __( 'The price represented as a number.', 'wogo' ),
                'label' => __( 'Shipping Price', 'wogo' ),
                'extra' => array(
                    'data-wogo_validation' => true,
                    'data-wogo_required' => true,
                    'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
                ),
                'value' => isset( $shipping['price']['value'] ) ? $shipping['price']['value'] : '',
            );

            $shop_field['shipping['.$key.'][service]'] = array(
                'type' => 'text',
                'desc' => __( 'A free-form description of the service class or delivery speed.', 'wogo' ),
                'label' => __( 'Shipping Service', 'wogo' ),
                'extra' => array(
                    'data-wogo_validation' => true,
                    'data-wogo_required' => true,
                    'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
                ),
                'value' => isset( $shipping['service'] ) ? $shipping['service'] : '',
            );

            $shop_field['shipping['.$key.'][locationGroupName]'] = array(
                'type' => 'text',
                'desc' => __( 'The location where the shipping is applicable, represented by a location group name.', 'wogo' ),
                'label' => __( 'Shipping location Group Name', 'wogo' ),
                'value' => isset( $shipping['locationGroupName'] ) ? $shipping['locationGroupName'] : '',
            );

            $shop_field['shipping['.$key.'][locationId]'] = array(
                'type' => 'text',
                'desc' => __( 'The numeric id of a location that the shipping rate applies to as defined in the <a href="https://developers.google.com/adwords/api/docs/appendix/geotargeting" target="_blank">AdWords API.</a>', 'wogo' ),
                'label' => __( 'Shipping Location Id', 'wogo' ),
                'value' => isset( $shipping['locationId'] ) ? $shipping['locationId'] : '',
            );

            $shop_field['shipping['.$key.'][postalCode]'] = array(
                'type' => 'text',
                'desc' => __( '     The postal code range that the shipping rate applies to, represented by a postal code, a postal code prefix using * wildcard, a range between two postal codes or two postal code prefixes of equal length.', 'wogo' ),
                'label' => __( 'Shipping Postal Code', 'wogo' ),
                'wrap_close' => true,
                'value' => isset( $shipping['postalCode'] ) ? $shipping['postalCode'] : '',
            );
        }

    } else {
        $shop_field['shipping[0][country]'] = array(
            'wrap_start' => true,
            'type'       => 'text',
            'desc'       => __( 'The two-letter ISO 3166 country code for the country to which an item will ship.', 'wogo' ),
            'label'      => __( 'Shipping Country', 'wogo' ),
            'wrap_attr' => array(
                'class' => 'wogo-form-field wogo-html wogo-product-field-child-wrap',
            ),
            'extra' => array(
                'data-wogo_validation' => true,
                'data-wogo_required' => true,
                'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
            ),

        );

        $shop_field['shipping[0][region]'] = array(
            'type' => 'text',
            'desc' => __( 'The geographic region to which a shipping rate applies (e.g. zip code).', 'wogo' ),
            'label' => __( 'Shipping Region', 'wogo' ),
            'extra' => array(
                'data-wogo_validation' => true,
                'data-wogo_required' => true,
                'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
            ),
        );


        $shop_field['shipping[0][price][currency]'] = array(
            'type' => 'text',
            'desc' => __( 'The currency of the price.', 'wogo' ),
            'label' => __( 'Shipping Price Currency', 'wogo' ),
            'extra' => array(
                'data-wogo_validation' => true,
                'data-wogo_required' => true,
                'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
            ),
        );

        $shop_field['shipping[0][price][value]'] = array(
            'type' => 'text',
            'desc' => __( 'The price represented as a number.', 'wogo' ),
            'label' => __( 'Shipping Price', 'wogo' ),
            'extra' => array(
                'data-wogo_validation' => true,
                'data-wogo_required' => true,
                'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
            ),
        );

        $shop_field['shipping[0][service]'] = array(
            'type' => 'text',
            'desc' => __( 'A free-form description of the service class or delivery speed.', 'wogo' ),
            'label' => __( 'Shipping Service', 'wogo' ),
            'extra' => array(
                'data-wogo_validation' => true,
                'data-wogo_required' => true,
                'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
            ),
        );

        $shop_field['shipping[0][locationGroupName]'] = array(
            'type' => 'text',
            'desc' => __( 'The location where the shipping is applicable, represented by a location group name.', 'wogo' ),
            'label' => __( 'Shipping location Group Name', 'wogo' ),
        );

        $shop_field['shipping[0][locationId]'] = array(
            'type' => 'text',
            'desc' => __( 'The numeric id of a location that the shipping rate applies to as defined in the <a href="https://developers.google.com/adwords/api/docs/appendix/geotargeting" target="_blank">AdWords API.</a>', 'wogo' ),
            'label' => __( 'Shipping Location Id', 'wogo' ),
        );

        $shop_field['shipping[0][postalCode]'] = array(
            'type' => 'text',
            'desc' => __( '     The postal code range that the shipping rate applies to, represented by a postal code, a postal code prefix using * wildcard, a range between two postal codes or two postal code prefixes of equal length.', 'wogo' ),
            'label' => __( 'Shipping Postal Code', 'wogo' ),
            'wrap_close' => true,
        );
    }

     $shop_field[] = array(
        'wrap_close' => true,
        'type' => 'html',
        'html' => '<a href="#" class="button-primary wogo-product-field-addMore">' .__( 'Add More', 'wogo' ) . '</a>
            <a class="button-secondary wogo-product-field-remove" href="#">' . __( 'Cancle', 'wogo' ) . '</a>',
    );
    //close shippin


    $shop_field[] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-field wogo-html wogo-customattributes-wrap',
        ),
        'type' => 'html',
        'html' => '<h1 class="wogo-customattributes-head">' .
        __( 'Tax information.' , 'wogo' ) . '</h1>',
    );

    if ( isset( $product['taxes'] ) && count( $product['taxes'] ) ) {
        foreach ( $product['taxes'] as $key => $taxes ) {
            $shop_field['taxes['.$key.'][country]'] = array(
                'wrap_start' => true,
                'wrap_attr' => array(
                    'class' => 'wogo-form-field wogo-html wogo-product-field-child-wrap',
                ),
                'type' => 'text',
                'desc' => __( 'The country within which the item is taxed, specified with a two-letter ISO 3166 country code.', 'wogo' ),
                'label' => __( 'Tax Country', 'wogo' ),
                'extra' => array(
                    'data-wogo_validation' => true,
                    'data-wogo_required' => true,
                    'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
                ),
                'value' => isset( $taxes['country'] ) ? $taxes['country'] : '',
            );

            $shop_field['taxes['.$key.'][region]'] = array(
                'type' => 'text',
                'desc' => __( 'The geographic region to which the tax rate applies.', 'wogo' ),
                'label' => __( 'Tax Region', 'wogo' ),
                'extra' => array(
                    'data-wogo_validation' => true,
                    'data-wogo_required' => true,
                    'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
                ),
                'value' => isset( $taxes['region'] ) ? $taxes['region'] : '',
            );

            $shop_field['taxes['.$key.'][rate]'] = array(
                'type' => 'text',
                'desc' => __( 'The percentage of tax rate that applies to the item price.', 'wogo' ),
                'label' => __( 'Tax Rate', 'wogo' ),
                'extra' => array(
                    'data-wogo_validation' => true,
                    'data-wogo_required' => true,
                    'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
                ),
                'value' => isset( $taxes['rate'] ) ? $taxes['rate'] : '',
            );

            $shop_field['taxes['.$key.'][taxShip]'] = array(
                'label' => __( 'Tax Ship', 'wogo' ),
                'type' => 'checkbox',
                'required' => 'required',
                'desc' => 'Set to true if tax is charged on shipping.',
                'fields' => array(
                    array(
                        'label' => __( 'Tax Ship', 'wogo' ),
                        'value' => 'on',
                        'checked' => isset( $taxes['taxShip'] ) ? $taxes['taxShip'] : '',
                    ),
                ),
            );

            $shop_field['taxes['.$key.'][locationId]'] = array(
                'label' => __( 'Tax Location Id', 'wogo' ),
                'type' => 'text',
                'desc' => __( 'The numeric id of a location that the tax rate applies to as defined in the Adwords API (https://developers.google.com/adwords/api/docs/appendix/geotargeting).', 'wogo' ),
                'value' => isset( $taxes['locationId'] ) ? $taxes['locationId'] : '',
            );

            $shop_field['taxes['.$key.'][postalCode]'] = array(
                'label' => __( 'Tax Postal Code', 'wogo' ),
                'type' => 'text',
                'desc' => __( 'The postal code range that the tax rate applies to, represented by a ZIP code, a ZIP code prefix using * wildcard, a range between two ZIP codes or two ZIP code prefixes of equal length. Examples: 94114, 94*, 94002-95460, 94*-95*.', 'wogo' ),
                'wrap_close' => true,
                'value' => isset( $taxes['postalCode'] ) ? $taxes['postalCode'] : '',
            );
        }
    } else {
        $shop_field['taxes[0][country]'] = array(
            'wrap_start' => true,
            'wrap_attr' => array(
                'class' => 'wogo-form-field wogo-html wogo-product-field-child-wrap',
            ),
            'type' => 'text',
            'desc' => __( 'The country within which the item is taxed, specified with a two-letter ISO 3166 country code.', 'wogo' ),
            'label' => __( 'Tax Country', 'wogo' ),
            'extra' => array(
                'data-wogo_validation' => true,
                'data-wogo_required' => true,
                'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
            ),
        );

        $shop_field['taxes[0][region]'] = array(
            'type' => 'text',
            'desc' => __( 'The geographic region to which the tax rate applies.', 'wogo' ),
            'label' => __( 'Tax Region', 'wogo' ),
            'extra' => array(
                'data-wogo_validation' => true,
                'data-wogo_required' => true,
                'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
            ),
        );

        $shop_field['taxes[0][rate]'] = array(
            'type' => 'text',
            'desc' => __( 'The percentage of tax rate that applies to the item price.', 'wogo' ),
            'label' => __( 'Tax Rate', 'wogo' ),
            'extra' => array(
                'data-wogo_validation' => true,
                'data-wogo_required' => true,
                'data-wogo_required_error_msg'=> __( 'This field is required', 'wogo' ),
            ),
        );

        $shop_field['taxes[0][taxShip]'] = array(
            'label' => __( 'Tax Ship', 'wogo' ),
            'type' => 'checkbox',
            'required' => 'required',
            'desc' => 'Set to true if tax is charged on shipping.',
            'fields' => array(
                array(
                    'label' => __( 'Tax Ship', 'wogo' ),
                    'value' => 'on',
                ),
            ),
        );

        $shop_field['taxes[0][locationId]'] = array(
            'label' => __( 'Tax Location Id', 'wogo' ),
            'type' => 'text',
            'desc' => __( 'The numeric id of a location that the tax rate applies to as defined in the Adwords API (https://developers.google.com/adwords/api/docs/appendix/geotargeting).', 'wogo' ),
        );

        $shop_field['taxes[0][postalCode]'] = array(
            'label' => __( 'Tax Postal Code', 'wogo' ),
            'type' => 'text',
            'desc' => __( 'The postal code range that the tax rate applies to, represented by a ZIP code, a ZIP code prefix using * wildcard, a range between two ZIP codes or two ZIP code prefixes of equal length. Examples: 94114, 94*, 94002-95460, 94*-95*.', 'wogo' ),
            'wrap_close' => true,
        );
    }

    $shop_field[] = array(
        'wrap_close' => true,
        'type' => 'html',
        'html' => '<a href="#" class="button-primary wogo-product-field-addMore">' .__( 'Add More', 'wogo' ) . '</a>
            <a class="button-secondary wogo-product-field-remove" href="#">' . __( 'Cancle', 'wogo' ) . '</a>',
    );

    //close taxes

    $shop_field['availabilityDate'] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-part',
        ),
        'type' => 'text',
        'desc' => __( 'The day a pre-ordered product becomes available for delivery.', 'wogo' ),
        'label' => __( 'Availability Date', 'wogo' ),
        'wrap_close' => true,
        'value' => isset( $product['availabilityDate'] ) ? $product['availabilityDate'] : '',
    );

    $shop_field[] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-field wogo-html wogo-customattributes-wrap',
        ),
        'type' => 'html',
        'html' => '<h1 class="wogo-customattributes-head">A list of custom (merchant-provided) attributes.</h1>',
    );

    if ( isset( $product['customAttributes'] ) && count( $product['customAttributes'] ) ) {
        foreach ( $product['customAttributes'] as $key => $customAttributes ) {
            $shop_field['customAttributes['.$key.'][name]'] = array(
                'wrap_start' => true,
                'wrap_attr' => array(
                    'class' => 'wogo-form-field wogo-product-field-child-wrap',
                ),
                'type' => 'text',
                'desc' => __( 'The name of the attribute.', 'wogo' ),
                'label' => __( 'Custom Attributes Name', 'wogo' ),
                'value' => isset( $customAttributes['name'] ) ? $customAttributes['name'] : '',
            );

            $shop_field['customAttributes['.$key.'][type]'] = array(
                'type' => 'text',
                'desc' => __( 'Acceptable values are: "boolean" "datetimerange" "float" "group" "int" "price" "text" "time" "url"', 'wogo' ),
                'label' => __( 'Custom Attributes Type', 'wogo' ),
                'value' => isset( $customAttributes['type'] ) ? $customAttributes['type'] : '',
            );

            $shop_field['customAttributes['.$key.'][unit]'] = array(
                'type' => 'text',
                'desc' => __( 'Free-form unit of the attribute. Unit can only be used for values of type INT or FLOAT.', 'wogo' ),
                'label' => __( 'Custom Attributes Unit', 'wogo' ),
                'value' => isset( $customAttributes['unit'] ) ? $customAttributes['unit'] : '',
            );

            $shop_field['customAttributes['.$key.'][value]'] = array(
                'type' => 'text',
                'desc' => __( 'The value of the attribute.', 'wogo' ),
                'label' => __( 'Custom Attributes Value.', 'wogo' ),
                'wrap_close' => true,
                'value' => isset( $customAttributes['value'] ) ? $customAttributes['value'] : '',
            );
        }
    } else {
        $shop_field['customAttributes[0][name]'] = array(
            'wrap_start' => true,
            'wrap_attr' => array(
                'class' => 'wogo-form-field wogo-product-field-child-wrap',
            ),
            'type' => 'text',
            'desc' => __( 'The name of the attribute.', 'wogo' ),
            'label' => __( 'Custom Attributes Name', 'wogo' ),

        );

        $shop_field['customAttributes[0][type]'] = array(
            'type' => 'text',
            'desc' => __( 'Acceptable values are: "boolean" "datetimerange" "float" "group" "int" "price" "text" "time" "url"', 'wogo' ),
            'label' => __( 'Custom Attributes Type', 'wogo' ),

        );

        $shop_field['customAttributes[0][unit]'] = array(
            'type' => 'text',
            'desc' => __( 'Free-form unit of the attribute. Unit can only be used for values of type INT or FLOAT.', 'wogo' ),
            'label' => __( 'Custom Attributes Unit', 'wogo' ),

        );

        $shop_field['customAttributes[0][value]'] = array(
            'type' => 'text',
            'desc' => __( 'The value of the attribute.', 'wogo' ),
            'label' => __( 'Custom Attributes Value.', 'wogo' ),
            'wrap_close' => true,
        );
    }

    $shop_field[] = array(
        'wrap_close' => true,
        'type' => 'html',
        'html' => '<a href="#" class="button-primary wogo-product-field-addMore">' .__( 'Add More', 'wogo' ) . '</a>
            <a class="button-secondary wogo-product-field-remove" href="#">' . __( 'Cancle', 'wogo' ) . '</a>',
    );
    //close customAttributes

    $shop_field[] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-field wogo-html wogo-customattributes-wrap',
        ),
        'type' => 'html',
        'html' => '<h1 class="wogo-customattributes-head">A list of custom group (merchant-provided) attributes.</h1>',
    );

    if ( isset( $product['customGroups'] ) && count( $product['customGroups'] ) ) {
        foreach ( $product['customGroups'] as $key => $customGroups ) {
            $shop_field['customGroups['.$key.'][name]'] = array(
                'wrap_start' => true,
                'wrap_attr' => array(
                    'class' => 'wogo-form-field wogo-product-field-child-wrap',
                ),
                'type' => 'text',
                'desc' => __( 'The name of the group.', 'wogo' ),
                'label' => __( 'Custom Groups Name', 'wogo' ),
                'value' => isset( $customGroups['name'] ) ? $customGroups['name'] : '',
            );

            $shop_field['customGroups['.$key.'][attributes][name]'] = array(
                'type' => 'text',
                'desc' => __( 'The name of the attribute.', 'wogo' ),
                'label' => __( 'Custom Groups Attributes Name', 'wogo' ),
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
                            "url"', 'wogo'
                        ),
                'label' => __( 'Custom Groups Attributes Type', 'wogo' ),
                'value' => isset( $customGroups['attributes']['type'] ) ? $customGroups['attributes']['type'] : '',
            );

            $shop_field['customGroups['.$key.'][attributes][unit]'] = array(
                'type' => 'text',
                'desc' => __( 'Free-form unit of the attribute. Unit can only be used for values of type INT or FLOAT.', 'wogo' ),
                'label' => __( 'Custom Groups Attributes Unit', 'wogo' ),
                'value' => isset( $customGroups['attributes']['unit'] ) ? $customGroups['attributes']['unit'] : '',
            );

            $shop_field['customGroups['.$key.'][attributes][value]'] = array(
                'type' => 'text',
                'desc' => __( 'The value of the attribute.', 'wogo' ),
                'label' => __( 'Custom Groups Attributes Value', 'wogo' ),
                'wrap_close' => true,
                'value' => isset( $customGroups['attributes']['value'] ) ? $customGroups['attributes']['value'] : '',
            );
        }
    } else {
        $shop_field['customGroups[0][name]'] = array(
            'wrap_start' => true,
            'wrap_attr' => array(
                'class' => 'wogo-form-field wogo-product-field-child-wrap',
            ),
            'type' => 'text',
            'desc' => __( 'The name of the group.', 'wogo' ),
            'label' => __( 'Custom Groups Name', 'wogo' ),
        );

        $shop_field['customGroups[0][attributes][name]'] = array(
            'type' => 'text',
            'desc' => __( 'The name of the attribute.', 'wogo' ),
            'label' => __( 'Custom Groups Attributes Name', 'wogo' ),
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
                        "url"', 'wogo'
                    ),
            'label' => __( 'Custom Groups Attributes Type', 'wogo' ),
        );

        $shop_field['customGroups[0][attributes][unit]'] = array(
            'type' => 'text',
            'desc' => __( 'Free-form unit of the attribute. Unit can only be used for values of type INT or FLOAT.', 'wogo' ),
            'label' => __( 'Custom Groups Attributes Unit', 'wogo' ),
        );

        $shop_field['customGroups[0][attributes][value]'] = array(
            'type' => 'text',
            'desc' => __( 'The value of the attribute.', 'wogo' ),
            'label' => __( 'Custom Groups Attributes Value', 'wogo' ),
            'wrap_close' => true,
        );
    }

    $shop_field[] = array(
        'wrap_close' => true,
        'type' => 'html',
        'html' => '<a href="#" class="button-primary wogo-product-field-addMore">' .__( 'Add More', 'wogo' ) . '</a>
            <a class="button-secondary wogo-product-field-remove" href="#">' . __( 'Cancle', 'wogo' ) . '</a>',
    );

    //close customGroups

    $shop_field['customLabel0'] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-part',
        ),
        'type' => 'text',
        'desc' => __( 'Custom label 0 for custom grouping of items in a Shopping campaign.', 'wogo' ),
        'label' => __( 'CustomLabel0', 'wogo' ),
        'value' => isset( $product['customLabel0'] ) ? $product['customLabel0'] : '',
    );

    $shop_field['customLabel1'] = array(
        'type' => 'text',
        'desc' => __( 'Custom label 1 for custom grouping of items in a Shopping campaign.', 'wogo' ),
        'label' => __( 'CustomLabel1', 'wogo' ),
        'value' => isset( $product['customLabel1'] ) ? $product['customLabel1'] : '',
    );

    $shop_field['customLabel2'] = array(
        'type' => 'text',
        'desc' => __( 'Custom label 2 for custom grouping of items in a Shopping campaign.', 'wogo' ),
        'label' => __( 'CustomLabel2', 'wogo' ),
        'value' => isset( $product['customLabel2'] ) ? $product['customLabel2'] : '',
    );

    $shop_field['customLabel3'] = array(
        'type' => 'text',
        'desc' => __( 'Custom label 3 for custom grouping of items in a Shopping campaign.', 'wogo' ),
        'label' => __( 'CustomLabel3', 'wogo' ),
        'value' => isset( $product['customLabel3'] ) ? $product['customLabel3'] : '',
    );

    $shop_field['customLabel4'] = array(
        'type' => 'text',
        'desc' => __( 'Custom label 4 for custom grouping of items in a Shopping campaign.', 'wogo' ),
        'label' => __( 'CustomLabel4', 'wogo' ),
        'wrap_close' => true,
        'value' => isset( $product['customLabel4'] ) ? $product['customLabel4'] : '',
    );

    $shop_field[] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-field wogo-html wogo-customattributes-wrap',
        ),
        'type' => 'html',
        'html' => '<h1 class="wogo-customattributes-head">' .
        __( 'Specifies the intended destinations for the product.' , 'wogo' ) . '</h1>',
    );

    if ( isset( $product['destinations'] ) && count( $product['destinations'] ) ) {
        foreach ( $product['destinations'] as $key => $destinations ) {

            $shop_field['destinations['.$key.'][destinationName]'] = array(
                'wrap_start' => true,
                'wrap_attr' => array(
                    'class' => 'wogo-form-field wogo-html wogo-product-field-child-wrap',
                ),
                'type' => 'text',
                'desc' => __( 'The name of the destination.', 'wogo' ),
                'label' => __( 'Destinations Name', 'wogo' ),
                'value' => isset( $destinations['destinationName'] ) ? $destinations['destinationName'] : '',
            );

            $shop_field['destinations['.$key.'][intention]'] = array(
                'type' => 'text',
                'desc' => __( 'Acceptable values are:
                        "default"
                        "excluded"
                        "optional"
                        "required"
                    ', 'wogo' ),
                'label' => __( 'Destinations Intention', 'wogo' ),
                'wrap_close' => true,
                'value' => isset( $destinations['intention'] ) ? $destinations['intention'] : '',
            );
        }
    } else {

        $shop_field['destinations[0][destinationName]'] = array(
            'wrap_start' => true,
            'wrap_attr' => array(
                'class' => 'wogo-form-field wogo-html wogo-product-field-child-wrap',
            ),
            'type' => 'text',
            'desc' => __( 'The name of the destination.', 'wogo' ),
            'label' => __( 'Destinations Name', 'wogo' ),
        );

        $shop_field['destinations[0][intention]'] = array(
            'type' => 'text',
            'desc' => __( 'Acceptable values are:
                    "default"
                    "excluded"
                    "optional"
                    "required"
                ', 'wogo' ),
            'label' => __( 'Destinations Intention', 'wogo' ),
            'wrap_close' => true,
        );
    }

    $shop_field[] = array(
        'wrap_close' => true,
        'type' => 'html',
        'html' => '<a href="#" class="button-primary wogo-product-field-addMore">' .__( 'Add More', 'wogo' ) . '</a>
            <a class="button-secondary wogo-product-field-remove" href="#">' . __( 'Cancle', 'wogo' ) . '</a>',
    );

    $shop_field['energyEfficiencyClass'] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-part',
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
                ', 'wogo' ),
        'label' => __( 'Energy Efficiency Class', 'wogo' ),
        'value' => isset( $product['energyEfficiencyClass'] ) ? $product['energyEfficiencyClass'] : '',
    );

    $shop_field['expirationDate'] = array(
        'type' => 'text',
        'desc' => __( 'Date that an item will expire.', 'wogo' ),
        'label' => __( 'Expiration Date', 'wogo' ),
        'value' => isset( $product['expirationDate'] ) ? $product['expirationDate'] : '',
    );

    $shop_field['identifierExists'] = array(
        'label' => __( 'Identifier Exists', 'wogo' ),
        'type' => 'checkbox',
        'desc' => __( 'False when the item does not have unique product identifiers appropriate to its category, such as GTIN, MPN, and brand. Required according to the Unique Product Identifier Rules for all target countries except for Canada.', 'wogo' ),
        'fields' => array(
            array(
                'label' => __( 'Identifier Exists', 'wogo' ),
                'value' => 'on',
                'checked' => isset( $product['identifierExists'] ) ? $product['identifierExists'] : ''
            ),
        ),
    );

    $shop_field['installment[amount][currency]'] = array(
        'type' => 'text',
        'desc' => __( 'Brazil only.     The currency of the price.', 'wogo' ),
        'label' => __( 'Installment Amount Currency', 'wogo' ),
        'value' => isset( $product['installment']['amount']['currency'] ) ? $product['installment']['amount']['currency'] : '',
    );
    $shop_field['installment[amount][value]'] = array(
        'type' => 'text',
        'desc' => __( 'Brazil only. The amount the buyer has to pay per month.', 'wogo' ),
        'label' => __( 'Installment Amount Value', 'wogo' ),
        'value' => isset( $product['installment']['amount']['value'] ) ? $product['installment']['amount']['value'] : '',
    );

    $shop_field['installment[months]'] = array(
        'type' => 'text',
        'desc' => __( 'Brazil only. The currency of the price.', 'wogo' ),
        'label' => __( 'Installment Months', 'wogo' ),
        'value' => isset( $product['installment']['months'] ) ? $product['installment']['months'] : '',
    );

    $shop_field['isBundle'] = array(
        'label' => __( 'Is Bundle', 'wogo' ),
        'type' => 'checkbox',
        'desc' => __( 'Whether the item is a merchant-defined bundle. A bundle is a custom grouping of different products sold by a merchant for a single price.', 'wogo' ),
        'fields' => array(
            array(
                'label' => __( 'Is Bundle', 'wogo' ),
                'value' => 'on',
                'checked' => isset( $product['isBundle'] ) ? $product['isBundle'] : '',
            ),
        ),
    );

    $shop_field['kind'] = array(
        'type' => 'text',
        'value' => 'content#product',
        'label' => __( 'Kind', 'wogo' ),
        'desc' => __( '', 'wogo' ),
        'value' => isset( $product['kind'] ) ? $product['kind'] : '',
    );

    $shop_field['loyaltyPoints[name]'] = array(
        'type' => 'text',
        'desc' => __( 'Japan only. Name of loyalty points program. It is recommended to limit the name to 12 full-width characters or 24 Roman characters.', 'wogo' ),
        'label' => __( 'LoyaltyPoints Name', 'wogo' ),
        'value' => isset( $product['loyaltyPoints']['name'] ) ? $product['loyaltyPoints']['name'] : '',
    );

    $shop_field['loyaltyPoints[pointsValue]'] = array(
        'type' => 'text',
        'desc' => __( 'Japan only. The retailer\'s loyalty points in absolute value.', 'wogo' ),
        'label' => __( 'LoyaltyPoints Points Value', 'wogo' ),
        'value' => isset( $product['loyaltyPoints']['pointsValue'] ) ? $product['loyaltyPoints']['pointsValue'] : '',
    );

    $shop_field['loyaltyPoints[ratio]'] = array(
        'type' => 'text',
        'desc' => __( 'Japan only. The ratio of a point when converted to currency. Google assumes currency based on Merchant Center settings. If ratio is left out, it defaults to 1.0.', 'wogo' ),
        'label' => __( 'LoyaltyPoints Ratio', 'wogo' ),
        'value' => isset( $product['loyaltyPoints']['ratio'] ) ? $product['loyaltyPoints']['ratio'] : '',
    );

    $shop_field['merchantMultipackQuantity'] = array(
        'type' => 'text',
        'desc' => __( 'The number of identical products in a merchant-defined multipack.', 'wogo' ),
        'label' => __( 'Merchant Multipack Quantity', 'wogo' ),
        'value' => isset( $product['merchantMultipackQuantity'] ) ? $product['merchantMultipackQuantity'] : '',
    );

    $shop_field['mobileLink'] = array(
        'type' => 'text',
        'desc' => __( 'Link to a mobile-optimized version of the landing page.', 'wogo' ),
        'label' => __( 'Mobile Link', 'wogo' ),
        'value' => isset( $product['mobileLink'] ) ? $product['mobileLink'] : '',
    );

    $shop_field['onlineOnly'] = array(
        'label' => __( 'On Line Only', 'wogo' ),
        'type' => 'checkbox',
        'desc' => __( 'Whether an item is available for purchase only online.', 'wogo' ),
        'fields' => array(
            array(
                'label' => __( 'On Line Only', 'wogo' ),
                'value' => 'on',
                'checked' => isset( $product['onlineOnly'] ) ? $product['onlineOnly'] : '',
            ),
        ),
    );

    $shop_field['salePrice[currency]'] = array(
        'type' => 'text',
        'desc' => __( 'The currency of the price.', 'wogo' ),
        'label' => __( 'Sale Price Currency', 'wogo' ),
        'value' => isset( $product['salePrice']['currency'] ) ? $product['salePrice']['currency'] : '',
    );

    $shop_field['salePrice[value]'] = array(
        'type' => 'text',
        'desc' => __( 'The price represented as a number.', 'wogo' ),
        'label' => __( 'Sale Price Value', 'wogo' ),
        'value' => isset( $product['salePrice']['value'] ) ? $product['salePrice']['value'] : '',
    );

    $shop_field['salePriceEffectiveDate'] = array(
        'type' => 'text',
        'desc' => __( 'Date range during which the item is on sale.', 'wogo' ),
        'label' => __( 'Sale Price Effective Date', 'wogo' ),
        'value' => isset( $product['salePriceEffectiveDate'] ) ? $product['salePriceEffectiveDate'] : '',
    );

    $shop_field['shippingLabel'] = array(
        'type' => 'text',
        'desc' => __( 'The shipping label of the product, used to group product in account-level shipping rules.', 'wogo' ),
        'label' => __( 'Shipping Label', 'wogo' ),
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
            ', 'wogo' ),
        'label' => __( 'Size System', 'wogo' ),
        'value' => isset( $product['sizeSystem'] ) ? $product['sizeSystem'] : '',
    );

    $shop_field['sizeType'] = array(
        'type' => 'text',
        'desc' => __( 'Acceptable values are:

                "maternity"
                "oversize"
                "petite"
                "regular"
            ', 'wogo' ),
        'label' => __( 'Size Type', 'wogo' ),
        'value' => isset( $product['sizeType'] ) ? $product['sizeType'] : '',
    );

    $shop_field['unitPricingBaseMeasure'] = array(
        'type' => 'text',
        'desc' => __( 'The preference of the denominator of the unit price.', 'wogo' ),
        'label' => __( 'Unit Pricing Base Measure', 'wogo' ),
        'value' => isset( $product['unitPricingBaseMeasure'] ) ? $product['unitPricingBaseMeasure'] : '',
    );

    $shop_field['unitPricingMeasure'] = array(
        'type' => 'text',
        'desc' => __( 'The measure and dimension of an item.', 'wogo' ),
        'label' => __( 'Unit Pricing Measure', 'wogo' ),
        'value' => isset( $product['unitPricingMeasure'] ) ? $product['unitPricingMeasure'] : '',
    );

    /*$shop_field['validatedDestinations[]'] = array(
        'type' => 'text',
        'desc' => __( '', 'wogo' ),
        'label' => __( 'Validated Destinations', 'wogo' ),
    );*/

    /*$shop_field[] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-field wogo-html wogo-customattributes-wrap',
        ),
        'type' => 'html',
        'html' => '<h1 class="wogo-customattributes-head">' .
        __( 'Warning.' , 'wogo' ) . '</h1>',
    );

    $shop_field['warnings[domain][]'] = array(
        'wrap_start' => true,
        'wrap_attr' => array(
            'class' => 'wogo-form-field wogo-html wogo-product-field-child-wrap',
        ),
        'type' => 'text',
        'desc' => __( '', 'wogo' ),
        'label' => __( 'Warnings Destinations', 'wogo' ),
    );

    $shop_field['warnings[message][]'] = array(
        'type' => 'text',
        'desc' => __( '', 'wogo' ),
        'label' => __( 'Warnings Message', 'wogo' ),
    );

    $shop_field['warnings[reason][]'] = array(
        'type' => 'text',
        'desc' => __( '', 'wogo' ),
        'label' => __( 'Warnings Reason', 'wogo' ),
        'wrap_close' => true,
    );

    $shop_field[] = array(
        'wrap_close' => true,
        'type' => 'html',
        'html' => '<a href="#" class="wogo-product-field-addMore">' .__( 'Add More', 'wogo' ) . '</a>
            <a class="wogo-product-field-remove" href="#">' . __( 'Cancle', 'wogo' ) . '</a>',
    );*/




    $shop_field['id'] = array(
        'type' => 'text',
        'desc' => __( '', 'wogo' ),
        'label' => __( 'ID', 'wogo' ),
        'value' => isset( $product['id'] ) ? $product['id'] : '',
    );

    $shop_field['googleProductCategory'] = array(
        'type' => 'text',
        'desc' => __( 'Google\'s category of the item.', 'wogo' ),
        'label' => __( 'Google Product Category', 'wogo' ),
        'value' => isset( $product['googleProductCategory'] ) ? $product['googleProductCategory'] : '',
    );

    if ( isset( $product['additionalImageLinks'] ) && count( $product['additionalImageLinks'] ) ) {
        foreach ( $product['additionalImageLinks'] as $key => $additionalImageLinks ) {
            $remove =  ( $key > 0 ) ? true : false;
            $shop_field['additionalImageLinks['.$key.']'] = array(
                'type' => 'text',
                'desc' => '(list)    Additional URLs of images of the item.',
                'label' => __( 'Additional image link', 'wogo' ),
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
            'label' => __( 'Additional image link', 'wogo' ),
            'extra' => array(
                'data-add_more' => true,
                'data-field_name' => 'additionalImageLinks[]'
            )
        );
    }

    $shop_field['imageLink'] = array(
        'type' => 'text',
        'desc' => __( 'URL of an image of the item.', 'wogo' ),
        'label' => __( 'Image Link', 'wogo' ),
        'value' => isset( $product['imageLink'] ) ? $product['imageLink'] : '',
    );

    $shop_field['adult'] = array(
        'label' => __( 'Adult', 'wogo' ),
        'type' => 'checkbox',
        'desc' => __( 'Set to true if the item is targeted towards adults.', 'wogo' ),
        'fields' => array(
            array(
                'label' => __( 'Enable Adult Content', 'wogo' ),
                'value' => 'on',
                'checked' => isset( $product['adult'] ) ? $product['adult'] : '',
            ),
        ),
    );

    $shop_field['adwordsGrouping'] = array(
        'type' => 'text',
        'desc' => ' Used to group items in an arbitrary way. Only for CPA%, discouraged otherwise.',
        'label' => __( 'Adwords Grouping', 'wogo' ),
        'value' => isset( $product['adwordsGrouping'] ) ? $product['adwordsGrouping'] : '',
    );

    if ( isset( $product['adwordsLabels'] ) && count( $product['adwordsLabels'] ) ) {
        foreach ( $product['adwordsLabels'] as $key => $adwordsLabels ) {
            $remove = ( $key > 0 ) ? true : false;
            $shop_field['adwordsLabels['.$key.']'] = array(
                'type' => 'text',
                'desc' => '(list)    Similar to adwords_grouping, but only works on CPC.',
                'label' => __( 'Adwords Label', 'wogo' ),
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
            'label' => __( 'Adwords Label', 'wogo' ),
            'extra' => array(
                'data-add_more' => true,
                'data-field_name' => 'adwordsLabels[]'
            )
        );
    }

    /*$shop_field['adwords_qu_param'] = array(
        'type' => 'text',
        'label' => __( 'Adwords query param', 'wogo' ),
    );*/

    $shop_field['adwordsRedirect'] = array(
        'type' => 'text',
        'desc' => 'Allows advertisers to override the item URL when the product is shown within the context of Product Ads.     Target age group of the item.',
        'label' => __( 'Adwords Redirect', 'wogo' ),
        'value' => isset( $product['adwordsRedirect'] ) ? $product['adwordsRedirect'] : '',
    );

    $shop_field['ageGroup'] = array(
        'type' => 'text',
        'label' => __( 'Age group', 'wogo' ),
        'desc' => __( 'Acceptable values are: "adult" "infant" "kids" "newborn" "toddler"', 'wogo' ),
        'value' => isset( $product['ageGroup'] ) ? $product['ageGroup'] : '',
    );

    $shop_field['color'] = array(
        'type' => 'text',
        'desc' => __( '  Color of the item.', 'wogo' ),
        'label' => __( 'Color', 'wogo' ),
        'value' => isset( $product['color'] ) ? $product['color'] : '',
    );

    $shop_field['expirationDate'] = array(
        'type' => 'text',
        'desc' => __( '', 'wogo' ),
        'label' => __( 'Expiration date', 'wogo' ),
        'value' => isset( $product['expirationDate'] ) ? $product['expirationDate'] : '',
    );

    $shop_field['gender'] = array(
        'type' => 'text',
        'desc' => __( 'Acceptable values are:
                "female"
                "male"
                "unisex"
            ', 'wogo' ),
        'label' => __( 'Age group', 'wogo' ),
        'value' => isset( $product['gender'] ) ? $product['gender'] : '',
    );

    $shop_field['gtin'] = array(
        'type' => 'text',
        'desc' => __( 'Global Trade Item Number (GTIN) of the item.', 'wogo' ),
        'label' => __( 'Gtin', 'wogo' ),
        'value' => isset( $product['gtin'] ) ? $product['gtin'] : '',
    );

    $shop_field['itemGroupId'] = array(
        'type' => 'text',
        'desc' => __( 'Shared identifier for all variants of the same product.', 'wogo' ),
        'label' => __( 'Item Group ID', 'wogo' ),
        'value' => isset( $product['itemGroupId'] ) ? $product['itemGroupId'] : '',
    );

    $shop_field['material'] = array(
        'type' => 'text',
        'desc' => __( 'The material of which the item is made.', 'wogo' ),
        'label' => __( 'Material', 'wogo' ),
        'value' => isset( $product['material'] ) ? $product['material'] : '',
    );

    $shop_field['pattern'] = array(
        'type' => 'text',
        'desc' => __( 'The item\'s pattern (e.g. polka dots).', 'wogo' ),
        'label' => __( 'Pattern', 'wogo' ),
        'value' => isset( $product['pattern'] ) ? $product['pattern'] : '',
    );

    $shop_field['productType'] = array(
        'type' => 'text',
        'desc' => __( 'Your category of the item.', 'wogo' ),
        'label' => __( 'Product Type', 'wogo' ),
        'value' => isset( $product['productType'] ) ? $product['productType'] : '',
    );

    $shop_field['shippingWeight[unit]'] = array(
        'type' => 'text',
        'desc' => __( 'The unit of value.', 'wogo' ),
        'label' => __( 'Shipping Weight Unit', 'wogo' ),
        'value' => isset( $product['shippingWeight']['unit'] ) ? $product['shippingWeight']['unit'] : '',
    );

    $shop_field['shippingWeight[value]'] = array(
        'type' => 'text',
        'desc' => __( 'The weight of the product used to calculate the shipping cost of the item. System in which the size is specified. Recommended for apparel items. ', 'wogo' ),
        'label' => __( 'Shipping Weight value', 'wogo' ),
        'value' => isset( $product['shippingWeight']['value'] ) ? $product['shippingWeight']['value'] : '',
    );
    if ( isset( $product['sizes'] ) && count( $product['sizes'] ) ) {
        foreach ( $product['sizes'] as $key => $sizes ) {
            $remove = ( $key > 0 ) ? true : false;
            $shop_field['sizes['.$key.']'] = array(
                'type' => 'text',
                'desc' => __( 'Size of the item.', 'wogo' ),
                'label' => __( 'Sizes', 'wogo' ),
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
            'desc' => __( 'Size of the item.', 'wogo' ),
            'label' => __( 'Sizes', 'wogo' ),
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
        'desc' => __( '', 'wogo' ),
        'label' => __( 'Year', 'wogo' ),
    );*/
    echo '<div class="wogo-form-wrap">';
    echo '<form method="post" class="wogo-form wogo-form-product" action="">';
    ?>
    <h1 class="wogo-product-info"><?php _e( 'Product Information', 'wogo' ); ?></h1>

    <?php

    foreach( $shop_field as $name => $field_obj ) {

        if( ! isset( $field_obj['type'] ) || empty( $field_obj['type'] ) ) {
            continue;
        }

        switch ( $field_obj['type'] ) {
            case 'text':
                echo WOGO_Admin_Settings::getInstance()->text_field( $name, $field_obj );
                break;
            case 'select':
                echo WOGO_Admin_Settings::getInstance()->select_field( $name, $field_obj );
                break;
            case 'textarea':
                echo WOGO_Admin_Settings::getInstance()->textarea_field( $name, $field_obj );
                break;
            case 'radio':
                echo WOGO_Admin_Settings::getInstance()->radio_field( $name, $field_obj );
                break;
            case 'checkbox':
                echo WOGO_Admin_Settings::getInstance()->checkbox_field( $name, $field_obj );
                break;
            case 'hidden':
                echo WOGO_Admin_Settings::getInstance()->hidden_field( $name, $field_obj );
                break;
            case 'multiple':
                echo WOGO_Admin_Settings::getInstance()->multiple_select_field( $name, $field_obj );
                break;
            case 'html':
                echo WOGO_Admin_Settings::getInstance()->html_field( $name, $field_obj );
                break;
        }
    }
    ?>
    <div class="wogo-clear"></div>
    <input type="submit" class="button button-primary" value="<?php _e( 'Send', 'wogo'); ?>" name="wogo_submit">
    <div class="wogo-spinner-wrap"></div>
    <?php
    echo '</form>';
    echo '</div>';
?>
</div>

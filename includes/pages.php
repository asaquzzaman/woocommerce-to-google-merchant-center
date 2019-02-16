<?php
function woogool_pages() {
    $path                      = dirname(__FILE__) . '/../views';
    $pages                     = array();
    $woogool_page              = woogool_page_slug();
    $pages['woogool'] = woogool_sigle_product_items( $path );
    $pages['woogool_multiple'] = woogool_multi_product_items( $path );

    return apply_filters( 'woogool_pages', $pages, $path );
}

// function woogool_license( $path ) {
//     $license = array();

//     $license = array(
//         'id'        => 'woogool-license',
//         'title'     => __( 'License', 'woogool' ),
//         'file_slug' => 'license/license',
//         'file_path' => $path . '/license/license.php',
//     );

//     return $license;
// }

// function woogool_tutorial( $path ) {
//     $tutorial = array();

//     $tutorial = array(
//         'id'        => 'woogool-multi-product',
//         'title'     => __( 'Tutorial', 'woogool' ),
//         'file_slug' => 'tutorial/tutorial',
//         'file_path' => $path . '/tutorial/tutorial.php',

//         'submenu' => array(
//             'single' => array(
//                 'id'        => 'woogool-single-tutorial',
//                 'title'     => __( 'Single Product', 'woogool' ),
//                 'file_slug' => 'tutorial/single',
//                 'file_path' => $path . '/tutorial/single.php',
//             ),

//             'multiple' => array(
//                 'id'        => 'woogool-multi-product-tutorial',
//                 'title'     => __( 'Multiple Product', 'hrm' ),
//                 'file_slug' => 'tutorial/multiple',
//                 'file_path' => $path . '/tutorial/multiple.php',
//             )
//         ),
//     );

//     return $tutorial;
// }

function woogool_multi_product_items( $path ) {
	$multi = array();

    $multi = array(
        
        'new_feed' => array(
            'id'        => 'woogool-new-feed',
            'title'     => __( 'New Feed', 'woogool' ),
            'file_slug' => 'multiple/new-feed',
            'file_path' => $path . '/multiple/new-feed.php',
        ),

        'feed-lists' => array(
            'id'        => 'woogool-feed-lists',
            'title'     => __( 'Feed Lists', 'hrm' ),
            'file_slug' => 'multiple/feed-lists',
            'file_path' => $path . '/multiple/feed-lists.php',
        )
        
    );

    return $multi;
}

function woogool_sigle_product_items( $path ) {
	$single = array();
    $is_new = woogool_is_wc_new();

    $single['merchant_product'] = array(
        'id'        => 'woogool-merchant-product',
        'title'     => __( 'Merchant Products', 'woogool' ),
        'file_slug' => 'singe/merchant-product',
        'file_path' => $path . '/single/merchant-product.php',

        // 'submenu' => array(
        //     'merchant_product' => array(
        //         'id'        => 'woogool-merchant-product',
        //         'title'     => __( 'Merchant Products', 'woogool' ),
        //         'file_slug' => 'singe/merchant-product',
        //         'file_path' => $path . '/single/merchant-product.php',
        //     ),

        //     'new_product' => array(
        //         'id'        => 'woogool-new-product',
        //         'title'     => __( 'New Product', 'hrm' ),
        //         'file_slug' => 'single/new-product',
        //         'file_path' => $is_new ? $path . '/single/new-product.php' : $path . '/single/old-wc-new-product.php',
        //     ),
        //     'settings' => array(
        //         'id'        => 'woogool-settings',
        //         'title'     => __( 'Settings', 'hrm' ),
        //         'file_slug' => 'single/settings',
        //         'file_path' => $path . '/single/settings.php',
        //     ),
        // ),
    );

    $single['new_product'] = array(
        'id'        => 'woogool-new-product',
        'title'     => __( 'New Product', 'hrm' ),
        'file_slug' => 'single/new-product',
        'file_path' => $is_new ? $path . '/single/new-product.php' : $path . '/single/old-wc-new-product.php',
    );

    $single['settings'] = array(
        'id'        => 'woogool-settings',
        'title'     => __( 'Settings', 'hrm' ),
        'file_slug' => 'single/settings',
        'file_path' => $path . '/single/settings.php',
    );

     $single['tutorial'] = array(
        'id'        => 'woogool-tutorial',
        'title'     => __( 'Tutorial', 'hrm' ),
        'file_slug' => 'single/tutorial',
        'file_path' => $path . '/single/tutorial.php',
    );

    return $single;
}

function woogool_page_slug() {
    return apply_filters( 'woogool_slug', 'woogool' );
}

?>
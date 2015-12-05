<div class="wrap wogo" id="wogo">
    <?php
    $url_product     = admin_url( 'edit.php?post_type=product&page=product_wogo' );
    $url_new_product = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_new_product' );
    $url_setting     = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_settings' );
    $url_updates     = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_update' );
    $url_new_feed    = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_new_feed' );
    $url_feed        = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_xml_feed' );
    $url_feed_list   = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_xml_feed_list' );

    if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_settings' ) {
        $settings = 'nav-tab-active';
    } else if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_new_product' ) {
        $new_product = 'nav-tab-active';
    } else if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_update' ) {
        $updates = 'nav-tab-active';
    } else if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_xml_feed' ) {
        $feed = 'nav-tab-active';
    } else if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_xml_feed_list' ) {
        $feed_list = 'nav-tab-active';
    } else if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_new_feed' ) {
        $new_feed = 'nav-tab-active';
    } else {
        $product = 'nav-tab-active';
    }
    ?>
    <h2 class="nav-tab-wrapper wogo-nav-tab-wrap">
        <a href="<?php echo $url_product; ?>" class="nav-tab <?php echo isset( $product ) ? $product : '' ; ?>"><?php _e( 'Merchant Products', 'wogo' ); ?></a>
        <a href="<?php echo $url_new_product; ?>" class="nav-tab <?php echo isset( $new_product ) ? $new_product : '' ; ?>"><?php _e( 'Single Product', 'wogo' ); ?></a>
        <a href="<?php echo $url_setting; ?>" class="nav-tab <?php echo isset( $settings ) ? $settings : ''; ?>"><?php _e( 'Settings', 'wogo' ); ?></a>
        <a href="<?php echo $url_feed; ?>" class="nav-tab <?php echo isset( $feed ) ? $feed : '' ; ?>"><?php _e( 'Products Feed', 'wogo' ); ?></a>
        <a href="<?php echo $url_feed_list; ?>" class="nav-tab <?php echo isset( $feed_list ) ? $feed_list : '' ; ?>"><?php _e( 'Products Feed List', 'wogo' ); ?></a>
    </h2>
    <?php
    if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) {

        if ( isset( $_GET['page'] ) && $_GET['page'] == 'product_wogo' && isset( $_GET['tab']) && $_GET['tab'] == 'wogo_settings' ) {

            include_once dirname(__FILE__) . '/settings.php';
        } else if( isset( $_GET['page'] ) && $_GET['page'] == 'product_wogo' && isset( $_GET['tab']) && $_GET['tab'] == 'wogo_new_product'  ) {

            include_once dirname(__FILE__) . '/new-product.php';
        } else if( isset( $_GET['page'] ) && $_GET['page'] == 'product_wogo' && isset( $_GET['tab']) && $_GET['tab'] == 'wogo_new_feed'  ) {

            include_once dirname(__FILE__) . '/new-feed.php';
        } else if( isset( $_GET['page'] ) && $_GET['page'] == 'product_wogo' && isset( $_GET['tab']) && $_GET['tab'] == 'wogo_xml_feed'  ) {

            include_once dirname(__FILE__) . '/feed.php';
        } else if( isset( $_GET['page'] ) && $_GET['page'] == 'product_wogo' && isset( $_GET['tab']) && $_GET['tab'] == 'wogo_xml_feed_list'  ) {

            include_once dirname(__FILE__) . '/feed-list.php';
        } else {

            include_once dirname(__FILE__) . '/products.php';
        }
    }

    ?>
</div>
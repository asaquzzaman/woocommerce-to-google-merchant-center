<div class="wrap">
    <?php
    $url_product = admin_url( 'edit.php?post_type=product&page=product_wogo' );
    $url_new_product = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_new_product' );
    $url_setting = admin_url( 'edit.php?post_type=product&page=product_wogo&tab=wogo_settings' );
    if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_settings' ) {
        $settings = 'nav-tab-active';
    } else if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_new_product' ) {
        $new_product = 'nav-tab-active';
    } else {
        $product = 'nav-tab-active';
    }
    ?>
    <h2 class="nav-tab-wrapper wogo-nav-tab-wrap">
        <a href="<?php echo $url_product; ?>" class="nav-tab <?php echo isset( $product ) ? $product : '' ; ?>"><?php _e( 'Merchant Products', 'wogo' ); ?></a>
        <a href="<?php echo $url_new_product; ?>" class="nav-tab <?php echo isset( $new_product ) ? $new_product : '' ; ?>"><?php _e( 'New Product', 'wogo' ); ?></a>
        <a href="<?php echo $url_setting; ?>" class="nav-tab <?php echo isset( $settings ) ? $settings : ''; ?>"><?php _e( 'Settings', 'wogo' ); ?></a>

    </h2>
    <?php
    if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) {

        if ( isset( $_GET['page'] ) && $_GET['page'] == 'product_wogo' && isset( $_GET['tab']) && $_GET['tab'] == 'wogo_settings' ) {
            require_once dirname(__FILE__) . '/settings.php';
        } else if( isset( $_GET['page'] ) && $_GET['page'] == 'product_wogo' && isset( $_GET['tab']) && $_GET['tab'] == 'wogo_new_product'  ) {
        	if ( $is_access_premission ) {
            	require_once dirname(__FILE__) . '/new-product.php';
        	}
        } else {
            if ( $is_access_premission ) {
                require_once dirname(__FILE__) . '/products.php';
            }
        }
    }

    ?>
</div>
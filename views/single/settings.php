
<?php
$user_id = get_current_user_id();
$settings = array();
$settings['client_id'] =  array(
    'label'    => __( 'Client ID', 'hrm' ),
    'type'     => 'text',
    'value'    => get_user_meta( $user_id, 'wogo_client_id', true ),
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    )
);

$settings['client_secret'] = array(
    'type'  => 'text',
    'label' => __( 'Client Secret', 'woogool' ),
    'value' => get_user_meta( $user_id, 'wogo_client_secret', true ),
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
);
$settings['merchant_account_id'] = array(
    'type'  => 'text',
    'label' => __( 'Merchant Account ID', 'woogool' ),
    'value' => get_user_meta( $user_id, 'merchant_account_id', true ),
    'extra' => array(
        'data-woogool_validation'         => true,
        'data-woogool_required'           => true,
        'data-woogool_required_error_msg' => __( 'This field is required', 'woogool' ),
    ),
);



?>
 <div class="woogool-notice woogool-warning">
    <?php _e( 'Settings field are need for single product submission not for multiple product feed', 'woogool' ); ?>
</div>
<div class="metabox-holder">
    <div class="postbox">
        <h2 class="hndle">Settings</h2>
        <div class="inside">
            <form action="" method="post" class="woogool-form">
            	<?php echo WooGool_Admin_Settings::getInstance()->text_field( 'client_id', $settings['client_id'] ); ?>
            	<?php echo WooGool_Admin_Settings::getInstance()->text_field( 'client_secret', $settings['client_secret'] ); ?>
                <?php echo WooGool_Admin_Settings::getInstance()->text_field( 'merchant_account_id', $settings['merchant_account_id'] ); ?>
            	<p>
                    <label>
                        <strong><?php _e( 'Authorized Rredirect uri', 'woogool' ); ?></strong>
                    </label>
                    <?php echo admin_url( 'admin.php?page=woogool&tab=new_product' ); ?>&nbsp;<br>
                    <span class="description"><?php _e( 'This url you will be needed when you creating a new client ID for google api authenticate.', 'woogool' ); ?></span>
                </p>
                <input type="submit" class="button button-primary" value="<?php _e( 'Save Settings', 'woogool'); ?>" name="woogool_settings">
            </form>
        </div>
    </div>
</div>

<style type="text/css">
    .woogool-form .woogool-form-field label {
        font-size: 14px;
        font-weight: normal;
    }
</style>


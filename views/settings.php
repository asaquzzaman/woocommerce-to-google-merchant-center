
<?php
$user_id = get_current_user_id();
$settings = array();
$settings['client_id'] =  array(
    'label'    => __( 'Client ID', 'hrm' ),
    'type'     => 'text',
    'value'    => get_user_meta( $user_id, 'wogo_client_id', true ),
    'extra' => array(
        'data-wogo_validation'         => true,
        'data-wogo_required'           => true,
        'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
    )
);

$settings['client_secret'] = array(
    'type'  => 'text',
    'label' => __( 'Client Secret', 'wogo' ),
    'value' => get_user_meta( $user_id, 'wogo_client_secret', true ),
    'extra' => array(
        'data-wogo_validation'         => true,
        'data-wogo_required'           => true,
        'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
    ),
);
$settings['merchant_account_id'] = array(
    'type'  => 'text',
    'label' => __( 'Merchant Account ID', 'wogo' ),
    'value' => get_user_meta( $user_id, 'merchant_account_id', true ),
    'extra' => array(
        'data-wogo_validation'         => true,
        'data-wogo_required'           => true,
        'data-wogo_required_error_msg' => __( 'This field is required', 'wogo' ),
    ),
);



?>
<form action="" method="post" class="wogo-form">
	<?php echo WOGO_Admin_Settings::getInstance()->text_field( 'client_id', $settings['client_id'] ); ?>
	<?php echo WOGO_Admin_Settings::getInstance()->text_field( 'client_secret', $settings['client_secret'] ); ?>
    <?php echo WOGO_Admin_Settings::getInstance()->text_field( 'merchant_account_id', $settings['merchant_account_id'] ); ?>
	<p>
        <label>
            <strong><?php _e( 'Authorized Rredirect uri', 'wogo' ); ?></strong>
        </label>
        <?php echo admin_url( 'edit.php?post_type=product&page=product_wogo' ); ?>&nbsp;<br>
        <span class="description"><?php _e( 'This url you will be needed when you creating a new client ID for google api authenticate.', 'wogo' ); ?></span>
    </p>
    <input type="submit" class="button button-primary" value="<?php _e( 'Save Settings', 'wogo'); ?>" name="wogo_settings">
</form>
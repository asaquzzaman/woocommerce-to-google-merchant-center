<?php

$header_path = dirname(__FILE__) . '/header.php';

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}


$errors = array();
if ( isset( $_POST['hrm_front_end'] ) ) {
    if ( empty( $_POST['email'] ) ) {
        $errors[] = __( 'Empty email address', 'hrm' );
    }

    if ( empty( $_POST['license_key'] ) ) {
        $errors[] = __( 'Empty license key', 'hrm' );
    }

    if ( !$errors ) {
        update_option( 'woogoo_license', array('email' => $_POST['email'], 'key' => $_POST['license_key']) );
        delete_transient( 'woogoo_license' );

        $license_status = get_option( 'woogoo_license' );

        if ( !isset( $license_status->request_status ) || $license_status->request_status != true ) {
            $response = WooGool_Admin_Update::getInstance()->activation( 'woogoo_activation' );
            if ( $response && isset( $response->request_status ) && $response->request_status ) {
                update_option( 'woogoo_license', $response );
            }
        }
        echo '<div class="updated"><p>' . __( 'Settings Saved', 'hrm' ) . '</p></div>';
    }
}

if ( isset( $_POST['delete_license'] ) ) {
    delete_option( 'woogoo_license' );
    delete_transient( 'woogoo_license' );
    delete_option( 'woogoo_license' );
}

$license = WooGool_Admin_Update::getInstance()->get_license_key();

$email = isset( $license->email ) && $license->email ? $license->email : '';
$key = isset( $license->key ) && $license->key ? $license->key : '';

?>
<div class="wrap">
    <?php screen_icon( 'plugins' ); ?>
    <h2><?php _e( 'Plugin Activation', 'hrm' ); ?></h2>

    <p class="description">
        Enter the E-mail address that was used for purchasing the plugin and the license key.
        We recommend you to enter those details to get regular <strong>plugin update and support</strong>.
    </p>

    <?php
    if ( $errors ) {
        foreach ($errors as $error) {
            ?>
            <div class="error"><p><?php echo $error; ?></p></div>
            <?php
        }
    }

    $license_status = get_option( 'woogoo_license' );
    if ( !isset( $license_status->request_status ) || $license_status->request_status != true ) {
        ?>

        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th><?php _e( 'E-mail Address', 'hrm' ); ?></th>
                    <td>
                        <input type="email" name="email" class="regular-text" value="<?php echo esc_attr( $email ); ?>" required>
                        <span class="description"><?php _e( 'Enter your purchase Email address', 'hrm' ); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'License Key', 'hrm' ); ?></th>
                    <td>
                        <input type="text" name="license_key" class="regular-text" value="<?php echo esc_attr( $key ); ?>">
                        <span class="description"><?php _e( 'Enter your license key', 'hrm' ); ?></span>
                    </td>
                </tr>
            </table>

            <?php submit_button( 'Save & Activate', 'hrm_front_end', 'hrm_front_end' ); ?>
        </form>
    <?php } else { ?>

        <div class="updated">
            <p><?php _e( 'Plugin is activated', 'hrm' ); ?></p>
        </div>

        <form method="post" action="">
            <?php submit_button( __( 'Delete License', 'hrm' ), 'delete', 'delete_license' ); ?>
        </form>

    <?php } ?>
</div>
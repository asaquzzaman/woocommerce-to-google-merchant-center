<?php

/**
 * Installer Class
 *
 * @package 
 */
class WooGool_Admin_Upgrade {

 
    /** @var array DB updates that need to be run */
    private static $updates = array(
        '1.0' => 'updates/update-1.0.php',
    );

    /**
     * Binding all events
     *
     * @since 0.1
     *
     * @return void
     */
    function __construct() {
        add_action( 'admin_notices', array( $this, 'show_update_notice' ) );
        add_action( 'admin_init', array( $this, 'do_updates' ) );
    }

    /**
     * Check if need any update
     *
     * @since 1.0
     *
     * @return boolean
     */
    public function is_needs_update() {
        return false;
        $installed_version = get_option( 'woogool_version' );

        // may be it's the first install
        if ( ! $installed_version ) {
            return false;
        }

        if ( version_compare( $installed_version, WOOGOOL_VERSION, '<' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Show update notice
     *
     * @since 1.0
     *
     * @return void
     */
    public function show_update_notice() {
        if ( ! $this->is_needs_update() ) {
            return;
        }
        ?>
        <div id="message" class="updated">
            <p><?php _e( '<strong>WooGool Data Update Required</strong> &#8211; We need to update your install to the latest version', 'woogool' ); ?></p>
            <p class="submit"><a href="<?php echo add_query_arg( array( 'wp_woogool_do_update' => true ), $_SERVER['REQUEST_URI'] ); ?>" class="wp-update-btn button-primary"><?php _e( 'Run the updater', 'woogool' ); ?></a></p>
        </div>

        <script type="text/javascript">
            jQuery('.wp-update-btn').click('click', function(){
                return confirm( '<?php _e( 'It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', 'woogool' ); ?>' );
            });
        </script>
        <?php
    }

    /**
     * Do all updates when Run updater btn click
     *
     * @since 1.0
     *
     * @return void
     */
    public function do_updates() {
        if ( isset( $_GET['wp_woogool_do_update'] ) && $_GET['wp_woogool_do_update'] ) {
            $this->perform_updates();
        }
    }

    /**
     * Perform all updates
     *
     * @since 1.0
     *
     * @return void
     */
    public function perform_updates() {
        if ( ! $this->is_needs_update() ) {
            return;
        }

        $installed_version = get_option( 'woogool_version' );

        foreach ( self::$updates as $version => $path ) {
            if ( version_compare( $installed_version, $version, '<' ) ) {
            	$path = dirname( __FILE__ ) .'/'. $path; 
            	
            	if ( file_exists( $path ) ) {
            		include $path;
                	update_option( 'woogool_version', $version );	
            	}
            }
        }

        // update to latest version
        //update_option( 'woogool_version', WOOGOOL_VERSION );
        //update_option( 'woogool_db_version', WOOGOOL_VERSION );

        $location = remove_query_arg( array( 'wp_woogool_do_update' ), $_SERVER['REQUEST_URI'] );
        wp_redirect( $location );
        exit();
    }


}
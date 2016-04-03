<?php
$header_path = dirname(__FILE__) . '/header.php';

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}

?>
<!-- default $this for class hrm_Admin, $tab; -->
<div class="" id="">
    <?php WooGool_Admin_Settings::getInstance()->show_sub_tab_page( $page, $tab, $subtab ); ?>
</div>
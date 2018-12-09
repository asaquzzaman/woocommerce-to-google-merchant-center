<?php
$query_args = woogool_get_query_args();

$page       = $query_args['page'];
$tab        = $query_args['tab'];
$subtab     = $query_args['sub_tab'];

$header_path = dirname(__FILE__) . '/header.php';

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}

?>
<!-- default $this for class hrm_Admin, $tab; -->
<div class="woogool-tab wrap" id="woogool-tab-wrap">
    <?php WooGool_Admin_Settings::getInstance()->show_tab_page( $page, $tab, $subtab ); ?>
</div>
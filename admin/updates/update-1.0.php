<?php
$feeds =  woogool_get_feeds();

foreach ( $feeds as $key => $feed_obj ) {
	WooGool_Admin_Feed::instance()->update_xml_meta_content( $feed_obj->ID, $feed_obj->post_content );			
}
	
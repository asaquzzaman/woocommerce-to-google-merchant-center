<?php
$menu = woogool_pages();
?>
<h2 class="nav-tab-wrapper">
    <?php

    foreach ( $menu as $tab_key => $tab_event ) {
        $active = ( $tab == $tab_key ) ? 'nav-tab-active' : '';
        $url = woogool_tab_menu_url( $tab_key );
        printf( '<a href="%1$s" class="nav-tab %4$s" id="%2$s-tab">%3$s</a>',$url, $tab_event['id'], $tab_event['title'], $active );
    }

    ?>
</h2>
<?php
if ( ! $subtab ) {
   if( !isset( $menu[$tab]['submenu'] ) ) {
        return;
    }

    if ( !count( $menu[$tab]['submenu'] ) ) {
        return;
    }

    $subtab = key( $menu[$tab]['submenu'] );
}


?>
<h3 class="woogool-sub-nav">
    <ul class="woogool-subsubsub">
        <?php
            $sub_menu = array();

            foreach ( $menu[$tab]['submenu'] as $sub_key => $sub_event ) {
                $sub_active = ( $sub_key == $subtab ) ? 'woogool-sub-current' : '';
                $sub_event['id'] = isset( $sub_event['id'] ) ? $sub_event['id'] : '';
                $sub_url = woogool_subtab_menu_url( $tab, $sub_key );
                $sub_menu[] = sprintf( '<li><a class="%4$s" href="%1$s" id="%2$s-tab">%3$s</a></li>',$sub_url , $sub_event['id'], $sub_event['title'], $sub_active );
            }

            echo count( $sub_menu ) ? implode( '|', $sub_menu ) : '';
        ?>
    </ul>
</h3>

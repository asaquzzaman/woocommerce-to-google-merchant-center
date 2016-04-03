<?php
$is_access_premission = WooGool()->individual->check_authenticate();

if ( ! $is_access_premission ) {
    WooGool()->individual->authentication_process();
    return;
}

?>

<?php
    if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'woogool_product_details' ) {
        if( isset( $_GET['product_id'] ) && !empty( $_GET['product_id'] ) ) {
            require_once dirname(__FILE__) . '/single-product.php';
            return;
        }
    }
?>

<?php
require_once WOOGOOL_INCLUDES_PATH . '/countries.php';
require_once WOOGOOL_INCLUDES_PATH . '/languages.php';

try{
    $products = woogool_get_products_list();
    $products = $products->getResources();
} catch(Exception $e) {
  echo 'Message From Google: ' .$e->getMessage();
}

$products = isset( $products ) ? $products : array();
if(!count($products)) {
    ?>
    <p><h3><?php _e( 'No product found!', 'woogool' ); ?></h3></p>
    <?php
    return;
}
global $wpdb;

?>

<table class="widefat">
    <thead>
        <tr>

            <th><?php _e( 'Title', 'woogool' ); ?></th>
            <th><?php _e( 'Price', 'woogool' ); ?></th>
            <th><?php _e( 'Availability', 'woogool' ); ?></th>
            <th><?php _e( 'Condition', 'woogool' ); ?></th>
            <th><?php _e( 'Country', 'woogool' ); ?></th>
            <th><?php _e( 'Language', 'woogool' ); ?></th>
            <th><?php _e( 'Delete', 'woogool' ); ?></th>
        </tr>
    </thead>
    <?php
        foreach( $products as $product ) {
            $price = $product->getPrice();
            $url = admin_url( 'edit.php?post_type=product&page=product_woogool' );
            $postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $product->title . "'" );
            ?>
            <tr>
                <td><?php echo $product->title; ?></td>
                <td><?php echo woogool_get_currency( $price->currency ) . $price->value; ?></td>
                <td><?php echo $product->availability; ?></td>
                <td><?php echo $product->condition; ?></td>
                <td><?php echo $countries[$product->targetCountry]; ?></td>
                <td><?php echo $languages[$product->contentLanguage]; ?></td>
                <td><a href="<?php echo $url.'&action=delete&product_id='. $postid ; ?>"><?php _e('Delete', 'woogool' ); ?></a></td>
            </tr>

            <?php
        }
    ?>
</table>
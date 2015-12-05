<?php
$is_access_premission = $this->check_authenticate();

if ( ! $is_access_premission ) {
    $this->authentication_process();
    return;
}

?>

<?php
    if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'wogo_product_details' ) {
        if( isset( $_GET['product_id'] ) && !empty( $_GET['product_id'] ) ) {
            require_once dirname(__FILE__) . '/single-product.php';
            return;
        }
    }
?>

<?php
require_once dirname(__FILE__) . '/../includes/countries.php';
require_once dirname(__FILE__) . '/../includes/languages.php';

try{
    $products = wogo_get_products_list();
    $products = $products->getResources();
} catch(Exception $e) {
  echo 'Message From Google: ' .$e->getMessage();
}

$products = isset( $products ) ? $products : array();
if(!count($products)) {
    ?>
    <p><h3><?php _e( 'No product found!', 'wogo' ); ?></h3></p>
    <?php
    return;
}
global $wpdb;

?>

<table class="widefat">
    <thead>
        <tr>

            <th><?php _e( 'Title', 'wogo' ); ?></th>
            <th><?php _e( 'Price', 'wogo' ); ?></th>
            <th><?php _e( 'Availability', 'wogo' ); ?></th>
            <th><?php _e( 'Condition', 'wogo' ); ?></th>
            <th><?php _e( 'Country', 'wogo' ); ?></th>
            <th><?php _e( 'Language', 'wogo' ); ?></th>
            <th><?php _e( 'Delete', 'wogo' ); ?></th>
        </tr>
    </thead>
    <?php
        foreach( $products as $product ) {
            $price = $product->getPrice();
            $url = admin_url( 'edit.php?post_type=product&page=product_wogo' );
            $postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $product->title . "'" );
            ?>
            <tr>
                <td><?php echo $product->title; ?></td>
                <td><?php echo wogo_get_currency( $price->currency ) . $price->value; ?></td>
                <td><?php echo $product->availability; ?></td>
                <td><?php echo $product->condition; ?></td>
                <td><?php echo $countries[$product->targetCountry]; ?></td>
                <td><?php echo $languages[$product->contentLanguage]; ?></td>
                <td><a href="<?php echo $url.'&action=delete&product_id='. $postid ; ?>"><?php _e('Delete', 'wogo' ); ?></a></td>
            </tr>

            <?php
        }
    ?>
</table>
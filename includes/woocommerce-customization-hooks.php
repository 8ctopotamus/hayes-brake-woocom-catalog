<?php
/*
* Remove the description tab
* Remove the reviews tab
* Remove the additional information tab
*/
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );
    unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );
    return $tabs;
}

/*
* Removes Single Product categories from under short description
*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// add_action( 'woocommerce_before_single_product', 'woocommerce_template_single_meta', 10 );

?>

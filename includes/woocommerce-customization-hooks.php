<?php
/*
* Declare WooCommerce Support
* Remove sorting dropdown from shop template
 *show products from 2 cats on product cat archives
* Remove the description tab
* Remove the reviews tab
* Remove the additional information tab
*/

// Declare WooCommerce Support
add_theme_support( 'woocommerce' );

// remove default sorting dropdown on shop template
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

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


// show products from 2 cats
// on product cat archives
function product_cats_filter($query) {
  if ( !is_admin() && is_product_category() && !empty($_GET['prods']) && $query->is_main_query()) {

    $queryParams = explode(' ', $_GET['prods']);

    $taxArray = [];

    forEach($queryParams as $param) {
       array_push($taxArray , array(
	        'taxonomy' => 'product_cat',
	        'field' => 'slug',
	        'terms' => $param
	      )
       );
    }

    // add relation to inclusivly filter multiple cats
    $taxArray['relation'] = 'AND';

    $query->set('tax_query', $taxArray);
  }
}

add_action('pre_get_posts','product_cats_filter');


?>

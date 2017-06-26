<?php
/*
* Customize Product Title and move above product image
*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action('woocommerce_before_single_product', 'woocommerce_hayes_single_title', 10);
function woocommerce_hayes_single_title() {
	global $product;
	?>

  <div class="row">
    <img
      src="<?php echo plugins_url( '../images/brake-type-icons/hydraulic-brake.png', __FILE__ )?>"
    	class="brake-type-icon"
    	alt="hydraulic brake"
    />

    <?php the_title( '<h1 class="product_title entry-title">', '</h1>' ); ?>

    <?php if ( get_field('introduction') ) {
    	echo '<h3 class="introduction">';
    	echo the_field('introduction');
    	echo '</h3>';
    } ?>

		<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
  </div>

<?php }


/*
* Extra Design elements before the product summary
*/
add_action( 'woocommerce_before_single_product', 'xtraDesignElements', 50 );
function xtraDesignElements() {
  echo '<div class="cf"></div>';
  echo '<div class="hr-group"><hr/><hr/><hr/></div>';
}

?>

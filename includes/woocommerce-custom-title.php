<?php
/*
* Customize Product Title and move above product image
*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action('woocommerce_before_single_product', 'woocommerce_hayes_single_title', 10);
function woocommerce_hayes_single_title() {
	global $product;
	global $post;

	$marketTypes = [];
  $terms = get_the_terms( $post->ID, 'product_cat' );

	foreach ($terms as $term) {
    $product_cat_name = $term->name;
		// Brake Type Icons
		if ($product_cat_name === 'Hydraulic Brakes') {
			$catIconPath = 'hydraulic-brake.png';
		} elseif ($product_cat_name === 'Master Cylinder') {
			$catIconPath = 'master-cylinder.png';
		} elseif ($product_cat_name === 'Actuators') {
		  $catIconPath = 'actuator.png';
	  } elseif ($product_cat_name === 'Mechanical Brakes') {
			$catIconPath = 'mechanical-brake.png';
		} else {
			array_push($marketTypes, $product_cat_name);
		}
	}

	?>

  <div class="row">
    <img
      src="<?php echo plugins_url( '../images/brake-type-icons/' . $catIconPath, __FILE__ )?>"
    	class="brake-type-icon"
    	alt="hydraulic brake"
    />

    <?php the_title( '<h1 class="product_title entry-title">', '</h1>' ); ?>

    <?php if ( get_field('introduction') ) {
    	echo '<h3 class="introduction">';
    	echo the_field('introduction');
    	echo '</h3>';
    } ?>

		<?php
			foreach($marketTypes as $icon) {
				if ($icon === 'UTV or ROV or SXS') {
					$icon = 'utv';
				}
				echo '<img src="'. plugins_url( '../images/market-category-icons/'. $icon . '.png', __FILE__ ) .'" alt="'. $icon .' Markets" class="market-icon" />';
			}
		?>
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

<?php
/*
  Plugin Name: Hayes Brake WooCommerce Catalog
  Plugin URI:  https://zylo.wtf
  Description: Woocommerce customizations for Hayes Brake
  Version:     1.0
  Author:      Zylo, LLC
  Author URI:  https://zylo.wtf
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



function hayes_cat_register_scripts_and_styles() {
	wp_enqueue_style( 'hayes-cat-style', plugins_url( '/css/custom.css',  __FILE__ ));
	//wp_enqueue_script( 'simply-countdown-script', plugins_url( '/js/simplyCountdown.js',  __FILE__ ), array(), '', true);
}
add_action('wp_enqueue_scripts', 'hayes_cat_register_scripts_and_styles');


/*
* hides woocommerce tabs
*/
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab
    return $tabs;
}


/*
* Customize Product Title and move above product image
*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action('woocommerce_before_single_product_summary', 'woocommerce_hayes_single_title', 10);
function woocommerce_hayes_single_title() { ?>
  <img
  	src="<?php bloginfo('template_directory'); ?>/images/brake-type-icons/hydraulic-brake.png"
  	class="brake-type-icon"
  	alt="hydraulic brake"
  />

  <?php the_title( '<h1 class="product_title entry-title">', '</h1>' );

  if ( get_field('introduction') ) {
  	echo '<h3 class="introduction">';
  	echo the_field('introduction');
  	echo '</h3>';
  }
}


/*
* Moves Single Product categories to under title
*/
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_meta', 10 );


/*
* Add "ask an expert" and "Spec Sheet download" buttons
*/
add_action('woocommerce_share', 'renderButtons', 40);
function renderButtons() { ?>
	<div id="detail-buttons">
		<div id="detail-ask-our-experts">
			<a class="hb-button orange" href="<?php echo site_url(); ?>/ask-our-experts/">ask our experts</a>
		</div>

		<?php if (get_field('spec_sheet')) { ?>
			<div id="detail-download-spec-sheet">
				<a class="hb-button gray" href="<?php echo the_field('spec_sheet');?>" download>download spec sheet</a>
			</div>
		<?php } ?>
	</div>
<?php }



/*
* Adds Specifications table to product page
*/
add_action('woocommerce_after_single_product_summary', 'renderSpecTable', 40);
function renderSpecTable() {
	/*
	 * ACF CUSTOM FIELDS! - Generates Specifications Table
	 */
	 $fields = array(
		 $weight = get_field_object('hydraulic_weight'),
	 	 $refDim1 = get_field_object('hydraulic_reference_dimensions_1'),
	 	 $refDim2 = get_field_object('hydraulic_reference_dimensions_2'),
	 	 $refDim3 = get_field_object('hydraulic_reference_dimensions_3'),
	 	 $rotorDiameterSm = get_field_object('hydraulic_rotor_diameter_small'),
	 	 $rotorDiameterLg = get_field_object('hydraulic_rotor_diameter_large'),
	 	 $rotorThickness = get_field_object('hydraulic_rotor_thickness'),
	 	 $liningType = get_field_object('hydraulic_lining_type'),
	 	 $totalLiningArea = get_field_object('hydraulic_total_lining_area'),
	 	 $usableLiningThickness = get_field_object('hydraulic_usable_lining_thickness'),
	 	 $offset = get_field_object('hydraulic_offset'),
	 	 $pistonDiameter = get_field_object('hydraulic_piston_diameter'),
	 	 $maxPressure = get_field_object('hydraulic_max_pressure'),
	 	 $fluidDisplacement = get_field_object('hydraulic_fluid_displacement'),
	 	 $fluidType = get_field_object('hydraulic_fluid_type'),
	 	 $fluidInlet = get_field_object('hydraulic_fluid_inlet'),
	 	 $bleeder = get_field_object('hydraulic_bleeder')
	 );

	?>

  <div class="cf"></div>

  <h3>SPECIFICATIONS</h3>

	<table class="specifications-table">
		<tbody>
			<?php
			/*
			* Get predefined Specification fields
			*/

			foreach ($fields as $field) {
				if ( $field['value'] ) {
					echo '<tr>';
					if ( is_array($field['value']) ) {
						echo '<td>' . $field['label'] . '</td>';
						echo '<td>';
						forEach ($field['value'] as $val) {
							echo $val . '<br/>';
						}
						echo '</td>';
					}
					else {
						echo '<td>' . $field['label'] . '</td><td>' . $field['value'] . '</td>';
					}
					echo '</tr>';
				}
	 	 	}

		  /*
			 * Additional Repeater fields for table
			 */
			if ( have_rows('additional_specifications') ): ?>
		 		<tr>
		 		<?php while( have_rows('additional_specifications') ): the_row();
		 			// vars
		 			$label = get_sub_field('specification_label');
		 			$value = get_sub_field('specification_value');
		 			?>

					<td>
						<?php echo $label; ?>
					</td>
		 			<td>
		 				<?php echo $value; ?>
					</td>

		 		<?php endwhile; ?>
				</tr>
		 	<?php endif; ?>
		</tbody>
	</table>
	<p>Specifications are guidelines only and subject to change. Consult Hayes for specific model, part number, and assembly drawings.</p>
<?php }

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

// Warning that ACF needs to be installed and activated
function my_acf_notice() { ?>
	<div class="update-nag notice">
	  <p><?php _e( 'Please install the Advanced Custom Fields and ACF Repeater Fields plugins (Both included in ACF PRO), they are required for the "Hayes Brake WooCommerce Catalog" plugin to work properly!', 'my_plugin_textdomain' ); ?></p>
	</div>
<?php }

//check for ACF. If available, run plugin
if( !class_exists('acf') || !function_exists( 'the_field') ) {
	add_action( 'admin_notices', 'my_acf_notice' );
	return;
}

// styles and scripts
function hayes_cat_register_scripts_and_styles() {
	wp_enqueue_style( 'hayes-cat-style', plugins_url( '/css/custom.css',  __FILE__ ));
	wp_register_script('update-product-archive-sidebar', plugin_dir_url( __FILE__ )  . '/js/update-product-archive-sidebar.js', '', '', true);

	if (!is_admin() && is_product_category() && !empty($_GET['prods'])) {
			wp_enqueue_script('update-product-archive-sidebar');
	}
}
add_action('wp_enqueue_scripts', 'hayes_cat_register_scripts_and_styles');

// generates custom admin fields
include( plugin_dir_path( __FILE__ ) . 'includes/acf-custom-fields.php');
// disables/moves various parts of the WooCommerce Templates
include( plugin_dir_path( __FILE__ ) . 'includes/woocommerce-customization-hooks.php');
// moves/customizes woocommerce title
include( plugin_dir_path( __FILE__ ) . 'includes/woocommerce-custom-title.php');
// adds ask an expert and spec sheet buttons
include( plugin_dir_path( __FILE__ ) . 'includes/spec-sheet-button.php');
// generates spec table
include( plugin_dir_path( __FILE__ ) . 'includes/specifications-table.php');

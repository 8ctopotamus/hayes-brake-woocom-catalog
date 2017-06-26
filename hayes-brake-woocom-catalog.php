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

// disables/moves various parts of the WooCommerce Templates
include( plugin_dir_path( __FILE__ ) . 'includes/woocommerce-customization-hooks.php');
include( plugin_dir_path( __FILE__ ) . 'includes/experts-spec-sheet-buttons.php');
include( plugin_dir_path( __FILE__ ) . 'includes/woocommerce-custom-title.php');
include( plugin_dir_path( __FILE__ ) . 'includes/specifications-table.php');

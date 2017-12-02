<?php
/*
* Adds Specifications table to product page
*/
add_action('woocommerce_after_single_product_summary', 'renderSpecTableAndTorqueInfo', 40);
function renderSpecTableAndTorqueInfo() {
  global $post;

  /*
   * ACF CUSTOM FIELDS! - Generates Specifications Table
   */

  $terms = get_the_terms( $post->ID, 'product_cat' );
  foreach ($terms as $term  ) {
    $product_cat_name = $term->name;

    if ($product_cat_name === 'Hydraulic Brakes' || $product_cat_name === 'Mechanical Brakes') {
      $specifications = array(
        $weight = get_field_object('hydraulic_weight'),
        $rotorDiameterSm = get_field_object('hydraulic_rotor_diameter'),
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
    } elseif ($product_cat_name === 'Master Cylinder') {
      $specifications = array(
        $weight = get_field_object('master_cyl_weight'),
        $pistonDiameter = get_field_object('master_cyl_piston_diameter'),
        $leverRotaion = get_field_object('master_cyl_lever_ration'),
        $hand = get_field_object('master_cyl_hand'),
        $brakeLight = get_field_object('master_cyl_brake_light'),
        $fluidType = get_field_object('master_cyl_fluid_type')
      );
    } elseif ($product_cat_name === 'Actuators') {
      $specifications = array(
        $weight => get_field_object('actu_weight'),
        $maxPressure => get_field_object('actu_max_pressure'),
        $type => get_field_object('actu_type'),
        $fluidDisplacement => get_field_object('actu_fluid_displacement'),
        $fluidType => get_field_object('actu_fluid_type'),
        $typicalSpecs => get_field_object('actu_typical_specifications')
      );
    }
 }

 // ACF - common product fields
 $refDims = array(
   $refDim1 = get_field('reference_dimensions_1'),
   $refDim2 = get_field('reference_dimensions_2'),
   $refDim3 = get_field('reference_dimensions_3')
 );
 $torqueInfo = get_field('torque_information');
 $torqueInfo2 = get_field('torque_information_2');


 // calculate the grid
 if (!empty($refDims) || $torqueInfo || $torqueInfo2 ) {
   $gridSize = 6;
 }
 else {
   $gridSize = 12;
 }

?>

  <div class="cf"></div>
  <div class="hr-group">
    <hr/>
    <hr/>
    <hr/>
  </div>

  <div class="row">
    <div class="col-<?php echo $gridSize; ?>">
      <h3>SPECIFICATIONS</h3>
      <table class="specifications-table">
        <tbody>
          <?php
          /*
          * Get predefined Specification fields
          */
          foreach ($specifications as $field) {
            if ( $field['value'] ) {
              // Begin row
              echo '<tr>';

              // multiselect fields
              if ( is_array($field['value']) ) {
                echo '<td>' . $field['label'] . '</td>';
                echo '<td>';
                  forEach ($field['value'] as $val) {
                    echo $val . '<br/>';
                  }
                echo '</td>';
              }
              // single line fields
              else {
                echo '<td>' . $field['label'] . '</td><td>' . $field['value'] . ' ' . $field['append'] . '</td>';
              }

              // end row
              echo '</tr>';
            }
          }

          /*
           * Additional Repeater fields for table
           */
          if ( have_rows('additional_specifications') ): ?>

            <?php while( have_rows('additional_specifications') ): the_row();
              // vars
              $label = get_sub_field('specification_label');
              $value = get_sub_field('specification_value');
              ?>
              <tr>
                <td>
                  <?php echo $label; ?>
                </td>
                <td>
                  <?php echo $value; ?>
                </td>
              </tr>
            <?php endwhile; ?>

          <?php endif; ?>
        </tbody>
      </table>
      <p>Specifications are guidelines only and subject to change. Consult Hayes for specific model, part number, and assembly drawings.</p>
    </div>

    <?php if(!empty($refDims) || $torqueInfo || $torqueInfo2) {?>
      <div class="col-6">

        <?php if ($torqueInfo || $torqueInfo2) { ?>
          <h3>TORQUE INFORMATION</h3>
        <?php } ?>

        <?php if ($torqueInfo) { ?> 
          <a href="<?php echo $torqueInfo; ?>" class="torque-info">
            <img
              src="<?php echo $torqueInfo; ?>"
              
              alt="torque info" />
           </a>
        <?php } ?>

        <?php if ($torqueInfo2) { ?>
          <a href="<?php echo $torqueInfo2; ?>" class="torque-info">
            <img
              src="<?php echo $torqueInfo2; ?>"
              class="torque-info"
              alt="torque info 2" />
           </a>
        <?php } ?>
     

        <?php
          if (get_field('reference_dimensions_1')) {
            echo '<h3>REFERENCE DIMENSIONS</h3>';
          }

          forEach($refDims as $ref) {
            if ($ref) { ?>
              <a class="reference-dimensions" href="<?php echo $ref; ?>">
                <img src="<?php echo $ref; ?>" alt="reference dimensions" />
              </a>
            <?php }
          }
        ?>
      </div>
    <?php } ?>
  </div>


<?php } ?>

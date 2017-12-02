<?php
/*
* Add "ask an expert" and "Spec Sheet download" buttons
*/
add_action('woocommerce_share', 'renderButtons', 40);
function renderButtons() { ?>
	<div id="detail-buttons">
		<?php if (get_field('spec_sheet')) { ?>
			<div id="detail-download-spec-sheet">
				<a class="hb-button gray" href="<?php echo the_field('spec_sheet');?>" download>download spec sheet</a>
			</div>
		<?php } ?>
	</div>
<?php }
?>

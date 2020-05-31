<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
|                              // Mon, Sep 29, 2008 |
+--------------------------------------------------*/


$basedir = dirname(dirname(dirname(__FILE__)));
require_once("{$basedir}/initvars.inc.php");
require_once("{$basedir}/config.inc.php");

?>
<fieldset class="fee_details">
<div id="fee_fieldset" class="fieldset" style="float:left;">

	<div id="fee_fieldset_repeat">
		<?php
		$defaultFee = 0.00;
		$index = 1;
			
		if (isset($feeSectionId) && isset($feeSectionLevel)) {
			$feeInfo = $paidCategoriesHelper->loadFeeInfo($feeSectionId, $feeSectionLevel);
		}
		?>
		
		<?php if ($feeSectionLevel == 2) { ?>
		<input type="radio" name="inherit" value="1" <?php if(!count($feeInfo)) echo "checked"; ?>> Inherit category settings<br>
		<input type="radio" name="inherit" value="0" <?php if(count($feeInfo)) echo "checked"; ?>> Use the following settings<br><br>
		<?php } ?>

		
		<?php
			
		foreach($feeInfo as $key=>$fee) {
			if ($key == "0,0") {
				$defaultFee = $fee;
				
			} else {
		?>
		
				<div id="fee_row[<?php echo $index; ?>]" class="fee_row">
					<?php echo $paidCategoriesHelper->getLocationSelect("fee_loc[{$index}]", "fee_loc", $key); ?>
					<span><?php echo $paypal_currency_symbol; ?></span>
					<input type="text" size="6" 
						name="fee[<?php echo $index; ?>]" class="fee" value="<?php echo $fee; ?>">
					<img src="../paid_cats/admin/images/delete.png" class="fee_add_remove" 
						onclick="removeFeeRow(<?php echo $index; ?>);">
				</div>
				
		<?php
				$index++;
			}
		}
		?>
	</div>
	
	<div id="fee_row_template" class="fee_row">
		<?php echo $paidCategoriesHelper->getLocationSelect("fee_loc[%index%]", "fee_loc"); ?>
		<span><?php echo $paypal_currency_symbol; ?></span>
		<input type="text" size="6" name="fee[%index%]" class="fee">
		<img src="../paid_cats/admin/images/delete.png" class="fee_add_remove" 
			onclick="removeFeeRow(%index%);">
	</div>

	<div id="fee_row_default" class="fee_row">
		<input type="hidden" name="fee_loc[0]" value="0,0">
		<div id="fee_loc_default" class="fee_loc" style="padding-top:3px;">
			<?php if($index == 1) { ?>
				<div id="all_cities">For all cities</div>
				<div id="other_cities" style="display:none;">For all other cities</div>
			<?php } else { ?>
				<div id="all_cities" style="display:none;">For all cities</div>
				<div id="other_cities">For all other cities</div>
			<?php } ?>
		</div>
		<span><?php echo $paypal_currency_symbol; ?></span>
		<input type="text" size="6" class="fee" 
			name="fee[0]" value="<?php echo $defaultFee; ?>">
		<img src="../paid_cats/admin/images/add.png" class="fee_add_remove" 
			onclick="addFeeRow();"> 
	</div>
		
</div>
<div style="float:left; margin-left: 10px; background-color: lightyellow; 
	border: 1px solid white; padding: 5px;" class="tip">
	
	<div style="float:left; width: 22px;">
	<img src="images/tip.gif" border="0" style="vertical-align:middle">
	</div>
	
	<div style="float:left; width: 170px;">
	Click <img src="../paid_cats/admin/images/add.png" style="vertical-align:middle">
	to setup city specific fees. To allow free posting in any/all cities, 
	set the fee to 0.</div>
</div>
</fieldset>

<script type="text/javascript">
initFeeTable(<?php echo $index-1; ?>);
</script>
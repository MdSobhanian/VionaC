<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: search.inc.php                              | 
| The search form                                   |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Sun, Oct 23, 2005 ]---*/


require_once("initvars.inc.php");
require_once("config.inc.php");


if ($xview == "main" || $show_sidebar_always) 
{
	$searchbox_on_top = 0;
	$field_sep = "";
}
else
{
	$searchbox_on_top = 1;
	$field_sep = "";
}



if($dir_sort) 
{
	$sortcatsql = "ORDER BY catname";
	$sortsubcatsql = "ORDER BY subcatname";
}
else
{

	$sortcatsql = "ORDER BY pos";
	$sortsubcatsql = "ORDER BY scat.pos";
}

?>
<form action="?" id="formSearch" method="get">
<div>
<input type="hidden" name="cityid" value="<?php echo $xcityid; ?>">
<input type="hidden" name="lang" value="<?php echo $xlang; ?>">
<!-- Begin Version 5.7 - XSS fix -->
<input name="search" class="input_search" type="text" size="<?php echo $searchbox_on_top?20:20; ?>" value="<?php echo $_GETs['search']; ?>" data-default=" keyword">
<!-- End Version 5.7 - XSS fix -->

<?php

/* Begin Version 5.7 - Postable category fix */
if ($postable_category)
/* End Version 5.7 - Postable category fix */
{

?>
            <div class="metaFieldStructure">

	<?php
	
	if ($xsubcathasprice)
	{

	?>

		<?php echo $field_sep; ?>

<span class="metaFieldLabel">
		<?php echo $xsubcatpricelabel; ?>:</span>
		<input type="text" name="pricemin" size="4" data-default=" min"><?php echo $lang['SEARCH_TO']; ?> 
		<input type="text" name="pricemax" size="4" data-default=" max">

	<?php

	}

	?>

	<?php

	foreach ($xsubcatfields as $fldnum=>$fld)
	{
		if($fld['SEARCHABLE'])
		{

	?>

		<?php echo $field_sep; ?>

		<?php echo $fld['NAME']; ?>: 

		<?php if ($fld['TYPE'] == 'N') { ?>

			<input type="text" name="x[<?php echo $fldnum; ?>][min]" size="3"><?php echo $lang['SEARCH_TO']; ?>  
			<input type="text" name="x[<?php echo $fldnum; ?>][max]" size="3">

		<?php } else if ($fld['TYPE'] == "D") { ?>

			<select name="x[<?php echo $fldnum; ?>]">
			<option value="">- <?php echo $lang['ALL']; ?> -</option>
			<?php
			foreach ($fld['VALUES_A'] as $v)
			{
				echo "<option value=\"$v\">$v</option>";
			}
			?>
			</select>

		<?php } else { ?>

			<input type="text" name="x[<?php echo $fldnum; ?>]" size="10">

		<?php } ?>


	<?php

		}
	}

	?>

	<input type="hidden" name="view" value="ads">	<!-- Begin Version 5.7 - Postable category fix -->
	<?php if ($xsubcatid) { ?>
	<input type="hidden" name="subcatid" value="<?php echo $xsubcatid; ?>">
	<?php } else { ?>
	<input type="hidden" name="catid" value="<?php echo $xcatid; ?>">
	<?php } ?>
	<!-- End Version 5.7 - Postable category fix -->
	
<?php

}

elseif ($xcatid > 0)
{
    /* Begin Version 5.0 */
	
	$sql = "SELECT subcatid, subcatname AS subcatname
			FROM $t_subcats scat
			WHERE catid = $xcatid
				AND enabled = '1'
			$sortsubcatsql";

	$scatres = mysql_query($sql);
	$subcatcount = mysql_num_rows($scatres);
	$show_subcats = true;

	if ($shortcut_categories && $subcatcount == 1) {
	
	    // Check if the only subcat has got the same name as the cat.
	    $only_subcat = mysql_fetch_array($scatres);
	    if ($only_subcat['subcatname'] == $xcatname) {
	        $show_subcats = false;
	    }
	    
	    // Reset resultset pointer.
	    mysql_data_seek($scatres, 0);
	}
			    
    /* End Version 5.0 */
?>
    
    <!-- Begin Version 5.0 -->
    <?php if ($show_subcats) { ?>

    	<?php echo $field_sep; ?>
    
    	<select name="subcatid" class="input_drop_down" style="height:24px;">
    	<option value="0">- <?php echo $lang['ALL']; ?> -</option>
    	<?php
    
    	while ($row=mysql_fetch_array($scatres))
    	{
    		echo "<option value=\"$row[subcatid]\">$row[subcatname]</option>\n";
    	}
    
    	?>
    	</select>
	
	<?php } ?>
	<!-- End Version 5.0 -->
	
	<input type="hidden" name="view" value="ads">
	<input type="hidden" name="catid" value="<?php echo $xcatid; ?>">

<?php

}

elseif ($xview == "events" || $xview == "showevent")
{

?>

	<select><option value="0">- <?php echo $lang['ALL']; ?> -</option></select>
	<input type="hidden" name="view" value="events">


<?php

}

else
{

?>
	
	<?php echo $field_sep; ?>

	<select name="catid" class="input_drop_down" style="height:24px;">
	<option value="0">- <?php echo $lang['ALL']; ?> -</option>
	<?php
	
	$sql = "SELECT catid, catname AS catname
			FROM $t_cats
			WHERE enabled = '1'
			$sortcatsql";

	$catres = mysql_query($sql);

	while ($row=mysql_fetch_array($catres))
	{
		echo "<option value=\"$row[catid]\">$row[catname]</option>\n";
	}

	?>
	<?php if($enable_calendar) { ?><option value="-1"><?php echo $lang['EVENTS']; ?></option><?php } ?>
	</select>
	<input type="hidden" name="view" value="ads">

<?php

}

?>

<?php 
/* Begin Version 5.7 - Postable region fix */
if($xcityid>0 || $postable_country)
{
    $cityid = ($xcityid > 0 ? $xcityid : $child_city['cityid']);
/* End Version 5.7 - Postable region fix */
?>

	<?php
	if($location_sort) $sort = "ORDER BY areaname";
    else $sort = "ORDER BY pos";
    
	$sql = "SELECT areaname FROM $t_areas WHERE cityid = $cityid $sort";
	$area_res = mysql_query($sql);
	if (mysql_num_rows($area_res))
	{
	?>

	<?php echo $field_sep; ?>
	<?php echo $lang['POST_LOCATION']; ?>:
	<select name="area" class="input_drop_down" style="height:24px;">
	<option value="">- <?php echo $lang['ALL']; ?> -</option>

	<?php

		while($area_row = mysql_fetch_array($area_res))
		{
			echo "<option value=\"$area_row[areaname]\"";
			if ($_GET['area'] == $area_row['areaname']) echo " selected";
			echo ">$area_row[areaname]</option>";
		}

	?>

	</select>

	<?php 
	}
	?>

<?php 
}
?>
</div>
  <div class="formSubmitWrap">
<br />
<input type="submit" name="submit" value="search" class="button" id="searchButton" style="width:105px; font-weight:normal;">

</div>
</div>
</form>
    <script>
      jQuery("form[name='formRefineSearch'] input[type='text']").focus(function(){
        if (jQuery(this).is("[data-default]")){
          if (jQuery(this).val()==jQuery(this).attr("data-default")){
            jQuery(this).val("");
          }
        }
      });
      jQuery("form[name='formRefineSearch'] input[type='text']").focus(function(){
        if (jQuery(this).is("[data-default]")){
          if (jQuery(this).val()==jQuery(this).attr("data-default")){
            jQuery(this).val("");
          }
        }
      });
      jQuery("form[name='formRefineSearch'] input[type='text']").blur(function(){
        if (jQuery(this).is("[data-default]")){
          if (jQuery.trim(jQuery(this).val())==""){
            jQuery(this).val(jQuery(this).attr("data-default"));
          }
        }
      });
      jQuery("form[name='formRefineSearch']").submit(function(){
        jQuery("form[name='formRefineSearch'] input[type=text]").each(function() {
          if (jQuery(this).val()==jQuery(this).attr("data-default")){
            jQuery(this).val("");
          }
        });
      });
    </script>

 
<!--<a id="simple-menu" href="#sidr">Toggle menu</a> -->
<div id="simple-menu" class="nav-trigger sidebar-toggle"><a id="simple-menu" href="#sidr"></a></div>


<div id="sidr">
  <!-- content -->
  <ul>
    <li><a href="<?php echo "{$script_url}"; ?>" style="color:#000 !important;">Home</a></li>
    <li class="active"><a href="<?php echo $postlink; ?>">Post Ad</a></li>
    <li><a href="<?php echo "{$script_url}"; ?>/myaccount">My Account</a></li>
        <li></li>
            <li><a href="<?php echo "{$script_url}"; ?>/AllCities">Change City</a></li>
                    <li></li>
  </ul>
</div>

<script>
$(document).ready(function() {
  $('#simple-menu').sidr();
});
</script>


    <div id="tlHeader" class="siteHeader">
      
      

      <div id="logo">
      <?php
		/* Begin Version 5.0 */
		//$homeurl = buildURL("main", array(0));
		$homeurl = $script_url."/".$default_city;
		/* End Version 5.0 */
		?>
      <a href="<?php echo $script_url; ?>/<?php echo $default_city; ?>" style="background-image:url(<?php echo "{$script_url}"; ?>/images/logo_transparentbg.png); background-size:160px 46px;"></a></div>

	<div id="postAdButton" class="tlBlock">
        <form name="formPost" id="formPost" action="<?php echo $postlink; ?>" method="get">
      <input type="button" value="Post Ad" class="button" onClick="location.href='<?php echo $postlink; ?>';" id="postAdButton">
       <input type="button" value="My Account" class="button" onClick="location.href='<?php echo "{$script_url}"; ?>/myaccount';" id="postAdButton">
    </form>
   
      </div><!-- #postAdButton -->

      
      <div id="searchInline" class="tlBlock">
        <span class="search-wrapper">
        <form name="formSearch" id="formSearch" action="?" method="get">
      <input type="hidden" name="cityid" value="<?php echo $xcityid; ?>">
      <input type="hidden" name="lang" value="<?php echo $xlang; ?>">
	<input type="hidden" name="view" value="ads">
      <input type="text" size="15" name="search" value="<?php echo $_GETs['search']; ?>" data-default=" keyword" maxlength="100">
      
        
	<select name="catid">
		<?php
		$sql = "SELECT catid, catname
				FROM $t_cats
				ORDER BY catname";
		$res = mysql_query($sql) or die(mysql_error());
		
		while($row=mysql_fetch_array($res))
		{
			echo "<option value=\"$row[catid]\"";
			if ($row['catid'] == $thisitem['catid'] || (!$thisitem && $row['catid'] == $_REQUEST['catid'])) echo " selected";
			echo ">$row[catname]</option>";
		}

		?>
	</select>
      
      <input type="submit" value="search" class="button" id="searchButton">
    </form>

 <script>
      jQuery("form[name='formSearch'] input[type='text']").focus(function(){
        if (jQuery(this).is("[data-default]")){
          if (jQuery(this).val()==jQuery(this).attr("data-default")){
            jQuery(this).val("");
          }
        }
      });
      jQuery("form[name='formSearch'] input[type='text']").blur(function(){
        if (jQuery(this).is("[data-default]")){
          if (jQuery.trim(jQuery(this).val())==""){
            jQuery(this).val(jQuery(this).attr("data-default"));
          }
        }
      });
      jQuery("form[name='formSearch']").submit(function(){
        jQuery("form[name='formSearch'] input[type=text]").each(function() {
          if (jQuery(this).val()==jQuery(this).attr("data-default")){
            jQuery(this).val("");
          }
        });
      });
    </script>

      </span>
      </div>

      <div id="community" class="tlBlock">
       
         <h1> <span class="city" style="text-transform:lowercase; color:black;"><?php if ($xcityid == "0") { ?><a href="/AllCities" target="_top" title="Please choose a location">Select your city</a><?php } ?><?php echo $xcityid>0 && !$postable_country?"$xcityname, $xcountryname":$xcountryname; ?></span></h1>
        
      </div><!-- #community -->
    </div><!-- #tlHeader -->
  

  
  <div id="searchDropdown">
    <span class="search-wrapper">
        <form name="formSearch" id="formSearch" action="?" method="get">
          <input type="hidden" name="cityid" value="<?php echo $xcityid; ?>">
	      <input type="hidden" name="lang" value="<?php echo $xlang; ?>">
<input type="hidden" name="view" value="ads">
      <input type="text" size="<?php echo $searchbox_on_top?20:20; ?>" name="search" value="<?php echo $_GETs['search']; ?>" data-default=" keyword" maxlength="100">

	<select name="catid">
		<?php
		$sql = "SELECT catid, catname
				FROM $t_cats
				ORDER BY catname";
		$res = mysql_query($sql) or die(mysql_error());
		
		while($row=mysql_fetch_array($res))
		{
			echo "<option value=\"$row[catid]\"";
			if ($row['catid'] == $thisitem['catid'] || (!$thisitem && $row['catid'] == $_REQUEST['catid'])) echo " selected";
			echo ">$row[catname]</option>";
		}

		?>
	</select>
      
      <input type="submit" value="search" class="button" id="searchButton">
    </form>
      </span>
  </div>

 <div id="pageBackground">
  <div id="mainCellWrapper">

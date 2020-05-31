<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                         |
+===================================================+
| File: admin/language.php                          |
| Edit language files                               |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Wed, Oct 26, 2005 ]---*/

require_once("admin.inc.php");
require_once("aauth.inc.php");

?>

<?php include_once("aheader.inc.php"); ?>

<?php

if (isset($_POST['feature_sub']))
		{
			if ($_POST['smtp_function'] == '1') { 
		$feature_upd = mysql_query("update clf_feature_control set default_city = '".$_POST['default_city']."', max_abuse_reports = '".$_POST['max_abuse_reports']."',
		sef = '".$_POST['sef']."', site_calendar = '".$_POST['site_calendar']."', post_image = '".$_POST['post_image']."',
		numbers_directory = '".$_POST['numbers_directory']."', numbers_location = '".$_POST['numbers_location']."', numbers_picture = '".$_POST['numbers_picture']."',
		currency_symbol = '".$_POST['currency_symbol']."', rich_text = '".$_POST['rich_text']."',
		smtp_function = '".$_POST['smtp_function']."', smtp_host = '".$_POST['smtp_host']."', smtp_port = '".$_POST['smtp_port']."', smtp_authenticate = '".$_POST['smtp_authenticate']."', smtp_username = '".$_POST['smtp_username']."', smtp_password = '".$_POST['smtp_password']."'");
			} else 
			{
			
			$feature_upd = mysql_query("update clf_feature_control set default_city = '".$_POST['default_city']."', max_abuse_reports = '".$_POST['max_abuse_reports']."',
		sef = '".$_POST['sef']."', site_calendar = '".$_POST['site_calendar']."', post_image = '".$_POST['post_image']."',
		numbers_directory = '".$_POST['numbers_directory']."', numbers_location = '".$_POST['numbers_location']."', numbers_picture = '".$_POST['numbers_picture']."',
		currency_symbol = '".$_POST['currency_symbol']."', rich_text = '".$_POST['rich_text']."', smtp_function = '".$_POST['smtp_function']."'");
			
			}
		}

		$feature_data_que = mysql_query("select * from clf_feature_control");
		$feature_data = mysql_fetch_array($feature_data_que);
		$city_que = mysql_query("select * from clf_cities");
		$city_name = mysql_fetch_array(mysql_query("select * from clf_cities where cityid = $feature_data[0]"));
?>

<script language="javascript">
function k2() {
  var func = "<?php echo $feature_data[10];  ?>";
  if ( func == '0' )
	{
	 document.getElementById('host').style.display='none';
	}
}
</script>
<body onLoad="k2();">
<script type="text/javascript">
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}
 
 
function prepareInputsForHints() {
  var inputs = document.getElementsByTagName("input");
  for (var i=0; i<inputs.length; i++){
    inputs[i].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    inputs[i].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
  var selects = document.getElementsByTagName("select");
  for (var k=0; k<selects.length; k++){
    selects[k].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    selects[k].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
  var textareas = document.getElementsByTagName("textarea");
  for (var m=0; m<textareas.length; m++){
    textareas[m].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    textareas[m].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
}
addLoadEvent(prepareInputsForHints);
</script>
<script type="text/javascript" language="javascript">

function disab()
{
 // document.getElementById('hostt').disabled=1;
 document.getElementById('host').style.display='none';
}
function enab()
{
document.getElementById('host').style.display = '';
}

</script>


<h2>Feature Control</h2>
<p class="tip"><img src="images/tip.gif" border="0" align="absmiddle"> You can control most of the features of your classifieds site from this page.</p>

<?php if ($feature_upd) { echo "<p><div class=\"msg\">Information updated successfully</div></p>"; } ?>
<form class="box" name="feature_control" action="feature_control.php" method="post">
<table border="0"><dl>
    <tr>
    <td width="180">Default City</td>
    <td>
    <select name="default_city" style="width:164px;">
    <option value="<?php echo $city_name[0]; ?>"><?php if ($city_name[0] == 0) { echo "None"; } else { echo $city_name[1]; } ?></option>
    <option value="0">None</option>
	<?php while ($city_data = mysql_fetch_array($city_que)) { ?>
    <option value="<?php echo $city_data[0]; ?>"><?php echo $city_data[1]; ?></option>
    <?php } ?>
    </select><span class="hint">You can set default city for your users. Usually we do not recommend.<span class="hint-pointer">&nbsp;</span>
  </span>
    </td>
    </tr>
    <tr>
      <td>Maximum Abuse Reports</td>
      <td><input type="text" size="4" name="max_abuse_reports" value="<?php echo $feature_data[1]; ?>" />
        <span class="hint">Number of reports before the ads are auto suspended. Set 0 to disable.<span class="hint-pointer">&nbsp;</span></span></td>
    </tr>
    <tr>
      <td>Numbers of Directory</td>
      <td><input type="text" size="4" name="numbers_directory" value="<?php echo $feature_data[5]; ?>" />
        <span class="hint">Set the numbers of category column you require in your index page.<i>(middle section)</i><span class="hint-pointer">&nbsp;</span></span></td>
    </tr>
    <tr>
      <td>Numbers of Location</td>
      <td><input type="text" size="4" name="numbers_location" value="<?php echo $feature_data[6]; ?>" />
        <span class="hint">Set the numbers of location column you require in your index page (<i>right hand side</i>).<span class="hint-pointer">&nbsp;</span></span></td>
    </tr>
    <tr>
      <td>Numbers of Picture Upload</td>
      <td><input type="text" size="4" name="numbers_picture" value="<?php echo $feature_data[7]; ?>" />
        <span class="hint">Set the numbers of defaul picture upload fields in ad posting page.<span class="hint-pointer">&nbsp;</span></span></td>
    </tr>
</dl>
    <tr>
      <td valign="top">Search Engine Friendly URL</td>
      <td>
        <label class="switchGREEN"><input type="radio" <?php if ($feature_data[2] == '1') { echo "checked='checked'"; } ?> name="sef" value="1" />Turn On</label>
        <label class="switchRED"><input type="radio" <?php if ($feature_data[2] == '0') { echo "checked='checked'"; } ?> name="sef" value="0" />Turn Off</label>
        </td>
    </tr>
    <tr>
    <td valign="top">Calendar</td>
    <td>
    <label class="switchGREEN"><input type="radio" <?php if ($feature_data[3] == '1') { echo "checked='checked'"; } ?> name="site_calendar" value="1" />Turn On</label>
    <label class="switchRED"><input type="radio" <?php if ($feature_data[3] == '0') { echo "checked='checked'"; } ?> name="site_calendar" value="0" />Turn Off</label>
    </td>
    </tr>
    <tr>
    <td valign="top">Post Image</td>
    <td>
    <label class="switchGREEN"><input type="radio" <?php if ($feature_data[4] == '1') { echo "checked='checked'"; } ?> name="post_image" value="1" />Turn On</label>
    <label class="switchRED"><input type="radio" <?php if ($feature_data[4] == '0') { echo "checked='checked'"; } ?> name="post_image" value="0" />Turn Off</label>
    </td>
    </tr>
    <tr>
      <td valign="top">Rich Text</td>
      <td><label class="switchGREEN">
        <input type="radio" <?php if ($feature_data[9] == '1') { echo "checked='checked'"; } ?> name="rich_text" value="1" />
        Turn On</label>
        <label class="switchRED">
          <input type="radio" <?php if ($feature_data[9] == '0') { echo "checked='checked'"; } ?> name="rich_text" value="0" />
          Turn Off</label></td>
    </tr>
<!--    <tr>
    <td>Change Currency Symbol</td>
    <td>
    <select style="width:166px;" name="currency_symbol">
     <option value="<?php //echo $feature_data[8]; ?>"><?php //echo $feature_data[8]; ?></option>
     <option value="$">$</option>
     <option value="&#128;">&euro;</option>
    </select>
    </td>
    </tr> -->
    <tr>
      <td valign="top">SMTP Function</td>
      <td>
        <label class="switchGREEN"><input type="radio" id="onn" onClick="enab();" <?php if ($feature_data[10] == '1') { echo "checked='checked'"; } ?> name="smtp_function" value="1" />Turn On</label> 
        <label class="switchRED"><input type="radio" id="off" onClick="disab();" <?php if ($feature_data[10] == '0') { echo "checked='checked'"; } ?> name="smtp_function" value="0" />Turn Off</label>
        </td>
    </tr>
    </table>
        
	<div id="host">    
    <table border="0" class="tt">
    <tr>
    <td width="180px">SMTP Host</td>
    <td><input type="text" size="30" id="hostt" name="smtp_host" value="<?php echo $feature_data[11]; ?>" /><span class="hint">This is the hostname of our SMTP. Usually it is "localhost". <br /><br><font class="err">Warning</font><br />Turning on the SMTP will disable PHP mail function. Do it if you know your settings.<span class="hint-pointer">&nbsp;</span></span></td>
    </tr>
    <tr>
    <td>SMTP Port</td>
    <td><input type="text" size="4" name="smtp_port" value="<?php echo $feature_data[12]; ?>" /><span class="hint">This is the required port number to connect to your SMTP host. Common SMTP port number is 25.<span class="hint-pointer">&nbsp;</span></span></td>
    </tr>
    <tr>
    <td>SMTP Authenticate</td>
    <td><select name="smtp_authenticate" style="width:164px;">
    <option value="<?php echo $feature_data[13]; ?>"><?php if ($feature_data[13] == '1') { echo 'TRUE'; } else { echo 'FALSE'; } ?></option>
    <option value="1">TRUE</option>
    <option value="0">FALSE</option>
    </select><span class="hint">Many server requires authentication and some doesn't. Depending on your SMTP settings provided by your hosting provider.<span class="hint-pointer">&nbsp;</span></span>
    </td>
    </tr>
    <tr>
    <td>SMTP User</td>
    <td><input type="text" size="30" name="smtp_username" value="<?php echo $feature_data[14]; ?>" /><span class="hint">Your SMTP authentication username if authentication is required.<span class="hint-pointer">&nbsp;</span></span></td>
    </tr>
    <tr>
    <td>SMTP Password</td>
    <td><input type="password" size="30" name="smtp_password" value="<?php echo $feature_data[15]; ?>" /><span class="hint">Your SMTP authentication password.<span class="hint-pointer">&nbsp;</span></span></td>
    </tr>
    </table>
    </div>
    
    <table>
    <tr>
    <td width="150px"></td>
    <td width="150px" align="right"><input type="submit" class="button" value="Submit" name="feature_sub" /></td>
    </tr>    
</table>
</form>



<?php include_once("afooter.inc.php"); ?>
</body>
</html>
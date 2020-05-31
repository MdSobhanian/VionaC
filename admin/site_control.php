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

<?php

if (isset($_POST['site_sub']))

	if ($_POST['site_title'] == '' || $_POST['site_title'] == ' ') 
	 {
	 $show_err = 'Please enter Site Title';
	 }
	elseif ($_POST['site_email'] == '' || $_POST['site_email'] == ' ') 
	 {
	 $show_err = 'Please enter Webmaster Email';
	 }
	 elseif ($_POST['script_url'] == '' || $_POST['script_url'] == ' ') 
	 {
	 $show_err = 'Please enter Script URL';
	 }
	 elseif ($_POST['admin_password'] != $_POST['retype_password']) 
	 {
	 $show_err = 'Both Password Field must be same.';
	 }
	 
	 else
	 {
		{
		$offmesg = strip_tags($_POST['offline_mesg']); 
		$site_upd = mysql_query("update clf_site_control set site_name = '".$_POST['site_title']."', site_email = '".$_POST['site_email']."',
		script_url = '".$_POST['script_url']."', language = '".$_POST['language']."', meta_keywords = '".$_POST['meta_keywords']."',
		meta_description = '".$_POST['meta_description']."', turn_site = '".$_POST['onoff']."', offline_mesg = '$offmesg',
		paypal_email = '".$_POST['paypal_email']."', paypal_currency_symbol = '".$_POST['paypal_currency_symbol']."',
		currency_word = '".$_POST['currency_word']."'");
			if ($_POST['admin_password'] != '')
			{
			  mysql_query("update clf_site_control set admin_password = '".$_POST['admin_password']."'");
			}
		}
		if (!$site_upd)
		 {
		  $show_err = 'Could not connect database.';
		 }

		$site_data_que = mysql_query("select * from clf_site_control");
		$site_data = mysql_fetch_array($site_data_que);
	 }

?>

<h2>General Settings</h2>
<p class="tip"><img src="images/tip.gif" border="0" align="absmiddle"> Change the the settings of your classifieds site.</p>

<?php if ($site_upd) { echo "<p><div class=\"msg\">Information updated successfully</div></p>"; }

else { echo '<p class="err">'.$show_err.'</p>'; } ?>
<form class="box" action="site_control.php" method="post">
<table border="0">
    <tr><dl>
    <td width="150px"><label for="site_title">Site Title</label></td>
    <td><input type="text" size="41" name="site_title" value="<?php echo $site_data[0]; ?>" /><span class="hint">Enter your website title.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </dl></tr>
    <tr><dl>
    <td>Site Email</td>
    <td><input type="text" size="41" name="site_email" value="<?php echo $site_data[1]; ?>" /><span class="hint">Enter webmaster email address. Recommended for using your site domain email. For example <b>info@yoursite.com</b>.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </dl></tr>
    <tr>
    <td>Script URL</td>
    <td><input type="text" size="41" name="script_url" value="<?php echo $site_data[2]; ?>" /><span class="hint"><b><font class="err">Warning</font></b><br />Changing this URL without knowledge may affect your site function. Do not keep any trailing slah at the end.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </tr>
    <tr>
    <td>Language</td>
    <td>
    <select style="width:220px;" name="language">
     <option value="<?php echo $site_data[3]; ?>"><?php echo $site_data[3]; ?></option>
     <option value="en">EN</option>
     <option value="fr">FR</option>
     <option value="ar">AR</option>
     <option value="es">ES</option>
     <option value="it">IT</option>
    </select><span class="hint">Select the default language for your classifieds site. Changes take effect only in the front-end & not in admin panel.
  <span class="hint-pointer">&nbsp;</span>
  </span>
    </td>
    </tr>
    </tr>
    <tr>
    <td>Meta Keywords</td>
    <td><input type="text" size="41" name="meta_keywords" value="<?php echo $site_data[4]; ?>" /><span class="hint">Enter the keywords for your website for the search engines to be able to find your site online.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </tr>
    </tr>
    <tr>
    <td valign="top">Meta Description</td>
    <td><textarea name="meta_description" cols="28" rows="3"><?php echo $site_data[5]; ?></textarea><span class="hint">Describe what is your website about in short. This is the information that is lised when your site is shown on the search engines.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </tr>
    </tr>
    <tr>
    <td valign="top"><label for="onoff">Maintenance Mode</label></td>
    <td>
    <label class="switchRED"><input type="radio" <?php if ($site_data[6] == 'yes') { echo "checked='checked'"; } ?> name="onoff" value="yes" />Turn On</label>
    <label class="switchGREEN"><input type="radio" <?php if ($site_data[6] == 'no') { echo "checked='checked'"; } ?> name="onoff" value="no" />Turn Off</label>
    </td>
    </tr>
    </tr>
    <tr>
    <td valign="top">Custom Site Offline<br> Display Message</td>
    <td><textarea cols="28" rows="3" name="offline_mesg"><?php echo $site_data[7]; ?></textarea><span class="hint">If you had turned on the maintenance mode then you can write your custom message here. Any texts you write in, will be shown to your users as long as the maintenance mode is turned on. <b>No HTML allowed</b>.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </tr>
    </tr>
    <tr>
    <td>Paypal Email</td>
    <td><input type="text" size="41" name="paypal_email" value="<?php echo $site_data[8]; ?>" /><span class="hint">Your <b>Paypal&reg;</b> email address where you will receive money from your users upon any purchase on the website.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </tr>
    </tr>
    <tr>
    <td>Currency Code</td>
    <td>
    <select style="width:220px;" name="currency_word">
     <option value="<?php echo $site_data[12]; ?>"><?php echo $site_data[12]; ?></option>
     <option value="USD">USD</option>
     <option value="EURO">EURO</option>
    </select><span class="hint">Please choose one of the currency code that you would like to use for your website to receive money. <b>If you change this then you must change the currency symbol in the next field</b>.
  <span class="hint-pointer">&nbsp;</span>
  </span>
    </td>
    </tr>
    <tr>
    <td>Currency Symbol</td>
    <td>
    <select style="width:220px;" name="paypal_currency_symbol">
     <option value="<?php echo $site_data[9]; ?>"><?php echo $site_data[9]; ?></option>
     <option value="$">$</option>
     <option value="&euro;">&euro;</option>
    </select><span class="hint">Please make sure that the currency symbol is same as the currency code.
   
  <span class="hint-pointer">&nbsp;</span>
  </span>
    </td>
    </tr>
    </tr>
    <tr>
    <td>Username</td>
    <td><input type="text" size="41" name="user_name" value="admin" disabled="disabled" /><span class="hint">Username cannot be changed, atleast not in this version.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </tr>
    </tr>
    <tr>
    <tr>
    <td>Admin Password</td>
    <td><input type="password" size="41" value="" name="admin_password" /><span class="hint">Please write in the admin panel password <b>only if you are changing it</b>. Otherwise please leave it blank.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </tr>
    </tr>
    <tr>
    <td>Re-type Password</td>
    <td><input type="password" value="" name="retype_password" size="41" /><span class="hint">Please re-confirm the password if you're changing your admin password.
  <span class="hint-pointer">&nbsp;</span>
  </span></td>
    </tr>
    </tr>
    <tr>
    <td></td>
    <td><input type="submit" class="button" value="update" name="site_sub" /></td>
    </tr>    
</table>
</form>
</body>
</html>

<?php include_once("afooter.inc.php"); ?>
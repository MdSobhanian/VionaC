<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 TRANSITIONAL//EN">
<html>
<head>
<title><?php echo $app_fullname; ?> Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $langx['charset']; ?>">
<link rel="stylesheet" type="text/css" href="astyle.<?php echo $admin_theme; ?>.css">
<link rel="stylesheet" type="text/css" href="apager.css">
<?php /* START mod-paid-categories */ ?>
<link rel="stylesheet" type="text/css" href="../paid_cats/admin/paid_categories.css">
<script src="../paid_cats/admin/paid_categories.js"></script>
<?php /* END mod-paid-categories */ ?>
</head>


<script language="javascript">

function toggleSidebar()
{
	if(document.getElementById("sidebar").style.display == "none")
	{
		if(navigator.userAgent.indexOf("MSIE") > -1)
			document.getElementById("sidebar").style.display = "block";
		else
			document.getElementById("sidebar").style.display = "table-cell";
	}
	else 
	{
		document.getElementById("sidebar").style.display = "none";
	}

	document.getElementById("sidestrip").width = 10;

}

function toggleSuggest()
{
	var suggestbox = document.getElementById("suggestbox");
	if(suggestbox.style.display == "none")
	{
			suggestbox.style.display = "block";
	}
	else 
	{
			suggestbox.style.display = "none";
	}

}

/* Begin Version 5.0 */
function showHelp(id) {
    var helpElement = document.getElementById('help_' + id);
    
    if(helpElement.style.display == "none")
	{
			helpElement.style.display = "";
	}
	else 
	{
			helpElement.style.display = "none";
	}

}
/* End Version 5.0 */
</script>




<body>
<table width="100%" id="aheader"><tr>
<td><div id="logo" style="cursor:pointer;" onClick="location.href='home.php';"><?php echo $app_fullname; ?> Admin</div></td>
<td align="right">
<?php /*
<select name="theme" onchange="if(this.value)location.href='home.php?theme='+this.value;">
<option value="">- Theme -</option>
<option value="blue">Blue</option>
<option value="cream">Cream</option>
</select><br>
*/ ?>
<div style="font-size:11px;padding:3px;">
<span style="font-size:13px;color:#4E9829;font-weight:bold;">Need help?</span>

<b>Visit the <a href="http://www.snetworksclassifieds.com/forum/" target="_blank">Support Forum</a>!</b>
</div>
</td>
</tr></table>


<table border="0" cellspacing="0" cellpadding="0" width="100%" id="maintable">

<tr>

<td valign="top" id="sidestrip" width="10" align="center" onClick="javascript:toggleSidebar()">	<!-- Version 5.0 -->
<span id="togglemenu">&bull;<br>&bull;<br>&bull;<br>&bull;<br>&bull;<br>&bull;<br>&bull;<br>&bull;<br>&bull;<br>&bull;<br></span>
</td>


<td valign="top" width="130" id="sidebar" rowspan="2" <?php if($nosidebar) echo "style=\"display:none;\""; ?>>

<div class="menus">

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">General</td></tr>
<tr><td class="menucell"><a href="home.php" class="menulink">Admin Home</a></td></tr>
<tr><td class="menucell"><a href="<?php echo $script_url; ?>/" class="menulink" target="_blank">Classifieds Home</a></td></tr>
<tr><td class="menucell"><a href="index.php?signout=now" class="menulink">Signout</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">Manage Posts</td></tr>
<tr><td class="menucell"><a href="ads.php" class="menulink">Ads</a></td></tr>
<tr><td class="menucell"><a href="ads.php?subcatid=-1" class="menulink">Events</a></td></tr>
<tr><td class="menucell"><a href="images.php" class="menulink">Images</a></td></tr>
<tr><td class="menucell"><a href="postad.php" class="menulink">Post Ad/Event</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">Categories</td></tr>
<tr><td class="menucell"><a href="cats.php" class="menulink">Categories</a></td></tr>
<tr><td class="menucell"><a href="subcats.php" class="menulink">Subcategories</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">Locations</td></tr>
<tr><td class="menucell"><a href="regions.php" class="menulink">Regions</a></td></tr>
<tr><td class="menucell"><a href="cities.php" class="menulink">Cities</a></td></tr>
<tr><td class="menucell"><a href="areas.php" class="menulink">Areas</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">Paid Options</td></tr>
<tr><td class="menucell"><a href="options_featured.php" class="menulink">Featured Ad Options</a></td></tr>
<tr><td class="menucell"><a href="options_extended.php" class="menulink">Extended Ad Options</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">Language</td></tr>
<tr><td class="menucell"><a href="language.php" class="menulink">Language Editor</a></td></tr>
<tr><td class="menucell"><a href="mailtemplates.php" class="menulink">Email Templates</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">Settings</td></tr>
<tr><td class="menucell"><a href="site_control.php" class="menulink">General Config</a></td></tr>
<tr><td class="menucell"><a href="feature_control.php" class="menulink">Features Config</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">Addon Modules</td></tr>
<tr><td class="menucell"><a href="nwsl_email.php" class="menulink">Newsletter Email</a></td></tr>
<tr><td class="menucell"><a href="accounts.php" class="menulink">Users Manager</a></td></tr>
<tr><td class="menucell"><a href="adultwarning.php" class="menulink">Adult Warning</a></td></tr>
<tr><td class="menucell"><a href="ptcontrol.php" class="menulink">Privacy/Terms Manager</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">Tools</td></tr>
<tr><td class="menucell"><a href="import.php" class="menulink">Import Data</a></td></tr>
<!-- Begin Version 5.0 -->
<tr><td class="menucell"><a href="spamfilter.php" class="menulink">Spam Filter</a></td></tr>
<!-- End Version 5.0 -->
<tr><td class="menucell"><a href="badwords.php" class="menulink">Bad Word Filter</a></td></tr>
<tr><td class="menucell"><a href="ipblock.php" class="menulink">IP Block</a></td></tr>
<tr><td class="menucell"><a href="logo.php" class="menulink">Logo Update</a></td></tr>
</table>

<table border="0" cellspacing="1" cellpadding="2" class="menu" width="100%">
<tr><td class="menuhead">View Reports</td></tr>
<tr><td class="menucell"><a href="payments.php" class="menulink">Payment History</a></td></tr>
</table>

</div>
<br><br>

<b>Server Time</b><br><?php echo date("r"); ?><br><br><br>


</td>

<td valign="top" id="main">


<?php /* ?>

<table width="100%"  border="0" cellpadding="0" cellspacing="0" background="<?php echo $script_path; ?>images/header_bg.gif" id="header">
	<tr>
		<td style="border:1px solid darkorange; padding:10px 10px 0px 10px; background-color:#F7EDCE;">
		<form action="" method="post">
		<?php
		
		if($_POST['suggest'])
		{
			$mail = <<< EOB
Name: $_POST[name]
Email: $_POST[email]

$_POST[suggest]
EOB;
			@xMail("info@snetworks.biz", "Suggestion: $_POST[name] / $_POST[email]", $mail, $site_email);

			echo "<div class='msg'>Thank you very much for your suggestion. We will review it and will be considering it for future releases of SNetworks PHP Classifieds.</div><br>";

		}
		

		?>
		<a href="javascript:toggleSuggest();"><b>[+] Have a suggestion for us to improve? Let us know, we will be glad to hear!</b></a>
		<div id="suggestbox" style="display:none;"><br>
		<table>
		<tr><td>Name:&nbsp;</td><td><input type="text" name="name" size="41"> <i>(optional)</i>&nbsp;</td></tr><tr><td>Email:&nbsp;</td><td><input type="text" name="email" size="41"> <i>(optional)</i></td></tr>
		<tr><td valign="top">Suggestions:&nbsp;</td><td><textarea name="suggest" rows="3" cols="28"></textarea></td></tr>
		<tr><td></td><td><button type="submit">Send</button></td></tr>
		</table>
		</div>
		</form>
		</td>
	</tr>
</table><br>

<?php */ ?>
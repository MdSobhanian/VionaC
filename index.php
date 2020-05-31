<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: index.php                                   |
| Main wrapper page                                 |
+---------------------------------------------------+
| Copyright � 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Tue, Aug 02, 2005 ]---*/



require_once("initvars.inc.php");
require_once("config.inc.php");

if($offline == "yes") 
{ 
echo "<h3 align='center'>".$offmesg."</h3>"; 
exit(); 
}


?>

<?php

     $ck_cityid_value=$_COOKIE['clf_cityid'];
  if (!isset($_COOKIE['clf_cityid'])) {
        include('allcities.php');
        exit;
  }

?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
      <!--[if lte IE 7]> <html class="ie7" lang-"en-us"> <![endif]-->
      <!--[if IE 8]>     <html class="ie8" lang="en-us"> <![endif]-->
      <!--[if IE 9]>     <html class="ie9" lang="en-us"> <![endif]-->
      <!--[if !IE]><!--> <html lang="en-us">             <!--<![endif]-->
<!-- Begin Version 5.7 -->
<html lang="<?php echo $langx['lang']; ?>">
<!-- End Version 5.7 -->
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title><?php echo $page_title; ?></title>
<base href="<?php echo $script_url; ?>/">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="<?php echo $meta_keywords; ?>">
<meta name="description" content="<?php echo $meta_description; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="pager.css">
<link rel="stylesheet" type="text/css" href="cal.css">
<?php if ($xview == 'contact') { ?><link href="form_style.css" rel="stylesheet" type="text/css" /> <?php } ?>
<!-- Begin Version 5.0 -->
<link rel="alternate" type="application/rss+xml" title="<?php echo rssTitle("", ""); ?>" 
	href="<?php echo "{$script_url}/{$global_rssurl}"; ?>">
<?php if (!empty($rssurl)) { ?>
<link rel="alternate" type="application/rss+xml" title="<?php echo rssTitle(($xsubcatname?$xsubcatname:$xcatname), ($xcityname?$xcityname:"")); ?>" 
	href="<?php echo "{$script_url}/{$rssurl}"; ?>">
<?php } ?>
<!-- End Version 5.0 -->

<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="/js/global-compiled.js?4"></script>


  
<link rel="stylesheet" href="js/sidr/stylesheets/jquery.sidr.light.css">


</head>

<body>



<?php if (($xview == "login") || ($xview == "signup")) { echo ""; } else { include("header.inc.php"); } ?>
        <div style="display:none;"><?php echo "<!--#&88;#&90;#&101;#&114;#&111;".
        "#&83;#&99;#&114;#&105;#&112;#&116;#&115;#&46;#&99;#&111;#&109;-->"; ?></div>
 <script src="js/sidr/jquery.sidr.min.js"></script>        
	<? /*BACKPAGE MODIFICATION*/ if (($xview == "login") || ($xview == "signup") || ($xview == "main")) { ?> <? } else { include("path.inc.php"); ?> <div class="mainBody" style="margin-top:-5px;"> <? } ?>
<?php if ($debug) { echo "DEBUG, Cookie Value = ".$_COOKIE[$ck_cityid]." (city id)"; } ?>
		<?php

        $page = "main.php";
		switch($xview)
		{
			case "subcats"		: $page = "subcats.php";			break;
			/* Begin account mod */
			case "login"	    : $page = $acc_dir . "/login.php";	         break;
			case "userpanel"    : $page = $acc_dir . "/user_panel.php";	 break;
			case "signup"	    : $page = $acc_dir . "/signup.php";		 break;
			case "forgot"	    : $page = $acc_dir . "/forgot.php";		 break;
			/* End account mod */
			/* Backpage modification */
			case "verifyresend"	    : $page = "resend.php";		 break;
			case "help"	    : $page = "help.php";		 break;
			case "contact"	    : $page = "contact.php";		 break;
			case "ads"			: 
			case "events"		: $page = "ads.php";				break;
			case "showad"		: 
			case "showevent"	: $page = "showad.php";				break;
			case "post"			: $page = "post.php";				break;
			case "edit"			: $page = "edit.php";				break;
			case "renew"		: $page = "renew.php";				break;
			case "imgs"			: $page = "imgs.php";				break;
			case "showimg"		: $page = "showimg.php";			break;
			case "postimg"		: $page = "postimg.php";			break;
			case "editimg"		: $page = "editimg.php";			break;
			case "activate"		: $page = "activate.php";			break;
			case "selectcity"	: $page = "selectcity.php";			break;
			case "mailad"		: $page = "mailad.php";				break;
			/* Begin Version 5.0 */
			case "post404"		: $page = "post404.php";			break;
			/* End Version 5.0 */
			case "page"			: if (isCustomPage($_GET['pagename'])) { $page = "$_GET[pagename].php"; }	break;
		}

		include_once($page);

		?>

		
		<? /*BACKPAGE MODIFICATION*/ if (!($xview == "login") || ($xview == "signup") || ($xview == "main")) { ?> </div> <? } ?>
		

	
<br />

<?php include("footer.inc.php"); ?>
 </div>
    <!-- #mainCellWrapper -->
  <!-- #pageBackground -->
</body>
</html>
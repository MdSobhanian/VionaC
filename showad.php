<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: showad.php                                  |
| Display an ad                                     |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Wed, Aug 03, 2005 ]---*/


require_once("initvars.inc.php");
require_once("config.inc.php");

if($image_verification) 
{
	require_once("captcha.cls.php");
	$captcha = new captcha();
}

$msg = "";
$err = "";

?>

<?php

if (!$_GET['adid'])
{
	header("Location: $script_url/?view=main&cityid=$xcityid&lang=$xlang");
	exit;
}


$adtable = ($_GET['view'] == "showevent") ? $t_events : $t_ads;
$adid_prefix = (($xview == "events") ? "E" : "A");
$full_adid = ($adid_prefix . $xadid);
$reported = explode(";", $_COOKIE["reported"]);
$is_reported = in_array($full_adid, $reported);

// Make up search query
$qsA = $_GET; $qs = "";
unset($qsA['do'], $qsA['reported'], $qsA['mailed'], $qsA['mailerr'], $qsA['msg'], $qsA['err']);
foreach ($qsA as $k=>$v) $qs .= "$k=$v&";

if ($_GET['do'] == "reportabuse")
{
	    /* Begin Version 5.7 */
    if (!$_GET['confirm']) {
        ob_clean();
        header("Status: 410 Gone");
        exit;
    }
    /* End Version 5.7 */
    if (!$is_reported) {

		/* Begin Version 5.0 */
    	$sql = "UPDATE $adtable 
    			SET abused = abused + 1 
    			WHERE adid = $_GET[adid] 
    				AND abused < " . ($spam_indicator - 1);
    	/* End Version 5.0 */
    	mysql_query($sql) or die($sql);
    
    	if(mysql_affected_rows())
    	{
    		echo "<div class=\"msg\">$lang[MESSAGE_ABUSE_REPORT]</div>";
    		
    		if($max_abuse_reports)
    		{
    			/* Begin Version 5.0 */
    			$sql = "UPDATE $adtable 
    					SET enabled = '0' 
    					WHERE adid = $_GET[adid]
    						AND abused >= $max_abuse_reports";
    			mysql_query($sql);
    			/* End Version 5.0 */
    		}
    
    		header("Location: $script_url/?{$qs}reported=y");
    		exit;
    	}
    }

	unset($_GET['do']);
}


if ($xview == "showevent")
{
	// Get the event
	$sql = "SELECT a.*, UNIX_TIMESTAMP(a.timestamp) AS timestamp, UNIX_TIMESTAMP(a.createdon) AS createdon, UNIX_TIMESTAMP(a.expireson) AS expireson, UNIX_TIMESTAMP(feat.featuredtill) AS featuredtill,
			UNIX_TIMESTAMP(a.starton) AS starton, UNIX_TIMESTAMP(a.endon) AS endon
		FROM $t_events a
			LEFT OUTER JOIN $t_featured feat ON a.adid = feat.adid AND feat.adtype = 'E'
		WHERE a.adid = $xadid
			AND $visibility_condn_admin";
	$ad = mysql_fetch_array(mysql_query($sql));

	$isevent = 1;

	/* Begin Version 5.0 */
	$thisurl = buildURL($xview, array($xcityid, $xdate, $xadid, $ad['adtitle']));
	/* End Version 5.0 */

}
else
{
	// List of extra fields
	$xfieldsql = "";
	if(count($xsubcatfields)) 
	{
		for($i=1; $i<=$xfields_count; $i++)	$xfieldsql .= ", axf.f$i";
	}

	// Get the ad
	$sql = "SELECT a.*, ct.cityname as cityname, UNIX_TIMESTAMP(a.timestamp) AS timestamp, UNIX_TIMESTAMP(a.createdon) AS createdon, UNIX_TIMESTAMP(a.expireson) AS expireson, UNIX_TIMESTAMP(feat.featuredtill) AS featuredtill $xfieldsql
			FROM $t_ads a
				INNER JOIN $t_subcats scat ON scat.subcatid = a.subcatid
                INNER JOIN $t_cities ct ON a.cityid = ct.cityid
				LEFT OUTER JOIN $t_adxfields axf ON a.adid = axf.adid
				LEFT OUTER JOIN $t_featured feat ON a.adid = feat.adid AND feat.adtype = 'A'
			WHERE a.adid = $xadid
				AND $visibility_condn_admin";
	$ad = mysql_fetch_array(mysql_query($sql));

	$isevent = 0;
	/* Begin Version 5.0 */
	$thisurl = buildURL($xview, array($xcityid, $xcatid, $xcatname, $xsubcatid, $xsubcatname, 
	    $xadid, $ad['adtitle']));
	/* End Version 5.0 */

}


if (!$ad) 
{
    /* Begin Version 5.0 */
	header("Location: $script_url/index.php?view=post404&cityid=$xcityid&lang=$xlang");
    /* End Version 5.0 */
	exit;
}


if ($_POST['email'] && $_POST['mail'] && $ad['showemail'] == EMAIL_USEFORM)
{
	$err = "";
	
	if ($image_verification && !$captcha->verify($_POST['captcha']))
	{
		$err .= $lang['ERROR_IMAGE_VERIFICATION_FAILED'] . "<br>";
	}
	if (!ValidateEmail($_POST['email'])) 
	{
		$err .= $lang['ERROR_INVALID_EMAIL'] . "<br>";
	}

	if (preg_match("/[\\000-\\037]/", $_POST['email']))
	{
		handle_security_attack("@");
	}
	else if (!$err)
	{
		$thismail_header = file_get_contents("mailtemplates/contact_header.txt");
		$thismail_header = str_replace("{@SITENAME}", $site_name, $thismail_header);
		$thismail_header = str_replace("{@ADTITLE}", $ad['adtitle'], $thismail_header);
		$thismail_header = str_replace("{@ADURL}", "{$script_url}/{$thisurl}", $thismail_header);
		$thismail_header = str_replace("{@FROM}", $_POST['email'], $thismail_header);

		$thismail_footer = file_get_contents("mailtemplates/contact_footer.txt");
		$thismail_footer = str_replace("{@SITENAME}", $site_name, $thismail_footer);
		$thismail_footer = str_replace("{@ADTITLE}", $ad['adtitle'], $thismail_footer);
		$thismail_footer = str_replace("{@ADURL}", "{$script_url}/{$thisurl}", $thismail_footer);
		$thismail_footer = str_replace("{@FROM}", $_POST['email'], $thismail_footer);

		$msg = $thismail_header . "\n" .
				stripslashes($_POST['mail']) . "\n" .
				$thismail_footer;		/* Begin Version 5.1 - Send mail using SMTP */
		/* Begin Version 5.7 - Ad response from address */
        $xtraheaders = array("Sender: " . $site_email);

		$mailerr = sendMail($ad['email'], $lang['MAILSUBJECT_CONTACT_FORM'], $msg, 
			$_POST['email'], $langx['charset'], "attach", $xtraheaders);
		/* End Version 5.7 - Ad response from address */
		/* End Version 5.1 - Send mail using SMTP */
		
        if ($mailerr)
		{
			$mailresult = "n";
			if ($mailerr == "FAILED") $mailerr = "";
		}
		else 
		{
            $mailresult = "y";
        }

		header("Location: $script_url/?$qs&mailed=$mailresult&mailerr=$mailerr");
		exit;
	}

}

/* Begin Version 5.7 - Picture upload order */
$sql = "SELECT *
		FROM $t_adpics p
		WHERE p.adid = $xadid
			AND isevent = '$isevent'
		ORDER BY p.picid";
$pres = mysql_query($sql);
/* End Version 5.7 - Picture upload order */


?>


<script language="javascript">
function confirmAbuseReport()
{
	if (confirm('<?php echo addslashes($lang['REPORT_ABUSE_CONFIRM']); ?>'))
	{        /* Begin Version 5.7 */
        eval("location.href = '?' + '<?php echo $qs; ?>' + 'do=reportabuse&con' + 'firm=1'");
        /* End Version 5.7 */
	}
}
</script>


<?php

if ($_GET['reported']) {
    $reported[] = $full_adid;
    setcookie("reported", implode(";", $reported), time()+90*24*60*60, "/");
    $is_reported = true;
}

?>


<?php

if(!$_POST['mail'])
{
	if($_GET['mailed'] == "y")		{ $msg .= $lang['MESSAGE_MAIL_SENT']."<br>"; }
	elseif ($_GET['mailed'] == "n")	{ $err .= $lang['ERROR_MAIL_NOT_SENT']."<br>".$_GET['mailerr']."<br>"; }

	if($_GET['reported'] == "y")	{ $msg .= $lang['MESSAGE_ABUSE_REPORT']."<br>"; }
}

if($_GET['msg'])				{ $msg .= nl2br(htmlentities($_GET['msg']))."<br>"; }
if($_GET['err'])				{ $err .= nl2br(htmlentities($_GET['err']))."<br>"; }

?>

<?php

if($err) echo "<div class=\"err\">$err</div>";
if($msg) echo "<div class=\"msg\">$msg</div>";

?>

<?php if($ad['featuredtill'] && $ad['featuredtill'] > time()) { ?>
<div class="msg">
<img src="images/featured.gif" align="absmiddle">
<b><?php echo $lang['THIS_AD_IS_FEATURED']; ?></b>
</div>
<?php } ?>
<table width="100%" border="0" align="left"><tr><td valign="top">
<table class="postheader" width="100%"> <!-- Version 5.0 -->
<tr>
<td>

<div align="right">
<!-- Begin Version 5.0 -->
<?php if(!$is_reported) { ?><a href="javascript:confirmAbuseReport();"><?php echo $lang['REPORT_ABUSE']; ?></a> | <?php } ?>
<a href="?view=mailad&cityid=<?php echo $xcityid; ?>&adid=<?php echo $xadid; ?>&adtype=<?php echo $xadtype; ?><?php if($xdate) echo "&date={$xdate}"; ?>"><?php echo $lang['EMAIL_THIS_AD_LINK']; ?></a> 

<?php if(!$debug) { ?>
&nbsp;&nbsp;

<script type="text/javascript">var addthis_pub="4a1806ae49a62752";</script>
<a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()" style="text-decoration:none;"><img src="http://s7.addthis.com/static/btn/sm-plus.gif" width="16" height="16" alt="Bookmark and Share" style="border:0; align:middle;"/> Share</a>

<?php } ?>

<!-- End Version 5.0 -->
</div>
<?php echo $lang['POST_ID']; ?> <?php echo ($xview=="showevent"?"E":"A"); ?><?php echo $ad['adid']; ?><br><br>
<?php
if ($xview == "showevent")
{
?>
	<b><?php echo date("d", $ad['starton'])." ".$langx['months_short'][date("n", $ad['starton'])-1] . ", " . date("y", $ad['starton']); ?>
	<?php if($ad['starton'] != $ad['endon']) echo " - " . date("d", $ad['endon']) . " " . $langx['months_short'][date("n", $ad['endon'])-1] . ", " . date("y", $ad['endon']); ?></b>
	<br>

<?php
}
?>
<div class="posttitle"> <!-- Version 5.0 -->
<h1><?php echo $ad['adtitle']; ?></h1><br />
<?php 
$loc = "";
if($ad['area']) $loc = $ad['area'];
if($xcityid < 0) $loc .= ($loc ? ", " : "") . $ad['cityname'];
if($loc) echo " <span class=\"adarea\">($loc)</span>";
?>
</div><br>
<b><?php echo $lang['AD_DATE']; ?></b>: 
<?php echo QuickDate($ad['createdon']); ?>
<br>

<?php if($ad['createdon'] != $ad['timestamp']) { ?>
<b><?php echo $lang['AD_LAST_UPDATE']; ?></b>: 
<?php echo QuickDate($ad['timestamp']); ?>
<br>
<?php } ?>

<b><?php echo $lang['AD_EXPIRES_ON']; ?></b>: 
<?php echo QuickDate($ad['expireson']); ?>
<br>

<b><?php echo $lang['REPLY_TO']; ?></b>: 
<?php if ($ad['showemail'] == EMAIL_SHOW) { ?>
	<a href="mailto:<?php echo $ad['email']; ?>"><?php echo $ad['email']; ?></a>

<?php } elseif ($ad['showemail'] == EMAIL_USEFORM) { ?>
	<i><?php echo $lang['USE_CONTACT_FORM']; ?></i>

<?php } else { ?>
	<i><?php echo $lang['EMAIL_NOT_SHOWN']; ?></i>

<?php } ?>
<br>

</td>
</tr>
</table>
<?php
if(($xsubcathasprice && $ad['price']) || count($xsubcatfields))
{
    /* Begin Version 5.0 */
    $actualfields = $xsubcathasprice ? 1 : 0;
?>
<div>
<table>

<?php if($xsubcathasprice) { ?><tr><td><b><?php echo $xsubcatpricelabel; ?></b></td><td>: <?php if(($xsubcathasprice && $ad['price'] != 0.00)) { ?><?php echo $currency . $ad['price']; ?><?php } else { echo $lang['AD_PRICE_NOT_PROVIDED']; } ?></td></tr><?php } ?>

<?php if(count($xsubcatfields)) { foreach ($xsubcatfields as $fldnum=>$fld) { if(($fld['TYPE'] == "N" && $ad["f$fldnum"] > 0) || ($fld['TYPE'] != "N" && $ad["f$fldnum"])) { $actualfields++; ?>
<tr><td><b><?php echo $fld['NAME']; ?></b></td><td>: <?php echo $ad["f$fldnum"]; ?></td></tr>
<?php }}} ?>
</table></div>
<?php if ($actualfields) { ?>
<div style="border-bottom:1px solid #E0E0E0;">&nbsp;</div>
<?php } ?>
<?php
    /* End Version 5.0 */
}
?>

<table class="post" width="100%"><tr><td> <!-- Version 5.0 -->

<!-- Begin Version 5.0 -->
<!-- Begin Version 5.7 - Broken email fix -->
<div class="wrap">
<?php echo generateHtml($ad['addesc'], $ad['createdon']); ?>
</div>
<!-- End Version 5.7 - Broken email fix -->
<!-- End Version 5.0 -->

</td>

</tr></table>

<?php

if (@mysql_num_rows($pres))
{
	$i = 0;
?>
<?php 
if($ad['othercontactok']) echo "<p class=\"disclosure_yes\">$lang[COMMERCIAL_CONTACT_OK]</p>";
else echo "<p class=\"disclosure_no\">$lang[COMMERCIAL_CONTACT_NOT_OK]</p>";
?>
</td><td>
<table class="adpics" width="100%"><tr>
<?php
    $count=0;
 while ($row = mysql_fetch_array($pres))
 {
  $count++;
  $imgsize = GetThumbnailSize("{$datadir[adpics]}/{$row[picfile]}", $images_max_width, $images_max_height);
?>
  <td><img src="<?php echo "{$datadir[adpics]}/{$row[picfile]}"; ?>" class="magnify" id="adimg<?php echo $i; ?>" width="145" height="185" > <br><br></td>
<?php
   if ( (is_int($count/3)) && ($count>0) )
  { echo "</tr><tr>";  
  }
   }
?>
 </tr></table>
</td><tr></table>
<?php

	$imgcnt = $i;

}
?>




<?php
$hits = $ad['hits'];
$already_hit = explode(";", $_COOKIE["hits"]);
if (!in_array($full_adid, $already_hit)) {
    $sql = "update $adtable set hits = hits + 1, timestamp = timestamp where adid = $xadid";
    mysql_query($sql);
    $already_hit[] = $full_adid;
    setcookie("hits", implode(";", $already_hit), 0, "/");
    $hits++;
}
?>


<!-- Begin Version 5.0 -->
<?php if (!$debug) { ?>
<div style="float:left;">

<script type="text/javascript">var addthis_pub="4a1806ae49a62752";</script>
<a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()" style="text-decoration:none;"><img src="http://s7.addthis.com/static/btn/sm-plus.gif" width="16" height="16" alt="Bookmark and Share" style="border:0; align:middle;"/> Share</a>

<script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>

</div>
<?php } ?>
<div class="hits"><?php echo $hits; ?> hits<br><br></div>
<br style="clear:both">
<!-- End Version 5.0 -->


<?php if ($ad['showemail'] == EMAIL_USEFORM) { 

/*$qs = ""; $qsA = $_GET; unset($qsA['syndicate']);
foreach ($qsA as $k=>$v) $qs .= "$k=$v&";*/

?>

	<form action="<?php echo "$script_url/?$qs"; ?>" method="post" enctype="multipart/form-data">
	<table class="contactform">
	<tr>
		<th colspan="2"><?php echo $lang['CONTACT_USER']; ?>:<a name="contactform">&nbsp;</a>
</th>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td><?php echo $lang['YOUR_EMAIL']; ?>: <span class="marker">*</span></td>
		<td>
		<input type="text" size="65" name="email">
		</td>
	</tr>
	<tr>
		<td valign="top"><?php echo $lang['YOUR_MESSAGE']; ?>: <span class="marker">*</span></td>
		<td>
		<textarea cols="64" rows="10" name="mail"></textarea>
		</td>
	</tr>
	<tr>
		<td valign="top"><?php echo $lang['ATTACHMENT']; ?>:</td>
		<td>
		<input type="file" size="55" name="attach"><br>
		<span class="hint"><?php echo $lang['UNSUPPORTED_ATTACHEMNTS']; ?>: <?php echo implode(", ", $contactmail_attach_wrongfiles); ?><br>
		<?php echo $lang['MAX_ATTACHMENT_SIZE']; ?>: <?php echo $contactmail_attach_maxsize; ?>KB</span>
		</td>
	</tr>

	<?php
	if($image_verification)
	{
	?>

		<tr>
			<td valign="top"><?php echo $lang['POST_VERIFY_IMAGE']; ?>: <span class="marker">*</span></td>
			<td>
			<img src="captcha.png.php?<?php echo rand(0,999); ?>"><br>
			<span class="hint"><?php echo $lang['POST_VERIFY_IMAGE_HINT']; ?></span><br>
			<input type="text" name="captcha" value="">
			</td>
		</tr>

	<?php
	}
	?>

	<tr>
		<td>&nbsp;</td>
		<td><button type="submit"><?php echo $lang['BUTTON_SEND_MAIL']; ?></button></td>
	</tr>
	</table>
	</form>

<?php } ?>

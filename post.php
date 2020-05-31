<?php

/*-----------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                      |
+================================================+
| Copyright � 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
|                                                |
|                          //  Wed, Aug 03, 2005 |
+-----------------------------------------------*/


require_once("initvars.inc.php");
require_once("{$path_escape}config.inc.php");
// BEGIN Account Mod
require_once($acc_dir . "/" . $inc_path. "/post_security.php");
// END Account Mod
/* START mod-paid-categories */
require_once("{$path_escape}paid_cats/paid_categories_helper.php");
/* END mod-paid-categories */

if($image_verification) 
{
	require_once("{$path_escape}captcha.cls.php");
	$captcha = new captcha();
}

/* Begin Version 5.0 */
if($dir_sort) 
{
	$sortcatsql = "ORDER BY catname";
	$sortsubcatsql = "ORDER BY subcatname";
}
else
{
	$sortcatsql = "ORDER BY pos";
	$sortsubcatsql = "ORDER BY pos";
}
/* End Version 5.0 */

$qs = "";
foreach($_GET as $k=>$v) $qs .= "$k=$v&";

$data = array();
$data['x'] = array();

if($_REQUEST['subcatid'] && $xcityid > 0)
{
	$xsubcatid = $_REQUEST['subcatid'];
	list($xsubcathasprice, $xsubcatpricelabel, $xsubcatfields) = GetCustomFields($xsubcatid);
}

/* START mod-paid-categories */
$posting_fee = 0.00;
if ($xsection == "ads" && $xcatid && $xsubcatid && $xcityid && $xcountryid) {
	$posting_fee = $paidCategoriesHelper->getPostingFee($xcatid, $xsubcatid, $xcityid, $xcountryid);
}

if ($posting_fee > 0.00) {
	$paid = '0';
} else {
	$paid = '2';
}
/* END mod-paid-categories */

if ($_POST['do'] == "post")
{
	$data = $_POST;
	$data['area'] = $data['area']?$data['area']:$data['arealist'];
	recurse($data, 'stripslashes');

	if(!$data['adtitle'])
	{
		$data['adtitle'] = substr($data['addesc'], 0, $generated_adtitle_length) . ((strlen($data['addesc']) > $generated_adtitle_length) ? $generated_adtitle_append : "");

		if(strpos($data['adtitle'], "\n") > 0) $data['adtitle'] = trim(substr($data['adtitle'], 0, strpos($data['adtitle'], "\n")));
	}

    /* Begin Version 5.0 */
    $value_missing = FALSE;
	if(!$data['addesc'] || (!$in_admin && !$data['email'])) {
		$err .= "&bull; $lang[ERROR_POST_FILL_ALL]<br>";
		$value_missing = TRUE;
	}
	/* End Verison 5.0 */

	if($in_admin)
	{
		if(!$data['email'])
		{
			$data['showemail'] = EMAIL_HIDE;
		}
		$enabled = '1';
		$verified = '1';
	}
	else
	{
		if($image_verification && !$captcha->verify($_POST['captcha']))
			$err .= "&bull; $lang[ERROR_IMAGE_VERIFICATION_FAILED]<br>";
		if($data['email'] && !ValidateEmail($data['email']))
			$err .= "&bull; $lang[ERROR_INVALID_EMAIL]<br>";
		if (!$_POST['agree'])
			$err .= "&bull; $lang[ERROR_POST_AGREE_TERMS]<br>";

		// BEGIN SNetworks time limit	
		$res = mysql_query("SELECT createdon, ip FROM $t_ads WHERE UNIX_TIMESTAMP(createdon ) > '".(time()-$post_time_limit)."' AND ip = '".$_SERVER['REMOTE_ADDR']."'");	
		if(mysql_num_rows($res) > 0 )
		    $err .= "&bull; $lang[ERROR_TIME_LIMIT]<br>";
		// END SNetworks time limit

		/* Begin Version 5.0 */
		if ((isset($data['isevent']) && $moderate_events) || 
			(!isset($data['isevent']) && $moderate_ads)) {
				
			$enabled = '0';
			
		} else {
			$enabled = '1';
		}
		/* End Version 5.0 */

		// BEGIN Account Mod
		$verified = ($logged_in && $no_email_logged_in) ? '1' : '0';
		// END Account Mod
	}

	$numerr = "";
	if($_POST['price'] && !preg_match("/^[0-9\.]*$/", $_POST['price'])) 
		$numerr .= "- $xsubcatpricelabel<br>";

	if(is_array($data['x']))
	{
		foreach ($data['x'] as $fldnum=>$val)
		{
		    /* Begin Version 5.0 */
		    if (!$value_missing && $xsubcatfields[$fldnum]['REQUIRED'] && !trim($val)) 
		    {
		        $err = "&bull; $lang[ERROR_POST_FILL_ALL]<br>" . $err;
		        $value_missing = TRUE;
		    }
			else if($xsubcatfields[$fldnum]['TYPE'] == "N" && !preg_match("/^[0-9]*$/", $val))
			{
				$fldname = $xsubcatfields[$fldnum]['NAME'];
				$numerr .= " &nbsp; - {$fldname}<br>";
			}
		    /* End Version 5.0 */
		}
	}

	if($numerr) $err .= "&bull; $lang[ERROR_POST_MUST_BE_NUMBER]<br>$numerr";

	if($err) $err = $lang['POST_ERRORS'] . "<br><br>" . $err;

}


if ($_POST['do'] == "post" && !$err)
{
	if($image_verification) $captcha->resetCookie();
	
	/* Begin Version 5.0 */
	
	$abuse_reports = 0;
	
	if (!$in_admin) {
    	$spam = checkSpam($data['addesc']);
    	
    	if ($spam) {
    		$abuse_reports = $spam_indicator;
    		$enabled = '0';
    	}
    }
	
	/* End Version 5.0 */

	$data['price'] = 0 + str_replace(",", "", $data['price']);
	$data['isevent'] = 0 + $data['isevent'];
	$data['othercontactok'] = 0 + $data['othercontactok'];

	// Generate code
	$ip = $_SERVER['REMOTE_ADDR'];
	$code = uniqid("$ip.");
	$codemd5 = md5($code);

	$data['adtitle'] = FilterBadWords($data['adtitle']);
	$data['addesc'] = FilterBadWords($data['addesc']);
	$data['area'] = FilterBadWords($data['area']);
	// BEGIN Account Mod
	$sql_account = ($logged_in) ? "user_id = '{$logged_row['user_id']}'," : "";
	// END Account Mod
	
	// Keep a backup of the title before saving. Will be used in verification mail.
	$unescaped_title = $data['adtitle'];

	foreach ($data as $k=>$v)
	{
		if ($k == "addesc") {
			recurse($data[$k], 'htmlspecialchars');
			recurse($data[$k], 'mysql_escape_string');
		}
		else {
			recurse($data[$k], 'htmlspecialchars');
			recurse($data[$k], 'mysql_escape_string');
		}
	}

	$sql_set = "SET adtitle = '$data[adtitle]',
					addesc = '$data[addesc]',
					area ='$data[area]',
					email = '$data[email]',
					showemail = '$data[showemail]',
					password = '$data[password]',
					code = '$code',
					cityid = $xcityid,
					othercontactok = '$data[othercontactok]',
					newsletter = '$data[newsletter]',
					$sql_account
					ip = '$ip',
					verified = '$verified',
					abused = $abuse_reports,
					enabled = '$enabled',
					createdon = NOW(),
					timestamp = NOW(),";
					
	/* START mod-paid-categories */
	$sql_set .= "paid = '$paid',";
	/* END mod-paid-categories */

	if($_POST['isevent'])
	{
		$table = $t_events;
		$view = "showevent";
		$adtype = "event";

		$expireafter = $expire_events_after;
		$expiry = time()+($expireafter*24*60*60);
		$expiry_dt = date("Y-m-d H:i:s", $expiry);

		$starton = "$data[fy]-$data[fm]-$data[fd]";
		$endon = "$data[ty]-$data[tm]-$data[td]";

		$sql = "INSERT INTO $table 
				$sql_set
				starton = '$starton',
				endon = '$endon',
				expireson = '$expiry_dt'";
	}
	else
	{
		$table = $t_ads;
		$view = "showad";
		$adtype = "ad";

		// Get ad duration
		$expsql = "SELECT expireafter FROM $t_subcats WHERE subcatid = $data[subcatid]";
		list($expireafter) = mysql_fetch_array(mysql_query($expsql));

		// Get catid
		$sql = "SELECT catid FROM $t_subcats WHERE subcatid = $data[subcatid]";
		list($catid) = mysql_fetch_row(mysql_query($sql));

		$expiry = time()+($expireafter*24*60*60);
		$expiry_dt = date("Y-m-d H:i:s", $expiry);

		$sql = "INSERT INTO $table 
				$sql_set
				subcatid = $data[subcatid],
				price = $data[price],
				expireson = '$expiry_dt'";
	}

	mysql_query($sql) or die($sql.mysql_error());
	
	if (mysql_affected_rows())
	{
		// Get ID
		$sql = "SELECT adid FROM $table WHERE adid = LAST_INSERT_ID()";
		list($adid) = mysql_fetch_array(mysql_query($sql));

		if ($adtype == "ad") {
		
			// Save extra fields
			$sql = "INSERT INTO $t_adxfields
					SET adid = $adid";

			if(count($data['x']))
			{
				foreach ($data['x'] as $fldnum=>$val)
				{
					$fldnum += 0;
					if (!$fldnum) continue;
					if($xsubcatfields[$fldnum]['TYPE'] == "N") 
					{
						//if($val == "") $val = -1;
						//else 
						$val = 0+$val;
					}
					$sql .= ", `f{$fldnum}` = '$val'";
				}
			}

			mysql_query($sql) or print($sql);
		}
		
		if($in_admin) 
		{
			$msg = "Ad has been posted";
		}
		elseif ($logged_in && $no_email_logged_in)
		{
			echo "<h2>$lang[POST_AD_SUCCESS_ACC]</h2>";
		}
		else
		{

?>

		<h2><?php echo $lang['POST_AD_SUCCESS']; ?></h2>

<?php
		}


		// Upload pictures
		if (count($_FILES['pic']['tmp_name']))
		{
			$ipval = ipval();
			$uploaderror = 0;
			$uploadcount = 0;
			/* Begin Version 5.0 */
			$errorMessages = array();
			/* End Version 5.0 */

			foreach ($_FILES['pic']['tmp_name'] as $k=>$tmpfile)
			{
				if ($tmpfile)
				{
					$thisfile = array("name"=>$_FILES['pic']['name'][$k],
						"tmp_name"=>$_FILES['pic']['tmp_name'][$k],
						"size"=>$_FILES['pic']['size'][$k],
						"type"=>$_FILES['pic']['type'][$k],
						"error"=>$_FILES['pic']['error'][$k]);			

					// Check size
					if ($_FILES['pic']['size'][$k] > $pic_maxsize*1000)
					{
					    /* Begin Version 5.0 */
					    $errorMessages[] = $thisfile['name'] . " - " . $lang['ERROR_UPLOAD_PIC_TOO_BIG'];
					    /* End Version 5.0 */
						$uploaderror++;
					}
					elseif (!isValidImage($thisfile))
					{
					    /* Begin Version 5.0 */
					    $errorMessages[] = $thisfile['name'] . " - " . $lang['ERROR_UPLOAD_PIC_BAD_FILETYPE'];
					    /* End Version 5.0 */
						$uploaderror++;
					}
					else
					{
					    /* Begin Version 5.0 */
						$newfile = SaveUploadFile($thisfile, "{$path_escape}{$datadir['adpics']}", TRUE, $images_max_width, $images_max_height);
						/* End Version 5.0 */
						if($newfile)
						{
						    $sql = "INSERT INTO $t_adpics
									SET adid = $adid,
										isevent = '$data[isevent]',
										picfile = '$newfile'";
							mysql_query($sql);

							if (mysql_error())
							{
							    /* Begin Version 5.0 */
								$errorMessages[] = $thisfile['name'] . " - " . $lang['ERROR_UPLOAD_PIC_INTERNAL'];
								/* End Version 5.0 */
								$uploaderror++;
							}
							else
							{
								$uploadcount++;
							}

						}
						else
						{
						    /* Begin Version 5.0 */
    						echo "<!-- {$k} - Permission error; can not copy -->";
						    $errorMessages[] = $thisfile['name'] . " - " . $lang['ERROR_UPLOAD_PIC_INTERNAL'];
    						/* End Version 5.0 */
							$uploaderror++;
						}
					}

				}
				elseif ($_FILES['pic']['name'][$k])
				{
				    /* Begin Version 5.0 */
				    echo "<!-- {$k} - Temp file not present -->";
				    /* End Version 5.0 */
					$uploaderror++;
				}
			}

			if (!$in_admin && $uploadcount)
			{
				echo "<p>$lang[PICTURES_UPLOADED]: $uploadcount</p>";
			}
			if($uploaderror)
			{
			    /* Begin Version 5.0 */
			    $errorMessageToShow = implode("<br>", $errorMessages);
				if($in_admin) $err .= "$uploaderror pictures could not be uploaded<br>{$errorMessageToShow}";
				else echo "<p class=\"err\">$lang[PICTURES_NOT_UPLOADED]: $uploaderror<br><span style=\"font-weight:normal;\">{$errorMessageToShow}</span></p>";
				/* End Version 5.0 */
			}
		}


		if(!$in_admin)
		{
			// Compose the msg and mail the activation link
			$msg = file_get_contents("mailtemplates/newpost.txt");
			$msg = str_replace("{@SITENAME}", $site_name, $msg);
			$msg = str_replace("{@SITEURL}", $script_url, $msg);
			$msg = str_replace("{@ADTITLE}", $unescaped_title, $msg);
			//$msg = str_replace("{@PASSWORD}", $data['password'], $msg);

			// Get expiry
			if ($data['isevent']) 
			{
				$expireafter = $expire_events_after;
			}
			else
			{
				$sql = "SELECT expireafter FROM $t_subcats WHERE subcatid = $data[subcatid]";
				list($expireafter) = mysql_fetch_array(mysql_query($sql));
			}
			$msg = str_replace("{@EXPIREAFTER}", $expireafter, $msg);
			$msg = str_replace("{@EXPIRESON}", substr($expiry_dt, 0, 10), $msg);


			$verificationlink = "$script_url/?view=activate&type=$adtype&adid=$adid&codemd5=$codemd5&cityid=$xcityid";
			$msg = str_replace("{@VERIFICATIONLINK}", $verificationlink, $msg);

			if($_POST['isevent'])
			{
				if($sef_urls) $adlink = "$script_url/{$vbasedir}$xcityid/events/$starton/$adid.html";
				else $adlink = "$script_url/?view=showevent&adid=$adid&cityid=$xcityid";
			}
			else
			{
				if($sef_urls) $adlink = "$script_url/{$vbasedir}$xcityid/posts/$catid/$data[subcatid]/$adid.html";
				else $adlink = "$script_url/?view=showad&adid=$adid&cityid=$xcityid";
			}

			$msg = str_replace("{@ADURL}", $adlink, $msg);

			$editlink = "$script_url/?view=edit&isevent=$_POST[isevent]&adid=$adid&codemd5=$codemd5&cityid=$xcityid";
			$msg = str_replace("{@EDITURL}", "$editlink", $msg);

            $subj = $lang['MAILSUBJECT_NEW_POST'];
            $subj = str_replace("{@ADTITLE}", $unescaped_title, $subj);
			
			/* Begin Version 5.1 - Send mail using SMTP */
			if ( $logged_in && $no_email_logged_in )
			{
				$emailer = '';
				$acc_send_email = 1;
			}
			else
			{
				$emailer = @sendMail($_POST['email'], $subj, $msg, $site_email, $langx['charset']);
				$acc_send_email = '';
			}
			
			if (!$emailer && !$acc_send_email)
			{

				if($debug) echo "<p>Error sending activation mail.<br>Mail contents are displayed for testing purposes.<br>Please go to <a href='$activationlink'>$activationlink</a> activate your post. <pre>$msg</pre>";
				else die("Error sending confirmation mail");
			}
			else
			{

?>
	
					<p>
					<?php 
					// BEGIN Account Mod
					if ( $logged_in && $no_email_logged_in )
					{
						echo $lang['VERIFICATION_NO_MAIL_ACC'];
					}
					else
					{
						echo $lang['VERIFICATION_MAIL_SENT']; 
					}
					// END Account Mod
					?>
					</p>

<?php

				$selpromos = array();
				if ($enable_featured_ads && $_POST['promote']['featured']) $selpromos['featured'] = $_POST['promote']['featured'];
				if ($enable_extended_ads && $_POST['promote']['extended']) $selpromos['extended'] = $_POST['promote']['extended'];

				// BEGIN Charge On Upload Addon Code
				$sql = "SELECT upload_cost, upload_fields FROM $t_subcats WHERE subcatid='$xsubcatid'";
				$uoption = @mysql_fetch_array(mysql_query($sql));
				if ( $enable_extra_uploads && $_POST['mod_uploads'] && ($uploadcount > $pic_count ) ) 
				{
					$selpromos['uploads'] = 1;
				}
				// END Charge On Upload Addon Code

				/* START mod-paid-categories */
				if ($posting_fee > 0.00) $selpromos['posting_fee'] = true;
				/* END mod-paid-categories */


				if (count($selpromos))
				{
					$total_price = 0;
					$item_number = ($data['isevent'] ? "E" : "A") . $adid;

				?>

					<h2><?php echo $lang['PAY_FOR_PROMOTIONS']; ?></h2>

					<p><?php echo $lang['SELECTED_PROMOTIONS']; ?></p>

					<table class="invoice" cellspacing="0" cellpadding="0">

					<?php
					
					/* START mod-paid-categories */
					if ($selpromos['posting_fee']) {
						$item_number .= "-NEW1";
						$total_price += $posting_fee;
					?>
					
						<tr>
							<td class="firstcell"><?php echo $lang['POSTING_FEE']; ?></td>
							<td align="center">&nbsp;</td>
							<td class="maincell">
							<?php echo $paypal_currency_symbol; ?><?php echo number_format($posting_fee, 2); ?>
							</td>
						</tr>
						
					<?php 
					}
					/* END mod-paid-categories */
					
					if($selpromos['featured']) 
					{ 
						$sql = "SELECT days, price FROM $t_options_featured WHERE foptid = {$selpromos[featured]}";
						$foption = @mysql_fetch_array(mysql_query($sql));

						if ($foption)
						{
							$item_number .= "-FEA" . $selpromos['featured'];
							$total_price += $foption['price'];

					?>

							<tr>
								<td class="firstcell"><?php echo $lang['MAKE_FEATURED']; ?></td>
								<td align="center"><?php echo $foption['days']; ?> <?php echo $lang['DAYS']; ?></td>
								<td class="maincell">
								<?php echo $paypal_currency_symbol; ?><?php echo $foption['price']; ?></td>
							</tr>

					<?php
						}
					} 
					?>
					<?php 
					// BEGIN Charge On Upload Addon Code
					if($selpromos['uploads'])
					{ 
						$sql = "SELECT upload_cost, upload_fields FROM $t_subcats WHERE subcatid='$xsubcatid'";
						$uoption = @mysql_fetch_array(mysql_query($sql));

						if ( $uoption  )
						{
							$item_number .= "-UPL" . $selpromos['uploads'];
							$total_price += $uoption['upload_cost'];
						
						?>

							<tr class="gridcell">
								<td class="firstcell"><?php echo $lang['MOD_UPLOAD']; ?></td>
								<td align="center"><?php echo $uploadcount; ?> <?php echo $lang['MOD_FIELD']; ?></td>
								<td class="maincell">
								<?php echo $paypal_currency_symbol; ?><?php echo $uoption['upload_cost']; ?></td>
							</tr>

					<?php
						}
					} 
					// END Charge On Upload Addon Code
					?>
					<?php 
					if($selpromos['extended'])
					{ 
						$sql = "SELECT days, price FROM $t_options_extended WHERE eoptid = {$selpromos[extended]}";
						$eoption = @mysql_fetch_array(mysql_query($sql));

						if ($eoption)
						{
							$item_number .= "-EXA" . $selpromos['extended'];
							$total_price += $eoption['price'];
						
						?>

							<tr class="gridcell">
								<td class="firstcell"><?php echo $lang['MAKE_EXTENDED']; ?></td>
								<td align="center"><?php echo $eoption['days']; ?> <?php echo $lang['DAYS']; ?></td>
								<td class="maincell">
								<?php echo $paypal_currency_symbol; ?><?php echo $eoption['price']; ?></td>
							</tr>

					<?php
						}
					} 
					?>

					<tr class="totalrow">
						<td class="firstcell" width="150"><?php echo $lang['TOTAL_PRICE']; ?></td>
						<td align="center" width="75">&nbsp;</td>
						<td class="totalcell" width="75">
						<?php echo $paypal_currency_symbol; ?><?php echo number_format($total_price,2); ?></td>
					</tr>

					</table>
					<br>

					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="item_name" value="Payment for ad promotions">
						<input type="hidden" name="item_number" value="<?php echo $item_number; ?>">
						<input type="hidden" name="amount" value="<?php echo $total_price; ?>">
						<input type="hidden" name="currency_code" value="<?php echo $paypal_currency; ?>">
						<input type="hidden" name="return" value="<?php echo $script_url; ?>/afterpay.php?adid=<?php echo $adid; ?>&adtype=<?php echo ($data['isevent'] ? "E" : "A"); ?>&cityid=<?php echo $xcityid; ?>">
						<input type="hidden" name="cancel_return" value="<?php echo $script_url; ?>/cancelpay.php?cityid=<?php echo $xcityid; ?>">
						<input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
						<input type="hidden" name="no_shipping" value="1">
						<input type="hidden" name="no_note" value="0">
						<input type="hidden" name="notify_url" value="<?php echo $script_url; ?>/ipn.php">
						<?php /* ?><input type="image" name="submit" src="images/pay.gif" border="0" alt="Make payments with PayPal, it's fast, free, and secure!"><?php */ ?>
						<button type="submit" name="submit">Pay with Paypal</button>
					</form>

				<?php

				}
				else
				{

				?>

					<a href="?view=main&cityid=<?php echo $xcityid; ?>"><?php echo $lang['BACK_TO_HOME']; ?></a>

				<?php

				}

			}
		}
	}
	else
	{

		if($in_admin) 
		{
			$err .= "Error posting ad";
		}
		else
		{

?>

			<p class="error"><?php echo $lang['POST_AD_ERROR']; ?></p>
			<a href="?view=main&cityid=<?php echo $xcityid; ?>"><?php echo $lang['BACK_TO_HOME']; ?></a>

<?php
		}
	
	}

?>


<?php

	if($in_admin)
	{
		header("Location: ?msg=$msg&err=$err&cityid=$_REQUEST[cityid]&subcatid=".($_POST['postevent']?"-1":$_POST['subcatid']));
		exit;
	}

}

elseif (($_GET['subcatid'] || $_GET['postevent']) && $xcityid > 0)
{
	// Show the form //
	
	recurse($data, 'htmlspecialchars');

	if($_GET['subcatid'] == -1)
	{
		$_GET['postevent'] = $_REQUEST['postevent'] = 1;
	}

	// Get the expiry
	if ($_REQUEST['postevent'])
	{
		$expireafter = $expire_events_after;
	}
	else
	{
		$sql = "SELECT expireafter FROM $t_subcats WHERE subcatid = $_REQUEST[subcatid]";
		list($expireafter) = mysql_fetch_array(mysql_query($sql));
	}

	if ($_GET['subcatid'] > 0 || $_POST['subcatid'] > 0)
	{
		$subcatid = $_GET['subcatid'] ? $_GET['subcatid'] : $_POST['subcatid'];
		$sql = "SELECT cat.catid, cat.catname, scat.subcatname, 
						scat.hasprice, scat.pricelabel
				FROM $t_subcats scat 
					INNER JOIN $t_cats cat ON scat.catid = cat.catid
				WHERE subcatid = $subcatid 
					#AND scat.enabled = '1'
					#AND cat.enabled = '1'";
		list($catid, $catname, $subcatname, $hasprice, $pricelabel) = mysql_fetch_array(mysql_query($sql));
	}
	else
	{
		$subcatname = $catname = $lang['EVENTS'];
		
		// Date lists
		$dlist = "";
		for($i=1; $i<=31; $i++) $dlist .= "<option value=\"$i\">$i</option>\n";
		
		$mlist = "";
		for ($i=1; $i<=12; $i++) $mlist .= "<option value=\"$i\">".$langx['months'][$i-1]."</option>\n";
		
		$ylist = "";
		$thisy = date("Y");
		for ($i=0; $i<=1; $i++) $ylist .= "<option value=\"".($thisy+$i)."\">".($thisy+$i)."</option>";
	}

	
?>
<script language="javascript">

function insertLink(link)
{
	if (link)
	{
		var editpane = document.frmPost.addesc;
		var linkcode = "[URL]http://" + link + "[/URL]";

		editpane.focus();
		/*if (document.selection)
		{
			document.selection.createRange().text = linkcode;
		}
		else*/
		if (editpane.selectionStart || editpane.selectionStart == '0')
		{
			var selstart = editpane.selectionStart;
			var selend = editpane.selectionEnd;
			
			editpane.value = editpane.value.substring(0, selstart) + linkcode + editpane.value.substring(selend);
			editpane.selectionStart = selstart + linkcode.length;
			editpane.selectionEnd = editpane.selectionStart;
		}
		else
		{
			editpane.value = editpane.value + linkcode;
		}

		editpane.focus();
	}

}
</script>
	
<!-- Begin Version 5.0 -->
<script language="javascript">
function checkPostFields(form) {
	
	var msg = '';
	/* Begin Version 5.0 */
	var value_missing = false;
	/* End Version 5.0 */

	if (form.elements['addesc'].value == ''
			|| form.elements['email'].value == ''
			<?php if ($image_verification) { ?>
			|| form.elements['captcha'].value == ''
			<?php } ?>
			) {
		msg += '<?php echo $lang['ERROR_POST_FILL_ALL']; ?>\n';
		/* Begin Version 5.0 */
		value_missing = true;
		/* End Version 5.0 */
	}
	
	if (!form.elements['agree'].checked) {
		msg += '<?php echo $lang['ERROR_POST_AGREE_TERMS']; ?>\n';
	}
	
	/* Begin Version 5.0 */
	<?php 
	if(count($xsubcatfields)) {
		foreach($xsubcatfields as $fldnum=>$fld) {
		    if ($fld['REQUIRED']) {
	?>
	
	            if (!value_missing && !form.elements['x[<?php echo $fldnum; ?>]'].value) {
            		msg = '<?php echo $lang['ERROR_POST_FILL_ALL']; ?>\n' + msg;
            		value_missing = true;
	            }
	            
	<?php
	        }
	    }
	}
	?>
	/* End Version 5.0 */
	
	if (msg != '') {
		alert(msg);
		return false;
	}
}
</script>
<!-- End Version 5.0 -->

<?php if(!$in_admin) { ?>
<div>
	<h1><?php echo $lang['POST_AD']; ?></h1><br />

<?php } ?>

<!-- Begin Version 5.0 -->
<div class="postpath"><?php echo "<b>$xcountryname</b>" . ($postable_country ? "" : " &raquo; <b>$xcityname</b>") . (($_GET['postevent'] || $_GET['shortcutcat']) ?"":" &raquo; <b>$catname</b>")." &raquo; <b>$subcatname</b>"; ?> 
<!-- End Version 5.0 -->
<?php if(!$in_admin) { ?>
&nbsp; (<a href="?view=selectcity&targetview=post"><?php echo $lang['CHANGE']; ?></a>)
<?php } ?>
</div><br>

<?php 
/* START mod-paid-categories */ 
if ($posting_fee > 0.00) {
?>
	<div class="post_note">
	<?php echo str_replace("{@FEE}", "{$paypal_currency_symbol}{$posting_fee}", $lang['POSTING_FEE_NOTE']); ?>
	</div>
	<br>
<?php 
}
/* END mod-paid-categories */ 
?>

<div class="post_note"><?php echo str_replace("{@EXPIREAFTER}", $expireafter, $lang['POST_AD_NOTE']); ?></div><br>

<?php if($err) echo "<br><div class=\"err\">$err</div><br>"; ?>


<div class="mFormWrap">
<form action="<?php if($in_admin) echo "postad.php?cityid=$_GET[cityid]&subcatid=$_GET[subcatid]"; else echo "index.php?$qs"; ?>" method="post" name="frmPost" enctype="multipart/form-data" 
	onsubmit="return checkPostFields(this);">	<!-- Version 5.0 -->


<table class="postad" border="0" cellspacing="0" cellpadding="0">

	<tr>
		<td>
		
			<b><?php echo $lang['POST_ADTITLE']; ?>:</b><span class="marker">*</span> <br>
			<input name="adtitle" type="text" id="adtitle" size="80" maxlength="100" required value="<?php echo $data['adtitle']; ?>">

		</td>
	</tr>

	<tr><td>&nbsp;</td></tr>

	<tr>
		<td>
		
			<b><?php echo $lang['POST_LOCATION']; ?>:</b><br>


			<?php
			if($location_sort) $sort = "ORDER BY areaname";
            else $sort = "ORDER BY pos";
    
			$sql = "SELECT areaname FROM $t_areas WHERE cityid = $xcityid  $sort";
			$res = mysql_query($sql);
			if (mysql_num_rows($res))
			{
			?>

			<select name="arealist" onchange="javascript:if(this.value) { this.form.area.value=this.value; this.form.area.disabled=true; } else this.form.area.disabled=false;">

			<option value="" <?php if(!$data['area']) echo "selected"; ?>>(<?php echo $lang['SELECT']; ?>)</option>
			<?php
				$other_index = 1;
				while ($row = mysql_fetch_array($res))
				{
					$other_index++;
					echo "<option value=\"$row[areaname]\"";
					if ($data['area'] == $row['areaname']) { echo " selected"; $area_inlist = TRUE; }
					echo ">$row[areaname]</option>";
				}
			?>

			<option value="" <?php if($data['area'] && !$area_inlist) echo "selected"; ?>>(<?php echo $lang['OTHER']; ?>)</option>
			</select>

			<?php echo $lang['OR_SPECIFY']; ?>

			<input name="area" type="text" size="40" maxlength="50" value="<?php echo $data['area']; ?>" onKeyUp="javascript:if(this.form.arealist.selectedIndex!=<?php echo $other_index; ?>) this.form.arealist.selectedIndex=<?php echo $other_index; ?>;" <?php if($area_inlist) echo "disabled"; ?>>

			<?php
			}
			else
			{
			?>

			<input name="area" type="text" size="40" maxlength="50" value="<?php echo $data['area']; ?>">

			<?php
			}
			?>
	

		</td>
	</tr>
	
	<tr><td>&nbsp;</td></tr>
	
	<!-- Begin Version 5.0 -->
		
	<tr>
		<td valign="top"><b><?php echo $lang['POST_CONTENTS']; ?>:</b> <span class="marker">*</span><br>		<?php 
		/* Begin Version 5.6.3 - WMD editor can not be disabled fix */
		
        if(richTextAllowed(time())) { 
            $wmd_editor = array("name"=>"addesc", "content"=>$data['addesc']);
            include("{$path_escape}editor/wmd_editor.inc.php"); 
            
        } else {
        ?>
        
            <textarea name="addesc" required cols="78" rows="10" id="addesc"><?php echo $data['addesc']; ?></textarea><br>
        
        <?php 
        } 
        
        /* End Version 5.6.3 - WMD editor can not be disabled fix */?>

		</td>
	</tr>

	<!-- End Version 5.0 -->
		
	<tr><td>&nbsp;</td></tr>

	
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			
			<?php
			// Price field
			if ($hasprice)
			{
			?>
			
			<tr>
				<td><b><?php echo $pricelabel; ?>:</b></td><td><?php echo $currency; ?> <input type="text" name="price" size="5" maxlength="10" value="<?php echo $data['price']; ?>"></td>
			</tr>
			<tr><td>&nbsp;</td></tr>

			<?php
			}
			?>


			
			<?php 
			// Custom fields
			if(count($xsubcatfields))
			{
				foreach($xsubcatfields as $fldnum=>$fld)
				{
			?>
			<tr>
			    <!-- Begin Version 5.0 -->
				<td valign="top"><b><?php echo $fld['NAME']; ?>: </b>
				<?php if ($fld['REQUIRED']) { ?>
				<span class="marker">*</span>
				<?php } ?>
				</td>
			    <!-- End Version 5.0 -->
				<td>
				
				<?php

				switch($fld['TYPE'])
				{
					case "N":

				?>

					<input name="x[<?php echo $fldnum; ?>]" type="text" size="8" value="<?php echo $data['x'][$fldnum]; ?>">

				<?php

					break;

					case "D":

				?>

					<select name="x[<?php echo $fldnum; ?>]">
					<?php
					foreach ($fld['VALUES_A'] as $v)
					{
						echo "<option value=\"$v\"";
						if ($data['x'][$fldnum] == $v) echo " selected";
						echo ">$v</option>";
					}
					?>
					</select>

				<?php

					break;
					
					default:

				?>

					<input name="x[<?php echo $fldnum; ?>]" type="text" size="30" value="<?php echo $data['x'][$fldnum]; ?>">

				<?php

					break;

				}
				?>

				<br>
				<img src="images/spacer.gif" height="2"><br>
				</td>
			</tr>
			<?php 
				}
				echo "<tr><td colspan=\"2\">&nbsp;</td></tr>";
			}
			?>


			<?php /* ?>
			<tr>
				<td valign="top"><b><?php echo $lang['POST_PASSWORD']; ?>: </b><span class="marker">*</span> </td>
				<td><input name="password" type="password" id="password" size="30" maxlength="50" value=""><br><span class="hint"><?php echo $lang['POST_PASSWORD_HINT']; ?></span></td>
			</tr>

			<tr><td>&nbsp;</td></tr>
			<?php */ ?>

			<tr>
				<td valign="top"><b><?php echo $lang['POST_YOUREMAIL']; ?>:</b>
				<?php if(!$in_admin) { ?>&nbsp;<span class="marker">*</span><?php } ?></td>
				
				<td><input name="email" required type="text" id="email" size="30" maxlength="50" value="<?php if ($logged_in) { echo $logged_row['email']; } else { echo $data['email']; } ?>">

				<table border="0" cellspacing="1" cellpadding="0">
				<tr>
					<td><input name="showemail" type="radio" value="0" <?php if(isset($data['showemail']) && $data['showemail']==EMAIL_HIDE) echo "checked"; ?>></td>
					<td><?php echo $lang['POST_EMAILOPTION_HIDE']; ?></td>
					</tr>
				<tr>
					<td><input name="showemail" type="radio" value="2" <?php if(!isset($data['showemail']) || $data['showemail']==EMAIL_USEFORM) echo "checked"; ?>></td>
					<td><?php echo $lang['POST_EMAILOPTION_USEFORM']; ?></td>
					</tr>
				<tr>
					<td><input name="showemail" type="radio" value="1" <?php if($data['showemail']==EMAIL_SHOW) echo "checked"; ?>>&nbsp;</td>
					<td><?php echo $lang['POST_EMAILOPTION_SHOW']; ?></td>
					</tr>
					</table>
				</td>
			</tr>			

			<tr><td>&nbsp;</td></tr>


			<?php
			if($_GET['postevent'])
			{
			?>

				<tr>

					<td><b><?php echo $lang['POST_EVENT_START']; ?>:</b>  <span class="marker">*</span></td>
					<td>
					
					<select name="fm">
					<?php echo $mlist; ?>
					</select>
					
					<select name="fd">
					<?php echo $dlist; ?>
					</select> , 
					
					<select name="fy">
					<?php echo $ylist; ?>
					</select>
					
					</td>
					</tr>
				<tr>
					<td><b><?php echo $lang['POST_EVENT_END']; ?>: </b> <span class="marker">*</span></td>
					<td>
					
					<select name="tm">
					<?php echo $mlist; ?>
					</select>
					
					<select name="td">
					<?php echo $dlist; ?>
					</select> , 
					
					<select name="ty">
					<?php echo $ylist; ?>
					</select>
									
					</td>
				</tr>

				<?php
				if ($data['fm'])	// Version 5.0
				{
				?>

					<script language="javascript">

					document.frmPost.fm.options[<?php echo $data['fm']-1; ?>].selected = true;
					document.frmPost.fd.options[<?php echo $data['fd']-1; ?>].selected = true;
					document.frmPost.fy.options[<?php echo $data['fy']-date("Y"); ?>].selected = true;
					document.frmPost.tm.options[<?php echo $data['tm']-1; ?>].selected = true;
					document.frmPost.td.options[<?php echo $data['td']-1; ?>].selected = true;
					document.frmPost.ty.options[<?php echo $data['ty']-date("Y"); ?>].selected = true;

					</script>

				<?php
				}
				?>

			<?php
			}
			?>

			
			<?php
			if(!$in_admin && $image_verification)
			{
			?>

				<tr>
					<td valign="top"><b><?php echo $lang['POST_VERIFY_IMAGE']; ?>: <span class="marker">*</span></b></td>
					<td>
<!--					<img src="captcha.png.php?--><?php //echo rand(0,999); ?><!--"><br>-->
					<img src="captcha.image.php?<?php echo rand(0,999); ?>"><br>
					<span class="hint"><?php echo $lang['POST_VERIFY_IMAGE_HINT']; ?></span><br>
					<input type="text" name="captcha" value="">
					</td>
				</tr>

			<?php
			}
			?>

		</table>
		</td>
	</tr>
		
</table>
<br><br>
	<?php
	// BEGIN Charge On Upload Addon Code
	
	$upload_cost = '';
	$upload_fields = '';
	
	if ( $xsubcatid && $enable_extra_uploads )
	{
		$sql = "SELECT upload_cost, upload_fields FROM $t_subcats WHERE subcatid='$xsubcatid'";
		$res_upl = mysql_query($sql);
		$num_uploads = mysql_num_rows($res_upl);
		$upl_row = mysql_fetch_array($res_upl);
		$upload_cost = $upl_row['upload_cost'];
		$upload_fields = $upl_row['upload_fields'];
		
		if ( $upload_fields )
		{
	?>
			<script type="text/javascript">
                fields = 0;
                function addInput() 
                {
                    if (fields != 1) {
                        document.getElementById('more_fields').innerHTML += "<input type='hidden' name='mod_uploads' value='1'><?php 
                        foreach (range(1, $upload_fields) as $number) 
                        {
                            echo "<input type='file' name='pic[]' size='69'><br><img src='images/spacer.gif' height='2'><br>";
                        } ?>";
                    fields = 1;
                    } else {
                        document.form.add_more.disabled=true;
                    }
                }
            </script>

	<?php
		}
		
	}

	?>


<table class="postad" cellspacing="0" cellpadding="0" border="0" width="100%">

	<tr>
		<td><b><?php echo $lang['POST_UPLOAD_PICTURES']; ?>:</b><br>
		<span class="hint"><?php echo $lang['POST_MAX_PIC_FILESIZE']; ?>: <?php echo $pic_maxsize; ?>KB</span><br>
		<?php
		for ($i=1; $i<=$pic_count; $i++)
		{	
		?>
			<input type="file" name="pic[]" size="69"><br>
			<img src="images/spacer.gif" height="2"><br>
		<?php
		}
		?>
        <!-- BEGIN Charge On Upload Addon Code -->
        <?php if ( $num_uploads && $upload_fields ) { ?>
        <div id="more_fields"></div>
        <br>
        <input type="button" onClick="addInput()" name="add_more" value="<?php echo $lang['MOD_ADD'] . ' ' . $upload_fields . ' ' . $lang['MOD_MORE'] . ' ' . $paypal_currency_symbol . $upload_cost; ?>" />
        <?php } ?>
        <!-- END Charge On Upload Addon Code -->
		</td>
	</tr>

</table>
<br>


<table class="postad" cellspacing="0" cellpadding="0" border="0" width="100%">

	<tr>
		<td>
		<input type="checkbox" name="othercontactok" id="othercontactok" value="1" <?php if($data['othercontactok'] == 1) echo "checked"; ?>><label for="othercontactok"> <?php echo $lang['POST_COMMERCIAL_CONTACT']; ?></label>
		</td>
	</tr>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>
		<input type="checkbox" name="newsletter" id="newsletter" value="1" <?php if($data['newsletter'] == 1) echo "checked"; ?>> <label for="newsletter"><?php echo $lang['POST_NEWSLETTER_OPTION']; ?></label>
		</td>
	</tr>

	<tr><td colspan="2">&nbsp;</td></tr>

	<?php if(!$in_admin) { ?>

		<tr>
			<td>
			<input type="checkbox" name="agree" required id="agree" value="1"> <label for="agree"><?php echo $lang['POST_ACCEPT_TERMS']; ?></label>
			</td>
		</tr>

	<?php } ?>

</table>
<br>

<?php 
if(!$in_admin && $enable_promotions) 
{ 
	$sql = "SELECT * FROM $t_options_featured ORDER BY days ASC";
	$res_feat = mysql_query($sql);
	$num_feat = mysql_num_rows($res_feat);

	$sql = "SELECT * FROM $t_options_extended ORDER BY days ASC";
	$res_ext = mysql_query($sql);
	$num_ext = mysql_num_rows($res_ext);

	if ($num_feat || $num_ext)
	{

?>

<br><br>


<h3><?php echo $lang['AD_PROMOTIONS']; ?></h3>

<table class="postad" cellspacing="0" cellpadding="0" border="0" width="100%">

	<?php

	if($enable_featured_ads && $num_feat)
	{

	?>

		<tr>
			<td>
			<b><?php echo $lang['MAKE_FEATURED']; ?></b><br>
			<?php echo $lang['MAKE_FEATURED_DETAILS']; ?><br>
			<select name="promote[featured]">
			<option value="0"><?php echo $lang['DONT_MAKE_FEATURED']; ?></option>
			<?php
			while ($row = mysql_fetch_array($res_feat))
			{
				echo "<option value=\"$row[foptid]\"";
				if($data['promote']['featured'] == $row['foptid']) echo " selected";
				echo ">$row[days] $lang[DAYS] ({$paypal_currency_symbol}{$row[price]})</option>\n";
			}
			?>
			</select>
			</td>
		</tr>

		<tr><td>&nbsp;</td></tr>

	<?php
		
	}

	?>


	<?php 

	if($enable_extended_ads && $num_ext) 
	{
		/*if ($data['subcatid'])
		{
			$sql = "SELECT expireafter FROM $t_subcats WHERE subcatid = $data[subcatid]";
			list ($expireafter) = mysql_fetch_array(mysql_query($sql));
		}
		else
		{
			$expireafter = $expire_events_after;
		}*/


	?>

		<tr>
			<td>
			<b><?php echo $lang['MAKE_EXTENDED']; ?></b><br>
			<?php echo $lang['MAKE_EXTENDED_DETAILS']; ?><br>
			<select name="promote[extended]">
			<option value="0"><?php echo $lang['DONT_MAKE_FEATURED']; ?></option>
			<?php
			while ($row = mysql_fetch_array($res_ext))
			{
				$totaldays = $row['days'];
				echo "<option value=\"$row[eoptid]\"";
				if($data['promote']['extended'] == $row['eoptid']) echo " selected";
				echo ">+ $totaldays $lang[DAYS] ({$paypal_currency_symbol}{$row[price]})</option>\n";
			}
			?>
			</select>
			</td>
		</tr>

		<tr><td>&nbsp;</td></tr>

	<?php
	
	} 

	?>

</table>
<br>

<?php
	}
}
?>


<?php
if($_GET['postevent'])
{
?>
	<input name="isevent" type="hidden" id="isevent" value="1">
	<input name="postevent" type="hidden" id="postevent" value="1">

<?php
}
else
{
?>
	<input name="subcatid" type="hidden" id="subcatid" value="<?php echo $subcatid; ?>">
<?php
}
?>

<input name="do" type="hidden" id="do" value="post">
<div id="loginForm" style="width:100%; padding-top:20px; margin-left:-17px;;">
<input type="submit" id="submit" name="submit" class="signIn" value="<?php echo $lang['BUTTON_POST']; ?>" />
</div>
</div>
</form>
</div>

<?php

}

elseif ($_GET['catid'] && $xcityid > 0)
{
    /* Begin Version 5.0 */
	$catid = $_GET['catid'];
	$sql = "SELECT catname AS catname, COUNT(*) AS subcatcount, subcatid, subcatname 
	        FROM $t_cats cat 
	            INNER JOIN $t_subcats scat ON cat.catid = scat.catid 
	                AND scat.enabled = '1'
	        WHERE cat.catid = $catid AND cat.enabled = '1'
	        GROUP BY cat.catid";
	$catdetails = mysql_fetch_array(mysql_query($sql));
	$catname = $catdetails['catname'];
		
	if ($shortcut_categories && $catdetails['subcatcount'] == 1
	        && $catdetails['subcatname'] == $catname) {

	    // Redirect to the lone subcategory.
	    header("Location: index.php?view=post&cityid={$xcityid}&lang={$xlang}&catid={$catid}&subcatid={$catdetails['subcatid']}&shortcutcat=1&shortcutregion={$_GET['shortcutregion']}");
	    exit;
	}

    /* End Version 5.0 */
    
?>

<h1><?php echo $lang['POST_AD']; ?></h1><br />
<div class="postpath"><?php echo "<b>$xcountryname</b>" . ($postable_country ? "" : " &raquo; <b>$xcityname</b>") . " &raquo; <b>$catname</b>"; ?> 
&nbsp; (<a href="?view=selectcity&targetview=post"><?php echo $lang['CHANGE']; ?></a>)
</div><br>
<?php echo $lang['POST_SELECT_SUBCATEGORY']; ?><br> <br />
<ul class="postcats" style="column-count:2;-webkit-column-count:2;-moz-column-count:2;column-gap:3px;-webkit-column-gap:3px;-moz-column-gap:3px;line-height:2.5; text-transform:lowercase;">

<?php
	// Get subcategory names
	$sql = "SELECT subcatid, subcatname AS subcatname
			FROM $t_subcats
			WHERE catid = $_GET[catid]
				AND enabled = '1'
			$sortsubcatsql";	// Version 5.0
	$res = mysql_query($sql);

	while ($row = mysql_fetch_array($res))
	{

?>
        <!-- Begin Version 5.0 -->
		<li class="post_li"><a href="?view=post&cityid=<?php echo $xcityid; ?>&lang=<?php echo $xlang; ?>&catid=<?php echo $_GET['catid']; ?>&subcatid=<?php echo $row['subcatid']; ?>&shortcutregion=<?php echo $_GET['shortcutregion']; ?>"><?php echo $row['subcatname']; ?></a></li>
        <!-- End Version 5.0 -->
<?php
	
	}

?>

</ul>

<?php

}

elseif($xcityid > 0)
{

?>

<h1><?php echo $lang['POST_AD']; ?></h1><br />
<!-- Begin Version 5.0 -->
<div class="postpath"><?php echo "<b>$xcountryname</b>" . ($postable_country ? "" : " &raquo; <b>$xcityname</b>"); ?>
<!-- End Version 5.0 -->
&nbsp; (<a href="?view=selectcity&targetview=post"><?php echo $lang['CHANGE']; ?></a>)
</div><br>
<?php echo $lang['POST_SELECT_CATEGORY']; ?><br><br />
<ul class="postcats" style="column-count:2;-webkit-column-count:2;-moz-column-count:2;column-gap:3px;-webkit-column-gap:3px;-moz-column-gap:3px;line-height:2.5; text-transform:lowercase;">

<?php
	// Get category names
	$sql = "SELECT catid, catname AS catname
			FROM $t_cats
			WHERE enabled = '1'
			$sortcatsql";		// Version 5.0
	$res = mysql_query($sql);

	while ($row = mysql_fetch_array($res))
	{

?>
        <!-- Begin Version 5.0 -->
		<li class="post_li"><a href="?view=post&cityid=<?php echo $xcityid; ?>&lang=<?php echo $xlang; ?>&catid=<?php echo $row['catid']; ?>&shortcutregion=<?php echo $_GET['shortcutregion']; ?>"><?php echo $row['catname']; ?></a></li>
        <!-- End Version 5.0 -->
<?php
	
	}

?>

<?php if($enable_calendar) { ?>
<li><a href="?view=post&cityid=<?php echo $xcityid; ?>&lang=<?php echo $xlang; ?>&postevent=1"><?php echo $lang['EVENTS']; ?></a></li>
<?php } ?>

<?php if($enable_images) { ?>
<li><a href="?view=postimg&cityid=<?php echo $xcityid; ?>&lang=<?php echo $xlang; ?>"><?php echo $lang['IMAGES']; ?></a></li>
<?php } ?>

</ul>

<?php

}
else
{
    /* Begin Version 5.0 */
	$sql = "SELECT countryname, COUNT(*) AS citycount, cityid, cityname 
	        FROM $t_countries c 
	            INNER JOIN $t_cities ct ON c.countryid = ct.countryid 
	                AND ct.enabled = '1'
	        WHERE c.countryid = $xcountryid AND c.enabled = '1'
	        GROUP BY c.countryid";
	$countrydetails = mysql_fetch_array(mysql_query($sql));
print_r($countrydetails);

	if ($shortcut_regions && $countrydetails['citycount'] == 1
	        && $countrydetails['cityname'] == $countrydetails['countryname']) {

	    // Redirect to the lone city.
	    header("Location: index.php?view={$_GET['view']}&cityid={$countrydetails['cityid']}&lang={$xlang}&catid={$_GET['catid']}&subcatid={$_GET['subcatid']}&postevent={$_GET['postevent']}&shortcutregion=1");
	    exit;
	
    } else {
            
        $qsplus = "";
        foreach($_GET as $k=>$v) if($k != "view") $qsplus .= "&$k=$v";

        header("Location: $script_url/?view=selectcity&targetview=$_GET[view]{$qsplus}");
        exit;
    }

    /* End Version 5.0 */
}

?>
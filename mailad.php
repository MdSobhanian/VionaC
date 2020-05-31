<?php

/*-----------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                      |
+================================================+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
|                                                |
|                          //  Sat, Dec 17, 2005 |
+-----------------------------------------------*/


require_once("initvars.inc.php");
require_once("config.inc.php");

$qs = "";
foreach($_GET as $k=>$v) $qs .= "$k=$v&";


if($image_verification) 
{
	require_once("captcha.cls.php");
	$captcha = new captcha();
}

if($_REQUEST['adid'])
{
	if ($_REQUEST['adtype'] == "E")
	{
		$sql = "SELECT adtitle FROM $t_events WHERE adid = $xadid";
		list($adtitle) = @mysql_fetch_row(mysql_query($sql));

        /* Begin Version 5.0 */
        $adurl = "{$script_url}/" . buildURL("showevent", array($xcityid, $xdate, $xadid, $adtitle));
        /* End Version 5.0 */
	}
	else if ($_REQUEST['adtype'] == "A")
	{
		$sql = "SELECT adtitle FROM $t_ads WHERE adid = $xadid";
		list($adtitle) = @mysql_fetch_row(mysql_query($sql));
		
		/* Begin Version 5.0 */
		
		$sql = "SELECT catname, subcatname 
				FROM $t_cats c INNER JOIN $t_subcats s ON s.catid = c.catid
				WHERE s.subcatid = $xsubcatid";
		$row = @mysql_fetch_array(mysql_query($sql));

        $adurl = "$script_url/" . buildURL("showad", array($xcityid, $xcatid, $row['catname'], 
            $xsubcatid, $row['subcatname'], $xadid, $adtitle));		
		/* End Version 5.0 */
	}
}

if(!$demo && $_POST['receiver_email'] && $_POST['receiver_email'] && $_POST['sender_email'] && $_POST['sender_name'])
{
	$err = "";

	if(!ValidateEmail($_POST['sender_email']) || !ValidateEmail($_POST['receiver_email']))
	{
		$err .= $lang['ERROR_INVALID_EMAIL']."<br>";
	}
	if($image_verification && !$captcha->verify($_POST['captcha']))
	{
		$err .= $lang['ERROR_IMAGE_VERIFICATION_FAILED']."<br>";
	}
	
	if(!$err)
	{
		$mail = file_get_contents("mailtemplates/mailad.txt");
		$mail = str_replace("{@SITENAME}", $site_name, $mail);
		$mail = str_replace("{@ADURL}", $adurl, $mail);
		$mail = str_replace("{@RECEIVERNAME}", $_POST['receiver_name'], $mail);
		$mail = str_replace("{@RECEIVEREMAIL}", $_POST['receiver_email'], $mail);
		$mail = str_replace("{@SENDERNAME}", $_POST['sender_name'], $mail);
		$mail = str_replace("{@SENDEREMAIL}", $_POST['sender_email'], $mail);

		/* Begin Version 5.1 - Send mail using SMTP */
		if(sendMail($_POST['receiver_email'], $lang['MAILSUBJECT_EMAIL_THIS_AD'], $mail, $site_email))
		/* End Version 5.1 - Send mail using SMTP */
		{
			if($sef_urls) $return_url = "$adurl?msg={$lang[MESSAGE_MAIL_SENT]}";
			else $return_url = "$adurl&msg={$lang[MESSAGE_MAIL_SENT]}";
			header("Location: $return_url");
			exit;
		}
		else
		{
			die("Error sending mail");
		}
	}
}


if($demo) $err = ($err?"$err<br>":"")."Feature disabled in demo";

?>
	
<!-- Begin Version 5.0 -->
<script language="javascript">
function checkFormFields(form) {
	
	var msg = '';

	if (form.elements['receiver_name'].value == ''
			|| form.elements['receiver_email'].value == ''
			|| form.elements['sender_name'].value == ''
			|| form.elements['sender_email'].value == ''
			<?php if ($image_verification) { ?>
			|| form.elements['captcha'].value == ''
			<?php } ?>
			) {
		msg += '<?php echo $lang['ERROR_POST_FILL_ALL']; ?>\n';
	}
	
	if (msg != '') {
		alert(msg);
		return false;
	}
}
</script>
<!-- End Version 5.0 -->

<!-- Begin Version 5.0 -->
<h2><?php echo $lang['EMAIL_THIS_AD']; ?>: <a href="<?php echo $adurl; ?>"><?php echo $adtitle; ?></a></h2>
<!-- End Version 5.0 -->

<?php if($err) { ?><div class="err"><?php echo $err; ?></div><br><?php } ?>

<form action="index.php?<?php echo $qs; ?>" method="post"
	onsubmit="return checkFormFields(this);">
<table border="0">
	<tr>
		<td><b><?php echo $lang['RECEIVER_NAME']; ?>: </b><span class="marker">*</span></td>
		<td><input type="text" name="receiver_name" size="30"></td>
	</tr>
	<tr>
		<td><b><?php echo $lang['RECEIVER_EMAIL']; ?>: </b><span class="marker">*</span></td>
		<td><input type="text" name="receiver_email" size="30"></td>
	</tr>
	<tr>
		<td><b><?php echo $lang['YOUR_NAME']; ?>: </b><span class="marker">*</span></td>
		<td><input type="text" name="sender_name" size="30"></td>
	</tr>
	<tr>
		<td><b><?php echo $lang['YOUR_EMAIL']; ?>: </b><span class="marker">*</span></td>
		<td><input type="text" name="sender_email" size="30"></td>
	</tr>
	<tr>
		<td valign="top"><b><?php echo $lang['YOUR_MESSAGE']; ?>: </b></td>
		<td>
		<?php 
		$mail = nl2br(file_get_contents("mailtemplates/mailad.txt"));
		$mail = str_replace("{@SITENAME}", $site_name, $mail);
		/* Begin Version 5.0 */
		$mail = str_replace("{@ADURL}", wordwrap($adurl, 75, "\n", true), $mail);
		/* End Version 5.0 */
		$mail = str_replace("{@RECEIVERNAME}", "{".$lang['RECEIVER_NAME']."}", $mail);
		$mail = str_replace("{@RECEIVEREMAIL}", "{".$lang['RECEIVER_EMAIL']."}", $mail);
		$mail = str_replace("{@SENDERNAME}", "{".$lang['YOUR_NAME']."}", $mail);
		$mail = str_replace("{@SENDEREMAIL}", "{".$lang['YOUR_EMAIL']."}", $mail);
		echo $mail;
		?>
		</td>
	</tr>

	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>

	<?php
	if($image_verification)
	{
	?>

		<tr>
			<td valign="top"><b><?php echo $lang['POST_VERIFY_IMAGE']; ?>: <span class="marker">*</span></b></td>
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
		<td><input type="hidden" name="do" value="send">		<!-- Begin Version 5.7 - XSS fix -->
		<input type="hidden" name="adtype" value="<?php echo $_REQUESTs['adtype']; ?>">
		<input type="hidden" name="adid" value="<?php echo $_REQUESTs['adid']; ?>">
		<!-- End Version 5.7 - XSS fix -->
		</td>
		<td>
			<button type="submit" name="send"><?php echo $lang['BUTTON_SEND_MAIL']; ?></button>&nbsp;
			<button type="button" onclick="javascript:location.href='<?php echo $adurl; ?>';"><?php echo $lang['BUTTON_CANCEL']; ?></button>
		</td>
	</tr>
</table>
</form>
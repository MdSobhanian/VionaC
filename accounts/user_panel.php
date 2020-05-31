<?php

ob_start();

define('IN_SCRIPT', true); 

// Extra security - do not remove
if ( empty($_GET['view']) && ( !$_POST || !$_GET ) )
{
	header("Location: ./"); 
	exit;
}



$path_escape = "./";

if ( $acc_construction )
{
	general_message($lang['ACC_CONSTRUCTION'], $lang['ACC_CONSTRUCTION_MSG'] . $go_back);
	exit;
}


include($inc_path . "/user_security.php");



switch ($action) 
{
case 'logout':
 
    
	setcookie ($ck_username, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
	setcookie ($ck_session, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
	setcookie ($ck_userid, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
	general_message($lang['ACC_LOGOUT'], $lang['ACC_HOPE'] . "<br><br><a href=\"./\">{$lang['ACC_GO_HOME']}</a>");
	header("Refresh: 5; url=./"); 
	
break;

case 'delete_ad':
 
    
	$del_res = query_db("SELECT adid FROM $t_ads WHERE adid = '".intval($_GET['adid'])."' 
						 AND user_id = '".$user_row['user_id']."' LIMIT 1");
	
					 
	if ( @mysql_num_rows($del_res) == 1 )
	{

		$adid = intval($_GET['adid']);
	
		// BEGIN Deletion
		$sql = "DELETE FROM $t_adxfields WHERE adid = $adid";
		mysql_query($sql);

		$sql = "SELECT picfile FROM $t_adpics WHERE adid = $adid AND isevent = '0'";
		$pres = mysql_query($sql);
		while($p=mysql_fetch_array($pres))
		{
			unlink("{$path_escape}{$datadir[adpics]}/$p[picfile]");
		}

		$sql = "DELETE FROM $t_adpics WHERE adid = $adid AND isevent = '0'";
		mysql_query($sql);

		$sql = "DELETE FROM $t_featured WHERE adid = $adid AND adtype = 'A'";
		mysql_query($sql);

		$sql = "DELETE FROM $t_promos_featured WHERE adid = $adid AND adtype = 'A'";
		mysql_query($sql);

		$sql = "DELETE FROM $t_promos_extended WHERE adid = $adid AND adtype = 'A'";
		mysql_query($sql);
		
		$sql = "DELETE FROM $t_ads WHERE adid = $adid";
		mysql_query($sql);
		// END Deletion
		
		
		$fields = array($t_adxfields, $t_adpics, $t_featured, $t_promos_featured, $t_promos_extended, $t_ads); 
	
		foreach($fields as $field) 
		{ 
			mysql_query("OPTIMIZE TABLE " . $field);
		} 

		
		general_message($lang['ACC_AD_DELETE'], $lang['ACC_DELETE_SU'] . "<br><br><a href=\"$acc_panel_link\">{$lang['ACC_RETURN']}</a>");
	}
	else
	{
		general_message($lang['ACC_ERROR'], $lang['ACC_NO_AD'] . "<br><br><a href=\"./\">{$lang['ACC_GO_HOME']}</a>");
	}					 
	
	
break;

case 'delete_event':
 
    
	$del_res = query_db("SELECT adid FROM $t_events WHERE adid = '".intval($_GET['adid'])."' 
						 AND user_id = '".$user_row['user_id']."' LIMIT 1");
						 
	if ( @mysql_num_rows($del_res) == 1 )
	{
		// BEGIN Event Deletion
		$adid = intval($_GET['adid']);

		$sql = "SELECT picfile FROM $t_adpics WHERE adid = $adid AND isevent = '1'";
		$pres = mysql_query($sql);
		while($p=mysql_fetch_array($pres))
		{
			unlink("{$path_escape}{$datadir[adpics]}/$p[picfile]");
		}

		$sql = "DELETE FROM $t_adpics WHERE adid = $adid AND isevent = '1'";
		mysql_query($sql);
		
		$sql = "DELETE FROM $t_featured WHERE adid = $adid AND adtype = 'E'";
		mysql_query($sql);

		$sql = "DELETE FROM $t_promos_featured WHERE adid = $adid AND adtype = 'E'";
		mysql_query($sql);

		$sql = "DELETE FROM $t_promos_extended WHERE adid = $adid AND adtype = 'E'";
		mysql_query($sql);
		
		$sql = "DELETE FROM $t_events WHERE adid = $adid";
		mysql_query($sql);
		// END Event Deletion
		
		$fields = array($t_adxfields, $t_adpics, $t_featured, $t_promos_featured, $t_promos_extended, $t_events); 
	
		foreach($fields as $field) 
		{ 
			mysql_query("OPTIMIZE TABLE " . $field);
		} 
		
		general_message($lang['ACC_EVENT_DEL'], $lang['ACC_EV_DEL_SU'] . "<br><br><a href=\"$acc_panel_link\">{$lang['ACC_RETURN']}</a>");
	}
	else
	{
		general_message($lang['ACC_ERROR'], $lang['ACC_NO_AD'] . "<br><br><a href=\"./\">{$lang['ACC_GO_HOME']}</a>");
	}					 
	
	
break;

case 'user_profile_edit':


	if ( strlen($user_row['avatar']) > 0 )
	{
		$avatar_text = '<div style="margin-left:4px; margin-bottom:10px;"><div><strong>'.$lang['ACC_CUR_AV'].'</strong></div>
						<div style="padding: 3px 0px 3px 0px;">
					    <img src="./' .$avatar_dir .'/' . $user_row['avatar'] . '" id="fImage" alt="" />
						</div>
					    <input type="checkbox" id="delete_avatar" name="delete_avatar" />
						<label for="delete_avatar" style="margin-top:-21px; font-size:12px;">&nbsp;' . $lang['ACC_DEL_IMG'].'</label></div>';	
	}
	else
	{
		$avatar_text = '<table width="100%" border="0" cellpadding="3">
						  <tr>
							<td>'.$lang['ACC_NO_AV'].'</td>
						  </tr>
						  <tr>
							<td>'.$lang['ACC_MAX_DIM'].': '.$avatar_max_height.' height x '.$avatar_max_width.' width</td>
						  </tr>
						  <tr>
							<td>'.$lang['ACC_MAX_FILE'].': '.$file_avatar_kb.' kb</td>
						  </tr>
<tr> <td width="100%">
<input name="img_upload" id="fileinput" type="file" size="40" />
</td> </tr>

						</table>
						<br>
						';	
	}
	
	
	
?>

  <div class="mFormWrap">  <br />
    <center><h1>Profile Settings</h1>  </center><br />

    <div id="loginForm" style="width:40% !important;">
      <form action="<?= $_SERVER["REQUEST_URI"] ?>&amp;action=save_changes" method="post" enctype="multipart/form-data" name="createAccount">
		<input type="hidden" name="user_id" value="<?= $user_row['user_id'] ?>">
      	<label for="createUsername"><?= $lang['ACC_USERNAME'] ?></label>
        <input name="update_username" type="text" id="createUsername" autocomplete="off" value="<?= $user_row['username'] ?>" />

        <label for="createEmail"><?= $lang['ACC_EMAIL_TWO'] ?></label>
        <input name="update_email" type="email"  id="createEmail" autocomplete="off" value="<?= $user_row['email'] ?>" />
      
        <label for="password">New Password<span id="passwordStrengthTest"></span></label>
        <input name="update_password" type="password" id="password" autocomplete="off" value="" />
      
        <label for="passwordConfirm">Confirm New Password<span id="passwordMatchTest"></span></label>
        <input type="password" name="password_confirm" id="passwordConfirm" autocomplete="off" value="">
        
       	<?php if ( @$image_verification_disabled ) { ?>
        <label for="captcha"><?= $lang['POST_VERIFY_IMAGE'] ?><div style="float:right; padding-bottom:7px; margin-top:-5px; padding-right:1px;"><img src="<?= $back_path ?>captcha.png.php?<?php echo rand(0,999); ?>"></div></label>
        <input name="captcha" type="text" required="required" id="captcha" autocomplete="off" value="">
		<?php } ?>
        <div class="terms" style="float:none; width:100%; position:relative; margin-left:15px;">
          <?= $avatar_text ?>
        </div>  
        
<? /*
        <div class="terms" style="float:left; width:100%; margin-right:-20px; padding-top:20px;">
          <input type="checkbox" name="terms" id="terms" value="1" checked disabled required></div><div class="terms" style="float:left; margin-left:20px;"> <label for="terms"> <?php echo $lang['ACC_SIGNUP_AGREEMENT']; ?></label>
        </div>
*/
?>


<div style="clear:both"></div>
        <div class="terms" style="float:left; margin-left:20px; padding-bottom:20px;">
          <input type="checkbox" name="newsletter" id="newsletter" value="1" <?php if($user_row['newsletter'] == 1) echo "checked"; ?>></div><div class="terms" style="float:left; margin-left:0px;"> <label for="newsletter" style="margin-left:3px; font-size:12px;"> Subscribe to newsletter</label>
        </div>
<div style="clear:both"></div>
      
        <div style="float:left;"><input type="submit" name="submit" value="Update Profile" class="signIn"></div>
        <div style="float:left; margin-left:15px;"><input type="button" name="myaccount" onClick="location.href='myaccount'" value="Back to My Account" class="signIn"></div>
<div style="clear:both"></div>      
      </form>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function() {
    $('#passwordStrengthTest').html(checkStrength($('#password').val()));

    $('#password').keyup(function() {
      $('#passwordStrengthTest').html(checkStrength($('#password').val()));
    });

    function checkStrength(password) {
      $('#passwordMatchTest').html(checkPasswordMatch(password, $('#passwordConfirm').val()));

      if (password.length == 0) {
        return null;
      } else if (password.length < 8) {
        $('#passwordStrengthTest').removeClass().addClass('short');
        return 'too short';
      } else {
        var strength = 0;

        // long password
        if (password.length >= 10) { strength += 1; }
        
        // uppercase & lowercase
        if (password.match(/([a-z])/) && password.match(/([A-Z])/)) { strength += 1; }
        
        // letters & numbers
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) { strength += 1; }


        // one special character
        if (password.match(/([^\w])/)) { strength += 1; }

        // two special characters
        if (password.match(/([^\w].*[^\w])/)) { strength += 1; }

        // strength determination
        if (strength < 2) {
          $('#passwordStrengthTest').removeClass().addClass('weak');
          return 'weak';
        } else if (strength == 2) {
          $('#passwordStrengthTest').removeClass().addClass('good');
          return 'good';
        } else {
          $('#passwordStrengthTest').removeClass().addClass('strong');
          return 'strong';
        }
      }
    }

    $('#passwordConfirm').keyup(function() {
      $('#passwordMatchTest').html(checkPasswordMatch($('#password').val(), $('#passwordConfirm').val()));
    });

    function checkPasswordMatch(password, passwordConfirm) {
      if (passwordConfirm.length == 0) {
        $('#passwordMatchTest').removeClass();
        return null;
      } else if (password == passwordConfirm) {
        $('#passwordMatchTest').removeClass().addClass('match');
        return 'match';
      } else {
        $('#passwordMatchTest').removeClass().addClass('noMatch');
        return 'mismatch'
      }
    }

 /*   
      $('#emailMatchTest').html(checkEmailMatch($('#createEmail').val(), $('#createEmailConfirmation').val()));

      $('#createEmailConfirmation').keyup(function() {
        $('#emailMatchTest').html(checkEmailMatch($('#createEmail').val(), $('#createEmailConfirmation').val()));
      });

      $('#createEmail').keyup(function() {
        $('#emailMatchTest').html(checkEmailMatch($('#createEmail').val(), $('#createEmailConfirmation').val()));
      });

      function checkEmailMatch(email, emailConfirm) {
        if (emailConfirm.length == 0) {
          $('#emailMatchTest').removeClass();
          return null;
        } else if (email == emailConfirm) {
          $('#emailMatchTest').removeClass().addClass('match');
          return 'match';
        } else {
          $('#emailMatchTest').removeClass().addClass('noMatch');
          return 'mismatch'
        }
      }
    */
  });
  </script>

<? /* BEING DISABLED FOR BACKPAGE MODIFICATION	
<form method="post" action="<?= $_SERVER["REQUEST_URI"] ?>&amp;action=save_changes" enctype="multipart/form-data">
<input type="hidden" name="user_id" value="<?= $user_row['user_id'] ?>">
  <table width="505" border="0" align="center" cellpadding="4" cellspacing="1">
    <tr> 
	  <th colspan="2" style="background-color:white; padding:2px 0px 10px 0px;"><h1><?= $lang['ACC_PROFILE'] ?></h1></th>
	</tr>
    <tr>
      <td width="150"><?= $lang['ACC_USERNAME'] ?>:</td>
      <td><input name="update_username" type="text" value="<?= $user_row['username'] ?>" size="40"></td>
    </tr>
    <tr>
      <td><?= $lang['ACC_PASSWORD'] ?>:</td>
      <td><input name="update_password" type="password" size="40"></td>
    </tr>
    <tr>
      <td><?= $lang['ACC_PASSWORD_CONF'] ?>:</td>
      <td><input name="password_confirm" type="password" size="40"></td>
    </tr>
    <tr>
      <td><?= $lang['ACC_EMAIL_TWO'] ?>:</td>
      <td><input name="update_email" type="text" value="<?= $user_row['email'] ?>" size="40"></td>
    </tr>
	<tr>
      <td><?= $lang['ACC_YOUR_AV'] ?>:</td>
      <td>
	    <?= $avatar_text ?>
	  </td>
    </tr>
	<tr>
    <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><button type="submit" value="Submit"><?= $lang['ACC_SUBMIT'] ?></button> &nbsp; <button type="reset" value="Reset"><?= $lang['ACC_RESET'] ?></button></td>
    </tr>
  </table>
</form>

ENDS HERE */ ?>

<?php

	
break;


case 'save_changes':


	if ( !empty($img_upload_type) )
	{
		$upload_type = 'avatar';
		include($inc_path . "/file_uploader.php");
	}
	
	$sql2 = "SELECT username FROM " . $t_users ." WHERE username = '$update_username'";
	$result2 = query_db($sql2);
	$row2 = mysql_fetch_array($result2);
	
	$sql3 = "SELECT email FROM " . $t_users ." WHERE email = '$update_email'";
	$result3 = query_db($sql3);
	$row3 = mysql_fetch_array($result3);
	
	
	// Checks to see if user changed username or email and if they already exist
	if ( ereg('[^A-Za-z0-9_ -]', $username) && $only_num_letters == 1 ) 
	{
		$error_message .= $lang['ACC_ERROR_NUMS']; 
	}
	if ( $user_row['username'] != $update_username && mysql_num_rows($result2) > 0 )
	{
		$user_error_msg = str_replace('%%USERNAME%%', $update_username, $lang['ACC_ERROR_USER_USE']);
		$error_message .= $user_error_msg; 
	}
	if ( $user_row['username'] != $update_username && mysql_num_rows($result2) <= 0 )
	{
		$login_again_msg = " " . $lang['ACC_DUE'];
		$clear_cookies = TRUE;
	}
	if ( $user_row['email'] != $update_email && mysql_num_rows($result3) > 0 )
	{
		$email_error_msg = str_replace('%%EMAIL%%', $update_email, $lang['ACC_ERROR_EMAIL_USE']);
		$error_message .= $email_error_msg; 
	}
	if ( strlen($update_username) <= 2 )
    { 
		$error_message .= $lang['ACC_ERROR_USER_MORE']; 
	}
	if ( (!ereg(".+\@.+\..+", $update_email)) || (!ereg("^[a-zA-Z0-9_@.-]+$", $update_email)) )
	{ 
		$error_message .= $lang['ACC_ERROR_EMAIL_VALID'];
	}
	if ( $update_password != $password_confirm && !empty($password_confirm) )
	{ 
	    $error_message .= $lang['ACC_ERROR_PASS_MATCH'];
	}
	if ( $update_username == $update_password && !empty($update_username) )
    { 
		$error_message .= $lang['ACC_ERROR_IDENTICAL']; 
	}
	if ( strlen($user_row['avatar']) > 0 && @$_POST['delete_avatar'] == 'on' )
	{
		unlink($site_path . $avatar_dir .'/' . $user_row['avatar']);
		unlink($site_path . $avatar_dir . '/' . $user_row['avatar_gd']);
		$delete_avatar = 'avatar = NULL, avatar_gd = NULL,';
		general_message($lang['ACC_AV_DELETED'], $lang['ACC_AV_DEL_SUC']);
	}
	
	
	if ( $error_message )
	{
		general_message($lang['ACC_ERROR'], "$error_message $go_back ");
	}
	else
	{
	
		if ( !empty($password_confirm) )
		{
			$md5_password = md5($update_password . SALT);
			$new_password = "password = '$md5_password',";
			
			$clear_cookies = TRUE;
			
			// BEGIN Send User Email (if you have to copy email code again don't use this one)
			$to = $user_row['email'];
			$time_now = date('m-d-Y g:i A', time());
			$subject = $lang['ACC_PASS_UP'];
			
			$email_array = array('%%USERNAME%%', '%%TIME%%', '%%SITENAME%%');
			$email_replace = array($user_row['username'], $time_now, $site_name);
			$user_email_msg = str_replace($email_array, $email_replace, $lang['ACC_CHANGE_EMAIL']);
			
			$message = $user_email_msg . $script_url;
			
			$mailheaders = "Return-path: $main_acc_email\n"; 
			$mailheaders .= "From: $main_acc_email\n"; 
			$mailheaders .= "Reply-To: $main_acc_email\n"; 
			
			mail($to, $subject, $message, $mailheaders);
			// END Send User Email
			
			$login_again_msg = "  {$lang['ACC_LOGIN_AGAIN']} " . $to;
		}
		
		if ( !empty($img_upload_name) && $upload_type == 'avatar' )
		{
			$new_avatar = "avatar = '$img_upload_name', avatar_gd = '$av_img_rename',";
		}
		
		$news_ltr_option = ($newsletter == 1) ? ", newsletter = '1'" : ", newsletter = NULL";
		
		
		if ( $clear_cookies == TRUE )
		{
			// delete user login due to password change
			setcookie ($ck_username, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
			setcookie ($ck_session, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
			setcookie ($ck_userid, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
		}
		
		if ( $error_message == '' )
		{	
		
			$sql = "UPDATE " . $t_users . " SET
					username = '$update_username',
					$new_password
					$delete_avatar
					$new_avatar
					email = '$update_email'
					$news_ltr_option 
					WHERE user_id = '$user_id'"; 
		
			//echo $sql . '<br>'; // testing
			if ( query_db($sql) )
			{
				if ( mysql_affected_rows() )
				{
					general_message($lang['ACC_USER_UPDATE'], $lang['ACC_PRO_UPDATE'] . ' ' . $login_again_msg . ' 
									 <br><br><a href="'.$acc_panel_link.'&amp;action=user_profile_edit">'.$lang['ACC_GO_BACK'].'</a>');
				}
				else
				{
					general_message($lang['ACC_NO_CHANGE'], $lang['ACC_NO_CHNG_PRO'] . ' ' . $login_again_msg . ' 
									 <br><br><a href="'.$acc_panel_link.'&amp;action=user_profile_edit">'.$lang['ACC_GO_BACK'].'</a>');
				}
				header('Refresh: 20; url="'.$acc_panel_link.'"');				 
			}
			else
			{
				general_message($lang['ACC_ERROR'], 'Error updating user profile'); 
			}
		   
		}
	
	}

break;



default:
 
 	//$public_profile_link = ( $sef_urls ) ?  $user_row['user_id'] : 'index.php?profile_value='.$user_row['user_id']; 
													   
	require_once("pager.cls.php");
	
	$colors = array('acc_row_dark', 'acc_row_light');
	
	$page = $_GET['page'] ? $_GET['page'] : 1;
	
	$adres = mysql_query("SELECT adid FROM $t_ads WHERE user_id = '".$user_row['user_id']."'");
	
	$adcount = @mysql_num_rows($adres);


?>


	<table width="100%" border="0" cellpadding="4">
	  <tr>
		<td><a href="<?= $_SERVER["REQUEST_URI"] . '&amp;action=user_profile_edit' ?>"><?= $lang['ACC_UPDATE_PRO'] ?></a></td>
		<td align="right"><font class="welcome"><?= $lang['ACC_HELLO'] . ' ' . $user_row['username'] ?></font></td>
	  </tr>
	 <!-- <tr>
		<td>'<a href="'.$public_profile_link.'">View your public profile</a></td>
	  </tr> -->
	<tr>
		<td colspan="2"><a href="<?= $_SERVER["REQUEST_URI"] . '&amp;action=logout' ?>"><?= $lang['ACC_LOGOUT'] ?></a></td>
	  </tr>
	</table>
	<br />
	<br />
	
	<!-- BEGIN ADS -->
	<?php
	
	$block_ad = FALSE;
	
	if ( $_GET['look'] == 'events' && $page > 1 )
	{
		$block_ad = TRUE;
	} 
	
	if ( $block_ad == FALSE ) 
	{ 
	?>
	
	<table width="100%" border="0" cellpadding="4" class="postlisting panel_border">
	  <tr class="head">
		<td>Your total ads: <?= $adcount ?></td>
	  </tr>
	  <?php	include($inc_path . "/user_ads.php"); ?>
	</table>
	<div style="float:right; padding: 5px 0px 5px 0px">
	<table>
	  <tr>
		<td><b><?php echo $lang['PAGE']; ?>: </b></td>
		<td><?php echo $pager->outputlinks(); ?></td>
	  </tr>
	</table>		  
	</div>
	<!-- END ADS -->
	<br />
	<br />
	<?php
	}
	
	$block_event = FALSE;
	
	if ( $_GET['look'] == 'ads' && $page > 1 )
	{
		$block_event = TRUE;
	} 
	
	if ( $enable_calendar == TRUE && $block_event == FALSE ) 
	{ 
	
		$evres = mysql_query("SELECT adid FROM $t_events WHERE user_id = '".$user_row['user_id']."'");
		
		$evcount = @mysql_num_rows($evres);
	
	?>
	<!-- BEGIN EVENTS -->
	<table width="100%" border="0" cellpadding="4" class="postlisting panel_border">
		<tr class="head">
		<td>Your total events: <?= $evcount ?></td>
	  </tr>
	  <?php include($inc_path . "/user_events.php"); ?>
	</table>
	<div style="float:right; padding: 5px 0px 5px 0px">
	<table>
	  <tr>
		<td><b><?php echo $lang['PAGE']; ?>: </b></td>
		<td><?php echo $pager->outputlinks(); ?></td>
	  </tr>
	</table>		  
	</div>
	<!-- END EVENTS -->
<?php
}

break;
}  // end switch


ob_end_flush();

?>
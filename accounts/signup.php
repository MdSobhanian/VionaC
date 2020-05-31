<body id="CreateAccount" class="CentralView">
<center><h1><a href="<?php echo $homeurl; ?>" target="_top"><img src="./images/logo_transparentbg.png" alt="Home"></a></h1></center><br /><br />
<?php

session_start();

define('IN_SCRIPT', true); 

// Extra security - do not remove
if ( empty($_GET['view']) && ( !$_POST || !$_GET ) )
{
	header("Location: ./"); 
	exit;
}


if ( $acc_construction )
{
	general_message($lang['ACC_CONSTRUCTION'], $lang['ACC_CONSTRUCTION_MSG'] . $go_back);
	exit;
}


if($image_verification) 
{
	require_once("{$path_escape}captcha.cls.php");
	$captcha = new captcha();
}



if ( !empty($_COOKIE[$ck_username]) || !empty($_COOKIE[$ck_session]) || !empty($_COOKIE[$ck_userid]) )
{
	header("Location: $acc_login_link");
	exit;
}
	


$user_ip = $_SERVER['REMOTE_ADDR'];


if ( $submit )
{
	
	$success = '';
	
	// BEGIN ERROR CHECKS
	if ( strlen($username) <= 2 )
    { 
		$error_message .= $lang['ACC_ERROR_USER_MORE']; 
	}
	if ( (!ereg(".+\@.+\..+", $email)) || (!ereg("^[a-zA-Z0-9_@.-]+$", $email)) )
	{ 
		$error_message .= $lang['ACC_ERROR_EMAIL_VALID']; 
	}
	$sql = "SELECT email FROM " . $t_users . " WHERE email = '$email'";
	$result = query_db($sql);
	if ( mysql_num_rows($result) ) 
	{
		$email_error_msg = str_replace('%%EMAIL%%', $email, $lang['ACC_ERROR_EMAIL_USE']);
		$error_message .= $email_error_msg; 
	}
	$sql2 = "SELECT username FROM " . $t_users . " WHERE username = '$username'";
	$result2 = query_db($sql2);
	if ( mysql_num_rows($result2) ) 
	{
		$user_error_msg = str_replace('%%USERNAME%%', $username, $lang['ACC_ERROR_USER_USE']);
		$error_message .= $user_error_msg; 
	}
	if ( ereg('[^A-Za-z0-9_ -]', $username) && $only_num_letters == 1 ) 
	{
		$error_message .= $lang['ACC_ERROR_NUMS']; 
	}
	if ( strlen($password) <= 2 )
	{ 
	    $error_message .= $lang['ACC_ERROR_PASS_MORE']; 
	}
	if ( $password != $password_confirm )
	{ 
	    $error_message .= $lang['ACC_ERROR_PASS_MATCH']; 
	}
	if ( $username == $password && !empty($username) )
    { 
		$error_message .= $lang['ACC_ERROR_IDENTICAL']; 
	}

	if( $image_verification && !$captcha->verify($_POST['captcha']) )
	{
	    $error_message .= "{$lang['ERROR_IMAGE_VERIFICATION_FAILED']}<br>";
	}	
	// END ERROR CHECKS
	
	if ( $error_message )
	{
		general_error_message($lang['ACC_ERROR'], $error_message);
	}
	else
	{
		
		$md5_password = md5($password . SALT);
		$join_date = time();
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$newsletter=$_POST['newsletter'];
		
		if ( !empty($how_found) )
		{
			$how_option = "how_found,";
		    $how_value = "'$how_found',";	
		}
		
		$sql = "INSERT INTO " . $t_users . " 
				( 
				 username, 
				 password, 
				 email, 
				 joined,
				 newsletter,
				 $how_option
				 user_ip
				) 
				VALUES 
				(
				 '$username',
				 '$md5_password',
				 '$email',
				 '$join_date',
				 '$newsletter',
				 $how_value
				 '$user_ip'
			    )";
		query_db($sql);
		
		unset($_SESSION['captcha']);
		
		if($image_verification) $captcha->resetCookie();
		
		if ($user_email_activation == 1)
		{
			
			$verify_link = $script_url . '/index.php?view=signup&action=email_activation&confirm=' . $md5_password . '&conf_join=' . $join_date;
			
			$to = $email;
			$subject = $lang['ACC_VER_SUB'];
			
			$email_array = array('%%USERNAME%%', '%%VERIFY%%', '%%PASSWORD%%');
			$email_replace = array($username, $verify_link, $password);
			$user_email_msg = str_replace($email_array, $email_replace, $lang['ACC_SIGNUP_EMAIL']);

			
			$message = $user_email_msg;

			$mailheaders = "Return-path: $main_acc_email\n"; 
			$mailheaders .= "From: $main_acc_email\n"; 
			$mailheaders .= "Reply-To: $main_acc_email\n"; 
			
			
			mail($to, $subject, $message, $mailheaders);
			
			$to_email_msg = str_replace('%%TO%%', $to, $lang['ACC_EMAIL_CUR_INACTIVE']);
			
			general_message($lang['ACC_EMAIL_DISPATCH'], $to_email_msg);	
			$success = 1;
		}
		else
		{
			general_message($lang['ACC_SIGNUP_SUCCESS'], $lang['ACC_PENDING_ADMIN']);
		}

		
	}
}

switch ($action) 
{
case 'email_activation':

	
	$sql = "SELECT user_id, username, password, active FROM " . $t_users . " 
			WHERE password = '$confirm'
			AND joined = '$conf_join'
			LIMIT 1";
	$result = query_db($sql);
	$row = mysql_fetch_array($result);
	

	if ( $row['active'] == 0 && mysql_num_rows($result) > 0 )
	{
		$sql = "UPDATE " . $t_users . " SET active ='1' WHERE user_id = '".$row['user_id']."' LIMIT 1";
		$result = query_db($sql);
		general_message($lang['ACC_SIGNUP_SUCCESS'], $lang['ACC_THANKS_JOIN'] ."<br><br><a href=\"".$script_url."/".$acc_login_link."\">{$lang['ACC_CLICK_LOGIN']}</a><br>");
	}
	elseif ( $row['active'] == 1 && mysql_num_rows($result) > 0 )
	{
		general_error_message($lang['ACC_ERROR'], $lang['ACC_ACTIVATED']);
	}
	else
	{
		general_error_message($lang['ACC_ERROR'], $lang['ACC_EXPIRED']);
	}
	

break;

default:
		
if ( $action != 'email_activation' && $success != 1 )
{
?>

  <div class="mFormWrap">  
    <h2>Sign Up</h2>  

    <div id="loginForm">
      <form name="createAccount" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>">
<input type="hidden" value="signup" name="action">
      <label for="createUsername"><?= $lang['ACC_USERNAME'] ?></label>
        <input name="username" type="text" required id="createUsername" autocomplete="off" value="<?= $_POST['username']; ?>" />

        <label for="createEmail"><?= $lang['ACC_EMAIL_TWO'] ?></label>
        <input name="email" type="email" required id="createEmail" autocomplete="off" value="<?= $_POST['email']; ?>" />
       
        <label for="createEmailConfirmation">Confirm Email<span id="emailMatchTest"></span></label>
        <input type="email" name="createEmailConfirmation" id="createEmailConfirmation" autocomplete="off" value="" />
      
        <label for="password"><?= $lang['ACC_PASSWORD'] ?><span id="passwordStrengthTest"></span></label>
        <input name="password" type="password" required="required" id="password" autocomplete="off" value="" />
      
        <label for="passwordConfirm"><?= $lang['ACC_PASSWORD_CONF'] ?><span id="passwordMatchTest"></span></label>
        <input type="password" name="password_confirm" id="passwordConfirm" autocomplete="off" value="">
        
       	<?php if ( $image_verification ) { ?>
        <label for="captcha"><?= $lang['POST_VERIFY_IMAGE'] ?><div style="float:right; padding-bottom:7px; margin-top:-5px; padding-right:1px;"><img src="<?= $back_path ?>captcha.image.php?<?php echo rand(0,999); ?>"></div></label>
        <input name="captcha" type="text" required="required" id="captcha" autocomplete="off" value="">
		<?php } ?>

      <? /*  <div class="terms"> */ ?>
          <?php /* echo $lang['ACC_SIGNUP_AGREEMENT']; */ ?>
        <? /* </div> */ ?>
        <div class="terms" style="float:left; margin-right:-20px;">
          <input type="checkbox" name="terms" id="terms" value="1" checked disabled required></div><div class="terms" style="float:left; margin-left:20px;"> <label for="terms"> <?php echo $lang['ACC_SIGNUP_AGREEMENT']; ?></label>
        </div>
<div style="clear:both"></div>
        <div class="terms" style="float:left; margin-right:-20px;">
          <input type="checkbox" name="newsletter" id="newsletter" value="1" <?php if($data['newsletter'] == 1) echo "checked"; ?>></div><div class="terms" style="float:left; margin-left:20px;"> <label for="newsletter"> <?php echo $lang['ACC_POST_NEWSLETTER_OPTION_SINGUP']; ?></label>
        </div>
      
        <input type="submit" name="submit" value="Sign Up" class="signIn">
      
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
    
  });
  </script>


<?php

}

break;

}

 
?>
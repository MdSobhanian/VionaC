<style type="text/css">
/*body {
  background-color: #ffffff !important;
}/*
</style>
<body id="index" class="CentralView">
<div id="centralIndexModule">
<center><a href="<?php echo $homeurl; ?>" target="_top"><img src="./images/logo_transparentbg.png" alt="Home"></a></center><br /><br />
<?php

ob_start();

define('IN_SCRIPT', true); 


if ( $acc_construction )
{
	general_message($lang['ACC_CONSTRUCTION'], $lang['ACC_CONSTRUCTION_MSG'] . $go_back);
	exit;
}



if( !empty($_COOKIE[$ck_username]) && !empty($_COOKIE[$ck_session]) && !empty($_COOKIE[$ck_userid]) )
{
	header("Location: $acc_panel_link");
	exit;
}


$user_ip = $_SERVER['REMOTE_ADDR'];

if ( $username_login_only == 1 )
{
	$u_row = $lang['ACC_USERNAME'];
	$u_field = '<input type="text" class="post" name="username" size="25" maxlength="30" value="'.$_POST['username'].'">';		
}
else
{
	$u_row = $lang['ACC_EMAIL'];
	$u_field = '<input type="text" class="post" name="update_email" size="25" maxlength="30" value="'.$_POST['update_email'].'">';
}



if ( $submit )
{
	
	
	if ( $username_login_only == 1 )
	{
		$u_not_empty = (!empty($username)) ? '1' : '0';
		$u_success = ($username == $row['username']) ? '1' : '0';
		$u_sql = "username = '$username'";
	}
	else
	{
		$u_not_empty = (!empty($update_email)) ? '1' : '0';
		$u_success = ($update_email == $row['email']) ? '1' : '0';
		$u_sql = "email = '$update_email'";
	}

	// BEGIN ERROR CHECKS
	$pro_pass = md5($password . SALT);
	$sql = "SELECT user_id, username, email, password, active, user_ip FROM $t_users 
			WHERE $u_sql AND password = '$pro_pass' LIMIT 1";
			
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);


	if ( empty($username) && $username_login_only == 1 )
	{ 
         $error_message .= $lang['ACC_ERROR_USERNAME']; 
	} 
	if ( empty($update_email) && !$username_login_only )
	{ 
         $error_message .= $lang['ACC_ERROR_EMAIL_VALID']; 
	} 
	if ( empty($password) )
	{ 
	     $error_message .= $lang['ACC_ERROR_PASS']; 
	}
	if ( $row['active'] == 0 && $pro_pass == $row['password'] )
	{ 
	     $error_message .= $lang['ACC_ERROR_NOT_ACTIVE']; 
	}
	if ( $u_not_empty == 1 && !empty($password) && mysql_num_rows($result) <= 0 )
	{ 
	     $error_message .= $lang['ACC_ERROR_LOGIN']; 
	}
	
	if ( $error_message )
	{
		general_error_message($lang['ACC_ERROR'], $error_message);
	}
	else
	{   
		if ( $submit && $error != TRUE ) 
		{
			
			$md5_password = md5($password . SALT);
			
			if ( $savecookies == 1 )
			{
				setcookie($ck_username, $row['username'], time() + $cookie_expire_time, $cookie_path, $cookie_domain);
				setcookie($ck_session, $md5_password, time() + $cookie_expire_time, $cookie_path, $cookie_domain);
				setcookie($ck_userid, $row['user_id'], time() + $cookie_expire_time, $cookie_path, $cookie_domain);
			}
			else
			{
				setcookie($ck_username, $row['username'], 0);
				setcookie($ck_session, $md5_password, 0);
				setcookie($ck_userid, $row['user_id'], 0);
			}
	
			
			$update_empty_ip = ($row['user_ip'] <= 0) ? ", user_ip = '$user_ip'" : "";
			
			$sql = "UPDATE " . $t_users . " SET last_login = '".time()."' $update_empty_ip WHERE user_id ='".$row['user_id']."'";
	        mysql_query($sql);
			header("Location: $acc_panel_link");
			exit;
		}
	}

}

?>


    <div class="mFormWrap mLoginForm">
      <h2><?= $lang['ACC_LOGIN'] ?></h2><br />

      <div id="loginForm">
        <form name="centralLogin" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>">
          <label for="centralEmail">Email</label>
          <input type="text" name="update_email" value="<? echo ($_POST['update_email']); ?>" id="centralEmail">

          <label for="centralPassword"><?= $lang['ACC_PASSWORD'] ?></label>
          <input type="password" name="password" autocomplete="off" value="" id="centralPassword">
      
           
            <p class="forgotPW"><a href="./index.php?view=forgot"><?= $lang['ACC_FORGOT_LOGIN_ON_LOGIN_PAGE'] ?></a></p>          

          <div class="centralRemember" style="margin:5px 15px 15px;">
            
            <input type="checkbox" name="savecookies" value="1" id="centralRemember" checked="checked">
            <label class="labelRight" for="centralRemember"><?= $lang['ACC_REMEMBER'] ?></label>
          </div>
      
          <input type="submit" name="submit" value="<?= $lang['ACC_SUBMIT'] ?>" class="signIn">
        </form>
        <div id="loginFormBtm">    
              
              <label>Don't have an account?</label>
              <p class="createAccount"><a href="<?= $acc_signup_link ?>" target="_top"><?= $lang['ACC_SIGNUP'] ?></a></p>
            
          
        </div><!-- end #loginFormBtm -->
      </div><!-- end loginForm -->  
    </div><!-- end .mFormWrap -->
  </div>


<? /* DISABLED OLD 
<form style="background-color:#fff;" action="<?= $_SERVER["REQUEST_URI"] ?>" method="post">
<br />
<table style="background-color:#eef;" width="200" border="0" align="center" cellpadding="3" cellspacing="2">
  <tr>
    <td height="35" colspan="2" valign="middle"><b><?= $lang['ACC_LOGIN'] ?></b></td>
  </tr> 
  <tr>
    <td width="80" style="padding-bottom:16px"><?= $u_row ?>: </td>
    <td><?= $u_field ?></td>
  </tr>
  <tr>
    <td style="padding-bottom:16px"><?= $lang['ACC_PASSWORD'] ?>: </td>
    <td><input type="password" class="post" name="password" size="25" maxlength="30" value="" ></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?= $lang['ACC_REMEMBER'] ?>: <input type="checkbox" name="savecookies" value="1" checked="checked"></td>
  </tr>
  <tr>
    <td colspan="2"><button type="submit" name="submit" value="Submit"><?= $lang['ACC_SUBMIT'] ?></button></td>
    </tr>
</table>

<table width="300" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td align="right"><a href="<?= $acc_signup_link ?>"><?= $lang['ACC_SIGNUP'] ?></a></td>
  </tr>
</table>
<br>
</form>

	*/ ?>

<?php

ob_end_flush();

?>
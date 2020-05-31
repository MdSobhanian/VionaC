<?php
// File is used to check user cookies to ensure it is the same user on post pages

	
	if ( empty($_COOKIE[$ck_username]) || empty($_COOKIE[$ck_session]) || empty($_COOKIE[$ck_userid]) )
	{
		$logged_in = FALSE;
	}
	else
	{

		$check_u = clean_var($_COOKIE[$ck_username]);
		$check_p = clean_var($_COOKIE[$ck_session]);
		$check_userid = intval($_COOKIE[$ck_userid]);
		
		$sql = "SELECT user_id, username, email FROM $t_users WHERE username = '$check_u' AND password = '$check_p' LIMIT 1";
		$logged_result = mysql_query($sql);
		$logged_row = mysql_fetch_array($logged_result);
		
		if ( $logged_row['user_id'] != $check_userid || mysql_num_rows($logged_result) <= 0 )
		{
			$logged_in = FALSE;
		}
		else
		{
			$logged_in = TRUE;
		}
		
		if ( $no_captcha_logged_in == 1 )
		{
			$image_verification = FALSE;
		}
		
	}	


	if ( $logged_in == FALSE && $force_user_login_post == 1 )
	{
		header("Location: $acc_login_link");
		exit;
	}
	

?>
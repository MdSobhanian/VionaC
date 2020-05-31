<?php
// File is used to check user cookies to ensure it is the same user

	
	if ( empty($_COOKIE[$ck_username]) || empty($_COOKIE[$ck_session]) || empty($_COOKIE[$ck_userid]) )
	{
		header("Location: $acc_login_link");
		exit;
	}
	
	$check_u = clean_var($_COOKIE[$ck_username]);
	$check_p = clean_var($_COOKIE[$ck_session]);
	$check_userid = intval($_COOKIE[$ck_userid]);
	
	$sql = "SELECT * FROM $t_users WHERE username = '$check_u' AND password = '$check_p' LIMIT 1";
	$result = mysql_query($sql);
	$user_row = mysql_fetch_array($result);
	
	if ( $user_row['user_id'] != $check_userid || mysql_num_rows($result) <= 0 )
	{
		setcookie ($ck_username, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
		setcookie ($ck_session, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
		setcookie ($ck_userid, "", time() - $cookie_expire_time, $cookie_path, $cookie_domain);
		general_message("ERROR", "User login has expired. $go_back");
		exit;
	}

	

?>
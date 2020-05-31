<?php

if( !defined('IN_SCRIPT') )
{
	die('Unauthorized Access is Forbidden');
}



// empty vars

$error = 0;
$name_too_short = '';
$error_message = '';


if ( !empty($_POST) )
{

	// posted invals
	$int_vars = array('savecookies', 'level', 'active');
	
	foreach($int_vars as $ints) 
	{ 
		$$ints = intval($_POST[$ints]); 
	} 
	
	// posted clean vars
	// User Edit Profile

	$update_username = clean_var($_POST['update_username']);
	$update_password = clean_var($_POST['update_password']);
	$update_email = clean_var($_POST['update_email']);

	

	$cle_vars = array('user', 'pass', 'submit', 'how_found', 'forgot_login', 'password', 'password_confirm', 'upload_type',
	'delete_user');
	
	foreach($cle_vars as $clevs) 
	{ 
		$$clevs = clean_var($_POST[$clevs]); 
	} 
	
}

if ( !empty($_GET) )
{
	$action = clean_var($_GET['action']);
	$confirm = clean_var($_GET['confirm']);
	$conf_join = clean_var($_GET['conf_join']);
	$profile_value = clean_var($_GET['profile_value']);

}

// Request vars

$user_id = intval($_REQUEST['user_id']);
$username = clean_var($_REQUEST['username']);
$email = clean_var($_REQUEST['email']);
$search_user_ip = $_REQUEST['search_user_ip'];
$row_username = clean_var($_REQUEST['row_username']);


// NOTE: img_upload file type doesn't need security

$img_upload_type = $_FILES["img_upload"]["type"];



?>
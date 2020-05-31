<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                         |
+===================================================+
| File: admin/index.php                             |
| Admin login                                       |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Tue, Aug 02, 2005 ]---*/

if(isset($_POST['dropfold']))
{
if (file_exists('../setup/upgrade/5.4_5.5'))
{
foreach(glob('../setup/upgrade/5.4_5.5/*.*') as $v){
    @unlink($v);
    }
}

if (file_exists('../setup/upgrade/5.0_5.2_5.3'))
{
foreach(glob('../setup/upgrade/5.0_5.2_5.3/*.*') as $v){
    @unlink($v);
    }
}

if (file_exists('../setup/upgrade'))
{
foreach(glob('../setup/upgrade/*.*') as $v){
    @unlink($v);
    }
}

if (file_exists('../setup'))
{
foreach(glob('../setup/*.*') as $v){
    @unlink($v);
    }
}

if (file_exists('../setup/upgrade/5.4_5.5'))
{
$dir1 = @rmdir('../setup/upgrade/5.4_5.5');
}

if (file_exists('../setup/upgrade/5.0_5.2_5.3'))
{
$dir2 = @rmdir('../setup/upgrade/5.0_5.2_5.3');
}

if (file_exists('../setup/upgrade'))
{
$dir3 = @rmdir('../setup/upgrade');
}

if (file_exists('../setup'))
{
$dir4 = @rmdir('../setup');
if (!$dir4)
{
$mssg =  '<form id="loginform" style="width:400px;"><span class="err">Opps! Cannot Delete</span><br /><br />It can be due to many reasons and you must delete files manually.<br><br /><li>Insufficient Folders/Files Permissions <i>(min CHMOD 755)</i></il><li>Other folder(s) exist in setup directory except script\'s origin folders.</li><li>Server does not allow file delete in this method</li></form>';
/*
print "<script>";
print "self.location='setupdel.php?show_err=Delete Permission Denied.'";
print "</script>";
*/
}
else
{
$showmsg = "Setup Folder Deleted Successcully.";
}
}
}
require_once("admin.inc.php");


if ($_POST['admin_pass'] && $_POST['admin_pass'] == $admin_pass)
// Login admin
{
    /* Begin Version 5.3 - Make admin login less strict */
    if ($strict_login)
    {
    	invalidateSession();
    	session_start();
    	session_regenerate_id();
    }
    /* End Version 5.3 - - Make admin login less strict */
    	setcookie($ck_admin, encryptForCookie($admin_pass, "admin", true), 0, "/");
	header("Location: home.php");
	exit;

}
elseif ($_GET['signout'])
// Signout admin
{
	setcookie($ck_admin, "", 0, "/");
	clearSalt("admin");

	/* Begin Version 5.3 - Make admin login less strict */
	if ($strict_login)
	{
	    invalidateSession();
	}
	/* End Version 5.3 - Make admin login less strict */

	header("Location: index.php");
	exit;
}
elseif (isAdmin())
// Already logged in. Redirect to admin home page
{
	header("Location: home.php");
	exit;
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 TRANSITIONAL//EN">
<html>
<head>
<title><?php echo $app_fullname; ?> Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $langx['charset']; ?>">
<?php echo '<div style="display:none;">&#83;&#78;&#101;&#116;&#119;&#111;&#114;&#107;&#115;&#67;&#108;&#97;&#115;&#115;&#105;&#102;&#105;&#101;&#100;&#115;&#46;&#99;&#111;&#109;</div>'; ?>
<link rel="stylesheet" type="text/css" href="astyle.<?php echo $admin_theme; ?>.css">
<link rel="stylesheet" type="text/css" href="apager.css">
</head>

<body id="loginpage">
<br><br><br><br><br><br><br><br><br>
<table align="center"><tr><td align="center">
<div id="logo"><?php echo $app_fullname; ?> Admin Panel</div><br>
<?php echo '<p><span class="err">'.$mssg.'</span></p>'; ?>
<?php
$fold = '../setup';
if (file_exists($fold))
{
echo '<form action="index.php" id="loginform" method="post">';
echo "<br><b>Setup Folder Detected.</b>";
?>

<b>Do you want to delete this folder.</b><br><br>  <button type="submit" name="dropfold">DELETE</button><br /><br>
</form>
<?php
}
else
{
?>

<form name="frmAdminLogin" action="" method="post" id="loginform">
<?php echo '<b>'.$showmsg.'</b>'; ?>
<p><b>Enter Admin Username</b> <br>
  <br>
  <input type="text" name="admin_user" size="25" <?php if($demo) { echo "value=\"admin\""; } ?>>
  <br>
</p>
<p><b>Enter Admin Password</b> <br><br>
  <input type="password" name="admin_pass" size="25" <?php if($demo) { echo "value=\"$admin_pass\""; } ?>><br><br>
</p>
<button type="submit">Login</button>
</form>

<?php
}
?>

<br><br>
Copyright &copy; 2005 <?php echo (($y=date("Y"))>2005 ? " - $y" : ""); ?> <a href="http://www.snetworksclassifieds.com/" target="_blank">SNetworksClassifieds.com</a>. All Rights Reserved.<br>
<br><br>

<?php /*
<select name="theme" onchange="if(this.value)location.href='home.php?theme='+this.value;">
<option value="">- Theme -</option>
<option value="blue">Blue</option>
<option value="cream">Cream</option>
</select>
*/ ?>


</td></tr></table>
</body>

</html>
<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: ipblock.inc.php                             |
| Block useres based on IP address                  |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Tue, Nov 29, 2005 ]---*/



if(!defined('CONFIG_LOADED'))
{
	die("&laquo;");
}

/* Begin Version 5.0 */

function encodeIP($ip)
{
	preg_match("/^([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)$/U", $ip, $ipp);
	$ipval = $ipp[4] + $ipp[3]*256 + $ipp[2]*256*256 + $ipp[1]*256*256*256;
	return  $ipval;
}

$ip = $_SERVER['REMOTE_ADDR'];
$ipval = encodeIP($ip);

/* Begin Version 5.1 - IP Range Block Bug Fix */
$sql = "SELECT ipid FROM $t_ipblock WHERE ipstart <= $ipval && ipend >= $ipval";
/* End Version 5.1 - IP Range Block Bug Fix */
$ipres = mysql_query($sql);

if (@mysql_num_rows($ipres))
{
	list($ipid) = @mysql_fetch_array($ipres);
	$sql = "UPDATE $t_ipblock SET blocks=blocks+1 WHERE ipid='$ipid'";
	mysql_query($sql);

	echo "You have been blocked from using the site for suspected improper usage.<br>Please contact the site administrator if you have any questions.";

	die;
}

/* End Version 5.0 */

?>
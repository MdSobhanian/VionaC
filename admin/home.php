<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                         |
+===================================================+
| File: admin/home.php                              |
| Admin home                                        |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Tue, Aug 02, 2005 ]---*/



require_once("admin.inc.php");
require_once("aauth.inc.php");

/* Begin Version 5.0 */
function printStat($sql) {
	list($stat) = mysql_fetch_row(mysql_query($sql));
	$stat += 0;
	echo number_format($stat);
}
/* End Version 5.0 */

?>
<?php include_once("aheader.inc.php"); ?>

<h2>Welcome <!-- Begin Version 5.7.6 --><?php $user_data_que = mysql_query("SELECT * from clf_user_data");
$user_data = mysql_fetch_array($user_data_que); echo ($user_data[0]); ?><!-- End Version 5.7.6 --> : Overview</h2>

<p class="tip"><img src="images/tip.gif" border="0" align="absmiddle"> Click to the left of the sidebar to show/hide the sidebar</p>

<!-- Begin Version 5.7.6 Version Check Feature -->

<?php if( ini_get('allow_url_fopen') ) {
 $versionFlash=file_get_contents('http://version.flash.snetworksclassifieds.com/index.php?version='.$app_ver.''); 
 echo ($versionFlash.'<br />&nbsp;');
}

else { ?><iframe src="http://version.flash.snetworksclassifieds.com/index.php?version=<?php echo $app_ver; ?>" width="100%" height="27px" frameborder="0" scrolling="no"></iframe> <br /><?php } ?>

<!-- End Version 5.7.6 Version Check Feature -->

<!-- Begin Version 5.0 -->

<table class="stats">
<tr>

<td class="column pay-stat-column">
<?php
$date = time();
$y = date("Y", $date);
$m = date("m", $date);
$d = date("d", $date);
$today_zero_hours = mktime(0, 0, 0, $m, $d, $y);
?>
<div class="stat pay-stat">
<a href="payments.php?fm=<?php echo $m; ?>&fd=<?php echo $d; ?>&fy=<?php echo $y; ?>&tm=<?php echo $m; ?>&td=<?php echo $d; ?>&ty=<?php echo $y; ?>">
<div class="stat-num">
<?php echo $paypal_currency_symbol; ?>
<?php printStat("SELECT SUM(amount) FROM $t_payments WHERE UNIX_TIMESTAMP(receivedat) >= $today_zero_hours"); ?>
</div>
<div class="stat-title">earned<br>today</div>
</a>
</div>

<?php
$w = date("w", $date);
$sunday_zero_hours = mktime(0, 0, 0, $m, $d-$w, $y);
$wy = date("Y", $sunday_zero_hours);
$wm = date("m", $sunday_zero_hours);
$wd = date("d", $sunday_zero_hours);
?>
<div class="stat pay-stat">
<a href="payments.php?fm=<?php echo $wm; ?>&fd=<?php echo $wd; ?>&fy=<?php echo $wy; ?>&tm=<?php echo $m; ?>&td=<?php echo $d; ?>&ty=<?php echo $y; ?>">
<div class="stat-num">
<?php echo $paypal_currency_symbol; ?>
<?php printStat("SELECT SUM(amount) FROM $t_payments WHERE UNIX_TIMESTAMP(receivedat) >= $sunday_zero_hours"); ?>
</div>
<div class="stat-title">earned<br>this week</div>
</a>
</div>

<?php
$dayone_zero_hours = mktime(0, 0, 0, $m, 1, $y);
?>
<div class="stat pay-stat">
<a href="payments.php?fm=<?php echo $m; ?>&fd=1&fy=<?php echo $y; ?>&tm=<?php echo $m; ?>&td=<?php echo $d; ?>&ty=<?php echo $y; ?>">
<div class="stat-num">
<?php echo $paypal_currency_symbol; ?>
<?php printStat("SELECT SUM(amount) FROM $t_payments WHERE UNIX_TIMESTAMP(receivedat) >= $dayone_zero_hours"); ?>
</div>
<div class="stat-title">earned<br>this month</div>
</a>
</div>
</td>

<td class="alt-column urgent-stat-column">
<div class="stat urgent-stat">
<a href="ads.php?abused=1&sortby=8">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_ads WHERE abused > 0"); ?>
</div>
<div class="stat-title">spam/reported<br>ads</div>
</a>
</div>

<div class="stat urgent-stat">
<a href="ads.php?subcatid=-1&abused=1&sortby=8">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_events WHERE abused > 0"); ?>
</div>
<div class="stat-title">spam/reported<br>events</div>
</a>
</div>
</td>

<td class="column warn-stat-column">
<div class="stat warn-stat">
<a href="ads.php?enabled=0">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_ads WHERE enabled = '0'"); ?>
</div>
<div class="stat-title">ads pending <br>approval</div>
</a>
</div>

<div class="stat warn-stat">
<a href="ads.php?subcatid=-1&enabled=0">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_events WHERE enabled = '0'"); ?>
</div>
<div class="stat-title">events pending<br>approval</div>
</a>
</div>

<div class="stat warn-stat">
<a href="images.php?enabled=0">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_imgs WHERE enabled = '0'"); ?>
</div>
<div class="stat-title">images pending<br>approval</div>
</a>
</div>
</td>

<td class="alt-column warn-stat-column">
<div class="stat warn-stat">
<a href="ads.php?verified=0">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_ads WHERE verified = '0'"); ?>
</div>
<div class="stat-title">ads pending <br>email verification</div>
</a>
</div>

<div class="stat warn-stat">
<a href="ads.php?subcatid=-1&verified=0">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_events WHERE verified = '0'"); ?>
</div>
<div class="stat-title">events pending<br>email verification</div>
</a>
</div>

<div class="stat warn-stat">
<a href="images.php?verified=0">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_imgs WHERE verified = '0'"); ?>
</div>
<div class="stat-title">images pending<br>email verification</div>
</a>
</div>
</td>

<td class="column cool-stat-column">
<div class="stat cool-stat">
<a href="ads.php?sortby=11">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_ads WHERE UNIX_TIMESTAMP(createdon) >= $today_zero_hours"); ?>
</div>
<div class="stat-title">ads<br>posted today</div>
</a>
</div>

<div class="stat cool-stat">
<a href="ads.php?subcatid=-1&sortby=11">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_events WHERE UNIX_TIMESTAMP(createdon) >= $today_zero_hours"); ?>
</div>
<div class="stat-title">events<br>posted today</div>
</a>
</div>

<div class="stat cool-stat">
<a href="images.php?sortby=10">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_imgs WHERE UNIX_TIMESTAMP(createdon) >= $today_zero_hours"); ?>
</div>
<div class="stat-title">images<br>posted today</div>
</a>
</div>
</td>

<td class="alt-column cool-stat-column">
<div class="stat cool-stat">
<a href="ads.php?verified=1&enabled=1&status=1">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_ads a WHERE $visibility_condn"); ?>
</div>
<div class="stat-title">ads<br>running</div>
</a>
</div>

<div class="stat cool-stat">
<a href="ads.php?subcatid=-1&verified=1&enabled=1&status=1">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_events a WHERE $visibility_condn"); ?>
</div>
<div class="stat-title">events<br>running</div>
</a>
</div>

<div class="stat cool-stat">
<a href="images.php?verified=1&enabled=1&status=1">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_imgs a WHERE $visibility_condn"); ?>
</div>
<div class="stat-title">images<br>running</div>
</a>
</div>
</td>

</tr>
</table>

<p>&nbsp;</p>

<? /* SECOND STATS STARTS FROM HERE */ ?>

<p><b>ADDON OVERVIEWS</b></p>

<table class="stats">
<tr>
<td class="column cool-stat-column">
<?php
$date = time();
$y = date("Y", $date);
$m = date("m", $date);
$d = date("d", $date);
$today_zero_hours = mktime(0, 0, 0, $m, $d, $y);
?>
<div class="stat cool-stat">
<a href="accounts.php?signup=<?php echo $today_zero_hours; ?>">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users WHERE UNIX_TIMESTAMP(joined) >= $today_zero_hours"); ?>
</div>
<div class="stat-title">new signup<br>today</div>
</a>
</div>

<?php
$w = date("w", $date);
$sunday_zero_hours = mktime(0, 0, 0, $m, $d-$w, $y);
$wy = date("Y", $sunday_zero_hours);
$wm = date("m", $sunday_zero_hours);
$wd = date("d", $sunday_zero_hours);
?>
<div class="stat cool-stat">
<a href="accounts.php?signup=<?php echo $sunday_zero_hours; ?>">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users WHERE UNIX_TIMESTAMP(joined) >= $sunday_zero_hours"); ?>
</div>
<div class="stat-title">signup(s)<br>this week</div>
</a>
</div>

<?php
$dayone_zero_hours = mktime(0, 0, 0, $m, 1, $y);
?>
<div class="stat pay-stat">
<a href="accounts.php?signup=<?php echo $dayone_zero_hours; ?>">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users WHERE UNIX_TIMESTAMP(joined) >= $dayone_zero_hours"); ?>
</div>
<div class="stat-title">signups<br>this month</div>
</a>
</div>
</td>

<td class="alt-column urgent-stat-column">
<div class="stat urgent-stat">
<a href="accounts.php?inactive=1">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users WHERE active = 0"); ?>
</div>
<div class="stat-title">unverified<br>account(s)</div>
</a>
</div>

<div class="stat urgent-stat">
<a href="accounts.php?unsubscribers=1">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users WHERE newsletter = 0"); ?>
</div>
<div class="stat-title">unsubscribed<br>newsletter users</div>
</a>
</div>

<div class="stat urgent-stat">
<a href="accounts.php" title="In last 30 days">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users WHERE UNIX_TIMESTAMP(last_login) >= $dayone_zero_hours"); ?>
</div>
<div class="stat-title">users with<br>no activity</div>
</a>
</div>
</td>

<td class="column warn-stat-column">
<div class="stat warn-stat">
<a href="accounts.php?active=1">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users WHERE active = '1'"); ?>
</div>
<div class="stat-title">active <br>accounts</div>
</a>
</div>

<div class="stat warn-stat">
<a href="accounts.php?subscribers=1">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users WHERE newsletter = '1'"); ?>
</div>
<div class="stat-title">newsletter<br>subscribers</div>
</a>
</div>

<div class="stat warn-stat">
<a href="accounts.php">
<div class="stat-num">
<?php printStat("SELECT COUNT(*) FROM $t_users"); ?>
</div>
<div class="stat-title">total registered<br>users</div>
</a>
</div>
</td>



</tr>
</table>

<!-- End Version 5.0 -->
	
<?php include_once("afooter.inc.php"); ?>
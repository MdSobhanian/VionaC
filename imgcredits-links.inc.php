<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: imgcredits.inc.php                          | 
| Links to view images by poster                    |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Sun, Oct 23, 2005 ]---*/


require_once("initvars.inc.php");
require_once("config.inc.php");


?>
<div class="imagecredits">
<div class="head"><?php echo $lang['IMAGES_CREDITS']; ?></div>

<?php

// Poster list
$sql = "SELECT postername, posteremail, COUNT(*) AS imgcount 
		FROM $t_imgs a
			INNER JOIN $t_cities ct ON a.cityid = ct.cityid
		WHERE $visibility_condn $loc_condn_img
		GROUP BY postername, posteremail";
$res = mysql_query($sql) or die(mysql_error());

while($authrow = @mysql_fetch_array($res))
{
	$posterenc = EncryptPoster("IMG", $authrow['postername'], $authrow['posteremail']);

	if ($sef_urls) $posterurl = "{$vbasedir}$xcityid/images/$posterenc/";
	else $posterurl = "?view=imgs&posterenc=$posterenc&cityid=$xcityid&lang=$xlang";
?>

<a href="<?php echo $posterurl; ?>"><?php echo $authrow['postername']; ?></a>
<span class="count">(<?php echo $authrow['imgcount']; ?>)</span><br>

<?php
}

?>

</div>
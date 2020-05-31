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
<b><?php echo $lang['IMAGES_CREDITS']; ?></b>&nbsp;
<select onchange="if(this.value) location.href='<?php echo $script_url; ?>/'+this.value;">
<option value="">- <?php echo $lang['SELECT']; ?> -</option>
<?php

// Poster list
$sql = "SELECT postername, posteremail, COUNT(*) AS imgcount 
		FROM $t_imgs a
			INNER JOIN $t_cities ct ON a.cityid = ct.cityid
		WHERE $visibility_condn $loc_condn_img
		GROUP BY postername, posteremail";
$res = mysql_query($sql) or die(mysql_error());

while($row = @mysql_fetch_array($res))
{
	$posterenc = EncryptPoster("IMG", $row['postername'], $row['posteremail']);

	/* Begin Version 5.0 */
	$posterurl = buildURL("imgs", array($xcityid, $posterenc));
	/* End Version 5.0 */
?>

<option value="<?php echo $posterurl; ?>" <?php if($posterenc == $xposterenc) echo "selected"; ?>><?php echo $row['postername']; ?> (<?php echo $row['imgcount']; ?>)</option>

<?php
}

?>

</select>
</div>
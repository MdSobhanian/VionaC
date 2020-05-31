<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: images.php                                  | 
| View user posted images                           |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Sun, Oct 23, 2005 ]---*/


require_once("initvars.inc.php");
require_once("config.inc.php");
require_once("pager.cls.php");

// Pager
$page = $_GET['page'] ? $_GET['page'] : 1;
$offset = ($page-1) * $images_per_page;

if ($sef_urls && !$xsearchmode)
{
    /* Begin Version 5.0 */
    $urlformat = buildURL("imgs", array($xcityid, $xposterenc, "{@PAGE}"));
    /* End Version 5.0 */
}
else
{
	/* Begin Version 5.0 */
	$excludes = array('page','msg');
	$urlformat = regenerateURL($excludes) . "page={@PAGE}";
	/* End Version 5.0 */
}

/* Begin Version 5.0 */
// The link to see all images
$allimgslink = buildURL("imgs", array($xcityid));
/* End Version 5.0 */

// View conditions
/* Begin Version 5.1 - Image poster case sensitivity bug fix */
if($xposterenc) $whereplus = "AND MD5(UPPER(CONCAT('IMG', '$encryptposter_sep', a.postername, '$encryptposter_sep', a.posteremail))) = '$xposterenc'";
/* End Version 5.1 - Image poster case sensitivity bug fix */

$whereplus .= " $loc_condn_img";

?>

<h2><?php if($xposterenc) { ?>
<?php echo $lang['IMAGES_BY']; ?> <?php echo $xpostername; ?>
<?php } else { ?>
<?php echo $lang['IMAGES']; ?>
<?php } ?>
</h2>

<table width="100%" cellpadding="0"><tr><td width="150">
<?php if($xposterenc) { ?>
<table><tr><td class="linkbox2" width="150">
<a href="<?php echo $allimgslink; ?>"><?php echo $lang['ALL_IMAGES']; ?></a>
</td></tr></table>
<?php } ?>
</td>
<td align="right">
<?php include_once("imgcredits.inc.php"); ?>
</td></tr></table><br><br>


<table width="98%"><tr><td valign="top">

<div class="imglisting">

<?php

$sql = "SELECT COUNT(*)
		FROM $t_imgs a
			INNER JOIN $t_cities ct ON a.cityid = ct.cityid
		WHERE $visibility_condn
			$whereplus";
list($imgcount) = mysql_fetch_array(mysql_query($sql));

$sql = "SELECT a.*, UNIX_TIMESTAMP(a.createdon) AS createdon, 
			COUNT(*) AS commentcount, ic.imgid AS hascomments
		FROM $t_imgs a
			INNER JOIN $t_cities ct ON a.cityid = ct.cityid
			LEFT OUTER JOIN $t_imgcomments ic ON a.imgid = ic.imgid
		WHERE $visibility_condn 
			$whereplus
		GROUP BY a.imgid
		ORDER BY a.timestamp DESC
		LIMIT $offset, $images_per_page";
$res = mysql_query($sql) or die($sql.mysql_error());

while ($row=mysql_fetch_array($res))
{
	$posterenc = EncryptPoster("IMG", $row['postername'], $row['posteremail']);
	/* Begin Version 5.0 */
	$imgurl = buildURL("showimg", array($xcityid, $posterenc, $row['imgid']));
	/* End Version 5.0 */
	
	$imgsize = GetThumbnailSize("{$datadir[userimgs]}/{$row[imgfilename]}", $thumb_max_width, $thumb_max_height);

?>

<div class="imgitem">
<?php echo $lang['POST_ID']; ?> M<?php echo $row['imgid']; ?>
<div class="head"><?php echo $row['imgtitle']; ?></div><br>

<div class="caption">

<?php echo $lang['POSTED_BY']; ?>

<?php if($row['showemail']) echo "<a href=\"mailto:$row[posteremail]\" class=\"poster\">$row[postername]</a>"; else echo "<span class=\"poster\">$row[postername]</span>"; ?>

<?php echo $lang['POSTED_ON']; ?>

<span class="time">
<?php echo QuickDate($row['createdon']); ?>
</span>

</div>

<a href="<?php echo $imgurl; ?>"><img class="img" id="img<?php echo $row['imgid']; ?>" border="0" src="<?php echo "{$datadir[userimgs]}/{$row[imgfilename]}"; ?>" width="<?php echo $imgsize[0]; ?>" height="<?php echo $imgsize[1]; ?>"></a><br>

<?php if($row['imgdesc']) { ?><div class="desc"><?php echo $row['imgdesc']; ?></div><?php } ?>

<a href="<?php echo $imgurl; ?>#comments">
<?php if($row['hascomments']) { ?>
(<?php echo $row['commentcount']; ?> <?php echo $lang['X_COMMENTS']; ?>)
<?php } else { ?>
(<?php echo $lang['ZERO_COMMENTS']; ?>)
<?php } ?>
</a>

</div>

<?php

}

?>

</div>

<?php

if ($imgcount > $images_per_page)
{
	$pager = new pager($urlformat, $imgcount, $images_per_page, $page);

?>

<br>
<div>
<table cellspacing="0" cellpadding="0">
<tr><td><b><?php echo $lang['PAGE']; ?>: &nbsp;</b></td><td><?php echo $pager->outputlinks(); ?></td></tr>
</table>
</div>

<?php

}

?>

</td></tr></table>
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

if (!$ximgid)
{
	header("Location: $script_url/?view=imgs&cityid=$xcityid&lang=$xlang");
	exit;
}

$sql = "SELECT *, UNIX_TIMESTAMP(createdon) AS createdon
		FROM $t_imgs a
		WHERE $visibility_condn_admin AND imgid = $ximgid";
$img = @mysql_fetch_array(mysql_query($sql));

if (!$img)
{
	header("Location: $script_url/?view=imgs&cityid=$xcityid&lang=$xlang");
	exit;
}

$qs = "";
foreach($_GET as $k=>$v) $qs .= "$k=$v&";


/* Begin Version 5.0 */
// The link to see all images
$allimgslink = buildURL("imgs", array($xcityid));
$userimgslink = buildURL("imgs", array($xcityid, $xposterenc));
/* End Version 5.0 */

if ($_POST['do']=="postcomment" && $_POST['comment'])
{
	/* Begin Version 5.0 */
	$data = $_POST;

	foreach ($data as $k=>$v)
	{
		if ($k == "comment") {
			recurse($data[$k], 'stripslashes');
			recurse($data[$k], 'htmlspecialchars');
			recurse($data[$k], 'mysql_escape_string');
		}
		else {
			recurse($data[$k], 'stripslashes');
			recurse($data[$k], 'htmlspecialchars');
			recurse($data[$k], 'mysql_escape_string');
		}
	}
	
	$data['postername'] = FilterBadWords($data['postername']);
	$data['comment'] = FilterBadWords($data['comment']);
	
	$sql = "INSERT INTO $t_imgcomments
			SET imgid = $ximgid,
			postername = '$data[postername]',
			comment = '$data[comment]'";
	mysql_query($sql) or die(mysql_error());
	if(mysql_affected_rows()) $msg = $lang['MESSAGE_COMMENT_POSTED'];
	/* End Version 5.0 */	
}


?>

<h2><?php echo "$lang[IMAGES_BY] $img[postername]" . " : " . $img['imgtitle']; ?></h2>

<?php if($msg) { ?><div class="msg"><?php echo $msg ?></div><?php } ?>
<?php if($err) { ?><div class="err"><?php echo $err ?></div><?php } ?>


<table width="100%" cellpadding="0" cellspacing="0"><tr><td>
<?php if($xposterenc) { ?>
<table border="0" cellpadding="2" cellspacing="1"><tr><td class="linkbox2" width="150">
<a href="<?php echo $allimgslink; ?>"><?php echo $lang['ALL_IMAGES']; ?></a>
</td><td class="linkbox2" width="150">
<a href="<?php echo $userimgslink; ?>"><?php echo $lang['ALL_IMAGES_BY']; ?> <?php echo $xpostername; ?></a>
</td></tr></table>
<?php } ?>
</td><td align="right" width="155">
<?php include("imgcredits.inc.php"); ?>
</td></tr></table>


<table width="98%"><tr><td valign="top">

<?php

if($img)
{
	$imgsize = GetThumbnailSize("{$datadir[userimgs]}/{$img[imgfilename]}", $images_max_width, $images_max_height);

?>

<div class="imgitem">
<?php echo $lang['POST_ID']; ?> M<?php echo $img['imgid']; ?>
<div class="head"><?php echo $img['imgtitle']; ?></div><br>

<div class="caption">

<?php echo $lang['POSTED_BY']; ?>

<?php if($img['showemail']) echo "<a href=\"mailto:$img[posteremail]\" class=\"poster\">$img[postername]</a>"; else echo "<span class=\"poster\">$img[postername]</span>"; ?>

<?php echo $lang['POSTED_ON']; ?>

<span class="time">
<?php echo QuickDate($img['createdon']); ?>
</span>

</div>
<img class="img" id="img<?php echo $img['imgid']; ?>" src="<?php echo "{$datadir[userimgs]}/{$img[imgfilename]}"; ?>" width="<?php echo $imgsize[0]; ?>" height="<?php echo $imgsize[1]; ?>">
<?php if($img['imgdesc']) { ?><div class="desc"><?php echo $img['imgdesc']; ?></div><?php } ?>
</div>

<?php

}

?>


<a name="comments"></a>
<div class="comments">
<div class="head"><?php echo $lang['COMMENTS']; ?></div>
<?php
$sql = "SELECT *, UNIX_TIMESTAMP(timestamp) AS timestamp 
		FROM $t_imgcomments 
		WHERE imgid = $ximgid 
		ORDER BY timestamp DESC";
$res = mysql_query($sql);
if(mysql_num_rows($res))
{
	echo "<br>";
	while($row=mysql_fetch_array($res))
	{
?>
<div class="commentitem">
<span class="poster"><?php echo $row['postername'] ? $row['postername'] : "(Anonymous)"; ?></span>
<span class="time">
<?php echo QuickDate($row['timestamp']); ?>
</span>
<span class="comment"><?php echo $row['comment']; ?></span>
</div>
<?php
	}
}
else
{
	echo "<div class=\"info\">$lang[NO_COMMENTS_MESSAGE]</div>";
}
?><br><br><br>


<form name="frmComments" action="index.php?<?php echo $qs; ?>" method="post">
<table>
<tr>
<td valign="top"><?php echo $lang['POST_YOURNAME']; ?>: </td>
<td><input type="text" size="50" name="postername"></td>
</tr>
<tr>
<td valign="top"><?php echo $lang['POST_YOURCOMMENTS']; ?>: </td>
<td><textarea cols="49" rows="5" name="comment"></textarea></td>
</tr>
<tr>
<td><input type="hidden" size="50" name="do" value="postcomment"></td>
<td><button type="submit" name="postcomment" value="1"><?php echo $lang['BUTTON_POST']; ?></button></td>
</tr>
</table>
</form>

</td></tr></table>
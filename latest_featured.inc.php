<?php

/*-----------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                      |
+================================================+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
|                                                |
|                          //  Sat, Dec 17, 2005 |
+-----------------------------------------------*/


require_once("initvars.inc.php");
require_once("config.inc.php");

?>
<?php
if($latest_featured_ads_count)
{
?>

<!-- Begin Version 5.0 -->
<div class="latestposts">
<!-- End Version 5.0 -->
<div class="head"><img src="images/featured.gif" align="absmiddle">&nbsp; <?php echo $lang['FEATURED_ADS']; ?></div>

<!-- Begin Version 5.0 -->
<table border="0" cellspacing="0" cellpadding="0"  class="postlisting" width="100%"> 
<!-- End Version 5.0 -->

<?php
	$sql = "SELECT a.*, ct.cityname, UNIX_TIMESTAMP(a.createdon) AS timestamp, feat.adid AS isfeat,
				COUNT(*) AS piccount, p.picfile AS picfile, scat.subcatname, scat.catid, cat.catname
			FROM $t_ads a
				INNER JOIN $t_featured feat ON a.adid = feat.adid AND feat.adtype = 'A' AND feat.featuredtill >= NOW()
				INNER JOIN $t_cities ct ON a.cityid = ct.cityid
				INNER JOIN $t_subcats scat ON a.subcatid = scat.subcatid
				INNER JOIN $t_cats cat ON scat.catid = cat.catid
				LEFT OUTER JOIN $t_adpics p ON a.adid = p.adid AND p.isevent = '0'
			WHERE $visibility_condn
				$loc_condn
			GROUP BY a.adid
			ORDER BY a.createdon DESC
			LIMIT $latest_featured_ads_count";
	$res_latest = mysql_query($sql) or die($sql.mysql_error());

	$css_first = "_first";
	while($row = mysql_fetch_array($res_latest))
	{
		/* Begin Version 5.0 */
		$url = buildURL("showad", array($xcityid, $row['catid'], $row['catname'], $row['subcatid'], $row['subcatname'], $row['adid'], $row['adtitle']));
		/* End Version 5.0 */

?>
	
		<?php 
		/*if($row['isfeat']) 
		{
			//$feat_class = "class=\"featured\"";
			$feat_img = "<img src=\"images/featured.gif\" align=\"absmiddle\">";
		} 
		else 
		{ 
			//$feat_class = "";
			$feat_img = "";
		}*/

		if($row['picfile']) 
		{
			$picfile = $row['picfile'];
			$imgsize = GetThumbnailSize("{$datadir[adpics]}/{$picfile}", $tinythumb_max_width, $tinythumb_max_height);
		}
		else 
		{
			$picfile = "";
		}
		?>

		<tr>
			<td width="15">
			<img src="images/bullet.gif" align="absmiddle">
			</td>
			
			<td>
			<b><a href="<?php echo $url; ?>" <?php echo $feat_class; ?>><?php echo $row['adtitle']; ?></a></b>
			<?php if(0&&$row['picfile']) { ?><img src="images/adwithpic.gif" align="absmiddle"><?php } ?><br>


			<span class="adcat">
			
			
			
			<?php echo "$row[catname] $path_sep $row[subcatname]"; ?>
			
			
			
			<?php 
			$loc = "";
			if($row['area']) $loc = $row['area'];
			if($xcityid < 0) $loc .= ($loc ? ", " : "") . $row['cityname'];
			if($loc) echo "<br>$loc";
			?>			
			
			</span>

			
			
			</td>

			<td  align="right" width="<?php echo $tinythumb_max_width; ?>">
			<?php if($picfile) { ?>
			<a href="<?php echo $url; ?>"><img src="<?php echo "{$datadir[adpics]}/{$picfile}"; ?>" border="0" width="<?php echo $imgsize[0]; ?>" height="<?php echo $imgsize[1]; ?>" style="border:1px solid black"></a>
			<?php } ?>
			</td>
			
		</tr>

<?php
		$css_first = "";
	}
?>

</table>
</div>

<?php
}
?>
<?php

/*-----------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                      |
+================================================+
| Copyright � 2005 George Robert (SNETWORKS),       |
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
if($upcoming_events_count)
{
?>

<!-- Begin Version 5.0 -->
<div class="latestposts">
<!-- End Version 5.0 -->

<!-- Begin Version 5.0 -->
<div class="head"><?php echo $lang['UPCOMING_EVENTS']; ?></div>
<!-- End Version 5.0 -->

<!-- Begin Version 5.0 -->
<table border="0" cellspacing="0" cellpadding="0"  class="postlisting" width="100%">
<!-- End Version 5.0 -->


<?php
	$sql = "SELECT a.*, UNIX_TIMESTAMP(a.starton) AS starton_ts, UNIX_TIMESTAMP(a.endon) AS endon_ts, feat.adid AS isfeat,
				COUNT(*) AS piccount, p.picfile AS picfile, ct.cityname
			FROM $t_events a
				INNER JOIN $t_cities ct ON a.cityid = ct.cityid
				LEFT OUTER JOIN $t_adpics p ON a.adid = p.adid AND p.isevent = '1'
				LEFT OUTER JOIN $t_featured feat ON a.adid = feat.adid AND feat.adtype = 'E' AND feat.featuredtill >= NOW()
			WHERE $visibility_condn
				$loc_condn
				AND a.starton >= NOW()
			GROUP BY a.adid
			ORDER BY a.starton ASC
			LIMIT $upcoming_events_count";
	$res_latest = mysql_query($sql) or die($sql.mysql_error());

	$css_first = "_first";
	while($row = mysql_fetch_array($res_latest))
	{
		
		$event_start_date = date("Y-m-d", $row['starton_ts']);

        /* Begin Version 5.0 */
        $url = buildURL("showevent", array($xcityid, $event_start_date, $row['adid'], $row['adtitle']));
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
			
			
			
						<!-- Begin Version 5.7 - Month translation -->
			<?php echo $langx['months'][date("n", $row['starton_ts'])-1] . " " . date("d", $row['starton_ts']) . ", " . date("Y", $row['starton_ts']); ?><br>
			<!-- End Version 5.7 - Month translation -->
			
			
			
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
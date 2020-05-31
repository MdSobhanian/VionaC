<?php


if( !defined('IN_SCRIPT') )
{
	die('Unauthorized Access is Forbidden');
}



	$offset = ($page-1) * $acc_ads_per_page;
	
	$urlformat = "{$vbasedir}{$_SERVER['PHP_SELF']}?view=userpanel&amp;look=ads&amp;page={@PAGE}";
	
	$pager = new pager($urlformat, $adcount, $acc_ads_per_page, $page);
												   

	$ad_sql = "SELECT a.adid, a.adtitle, a.code, a.cityid, a.subcatid, a.hits, a.abused, a.enabled, 
			   b.cityname, c.subcatname, c.catid, d.catname,
			   UNIX_TIMESTAMP(a.createdon) AS createdon, UNIX_TIMESTAMP(a.expireson) AS expireson
			   FROM $t_ads a, $t_cities b, $t_subcats c, $t_cats d
			   WHERE a.cityid = b.cityid
			   AND a.subcatid = c.subcatid
			   AND c.catid = d.catid
			   AND a.user_id = '".$user_row['user_id']."'
			   ORDER BY adid DESC 
			   LIMIT $offset, $acc_ads_per_page";
	$ad_res = query_db($ad_sql);
	
	
	
	if ( mysql_num_rows($ad_res) )
	{	
		
		$i = 0;
		
		while ( $ad_row = mysql_fetch_array($ad_res) )
		{
			
			if ( $ad_row['abused'] == 1 )
			{
				$status = '<font color="red">'.$lang['ACC_FLAGGED'].'</font>';
			}
			elseif ($ad_row['enabled'] == 0 )
			{
				$status = '<font color="gray">'.$lang['ACC_PENDING'].'</font>';
			}
			else
			{
				$status = '<font color="green">'.$lang['ACC_ACTIVE'].'</font>';
			}

			
			$feat_res = query_db("SELECT adid FROM $t_featured WHERE adid= ".$ad_row['adid']." LIMIT 1");
			$featured = ( @mysql_num_rows($feat_res) ) ? $lang['ACC_FEATURED'] : $lang['ACC_NOT_FEATURED'];
			
			if ( $sef_urls ) 
			{
				$url = $ad_row['cityid']."/posts/".$ad_row['catid']."-".$ad_row['catname']."/".$ad_row['subcatid']."-".$ad_row['subcatname']."/$ad_row[adid]-" . RemoveBadURLChars($ad_row['adtitle']) . ".html";
				
				$loc_url = $ad_row['cityid'] . "-{$ad_row[cityname]}/";
				
				$cat_url = $ad_row['cityid'] . "/posts/{$ad_row[catid]}-{$ad_row[catname]}/";

				$subcat_url = $ad_row['cityid'] . "/posts/{$ad_row[catid]}-{$ad_row[catname]}/{$ad_row[subcatid]}-{$ad_row[subcatname]}/";
			}
			else 
			{
				$url = "index.php?view=showad&amp;adid=$ad_row[adid]&amp;cityid=".$ad_row['cityid']."&amp;lang=$xlang";
				
				$loc_url = "index.php?view=main&amp;cityid={$ad_row[cityid]}";
				
				$cat_url = "index.php?view=ads&amp;catid={$ad_row[catid]}&amp;subcatid=&amp;cityid={$ad_row[cityid]}";
				
				$subcat_url = "index.php?view=ads&amp;catid={$ad_row['catid']}&amp;subcatid={$ad_row['subcatid']}&amp;cityid={$ad_row['cityid']}";
			}
			
			$catgory = '<a href="'.$cat_url.'">'.$ad_row['catname'].'</a>'.$path_sep.'<a href="'.$subcat_url.'">'.$ad_row['subcatname'].'</a>';
			
			$codemd5 = md5($ad_row["code"]);
			$edit_url = "index.php?view=edit&amp;adid=".$ad_row['adid']."&amp;codemd5=".$codemd5;
			
			if ( $enable_featured_ads && @mysql_num_rows($feat_res) <= 0 )
			{
				$feat_button = '<div style="padding-top:5px">
								  <button onClick="location.href=\''.$edit_url.'&amp;target=promote&amp;promo\'">'.$lang['ACC_FEATURE'].'</button>
								</div>';
			}
			

			?>
			
						  <tr>
						  	<td>
							<table width="100%" border="0" cellpadding="0" cellspacing="0" class="<?= $colors[$i++ % 2] ?>" >
							  <tr>
								<td width="75"><b><?= $lang['ACC_ID'] ?>:</b></td>
								<td width="60%">A<?= $ad_row['adid'] ?></td>
								<td width="80"><b><?= $lang['ACC_STATUS'] ?>:</b></td>
								<td width="40%"><?= $status ?></td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_TITLE'] ?>:</b></td>
								<td><?= $ad_row['adtitle'] ?></td>
								<td><b><?= $lang['ACC_PREMIUM'] ?>:</b></td>
								<td><?= $featured ?></td>
							  </tr>
							  <tr>
								<td><b><?= $lang['POST_LOCATION'] ?>:</b></td>
								<td><a href="<?= $loc_url ?>"><?= $ad_row['cityname'] ?></a></td>
								<td><b><?= $lang['ACC_ACTIONS'] ?>:</b></td>
								<td rowspan="5" valign="top">
<div style="text-align:left; line-height:20px">								
<a href="<?= $url ?>"><img src="images/icon_view.gif" width="18" height="18" alt="" align="absmiddle" border="0"> <?= $lang['ACC_AD_VIEW'] ?></a><br>
<a href="<?= $edit_url ?>"> <img src="images/icon_edit.gif" width="18" height="18" alt="" align="absmiddle" border="0"> <?= $lang['ACC_AD_EDIT'] ?></a><br>
<a href="index.php?view=userpanel&amp;action=delete_ad&amp;adid=<?= $ad_row['adid'] ?>" onclick="return(confirm('<?= $lang['ACC_SURE_DEL'] ?> (A<?= $ad_row['adid'] ?>)?'));"><img src="images/icon_delete.gif" width="18" height="18" alt="" align="absmiddle" border="0"> <?= $lang['ACC_AD_DEL'] ?></a>
<?= $feat_button ?>
</div>
</td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_CAT'] ?>:</b></td>
								<td><?= $catgory ?></td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_POSTED'] ?>:</b></td>
								<td><?php echo QuickDate($ad_row['createdon']); ?></td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_EXPIRE'] ?>:</b></td>
								<td><?php echo QuickDate($ad_row['expireson']); ?></td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_HITS'] ?>:</b></td>
								<td><?= $ad_row['hits'] ?></td>
								<td>&nbsp;</td>
							  </tr>
							</table>
							</td>
						  </tr>
			
			<?php
		}
	}
	else
	{
		?>
		<tr><td align="center" colspan="3"><?= $lang['ACC_NO_ADS'] ?></td></tr>
		<?php
	}	

	

?>
<?php


if( !defined('IN_SCRIPT') )
{
	die('Unauthorized Access is Forbidden');
}



	$offset = ($page-1) * $acc_evs_per_page;
	
	
	$urlformat = "{$vbasedir}{$_SERVER['PHP_SELF']}?view=userpanel&amp;look=events&amp;page={@PAGE}";
	
	$pager = new pager($urlformat, $evcount, $acc_evs_per_page, $page);
	
	$ev_sql = "SELECT a.adid, a.adtitle, a.code, a.cityid, a.starton, a.hits, a.abused, a.enabled, b.cityname,
			   UNIX_TIMESTAMP(a.createdon) AS createdon, UNIX_TIMESTAMP(a.expireson) AS expireson
			   FROM $t_events a, $t_cities b
			   WHERE a.cityid = b.cityid
			   AND a.user_id = '".$user_row['user_id']."'
			   ORDER BY adid DESC  
			   LIMIT $offset, $acc_evs_per_page";
												   
	$ev_res = query_db($ev_sql);
	
	
	

	if ( mysql_num_rows($ev_res) )
	{
		$i = 0;
		
		while ( $ev_row = mysql_fetch_array($ev_res) )
		{
			if ( $ev_row['abused'] == 1 )
			{
				$status = '<font color="red">'.$lang['ACC_FLAGGED'].'</font>';
			}
			elseif ($ev_row['enabled'] == 0 )
			{
				$status = '<font color="gray">'.$lang['ACC_PENDING'].'</font>';
			}
			else
			{
				$status = '<font color="green">'.$lang['ACC_ACTIVE'].'</font>';
			}
			
			$feat_res = query_db("SELECT adid FROM $t_featured WHERE adid= ".$ev_row['adid']." LIMIT 1");
			$featured = ( @mysql_num_rows($feat_res) ) ? $lang['ACC_EV_FEATURED'] : $lang['ACC_EV_NOT_FEATURED'] ;
			
			if ( $sef_urls ) 
			{

				$url = $ev_row['cityid']."/events/".$ev_row['starton']."/$ev_row[adid]-" . RemoveBadURLChars($ev_row['adtitle']) . ".html";
				
				$loc_url = $ev_row['cityid'] . "-{$ev_row[cityname]}/";
				
			}
			else 
			{
				$url = "index.php?view=showad&amp;adid=$ev_row[adid]&amp;cityid=".$ev_row['cityid']."&amp;lang=$xlang";
				
				$loc_url = "index.php?view=main&amp;cityid={$ev_row[cityid]}";

			}
			
			
			$codemd5 = md5($ev_row["code"]);

			$edit_url = "index.php?view=edit&amp;&amp;isevent=1&amp;adid=".$ev_row['adid']."&amp;codemd5=".$codemd5;
			
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
								<td width="60%">E<?= $ev_row['adid'] ?></td>
								<td width="80"><b><?= $lang['ACC_STATUS'] ?>:</b></td>
								<td width="40%"><?= $status ?></td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_TITLE'] ?>:</b></td>
								<td><?= $ev_row['adtitle'] ?></td>
								<td><b><?= $lang['ACC_PREMIUM'] ?>:</b></td>
								<td><?= $featured ?></td>
							  </tr>
							  <tr>
								<td><b>Location:</b></td>
								<td><a href="<?= $loc_url ?>"><?= $ev_row['cityname'] ?></a></td>
								<td><b><?= $lang['ACC_ACTIONS'] ?>:</b></td>
								<td rowspan="5" valign="top">
<div style="text-align:left; line-height:20px">								
<a href="<?= $url ?>"><img src="images/icon_view.gif" width="18" height="18" alt="" align="absmiddle" border="0"> <?= $lang['ACC_EV_VIEW'] ?></a><br>
<a href="<?= $edit_url ?>"> <img src="images/icon_edit.gif" width="18" height="18" alt="" align="absmiddle" border="0"> <?= $lang['ACC_EV_EDIT'] ?></a><br>
<a href="index.php?view=userpanel&amp;action=delete_event&amp;adid=<?= $ev_row['adid'] ?>" onclick="return(confirm('Are you sure you want to delete event ID (E<?= $ev_row['adid'] ?>)?'));"><img src="images/icon_delete.gif" width="18" height="18" alt="" align="absmiddle" border="0"> <?= $lang['ACC_EV_DEL'] ?></a>
<?= $feat_button ?>
</div>
</td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_STARTS'] ?>:</b></td>
								<td><?= $ev_row['starton'] ?></td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_POSTED'] ?>:</b></td>
								<td><?php echo QuickDate($ev_row['createdon']); ?></td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_EXPIRE'] ?>:</b></td>
								<td><?php echo QuickDate($ev_row['expireson']); ?></td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td><b><?= $lang['ACC_HITS'] ?>:</b></td>
								<td><?= $ev_row['hits'] ?></td>
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
		<tr><td align="center" colspan="3"><?= $lang['ACC_NO_EVENTS'] ?></td></tr>
		<?php

	}	

	

?>
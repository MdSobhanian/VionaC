<?php
/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS		                    |
+===================================================+
| File: admin/accounts.php                          |
| Admin section of account mod      			    |
+---------------------------------------------------+
| Email: support@snetworks.biz                      |
| Website: www.snetworksclassifieds.com				|
+--------------------------[ Fri, Dec 25, 2009 ]---*/

//error_reporting(E_ALL);


require_once("admin.inc.php");

require_once("aauth.inc.php");

require_once("../pager.cls.php");

require_once("../{$acc_dir}/acc_config.php");

$users_per_page = 50; // limit how many users to appear on each page


$_POST['do'] = strtolower($_POST['do']);

$_GET['do'] = strtolower($_GET['do']);

$_REQUEST['do'] = strtolower($_REQUEST['do']);


include_once("aheader.inc.php"); 


$acc_active = ($enable_account == 1) ? '<font color="green">Enabled</font>' : '<font color="red">Disabled</font>';

if ( $action == 'add_user' ) { $header_title = 'Add New User'; }
elseif ( $action == 'edit_user' ) { $header_title = 'Edit User Account'; }
else { $header_title = 'Users Manager'; }


if ( $_POST['del'] )
{
	$d = 0;
	$nd = 0;
	foreach ($_POST['delid'] as $del_id)
	{
		$sql = "DELETE FROM $t_users WHERE user_id = '$del_id' AND level != '".OWNER."'";
			
		if (mysql_query($sql) && mysql_affected_rows()) $d++;
		else $nd++;
	}
	
	$msg = "$d users(s) have been deleted";
	if($nd) $err = "$nd users(s) could not be deleted";
} 

?>


<h2><?= $header_title ?></h2>

<div align="right" style="padding:4px"><b>Account Mod is <?= $acc_active ?></b></div>

<div class="msg"><?= $msg; ?></div>

<div class="err"><?= $err; ?></div>


<?php

switch ($action)
{
case 'add_user':

	if ( $submit )
	{
		if ( strlen($update_username) <= 2 )
		{ 
			$error_message .= "The Username must be more than 2 characters<br>"; 
		}
		if ( empty($update_password) )
		{ 
			$error_message .= "Please enter a password for this user<br>"; 
		}
		if ( empty($update_email) )
		{ 
			$error_message .= "Please enter an email for this user<br>"; 
		}
		
		if ( $error_message )
		{
			echo "<div class=\"err\">{$error_message}</div>";
		}
		else
		{
			
			$md5_password = md5($update_password . SALT);
			$join_date = time();
			
			$sql = "INSERT INTO " . $t_users . " 
					( 
					 active,
					 username, 
					 password, 
					 email, 
					 joined
					) 
					VALUES 
					(
					 '1',
					 '$update_username',
					 '$md5_password',
					 '$update_email',
					 NOW()
					)";
			mysql_query($sql);
			
			if ( mysql_error() )
			{
				echo "<div class=\"err\">SQL error when adding new user</div><br>" .mysql_error();
			}
			else
			{
				echo "<div class=\"msg\">You have successfully added the new user &quot;{$update_username}&quot;</div>";
			}
		}	
		
	}
	
	?>
	
	<script language="javascript">
	<!-- 
	function randomPassword(length)
	{
	   chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
	   pass = "";
	   for(x=0;x<length;x++)
	   {
		 i = Math.floor(Math.random() * 67);
		 pass += chars.charAt(i);
	   }
	   return pass;
	}
	function formSubmit()
	{
	   passform.update_password.value = randomPassword(passform.length.value);
	   return false;
	}
	// -->
	</script>
	
    <form name="passform" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>">
	<input type="hidden" name="length" value="9">
	<div style="padding: 0px 0px 6px 386px"><a href="accounts.php">User Accounts Page</a></div>
	<table class="grid" cellspacing="1" cellpadding="6" width="500">
	  <tr class="gridhead">
		 <td colspan="2">Create New Account</td>
	  </tr>
	  <tr class="gridcell">
		 <td width="120">Username:</td>
		 <td><input name="update_username" type="text" value="<?= $row['username'] ?>" size="40"></td>
	  </tr>
	  <tr class="gridcell">
		<td>Password:</td>
		<td><input name="update_password" type="text" size="40"> &nbsp; <input type="button" class="button" value="Generate" onClick="javascript:formSubmit()" tabindex="2"></td>
	  </tr>
	  <tr class="gridcell">
		 <td>Email:</td>
		 <td><input name="update_email" type="text" value="<?= $row['email'] ?>" size="40"></td>
	  </tr>
	  <tr>
		 <td colspan="2">
		  <button type="submit" name="submit" value="Submit">Submit</button>
		  <button type="reset" value="Reset">Reset</button></td>
	  </tr>
	</table>  	
	</form>
	<?php
	
break;

case 'edit_user':


	$sql = "SELECT * FROM " . $t_users . " WHERE user_id = '{$user_id}' LIMIT 1";
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);

	
	if ( strlen($row['avatar']) > 0 )
	{
		$avatar_text = '<div>Current Avatar</div>
						<div style="padding: 3px 0px 3px 0px;">
					    <img src="../' .$avatar_dir .'/' . $row['avatar'] . '" id="fImage" alt="" />
						</div>
					    <input type="checkbox" name="delete_avatar" value="1" />
						&nbsp;Delete Image';	
	}
	else
	{
		$avatar_text = '<table width="100%" border="0" cellpadding="3">
						  <tr>
							<td>No avatar uploaded.</td>
						  </tr>
						  <tr>
							<td>Max dimensions: '.$avatar_max_height.' height x '.$avatar_max_width.' width</td>
						  </tr>
						  <tr>
							<td>Max filesize: '.$file_avatar_kb.' kb</td>
						  </tr>
						</table>
						<br>
						<input name="img_upload" type="file" size="30" />';	
	}
	
	if ( $row['level'] != OWNER )
	{
		$delete_user_option = '<input name="delete_user" type="checkbox" value="1"> Delete this user';
	}
	else
	{
		$delete_user_option = 'Site owners cannot be deleted';
	}
	
	$user_ip = ($row['user_ip'] <= 0) ? 'NULL' : '<a href="http://whois.domaintools.com/'.$row['user_ip'].'" target="_blank">'.$row['user_ip'].'</a>';
	$active = ($row['active'] != 1) ? '<font color="red">Inactive</font>' : '<font color="green">Active</font>';
	$how_found = (is_null($row['how_found'])) ? 'no entry' : $row['how_found'];
	$last_login = ($row['last_login'] <= 0) ? 'Never' : date('m-d-Y g:i A', $row['last_login']);
	
	if ( $submit )
	{
        	$newsletter=$_POST['newsletter'];	
		$success = '';
		$delete_avatar = '';
		
		if ( strlen($update_username) <= 2 )
		{ 
			$error_message .= "The Username must be more than 2 characters<br>"; 
		}
		if ( $update_password != $password_confirm )
		{ 
			$error_message .= "The Password and Confirm Password fields do not match<br>"; 
		}
		if ( $update_username == $update_password && !empty($update_username) )
		{ 
			$error_message .= "The Username and Password are identical.  Please change password<br>"; 
		}

		
		if ( $error_message )
		{
			echo "<div class=\"err\">{$error_message}</div>";
		}
		else
		{
			
			if ( !empty($update_password) )
			{
				$md5_password = md5($update_password . SALT);
				$new_password = "password = '$md5_password',";
			}
			
			if ( !empty($img_upload_type) )
			{
				$upload_type = 'avatar';
				$no_display_success_msg = 1; 
				$site_path = '../'; // added due to being in admin directory
				include_once("../{$acc_dir}/{$inc_path}/file_uploader.php");
				$new_avatar = "avatar = '$img_upload_name', avatar_gd = '$av_img_rename',";
			}
			
					
			if ( strlen($row['avatar']) > 0 && @$_POST['delete_avatar'] == 1 )
			{
				unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $avatar_dir . '/' . $row['avatar']);
				unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $avatar_dir . '/' . $row['avatar']);
				$delete_avatar = 'avatar = NULL, avatar_gd = NULL,';
			}
			
			if ( $delete_user == '1')
			{
				
				if ( strlen($row['avatar']) > 0 )
				{
					unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $avatar_dir . '/' . $row['avatar']);
				}
				$sql = "DELETE FROM " . USERS_TABLE . " WHERE user_id = '$user_id' LIMIT 1";
				
				$optimize = "OPTIMIZE TABLE " . USERS_TABLE;
				
				mysql_query($sql);
				
				mysql_query($optimize);
				
				$success = 'profile has been deleted successfully';
			}
			else
			{
				$sql = "UPDATE " . $t_users . " SET
						active = '".intval($_POST['active'])."',
						username = '$update_username',
						$new_password
						$delete_avatar
						$new_avatar
						email = '$update_email',
						newsletter = '$newsletter'
						WHERE user_id = '$user_id'
						LIMIT 1"; 
						
				mysql_query($sql);	
					
				//echo $sql;	// testing
				
				$success = 'profile has been updated successfully <a href="#" onclick="location.reload();">(refresh again)</a><br />&nbsp;';
			}	
			
		 echo "<div class=\"msg\">{$update_username}'s {$success}</div>";
	     }			
	}
	

	$count1 = mysql_query("SELECT adid FROM $t_ads WHERE user_id = '{$user_id}' AND enabled > '0'");
	$count2 = mysql_query("SELECT adid FROM $t_ads WHERE user_id = '{$user_id}' AND verified > '0'");
	$count3 = mysql_query("SELECT adid FROM $t_ads WHERE user_id = '{$user_id}' AND abused > '0'");
	
	$sql2 = "SELECT adid, adtitle, cityid FROM $t_ads WHERE enabled = '1' AND verified = '1' AND user_id = '{$user_id}' ORDER BY adid DESC LIMIT 5";
	$res2 = mysql_query($sql2);

	
	$user_ad_rows = '';
	
	if ( @mysql_num_rows($res2) )
	{
		while ( $row2 = mysql_fetch_array($res2) )
		{
			$user_ad_rows .= '<tr class="gridcell">
								<td><a href="'.$script_url.'/index.php?view=showad&adid='.$row2['adid'].'&cityid='.$row2['cityid'].'">'.$row2['adtitle'].'</a></td>
							 </tr>';
		}
		
		$user_ad_rows .= '<tr class="gridcell">
							<td colspan="2" align="right"><a href="ads.php?user_id='.$user_id.'">View More Ads</a>&nbsp;</td>
						  </tr>';
		
	}
	else
	{
		$user_ad_rows .= '<tr class="gridcell">
						    <td>Currently no active ads posted</td>
						 </tr>';
	}
	

	
	
?>
	
  <form method="post" action="<?= $_SERVER["REQUEST_URI"] ?>" enctype="multipart/form-data">
  <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
  <div style="padding: 0px 0px 6px 298px"><a href="accounts.php">User Accounts Page</a> | <a href="accounts.php?action=add_user">Add New User</a></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td valign="top">
		<!-- BEGIN left -->
		  <table class="grid" cellspacing="1" cellpadding="6" width="500">
			<tr class="gridhead">
			  <td colspan="2">EDIT <?= $row['username'] ?>'s Account</td>
			</tr>
			<tr class="gridcell">
			  <td width="150">Username:</td>
			  <td><input name="update_username" type="text" value="<?= $row['username'] ?>" size="40"></td>
			</tr>
			<tr class="gridcell">
			  <td>Password:</td>
			  <td><input name="update_password" type="password" size="40"></td>
			</tr>
			<tr class="gridcell">
			  <td>Confirm Password:</td>
			  <td><input name="password_confirm" type="password" size="40"></td>
			</tr>
			<tr class="gridcell">
			  <td>Email:</td>
			  <td><input name="update_email" type="text" value="<?= $row['email'] ?>" size="40"></td>
			</tr>
			<tr class="gridcell">
			  <td>Your Avatar:</td>
			  <td><?= $avatar_text ?> </td>
			</tr>
			<tr class="gridcell">
			  <td>User Active:</td>
			  <td><input name="active" type="radio" value="1" <?php if ($row['active'] == 1) { echo 'checked="checked"'; } ?> />  Yes
				  <input name="active" type="radio" value="0" <?php if ($row['active'] != 1) { echo 'checked="checked"'; } ?> />  No
			  </td>
			</tr>
			<?php /*if ($newsletter) {*/ ?>
			<tr class="gridcell">
			  <td>Newsletter Subscription:</td>
			  <td><input name="newsletter" type="radio" id="newsstat1" value="1" <?php if ($row['newsletter'] == 1) { echo 'checked="checked"'; } ?> /><label for="newsstat1">  Subscribed</label>
				  <input name="newsletter" type="radio" id="newsstat0" value="0" <?php if ($row['newsletter'] != 1) { echo 'checked="checked"'; } ?> /><label for="newsstat0">  Unsubscribed</label>
			  </td>
			</tr>			
			<?php /*}*/ ?>
			<tr class="gridcell">
			  <td>Delete User:</td>
			  <td><?= $delete_user_option ?> </td>
			</tr>
			<tr>
			  <td colspan="2">
			   <button type="submit" name="submit" value="Submit">Submit</button>
			   <button type="reset" value="Reset">Reset</button></td>
			</tr>
		  </table>
		  <!-- END left -->		</td>
		<td valign="top">
		  <!-- BEGIN right -->
		   <table class="grid" cellspacing="1" cellpadding="6" width="300">
			  <tr class="gridhead">
				<td colspan="2">More User Info</td>
			  </tr>
			  <tr class="gridcell">
				<td width="100" class="row1 bigtext">User IP:</td>
				<td class="row1 bigtext"><?= $user_ip ?></td>
			  </tr>
			  <tr class="gridcell">
				<td>Status:</td>
				<td class="row1 bigtext"><?= $active ?></td>
			  </tr>
			  <tr class="gridcell">
				<td>Last Login:</td>
				<td class="row1 bigtext"><?= $last_login ?></td>
			  </tr>
			  <tr class="gridcell">
				<td>Join Date:</td>
				<td class="row1 bigtext"><?= /*date('m-d-Y g:i A', */ $row['joined']; ?></td>
			  </tr>
			  <tr class="gridcell">
				<td>How Found:</td>
				<td class="row1 bigtext"><?= $how_found ?></td>
			  </tr>
			  <tr class="gridcell">
				<td>Approved Ads:</td>
				<td class="row1 bigtext"><?= @mysql_num_rows($count1) ?></td>
			  </tr>
			  <tr class="gridcell">
				<td>Verified Ads:</td>
				<td class="row1 bigtext"><?= @mysql_num_rows($count2) ?></td>
			  </tr>
			   <tr class="gridcell">
				<td>Abused Ads:</td>
				<td class="row1 bigtext"><?= @mysql_num_rows($count3) ?></td>
			  </tr>
		  </table>
		  <br />
		  <br />
		   <table class="grid" cellspacing="1" cellpadding="6" width="300">
			  <tr class="gridhead">
				<td colspan="2"><?= $row['username'] ?>'s Recent Ads</td>
			  </tr>
			  <?= $user_ad_rows ?>
			</table>  
		  <!-- END right -->
		</td>
	  </tr>
	</table>
  </form>

<?php

	
break;
	
default:
	
	
	// BEGIN sort users
	$order_by = ' ORDER BY user_id ASC';
	$pagin_sort = '';
	
	$search_sql = '';
	if ( !empty($_GET['search_user']))
	{
		$get_search_user = clean_var($_GET['search_user']);
		$search_sql = "WHERE username LIKE '%".$get_search_user."%'";
		$pagin_sort .= "&search_user=$get_search_user";
	}
	if ( !empty($_GET['subscribers']))
	{
		$get_news_value = clean_var($_GET['subscribers']);
		$search_sql = "WHERE newsletter = '".$get_news_value."'";
		$pagin_sort .= "&subscribers=$get_news_value";
	}
	if ( !empty($_GET['unsubscribers']))
	{
		$get_news_value2 = clean_var($_GET['unsubscribers']);
		$search_sql = "WHERE newsletter = '%".$get_news_value2."%'";
		$pagin_sort .= "&unsubscribers=$get_news_value2";
	}
	if ( !empty($_GET['active']))
	{
		$get_active_value = clean_var($_GET['active']);
		$search_sql = "WHERE active = '".$get_active_value."'";
		$pagin_sort .= "&active=$get_active_value";
	}
	if ( !empty($_GET['inactive']))
	{
		$get_inactive_value = clean_var($_GET['inactive']);
		$search_sql = "WHERE active = 0";
		$pagin_sort .= "&inactive=$get_inactive_value";
	}
	if ( !empty($_GET['signup']))
	{
		$get_signup_value = clean_var($_GET['signup']);
		$search_sql = "WHERE UNIX_TIMESTAMP(joined) >= '".$get_signup_value."'";
		$pagin_sort .= "&signup=$get_signup_value";
	}
	
	if ( !empty($_GET['sort']) && $_GET['sort'] != '0' )
	{
		$get_sort = clean_var($_GET['sort']);
		$order_by = " ORDER BY $get_sort DESC";
		$pagin_sort = "&sort=$get_sort";
	}
	
	
	$sort_menu = '
				  <select size="1" name="sort">
					<option value="0"> Choose sort option </option>
					<option value="active"> View inactive users </option>
					<option value="user_ip"> View by user IP </option>
					<option value="last_login"> View by last login </option>
				  </select>';
	// END sort users			  

	$page = $_GET['page'] ? $_GET['page'] : 1;

	$offset = ($page-1) * $users_per_page;
	
	$adres = mysql_query("SELECT user_id FROM $t_users $search_sql");
	
	$adcount = @mysql_num_rows($adres);
	
	$urlformat = "{$vbasedir}{$_SERVER['PHP_SELF']}?page={@PAGE}{$pagin_sort}";
	
	$pager = new pager($urlformat, $adcount, $users_per_page, $page);
	
	$sql = "SELECT * FROM $t_users $search_sql $order_by LIMIT $offset, $users_per_page";

	$res = mysql_query($sql);
	
	?>
	<table width="100%">
	<tr>
	<td>
	Account mod management page.  Click on the username to edit user's account.
	</td>
	</tr>
	</table>
	
	<div style="padding:12px 0px 6px 0px">
	<table width="100%">
	  <tr>
		<td>
			<form class="box" action="" method="get" style="width: 500px;">	
			<b>Search Username:</b>	<input name="search_user" type="text" maxlength="40" value="<?= $get_search_user ?>" /> 
			&nbsp;&nbsp;
			<b>Sort Users:</b> <?= $sort_menu ?> 
			<button type="submit">Go</button>
			</form>
		</td>
		<td align="right">
			<table>
			   <tr>
				  <td><b><?php echo $lang['PAGE']; ?>: </b></td>
				  <td><?php echo $pager->outputlinks(); ?></td>
			   </tr>
			</table>
		</td>
	  </tr>
	</table>
	</div>
	
	<script language="javascript">
	function checkall(state)
	{
		var n = frmUsers.elements.length;
		for (i=0; i<n; i++)
		{
			if (frmUsers.elements[i].name == "delid[]") frmUsers.elements[i].checked = state;
		}
	}
	</script>
		
	<form method="post" name="frmUsers">
	<table class="grid" cellspacing="1" cellpadding="6" width="100%">
		<tr class="gridhead">
			<td align="center" width="50">ID</td>
			<td align="center" width="70">Status</td>
			<td>Username</td>
			<td width="80" align="center">Total Ads</td>
			<td align="center" width="160">Last Login</td>
			<td align="center" width="120">User IP</td>
			<td align="center" width="80"><input type="checkbox" onclick="javascript:checkall(this.checked);"></td>
		</tr>
		<?php
		$i = 0;

		while ( $row = mysql_fetch_array($res) )
		{
		
			$i++;

			$cssalt = ($i%2 ? "" : "alt");
			
			$status = ($row['active'] != 1) ? '<font color="red">Inactive</font>' : '<font color="green">Active</font>';
			
			$user_ip = ($row['user_ip'] <= 0) ? 'Unavailable' : '<a href="http://whois.domaintools.com/'.$row['user_ip'].'" target="_blank">'.$row['user_ip'].'</a>';
			
			$last_login = ($row['last_login'] <= 0) ? 'Never' : date('m-d-Y g:i A', $row['last_login']);
			
			$cnt_res = mysql_query("SELECT COUNT(adid) FROM $t_ads WHERE user_id = '{$row['user_id']}' 
									AND enabled = '1' AND verified ='1'");
			$cnt_row = mysql_fetch_array($cnt_res);

		?>
		<tr class="gridcell<?php echo $cssalt; ?>">
			<td align="center"><?= $row['user_id'] ?></td>
			<td align="center"><?= $status ?></td>
			<td><a href="?action=edit_user&amp;user_id=<?= $row['user_id'] ?>"><?= $row['username'] ?></a></td>
			<td align="center"><?= $cnt_row['COUNT(adid)'] ?></td>
			<td align="center"><?= $last_login ?></td>
			<td align="center"><?= $user_ip ?></td>
			<td align="center"><input type="checkbox" name="delid[]" value="<?= $row['user_id'] ?>"></td>
		</tr>
		<?php
		
		}
		
		?>
		<tr class="gridhead">
			<td colspan="7"><button><a href="./accounts.php?action=add_user" style="color:#fff; text-decoration:none;">ADD NEW USER</a></button> &nbsp;<input type="submit" class="button" name="del" value="Delete Checked" onclick="return(confirm('Delete checked?'));"></td>
		</tr>
	</table>
	</form>
	<br />
	<div style="float:left; padding:5px;"><?php echo $adcount; ?> total results</div>
	<div style="float:right;">
	<table>
	   <tr>
	      <td><b><?php echo $lang['PAGE']; ?>: </b></td>
		  <td><?php echo $pager->outputlinks(); ?></td>
	   </tr>
	</table>
	</div>
	<br />
	<?php
	
break;
}



include_once("afooter.inc.php"); 

?>
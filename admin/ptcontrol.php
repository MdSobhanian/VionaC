<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                         |
+===================================================+
| File: admin/ptcontrol.php                         |
| Privacy & Terms Control Page                      |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Mon, Mar 19, 2012 ]---*/

require_once("admin.inc.php");
require_once("aauth.inc.php");

?>

<?php include_once("aheader.inc.php"); ?>

<?php

if (table_exists($t_privacy_terms, $db_name)) {
     echo'';
}
else {
  echo "<br /><blockquote><p class=\"msg\"><font color=\"red\"><strong>ERROR:</strong><br /><br />Database is/was not correctly installed or upgrading of database hasn't been processed successfully.</font></p><br /><p><ul><li>You may want to contact support for assistance.</li><li>Re-install the script if it was a new install or try running the upgrade process again if you were upgrading the script.</li><li>This error usually happens when the table <i>privacy_terms</i> does not exist in your database.</ul></p></blockquote><br />";
  include_once("afooter.inc.php");
  exit;
}

if ($app_ver < "5.7.6") {
  echo "<br /><blockquote><p class=\"msg\"><font color=\"red\"><strong>Licensing Error:</strong></font></p><br /><br />You're not using the correct version of the script. Please contact info@snetowrks.biz for assistance regarding getting original version of our classifieds script.<br /><p>SNetworks is very strict with this classifieds product. Illegally modifying or using the pirated copy is strctly prohibted and doing so is a offence. You are advised not to use any nulled/pirated copy of this product in order to avoid any legal issues with your classifieds website.</p><p><li>Notification has been sent to SNetworks server automatically.</li></p></blockquote><br />";
  include_once("afooter.inc.php");
  exit;
}

// Alternate options for checking database tables
// Following function can be used if in any case the server
// is not supporting the default method function for checking.
// If this function is being enabled (by advanced users only,
// then you must disable the next PHP function that checks tables.

/* function table_check ($tablename, $databasename) {
        $sql_show_tables="SHOW TABLES FROM $databasename";
        $tablelist= mysql_query ($sql_show_tables);
        while (list ($tmp_tbl_chk_func) = mysql_fetch_array ($tablelist)) {
            if ($tmp_tbl_chk_func == $tablename) {
              return TRUE;
            }
        }
        return FALSE;
}*/

// New database table checking code starts here     -v5.7.6
function table_exists($tablename, $database = false) {

    if(!$database) {
        $res = mysql_query("SELECT DATABASE()");
        $database = mysql_result($res, 0);
    }

    $res = mysql_query("
        SELECT COUNT(*) AS count
        FROM information_schema.tables
        WHERE table_schema = '$database'
        AND table_name = '$tablename'
    ");

    return mysql_result($res, 0) == 1;

}
// New database table checking code ends here       -v5.7.6

if (isset($_POST['privacy_submit'])) {

    if (($_SERVER['REQUEST_METHOD'] == "POST"))
		{
		    $pt_update = mysql_query("UPDATE $t_privacy_terms SET
            p_bannerads = '".$_POST['p_bannerads']."',
            p_shareinfo = '".$_POST['p_shareinfo']."',
    		p_crossmarketing = '".$_POST['p_crossmarketing']."',
            p_tacking = '".$_POST['p_tacking']."',
            p_sendcommunication = '".$_POST['p_sendcommunication']."',
    		p_under13 = '".$_POST['p_under13']."',
            p_internationally = '".$_POST['p_internationally']."',
            p_discloselegal = '".$_POST['p_discloselegal']."',
    		p_server_country = '".$_POST['p_server_country']."',
            p_forums = '".$_POST['p_forums']."',
            p_newslettermodule = '".$_POST['p_newslettermodule']."',
            p_membershipmodule = '".$_POST['p_membershipmodule']."',
            t_termsmodification = '".$_POST['t_termsmodification']."',
            t_adultcontent = '".$_POST['t_adultcontent']."',
            t_postingagents = '".$_POST['t_postingagents']."',
            t_paidads = '".$_POST['t_paidads']."',
            t_registeredtrademark = '".$_POST['t_registeredtrademark']."'
        ");

        $msg="Changes has been saved!";

           if (!$pt_update)   {
        echo "<p class=\"msg\"><font color=\"red\">Failed to save settings !</font> <font color=\"steelblue\"><br />You can try again by making sure you have proper priviliges on your SQL database.</font></p>";
        if ($debug == TRUE) {
          echo ('<p>DEBUG MODE ENABLED:<br /><strong>Invalid query:</strong> '.mysql_error().'</p>');
        }
        }

		}
    }

else    {
        $msg="<font color=\"red\">Incorrect method of submission.</font> Please try again.";
}

		$pt_data_que = mysql_query("SELECT * FROM $t_privacy_terms");
		$pt_data = mysql_fetch_array($pt_data_que);

?>

<h2>Privacy & Terms Controls</h2>
<table><tr><td valign="top"><img src="images/tip.gif" align="absmiddle">&nbsp;</td><td valign="top" class="tip">This is the privacy &&nbsp;terms page statements for your site: <?php echo($site_name); ?><br />Just answer the following questions and your terms & policies will be updated.</td></tr><tr><td>&nbsp;</td></tr></table>

<?php if ($pt_update) { echo ('<span class="msg">'.$msg.'</span><br /><br />'); } ?>

<form class="box" name="pt_update" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="0">
    <dl>
    <tr>
    <td width="573" nowrap>Do you run banner ads or any commercial ads on your site?</td>
    <td width="433"><select name="p_bannerads" id="p_bannerads">
      <option value="do not" <?php if ($pt_data[0] == 'do not') { ?>selected="selected"<?php } ?>>No</option>
      <option value="do" <?php if ($pt_data[0] == 'do') { ?>selected="selected"<?php } ?>>Yes</option>
    </select></td>
    </tr>
    <tr>
      <td nowrap>Are you sharing your user information with any third parties?</td>
      <td><select name="p_shareinfo" id="p_shareinfo">
        <option value="do not" <?php if ($pt_data[1] == 'do not') { ?>selected="selected"<?php } ?>>No</option>
        <option value="do" <?php if ($pt_data[1] == 'do') { ?>selected="selected"<?php } ?>>Yes</option>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Are you engaged with any cross marketing or link refferal program sites?</td>
      <td><select name="p_crossmarketing" id="p_crossmarketing">
        <option value="do not" <?php if ($pt_data[2] == 'do not') { ?>selected="selected"<?php } ?>>No</option>
        <option value="do" <?php if ($pt_data[2] == 'do') { ?>selected="selected"<?php } ?>>Yes</option>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Are you using any additional tracking cookies or web beacons?</td>
      <td><select name="p_tacking" id="p_tacking">
        <option value="do not" <?php if ($pt_data[3] == 'do not') { ?>selected="selected"<?php } ?>>Only default cookies</option>
        <option value="do" <?php if ($pt_data[3] == 'do') { ?>selected="selected"<?php } ?>>Additional cookies </option>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Will you communicate your users for any marketing purpose?</td>
      <td><select name="p_sendcommunication" id="p_sendcommunication">
        <option value="do not" <?php if ($pt_data[4] == 'do not') { ?>selected="selected"<?php } ?>>Not for marketing</option>
        <option value="do" <?php if ($pt_data[4] == 'do') { ?>selected="selected"<?php } ?>>Yes for marketing</option>
      </select></td>
    </tr>
</dl>
    <tr>
      <td valign="top" nowrap>Will you knowingly collect and/or keep information from persons under 13 years old on your site?</td>
      <td><select name="p_under13" id="p_under13">
        <option value="do" <?php if ($pt_data[6] == 'do') { ?>selected="selected"<?php } ?>>I will</option>
        <option value="do not" <?php if ($pt_data[6] == 'do not') { ?>selected="selected"<?php } ?>>I won't</option>
      </select></td>
    </tr>
    <tr>
    <td valign="top" nowrap>Is your classifieds site for local use only or international?</td>
    <td><select name="p_internationally" id="p_internationally">
      <option value="yes" <?php if ($pt_data['p_internationally'] == 'yes') { ?>selected="selected"<?php } ?>>International Site</option>
      <option value="no" <?php if ($pt_data['p_internationally'] == 'no') { ?>selected="selected"<?php } ?>>Local Site</option>
    </select></td>
    </tr>
    <tr>
    <td valign="top" nowrap>Will you disclose your user's information if required by law enforcement officers?</td>
    <td><select name="p_discloselegal" id="p_discloselegal">
      <option value="may not" <?php if ($pt_data['p_discloselegal'] == 'may not') { ?>selected="selected"<?php } ?>>I may not</option>
      <option value="may" <?php if ($pt_data['p_discloselegal'] == 'may') { ?>selected="selected"<?php } ?>>I may</option>
    </select></td>
    </tr>
    <tr>
      <td valign="top" nowrap>Which country is your server hosted currently? (name of the country only)</td>
      <td><input name="p_server_country" type="text" id="p_server_country" value="<?php echo $pt_data['p_server_country']; ?>"></td>
    </tr>
        <tr>
      <td valign="top" nowrap>Are you keeping the rights to modify your own terms of use?</td>
      <td><select name="t_termsmodification" id="t_termsmodification">
        <option value="We do not reserve" <?php if ($pt_data[12] == 'We do not reserve') { ?>selected="selected"<?php } ?>>We do not reserve</option>
        <option value="We do reserve" <?php if ($pt_data[12] == 'We do reserve') { ?>selected="selected"<?php } ?>>We do reserve</option>
      </select></td>
    </tr>
        <tr>
      <td valign="top" nowrap>Can your site have ADULT content or not?</td>
      <td><select name="t_adultcontent" id="t_adultcontent">
        <option value="not allowed" <?php if ($pt_data[13] == 'not allowed') { ?>selected="selected"<?php } ?>>Not Allowed</option>
        <option value="allowed" <?php if ($pt_data[13] == 'allowed') { ?>selected="selected"<?php } ?>>Adult Content Allowed</option>
      </select></td>
    </tr>
    <tr>
      <td valign="top" nowrap>Do you use any posting agents to make ad posts on behalf?</td>
      <td><select name="t_postingagents" id="t_postingagents">
        <option value="no" <?php if ($pt_data[14] == 'no') { ?>selected="selected"<?php } ?>>No</option>
        <option value="yes" <?php if ($pt_data[14] == 'yes') { ?>selected="selected"<?php } ?>>Yes</option>
      </select></td>
    </tr>
        <tr>
      <td valign="top" nowrap>Is it a paid classifieds ads website or free classifieds site?</td>
      <td><select name="t_paidads" id="t_paidads">
        <option value="no" <?php if ($pt_data[15] == 'no') { ?>selected="selected"<?php } ?>>Free Classifieds</option>
        <option value="yes" <?php if ($pt_data[15] == 'yes') { ?>selected="selected"<?php } ?>>Paid Classifieds</option>
      </select></td>
    </tr>
        <tr>
      <td valign="top" nowrap>Have you registered your business name? Is it a registered trademark?</td>
      <td><select name="t_registeredtrademark" id="t_registeredtrademark">
        <option value="no" <?php if ($pt_data[16] == 'no') { ?>selected="selected"<?php } ?>>No, not registered</option>
        <option value="yes" <?php if ($pt_data[16] == 'yes') { ?>selected="selected"<?php } ?>>Yes, registered under U.S</option>
      </select></td>
    </tr>
        <tr>
      <td valign="top" nowrap>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" nowrap>Are you using SNetworks Forum Addon Module?</td>
      <td><select name="p_forums" id="p_forums">
        <option value="no" <?php if ($pt_data[5] == 'no') { ?>selected="selected"<?php } ?>>No</option>
        <option value="yes" <?php if ($pt_data[5] == 'yes') { ?>selected="selected"<?php } ?>>Yes</option>
      </select></td>
    </tr>
    <tr>
      <td valign="top" nowrap>Are you using SNetworks Newsletter Addon Module?</td>
      <td><select name="p_newslettermodule" id="p_newslettermodule">
        <option value="no" <?php if ($pt_data[8] == 'no') { ?>selected="selected"<?php } ?>>No</option>
        <option value="yes" <?php if ($pt_data[8] == 'yes') { ?>selected="selected"<?php } ?>>Yes</option>
      </select></td>
    </tr>
    <tr>
      <td valign="top" nowrap>Are you using SNetworks Membership System Addon Module?</td>
      <td><select name="p_membershipmodule" id="p_membershipmodule">
        <option value="no" <?php if ($pt_data[7] == 'no') { ?>selected="selected"<?php } ?>>No</option>
        <option value="yes" <?php if ($pt_data[7] == 'yes') { ?>selected="selected"<?php } ?>>Yes</option>
      </select></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="573">&nbsp;</td>
      <td width="433" align="left"><input type="submit" class="button" value="Save Settings" name="privacy_submit" /></td>
    </tr>
</table>
</form>



<?php include_once("afooter.inc.php"); ?>
</body>
</html>
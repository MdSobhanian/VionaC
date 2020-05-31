<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: path.inc.php                                | 
| The page path                                     |
+---------------------------------------------------+
| Copyright � 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Sun, Oct 23, 2005 ]---*/


require_once("initvars.inc.php");
require_once("config.inc.php");


?>
<?php

if (!($xview == "main" && $xcityid === 0))
{
    /* Begin Version 5.0 */
//    $homelink    = buildURL("main", array(0));
    $homelink    = buildURL("main", array($xcityid, $xcityname));
    $countrylink = buildURL("main", array(0-$xcountryid, $xcountryname));
    $citylink    = buildURL("main", array($xcityid, $xcityname));
    /* End Version 5.0 */
?>

<table width="100%" border="0" cellpadding="3" cellspacing="0" id="path" style="background-color:#fff;"><tr><td>

	<!-- Begin Version 5.0 -->

	<a href="<?php echo $homelink; ?>"><?php echo $lang['HOME_LINK']; ?></a>
	<?php echo $path_sep; ?>
	<?php 
	// BEGIN Account Mod
	$x_opts = array("userpanel", "login", "signup", "forgot");
	if( in_array($xview, $x_opts) || $_COOKIE[$ck_userid] ) { 
	?>
	<a href="<?= $acc_panel_link ?>"><?= $lang['ACCOUNT_LINK'] ?></a>
	<?php echo $path_sep;
	  
	} 
	if( $xview == "signup" ) { 
	?>
	<a href="<?= $acc_signup_link ?>"><?= $lang['ACC_SIGNUP'] ?></a>
	<?php echo $path_sep;
	}
	// END Account Mod

	?>

	<?php if($xcityid !== 0) { ?>
	<a href="<?php echo $countrylink; ?>"><?php echo $xcountryname; ?></a>
	<?php echo $path_sep; ?>
	<?php } ?>

	<?php if($xcityid>0 && !$postable_country) { ?>
	<a href="<?php echo $citylink; ?>"><?php echo $xcityname; ?></a>
	<?php echo $path_sep; ?>
	<?php } ?>
				
	<!-- End Version 5.0 -->

	<?php
	// START OF BACKPAGE MODIFICATION

	if ($xview == "contact") { ?>
	<a href="?view=contact">Contact Us</a>
	<?php echo $path_sep; 
          } 

	if ($xview == "help") { ?>
	<a href="?view=help">Help</a>
	<?php echo $path_sep; 
          } 

	if( $xview == "verifyresend") { ?>
	<a href="?view=page&pagename=help">Help</a>
	<?php echo $path_sep; ?>
	<a href="?view=verifyresend">Retrieve Link</a>
	<?php echo $path_sep;
	}
	// END OF BACKPAGE MODIFICATION	

    /* Begin Version 5.0 */
    
	if ($xview == "showad" || ($xview == "mailad" && $xadtype == "A"))
	{
	    $catlink = buildURL("ads", array($xcityid, $xcatid, $xcatname));

		echo <<< EOB
		<a href="{$catlink}">$xcatname</a>$path_sep
EOB;

        if (!$postable_category) {        
    	    $subcatlink = buildURL("ads", array($xcityid, $xcatid, $xcatname, $xsubcatid, $xsubcatname));
    	    
            echo <<< EOB
	    	<a href="{$subcatlink}">$xsubcatname</a>

EOB;
        }
	}
	elseif ($xview == "ads" && $xsubcatid)
	{
		$catlink = buildURL("ads", array($xcityid, $xcatid, $xcatname));

		echo <<< EOB
		<a href="{$catlink}">$xcatname</a>$path_sep
		$xsubcatname

EOB;
	}
	
	/* End Version 5.0 */
	
	elseif (($xview == "ads" || $xview == "subcats") && $xcatid)
	{
		echo <<< EOB
		$xcatname

EOB;
	}
	elseif ($xview == "events")
	{
		echo <<< EOB
		$lang[EVENTS]

EOB;
	}
	elseif ($xview == "showevent")
	{
	    /* Begin Version 5.0 */
	    $eventlink = buildURL("events", array($xcityid, $xdate));
		echo <<< EOB
		<a href="{$eventlink}">$lang[EVENTS]</a>
		
EOB;
        /* End Version 5.0 */
	}
	
	/* Begin Version 5.0 */
	
	elseif ($xview == "post" || $xview == "postimg")
	{
	    $postlink = buildURL("custom", array("view"=>"post", "cityid"=>$xcityid));
		echo <<< EOB
		<a href="{$postlink}">$lang[POST_AD]</a>

EOB;

	}
	elseif ($xview == "edit" || $xview == "editimg")
	{
		echo <<< EOB
		$lang[EDIT_AD]

EOB;
	}
	elseif ($xview == "imgs" || $xview == "showimg")
	{
	    $imgslink = buildURL("imgs", array($xcityid));
		echo <<< EOB
		<a href="{$imgslink}">$lang[IMAGES]</a>
EOB;
	}
	
	/* End Version 5.0 */
	
	elseif ($xview == "selectcity")
	{
		if($_GET['targetview'] == "postimg") echo $lang['POST_IMG'];
		else echo $lang['POST_AD'];
	}
	elseif ($xview == "page")
	{
		//echo ucwords($_GET['pagename']);
	}

	?>

</td><td align="right"><?php
// BEGIN Account Mod
if ( $enable_account && ( $xview == "post" || $xview == "selectcity" ) )
{
	echo '<div align="right" style="padding: 1px 5px 8px 5px;">';
	if ( $_COOKIE[$ck_userid] )
	{
		echo $lang['ACC_LOGGED_IN'] . ' <a href="'.$acc_panel_link.'">'.$_COOKIE[$ck_username].'</a>';
	}
	else
	{
		echo '<a href="'.$acc_login_link.'">'.$lang['ACC_LOGIN_TEXT'].'</a>';
	}
	echo '</div>';
} 
// END Account Mod
?></td></tr></table>

<?php

}

?>

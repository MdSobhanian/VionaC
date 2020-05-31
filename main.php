<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: main.php                                    |
| Homepage with the directory                       |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Tue, Aug 02, 2005 ]---*/


require_once("initvars.inc.php");
require_once("config.inc.php");

?>

<?php /* include("welcome.inc.php"); */ ?>

 <div class="mainCellBackground" id="columnsTable" style="width: 100%;">

<?php

// Create main directory

if($dir_sort) 
{
	$sortcatsql = "ORDER BY catname";
	$sortsubcatsql = "ORDER BY subcatname";
}
else
{
	$sortcatsql = "ORDER BY pos";
	$sortsubcatsql = "ORDER BY scat.pos";
}



// First get ads per cat and subcat
$subcatadcounts = array();
$catadcounts = array();
$sql = "SELECT scat.subcatid, scat.catid, COUNT(*) as adcnt
		FROM $t_ads a
			INNER JOIN $t_subcats scat ON scat.subcatid = a.subcatid AND ($visibility_condn)
			INNER JOIN $t_cats cat ON cat.catid = scat.catid
			INNER JOIN $t_cities ct ON a.cityid = ct.cityid
		WHERE scat.enabled = '1'
			$loc_condn
		GROUP BY a.subcatid";

$res = mysql_query($sql) or die(mysql_error().$sql);

while($row=mysql_fetch_array($res))
{
	$subcatadcounts[$row['subcatid']] = $row['adcnt'];
	$catadcounts[$row['catid']] += $row['adcnt'];
}



// Categories
$sql = "SELECT catid, catname AS catname FROM $t_cats WHERE enabled = '1' $sortcatsql";
$rescats = mysql_query($sql) or die(mysql_error());
$catcount = @mysql_num_rows($rescats);

$percol_short = floor($catcount/$dir_cols);
$percol_long = $percol_short+1;
$longcols = $catcount%$dir_cols;

$i = 0;
$j = 0;
$col = 0;
$thiscolcats = 0;

while($rowcat=mysql_fetch_array($rescats))
{
	if ($j >= $thiscolcats)
	{
		$col++;
		$thiscolcats = ($col > $longcols) ? $percol_short : $percol_long;
		$j = 0;
		
		echo "<div class=\"indexSectionColumnBlock\"><div class=\"indexSectionColumn\">";
	}

	$i++;
	$j++;

    /* Begin Version 5.0 */
    $catlink = buildURL("ads", array($xcityid, $rowcat['catid'], $rowcat['catname']));
    /* End Version 5.0 */

	$adcount = 0+$catadcounts[$rowcat['catid']];

?>

        <div class="indexSectionButtons">
      	<a href="<?php echo $catlink; ?>" class="head"><?php echo $rowcat['catname']; ?></a>&nbsp;<span class="count"><?php echo $adcount; ?></span>
 	</div><ul>


	<?php 
	/* OBSELETE DUE TO BACKPAGE THEME
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="dir_cat">
	<tr><td height="8"></td></tr><tr>
	<th><a style="text-transform: lowercase;" class="head" href="<?php echo $catlink; ?>"><?php echo $rowcat['catname']; ?></a>
	<?php if($show_cat_adcount) { ?><span class="count"><?php echo $adcount; ?></span><?php } ?>
	</th>
	</tr>
	*/ 
	?>

<?php

	$sql = "SELECT scat.subcatid, scat.subcatname AS subcatname
	FROM $t_subcats scat
	WHERE scat.catid = $rowcat[catid]
		AND scat.enabled = '1'
	$sortsubcatsql";

	$ressubcats = mysql_query($sql) or die(mysql_error()."<br>$sql");
	/* Begin Version 5.0 */
	$subcatcount = mysql_num_rows($ressubcats);
	/* End Version 5.0 */

	while ($rowsubcat = mysql_fetch_array($ressubcats))
	{
	    /* Begin Version 5.0 */
	    if ($shortcut_categories && $subcatcount == 1 
	            && $rowsubcat['subcatname'] == $rowcat['catname']) {
	        continue;
	    }
	    /* End Version 5.0 */
	    
		$adcount = 0+$subcatadcounts[$rowsubcat['subcatid']];

        /* Begin Version 5.0 */
        $subcat_url = buildURL("ads", array($xcityid, $rowcat['catid'], $rowcat['catname'], 
            $rowsubcat['subcatid'], $rowsubcat['subcatname']));
        /* End Version 5.0 */

?>
                

		<li class="indexSectionList"><a href="<?php echo $subcat_url; ?>"><?php echo $rowsubcat['subcatname']; ?></a> 
		<?php if($show_subcat_adcount) { ?><span class="count">(<?php echo $adcount; ?>)</span><?php } ?>
		</li>


<?php

	}

?>
	
	</ul>
	

<?php

	if($j==$thiscolcats || $i==$catcount) echo "</div></div>";

}


?>



<?php //include_once("latest_featured.inc.php"); ?>

<?php //include_once("upcoming_featured_events.inc.php"); ?>

<?php //include_once("latest.inc.php"); ?>

<?php //include_once("upcoming_events.inc.php"); ?><!-- $sql -->
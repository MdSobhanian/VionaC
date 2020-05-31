<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| File: selectcity.php                              |
| Select a city and redirect to the specified view  |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Tue, Aug 02, 2005 ]---*/


require_once("initvars.inc.php");
require_once("config.inc.php");


$targetview = $_GET['targetview'];
$citylink_view = "view=$targetview&postevent=$_GET[postevent]";
//$citylink_view = "view=selectcity&targetview=$targetview";

if($location_sort) 
{
	$sort1 = "ORDER BY countryname";
	$sort2 = "ORDER BY cityname";
	/* Begin Version 5.0 */
	$sort3 = "ORDER BY areaname";
	/* End Version 5.0 */
}
else
{
	$sort1 = "ORDER BY c.pos";
	$sort2 = "ORDER BY ct.pos";
	/* Begin Version 5.0 */
	$sort3 = "ORDER BY pos";
	/* End Version 5.0 */
}

?>

<h1>
<?php echo $targetview=="postimg"?$lang['POST_IMG']:$lang['POST_AD']; ?>
</h1><br />


<?php
if ($_GET['cityid'] > 0)
{
	$sql = "SELECT * FROM $t_areas WHERE cityid = $_GET[cityid] {$sort3}";	// Version 5.0
	$res = mysql_query($sql);

	if(!mysql_num_rows($res))
	{
		header("Location: $script_url/?view=$targetview&postevent=$_GET[postevent]&cityid=$_GET[cityid]");
		exit;
	}
	else
	{
?>

    <!-- Begin Version 5.0 -->
    <div class="postpath"><?php echo "<b>$xcountryname</b> &raquo; <b>$xcityname</b>"; ?> 
    <?php if(!$in_admin) { ?>
    &nbsp; (<a href="?view=selectcity&targetview=post"><?php echo $lang['CHANGE']; ?></a>)
    <?php } ?>
    </div><br>
    <!-- End Version 5.0 -->
    
	<?php echo $lang['POST_SELECT_AREA']; ?><br>
	<ul class="postcats">

<?php
		while($area = mysql_fetch_array($res))
		{
?>
		
			<li><a href="?view=<?php echo $targetview; ?>&cityid=<?php echo $xcityid; ?>&area=<?php echo $area['areaname']; ?>"><?php echo $area['areaname']; ?></a></li>

<?php
		}
?>

			<li><a href="?view=<?php echo $targetview; ?>&cityid=<?php echo $xcityid; ?>"><b><?php echo $lang['SKIP_STEP']; ?></b></a></li>

	</ul>

<?php
	}
?>

<?php
}
else
{
?>

    <!-- Begin Version 5.0 -->
    <?php if ($_GET['cityid'] < 0) { ?>
    <div class="postpath"><?php echo "<b>$xcountryname</b>"; ?> 
    <?php if(!$in_admin) { ?>
    &nbsp; (<a href="?view=selectcity&targetview=post"><?php echo $lang['CHANGE']; ?></a>)
    <?php } ?>
    </div><br>
    <?php } ?>
    <!-- End Version 5.0 -->

	<?php echo $lang['POST_SELECT_CITY']; ?><br><br />
	<ul class="postcats">

	<?php

	// Show city list
	
	/* Begin Version 5.0 */
	if ($_GET['cityid'] < 0) {
	    $countryid = 0 - $_GET['cityid'];
    	$sql = "SELECT * FROM $t_countries c WHERE c.countryid = {$countryid} AND c.enabled = '1'";
    	
	} else {
	
    	$sql = "SELECT * FROM $t_countries c INNER JOIN $t_cities ct ON c.countryid = ct.countryid AND ct.enabled = '1' WHERE c.enabled = '1' GROUP BY c.countryid $sort1";
    }
	/* End Version 5.0 */
	
	$resc = mysql_query($sql);
	    	
	while($country = mysql_fetch_array($resc))
	{

	?>

	<li><b><?php echo $country['countryname']; ?></b></li><ul>

	<?php

		$sql = "SELECT * FROM $t_cities ct WHERE countryid = $country[countryid] AND enabled = '1' $sort2";
		$resct = mysql_query($sql);

		while($city=mysql_fetch_array($resct))
		{

		?>
		
		<!-- Begin Version 5.0 -->
		<li><a href="?<?php echo $citylink_view; ?>&cityid=<?php echo $city['cityid']; ?>&lang=<?php echo $xlang; ?>&catid=<?php echo $_GET['catid']; ?>&subcatid=<?php echo $_GET['subcatid']; ?>"><?php echo $city['cityname']; ?></a></li>
		<!-- End Version 5.0 -->
				
		<?php
		
		}

		?>

		<br>

		</ul>

	<?php

	}				

	?>

<?php
}
?>
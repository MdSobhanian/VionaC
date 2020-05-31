
<?php 

/*--------------------------------------------------+
| Adult Warning Module Admin File	 	|
| SNETWORKS PHP CLASSIFIEDS                      	|
+===================================================+
| Copyright © 2010 George Robert (SNETWORKS),		|
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
|                                                	|
|                          //  Tue, Mar 30, 2010 	|
+-----------------------------------------------*/


require_once("admin.inc.php");

require_once("aauth.inc.php");

include_once("aheader.inc.php");


	/*	$adult_cats_query = mysql_query("SELECT * FROM  $t_cats` WHERE  `alert` =  '1'");
		$adult_cats_row = mysql_fetch_array($adult_cats_query);

*/
?>

<h2>Manage Adult Categories</h2>

<?php if($msg) { ?><div class="msg"><?php echo $msg; ?></div><?php } ?>
<?php if($err) { ?><div class="err"><?php echo $err; ?></div><?php } ?>

<p class="tip"><img src="images/tip.gif" border="0" align="absmiddle"> This page only lists the categories that has adult warning enabled. You can enable adult warning in any categories by going to Categories > Edit Category > Enable Alert [checkbox]</p>

<!--<button name="add" type="button" onclick="javascript:location.href='?do=add&type=cat';" value="">Add New</button><br>-->
<div class="legend" align="right"><b>A</b> - Adult Warning Alert</div>
<form method="post" action="" name="frmCats">
<table class="grid" cellspacing="1" cellpadding="6" width="100%">
	<tr class="gridhead">
		<td>Adult Category</td>
		<td width="20" align="center">A</td>
		<td colspan="1" align="center" width="92" nowrap>Edit Alert</td>
	</tr>

<?php
$sql = "SELECT * FROM $t_cats WHERE `alert` = '1'";
$res = mysql_query($sql) or die(mysql_error());

$i = 0;
while ($row=mysql_fetch_array($res))
{
	$i++;
	$cssalt = ($i%2 ? "" : "alt");
?>

	<tr class="gridcell<?php echo $cssalt; ?>">
		<td><a href="subcats.php?catid=<?php echo $row['catid']; ?>"><?php echo $row['catname']; ?></a></td>
		<td align="center"><?php if($row['alert']) echo "<span class=\"yes\">+</span>"; 
		else echo "<span class=\"no\">X</span>"; ?></td>
		<td width="20" align="center"><a href="cats.php?do=edit&type=cat&catid=<?php echo $row['catid']; ?>"><img src="images/edit.gif" border="0" alt="Edit" title="Edit"></a></td>
	</tr>

<?php
}
?>

</table>
</form>
<button name="viewall" type="button" onclick="javascript:location.href='cats.php';" value="">View All Categories</button><br>


<?php 


 include_once("afooter.inc.php"); 
 
?>
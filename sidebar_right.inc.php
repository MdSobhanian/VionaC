<?php if($show_cats_in_sidebar && !($xview == "main" || $xpostmode) && !$show_sidebar_always) { ?>
<b><?php echo $lang['CATEGORIES']; ?> &raquo;</b><br><img src="images/spacer.gif" height="5"><br>
	<?php include("cats.inc.php"); ?>
	<br><br>
<?php } ?>

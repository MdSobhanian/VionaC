<?php

require_once("initvars.inc.php");
require_once("config.inc.php");

ob_start();

echo $_SESSION['ses_verified'];
echo $_SESSION['start'];

$xcatid=$_GET['catid'];
$xcityid=$_GET['cityid'];

$sql = "select alerttitle, alertdesc from $t_cats where catid='$xcatid'";
$res = mysql_query($sql) or die($sql.mysql_error());
list($alerttitle, $alertdesc) = mysql_fetch_array($res);

if ( $_POST['submit'] ) {
	setcookie("ck_adultverified", "Yes", 0, "/");
	header("Location: $script_url/index.php?view=ads&catid=$xcatid&cityid=$xcityid");
}

ob_flush();
?>

<style>
/* Core Formatting 
html {height: 100%;margin-bottom: 1px;}
body {margin: 0;line-height: 135%;}
body { min-width:982px;}
body {padding:0;margin:0;font-family:arial,sans-serif;background:#ffffff;font-size:62.5%;}
form {margin: 0;padding: 0;}
body {font-size: 12px;}
p {margin-top: 10px;margin-bottom: 15px;}
h1, h2, h3, h4, h5 {padding-bottom: 5px;margin: 25px 0 10px 0;font-weight: normal;line-height: 135%;}
h1 {font-size: 250%;}
h2 {font-size: 200%;}
h3 {font-size: 175%;}
h4 {font-size: 120%;line-height: 130%;}
h5 {font-size: 100%;}
a {text-decoration: none;}
a:hover {text-decoration: none;}
a {color: #9FB400;}
a { outline:0; /* remove dotted line */ }
.clr {clear:both;position:relative;font-size: 0;}
img {display:block;border:0}

#title {
	font-weight:bold;
	margin-top:50px;
}

#desc {
	margin-top:10px;
	margin-bottom:20px;
}

#img img {
	margin-top:20px;
	margin-bottom:20px;
}

#title, #desc, #img img, #buttons {
	text-align: center;
	margin-left: auto;
	margin-right: auto;
}*/
</style>

<html>
<head>
<title><?php echo $alerttitle; ?> - <?php echo $site_name; ?></title>
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="/js/global-compiled.js?4"></script>
<link rel="stylesheet" type="text/css" href="style.css">
  
<link rel="stylesheet" href="js/sidr/stylesheets/jquery.sidr.light.css">
</head>
<body>
<?php include('header.inc.php'); ?>
 <script src="js/sidr/jquery.sidr.min.js"></script>
<div id="title">
<?php echo $alerttitle; ?>
</div>

<div id="img">
	<img src="images/red-alert.jpg" width="105px" height="90px" />
</div>

<div id="desc" style="width:600px; height:auto; padding:10px 0px 10px 0px; text-align:justify;"><?php echo generateHtml($alertdesc, "1265572015"); ?></div>

<div class="mFormWrap" style="text-align:center;"><div id="loginForm">
<form id="adult" name="adult" method="post" action="<?= $_SERVER["REQUEST_URI"] ?>">
<input type="submit" name="submit" id="submit" class="signIn" value="I agree" />&nbsp;&nbsp;
<input type="button" name="disagree" value="I don't agree" class="signIn" onClick="history.go(-1)">&nbsp;</td>
</form><br />
</div>
</div>
</div>
<?php include('footer.inc.php'); ?>
</div>
</body>
</html>
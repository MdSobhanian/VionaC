<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                         |
+===================================================+
| File: admin/admin.inc.php                         |
| Admin specific options and includes               |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Tue, Aug 02, 2005 ]---*/


require_once("../initvars.inc.php");

$in_admin = TRUE;
$path_escape = "../";
require_once("../config.inc.php");
require_once("../pager.cls.php");
/* START mod-paid-categories */
require_once("../paid_cats/paid_categories_helper.php");
/* END mod-paid-categories */

if ($admin_auto_hide_sidebar && (
	strpos($_SERVER['PHP_SELF'], "ads.php")!==FALSE || 
	strpos($_SERVER['PHP_SELF'], "images.php")!==FALSE || 
	strpos($_SERVER['PHP_SELF'], "payments.php")!==FALSE
	))
{
	$nosidebar = TRUE;
}

$admin_theme = "default";

?>
<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS                         |
+===================================================+
| File: admin/aauth.inc.php                         |
| Ensure admin login                                |
+---------------------------------------------------+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
+--------------------------[ Tue, Aug 02, 2005 ]---*/


if (!isAdmin())
{
	header("Location: index.php");
	exit;
}

$admin_mode = TRUE;


?>
<?php

/*--------------------------------------------------+
| SNETWORKS PHP CLASSIFIEDS							|
+===================================================+
| Copyright © 2005 George Robert (SNETWORKS),       |
| All rights reserved.                              |
| E-mail: support@snetworks.biz                     |
| Web: http://www.snetworksclassifieds.com          |
|                              // Mon, Sep 29, 2008 |
+--------------------------------------------------*/


$basedir = dirname(dirname(__FILE__));
require_once("{$basedir}/initvars.inc.php");
require_once("{$basedir}/config.inc.php");


/* Initialize language phrases, if not available. */
if (!isset($lang['POSTING_FEE'])) $lang['POSTING_FEE'] = "Posting fee";
if (!isset($lang['POSTING_FEE_NOTE'])) $lang['POSTING_FEE_NOTE'] = "<b>You will be charged <b>{@FEE}</b> for making a post to this section.</b>";


class PaidCategoriesHelper {

	var $locations;
	var $locationSelect;
	
	function &getLocations($forceReload = false) {
		if (!isset($this->locations) || $forceReload) {
			$this->locations = array();
			
			$sql = "select ct.cityid, ct.cityname, ct.countryid, c.countryname
					from $GLOBALS[t_cities] ct 
						inner join $GLOBALS[t_countries] c on ct.countryid = c.countryid
					order by c.countryname, ct.cityname";
			$res = mysql_query($sql) or die(mysql_error());
			
			$currentRegion = 0;
			while ($row=mysql_fetch_array($res)) {
			
				if ($row['countryid'] != $currentRegion) {
					$key = '1,' . $row['countryid'];
					$this->locations[$key] = $row['countryname'];
					$currentRegion = $row['countryid'];
				}
				
				$key = '2,' . $row['cityid'];
				$this->locations[$key] = $row['cityname'];
			}
		}
		
		return $this->locations;
	}

	function &getLocationSelect($id, $class, $selection = "0,0", $forceReload = false) {
		$locations = &$this->getLocations($forceReload);
		$optionsHtml = "";
		
		foreach ($locations as $key=>$location) {
			if ($key{0} == '2') $location = "- {$location}";
			$optionsHtml.= "<option value='{$key}'";
			if ($key == $selection) $optionsHtml .= " selected";
			$optionsHtml .= ">{$location}</option>";
		}

		$html = "<select id='{$id}' name='{$id}' class='{$class}'>" . 
				$optionsHtml . "</select>";
		return $html;
	}
	
	function loadFeeInfo($secid, $seclevel) {
		global $t_fees;
		$feeInfo = array();
		$secid += 0;
		$seclevel += 0;
		
		$sql = "SELECT * FROM $t_fees 
				WHERE secid = '{$secid}' AND seclevel = '{$seclevel}'
				ORDER BY pos";
		$res = $this->query($sql);
		
		while ($row = mysql_fetch_array($res)) {
			$feeInfo["{$row[loclevel]},{$row[locid]}"] = $row['fee'];
		}
		
		return $feeInfo;
	}
	
	function saveFeeInfo($secid, $seclevel, $feeInfo) {
		global $t_fees;
		$fees = $feeInfo['fee'];
		$locations = $feeInfo['fee_loc'];
		$existenceCheck = array();
		$glue = "";
		$secid += 0;
		$seclevel += 0;

		/* First delete existing fee info. */
		$this->deleteFeeInfo($secid, $seclevel);
		
		if (is_array($fees) && is_array($locations)) {
		
			/* Now insert. */
			$sql = "INSERT INTO $t_fees(secid, seclevel, locid, loclevel, fee, pos) VALUES ";

			foreach($fees as $index=>$fee) {
				$fee += 0;
				if ($index !== "%index%") {
					$key = $locations[$index];
					
					if (!$existenceCheck[$key]) {
						list($loclevel, $locid) = explode(",", $key);
						$locid += 0;
						$loclevel += 0;
						$sql .= "{$glue} ( '{$secid}', '{$seclevel}', '{$locid}', '{$loclevel}', '{$fee}', '{$index}')";

						$existenceCheck[$key] = true;
						$glue = ",";
					}
				}
			}
		
			$this->query($sql) or $this->handleError(mysql_error() . "<br>{$sql}" );
		}
	}
	
	function deleteFeeInfo($secid, $seclevel, $locid=null, $loclevel=null) {
		global $t_fees;
		$where = "";
		
		if ($secid !== null && $seclevel !== null) {
			$secid += 0;
			$seclevel += 0;
			$where .= " secid = '{$secid}' AND seclevel = '{$seclevel}'";
		}
		
		if ($locid !== null && $loclevel !== null) {
			$locid += 0;
			$loclevel += 0;
			$where .= " locid = '{$locid}' AND loclevel = '{$loclevel}'";
		}
		
		if ($where) {
			$sql = "DELETE FROM $t_fees WHERE {$where}";
			$this->query($sql) or $this->handleError(mysql_error() . "<br>{$sql}" );
		}
	}
	
	function getPostingFee($catid, $subcatid, $cityid, $regionid) {
		global $t_fees;
		$catid += 0;
		$subcatid += 0;
		$cityid += 0;
		$regionid += 0;
		$fee = 0;
		
		$sql = "SELECT * FROM $t_fees 
				WHERE ((seclevel = 2 AND secid = $subcatid) 
						OR (seclevel = 1 AND secid = $catid)
					) AND ((loclevel = 2 AND locid = $cityid) 
						OR (loclevel = 1 AND locid = $regionid)
						OR (loclevel = 0 AND locid = 0))
				ORDER BY seclevel DESC, loclevel DESC
				LIMIT 1";
		$res = $this->query($sql) or $this->handleError(mysql_error() . "<br>{$sql}" );
		
		if (mysql_num_rows($res)) {
			$row = mysql_fetch_assoc($res);
			$fee = $row['fee'];
		}
		
		return number_format($fee, 2);
	}
	
	function getPostingFeeForAd($adid) {
		global $t_ads, $t_subcats, $t_cities;
		$adid += 0;
		$fee = 0;
		
		$sql = "SELECT subcat.catid, a.subcatid, a.cityid, ct.countryid
				FROM $t_ads a
					INNER JOIN $t_subcats subcat ON a.subcatid = subcat.subcatid
					INNER JOIN $t_cities ct ON a.cityid = ct.cityid
				WHERE adid = $adid";
		$res = $this->query($sql);
		
		if (mysql_num_rows($res)) {
			$row = mysql_fetch_assoc($res);
			$fee = $this->getPostingFee($row['catid'], $row['subcatid'], 
				$row['cityid'], $row['countryid']);
		}
		
		return $fee;
	}
	
	function markAdPaid($adid) {
		global $t_ads;
	
		$idlist = "";
		if (is_array($adid)) {
			foreach($adid as $k=>$v) $adid[$k] += 0; // Numerize.
			$idlist = implode(",", $adid);
		} else {
			$idlist = $adid+0;
		}
		
		$sql = "UPDATE $t_ads SET paid = '1' WHERE adid IN ($idlist)";
		$res = $this->query($sql) or $this->handleError(mysql_error() . "<br>{$sql}" );
		return $res;
	}
	
	function query($sql) {
		$this->debug("SQL: $sql<br>");
		$result = mysql_query($sql);
		$this->debug("Affected: " . mysql_affected_rows() . "<br>");
		return $result;
	}

	function handleError($message) {
		global $debug;
		if ($debug) {
			$messageHtml = '<div style="margin-bottom: 0px; padding: 10px; background-color: lightyellow; border-bottom: 1px solid darkorange;">';
			$messageHtml .= $message;
			$messageHtml .= '</div>';
			echo $messageHtml;
		}
	}
	
	function debug($str = "") {
		global $debug;
		if ($debug) echo "<pre>{$str}</pre>";
	}
}

$paidCategoriesHelper = new PaidCategoriesHelper();

?>
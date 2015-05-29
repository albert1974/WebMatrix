<?php
/**
 * @version		$Id: default.php 2012-01-30 15:24:18Z $
 * @package		BlastChat Config
 * @author 		BlastChat
 * @copyright	Copyright (C) 2004-2013 BlastChat. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @HomePage 	<http://www.blastchat.com>

 * This file is part of BlastChat Config.

 * BlastChat Config is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * BlastChat Config is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with BlastChat Config.  If not, see <http://www.gnu.org/licenses/>.
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$bc_task = htmlspecialchars(JRequest::getString('task', null), ENT_QUOTES, "UTF-8");
if ($bc_task == 'keepsession') {
	echo "ok";
	return;
}

$par = JComponentHelper::getParams('com_blastchatconfig');

$rids = htmlspecialchars(JRequest::getString('r', null), ENT_QUOTES, "UTF-8");
$intf = htmlspecialchars(JRequest::getString('i', null), ENT_QUOTES, "UTF-8");

/* disable cache */
//$cache = & JFactory::getCache();
//$cache->setCaching(false); // make sure cache is off

$bcData = new stdClass();

$bcData->detached = 1;
$bcData->client = 'conf';
$bcData->interface = $intf ? $intf : 'chat';//'chat';
$bcData->version = "4.0";

$bcData->roomids = $rids ? $rids : ''; //comma separated list of room ids to open
$bcData->id = "blastchatchat";

$document =& JFactory::getDocument();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
   xml:lang="<?php echo $document->language; ?>" lang="<?php echo $document->language; ?>" dir="<?php echo $document->direction; ?>" >
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />

<?php
include(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_blastchatconfig'. DIRECTORY_SEPARATOR . 'loader.php');
?>
</head>
<body>
	<div class="bcMainDetached bcMainLoading" id="<?php echo $bcData->id;?>"></div>
</body>
</html>

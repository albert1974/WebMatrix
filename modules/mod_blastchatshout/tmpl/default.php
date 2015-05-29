<?php
/**
 * @version		$Id: default.php 2012-01-30 15:24:18Z $
 * @package		BlastChat Shout
 * @author 		BlastChat
 * @copyright	Copyright (C) 2004-2013 BlastChat. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @HomePage 	<http://www.blastchat.com>

 * This file is part of BlastChat Shout.

 * BlastChat Shout is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * BlastChat Shout is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with BlastChat Shout.  If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$par = JComponentHelper::getParams('com_blastchatconfig');

$website = $params;

$bcData = new stdClass();
$bcData->detached = 0;
$bcData->client = 'shout';
$bcData->interface = $website->get("interface") ? $website->get("interface") : "shout";
$bcData->version = "4.0";

$bcData->roomids = $website->get("rids") ? $website->get("rids") : 1; //comma separated list of room ids to open
$bcData->id = "blastchatshout".$module->id;

$bcwidth = $website->get("width");
if (strpos($bcwidth, "%") === false) {
	$bcwidth .= "px";
}

$bcheight = $website->get("height");
if (strpos($bcheight, "%") === false) {
	$bcheight .= "px";
}

include(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_blastchatconfig'. DIRECTORY_SEPARATOR . 'loader.php');

echo '<div class="bcMainShout bcMainLoading" id="'.$bcData->id.'" style="width: '.$bcwidth.'; height: '.$bcheight.'"></div>';

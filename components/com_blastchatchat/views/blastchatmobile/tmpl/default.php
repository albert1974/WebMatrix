<?php
/**
 * @version		$Id: default.php 2012-01-30 15:24:18Z $
 * @package		BlastChat Chat
 * @author 		BlastChat
 * @copyright	Copyright (C) 2004-2013 BlastChat. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @HomePage 	<http://www.blastchat.com>

 * This file is part of BlastChat Chat.

 * BlastChat Chat is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * BlastChat Chat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with BlastChat Chat.  If not, see <http://www.gnu.org/licenses/>.
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$par = JComponentHelper::getParams('com_blastchatconfig');

$app = JFactory::getApplication('site');
$website = $app->getParams("com_blastchatchat");

$bcData = new stdClass();
$bcData->detached = 0;
$bcData->client = 'mob';
$bcData->interface = 'mob';
$bcData->version = "4.0";

$bcData->roomids = $website->get("rids") ? $website->get("rids") : ''; //comma separated list of room ids to open
$bcData->id = "blastchatmob";

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<title></title>
<?php
include(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_blastchatconfig'. DIRECTORY_SEPARATOR . 'loader.php');
?>
</head>
<body><div class="bcMain bcMainLoading" id="<?php echo $bcData->id;?>" style="width: 100%; height: 100%"></div>
</body>
</html>

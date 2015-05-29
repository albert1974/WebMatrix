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
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

$src = JPATH_ROOT . DIRECTORY_SEPARATOR . "components" . DIRECTORY_SEPARATOR . "com_blastchatconfig" . DIRECTORY_SEPARATOR . "config_default";
$dest = JPATH_ROOT . DIRECTORY_SEPARATOR . "components" . DIRECTORY_SEPARATOR . "com_blastchatconfig" . DIRECTORY_SEPARATOR . "config";

if ( !is_dir( $dest ) ) {
	if (@mkdir( $dest )) {
		if (!is_file($dest. DIRECTORY_SEPARATOR ."system.js")) {
			copy( $src. DIRECTORY_SEPARATOR ."system.js", $dest. DIRECTORY_SEPARATOR ."system.js");
		}
		if (!is_file($dest. DIRECTORY_SEPARATOR ."rooms.js")) {
			copy( $src. DIRECTORY_SEPARATOR ."rooms.js", $dest. DIRECTORY_SEPARATOR ."rooms.js");
		}
		if (!is_file($dest. DIRECTORY_SEPARATOR ."groups.js")) {
			copy( $src. DIRECTORY_SEPARATOR ."groups.js", $dest. DIRECTORY_SEPARATOR ."groups.js");
		}
		if (!is_file($dest. DIRECTORY_SEPARATOR ."roomsgroups.js")) {
			copy( $src. DIRECTORY_SEPARATOR ."roomsgroups.js", $dest. DIRECTORY_SEPARATOR ."roomsgroups.js");
		}
		if (!is_file($dest. DIRECTORY_SEPARATOR ."emoticons.js")) {
			copy( $src. DIRECTORY_SEPARATOR ."emoticons.js", $dest. DIRECTORY_SEPARATOR ."emoticons.js");
		}
		if (!is_file($dest. DIRECTORY_SEPARATOR ."sounds.js")) {
			copy( $src. DIRECTORY_SEPARATOR ."sounds.js", $dest. DIRECTORY_SEPARATOR ."sounds.js");
		}
		if (!is_file($dest. DIRECTORY_SEPARATOR ."api.blastchat.php.js")) {
			copy( $src. DIRECTORY_SEPARATOR ."api_custom.blastchat.php", $dest. DIRECTORY_SEPARATOR ."api.blastchat.php");
		}
		if (!is_file($dest. DIRECTORY_SEPARATOR ."index.html")) {
			copy( $src. DIRECTORY_SEPARATOR ."index.html", $dest. DIRECTORY_SEPARATOR ."index.html");
		}
		
		@mkdir( $dest . DIRECTORY_SEPARATOR . "css");
		copy( $src. DIRECTORY_SEPARATOR ."css" . DIRECTORY_SEPARATOR . "index.html", $dest. DIRECTORY_SEPARATOR ."css" . DIRECTORY_SEPARATOR . "index.html");
		@mkdir( $dest . DIRECTORY_SEPARATOR . "images");
		copy( $src. DIRECTORY_SEPARATOR ."images" . DIRECTORY_SEPARATOR . "index.html", $dest. DIRECTORY_SEPARATOR ."images" . DIRECTORY_SEPARATOR . "index.html");
		@mkdir( $dest . DIRECTORY_SEPARATOR . "js");
		copy( $src. DIRECTORY_SEPARATOR ."js" . DIRECTORY_SEPARATOR . "index.html", $dest. DIRECTORY_SEPARATOR ."js" . DIRECTORY_SEPARATOR . "index.html");
		@mkdir( $dest . DIRECTORY_SEPARATOR . "languages");
		copy( $src. DIRECTORY_SEPARATOR ."languages" . DIRECTORY_SEPARATOR . "index.html", $dest. DIRECTORY_SEPARATOR ."languages" . DIRECTORY_SEPARATOR . "index.html");
		@mkdir( $dest . DIRECTORY_SEPARATOR . "sounds");
		copy( $src. DIRECTORY_SEPARATOR ."sounds" . DIRECTORY_SEPARATOR . "index.html", $dest. DIRECTORY_SEPARATOR ."sounds" . DIRECTORY_SEPARATOR . "index.html");
	}
}

?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform"">
	<tr>
		<td>
			<div>
				<p>1. Create blastchat.com account, register your website and manage your registration using our <a href="http://www.blastchat.com/manager" target="_blank" title="BlastChat Manager">BlastChat Manager</a>.</p>
				<p>2. Copy Authentication data from step 1. to "Options".</p>
				<p>3. User interface configuration is located in components/com_blastchatconfig/config directory files. You can read more about it at our <a href="http://www.blastchat.com/configuration" target="_blank" title="BlastChat Configuration">Configuration</a> page.</p>
				<p>4. Install BlastChat Chat, BlastChat Shout and/or BlastChat Bar extensions.</p>
			<div>
		</td>
	</tr>
</table>
<div align="center" style="width:100%; font-size: 10px; text-align:center; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px;">Powered by <a href="http://www.blastchat.com" target="_blank" title="BlastChat - free chat for your website or blog">BlastChat</a></div>

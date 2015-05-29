<?php
/**
 * @version		$Id: api.blastchatc.php 2012-01-30 15:24:18Z $
 * @package		BlastChat Config
 * @author 		BlastChat
 * @copyright	Copyright (C) 2004-2013 BlastChat. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @HomePage 	<http://www.blastchat.com>

 * This file is part of BlastChat Config.

 * BlastChat Config is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License a” published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * BlastChat Config is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with BlastChat Config.  If not, see <http://www.gnu.org/licenses/>.
 */

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class BlastChatApiCustom extends BlastChatApi
{
	/*
	public function bc_createBlastChatData($bcData, $par) {
		static $called;
		static $bcDataJavascript;
	
		$cloc = "components" . DIRECTORY_SEPARATOR . "com_blastchatconfig" . DIRECTORY_SEPARATOR . "config_default";
		$cloccustom = "components" . DIRECTORY_SEPARATOR . "com_blastchatconfig" . DIRECTORY_SEPARATOR . "config";
		$webcloc = "components/com_blastchatconfig/config_default";
		$webcloccustom = "components/com_blastchatconfig/config";

		$bcData->request = "http://bcs.blastchat.com/bc/dist/bcif/bc.js";
	
		if ($par) {
			$cver = $par->get("configver");
			if (empty($cver) && $cver!=0) {
				echo "Missing BlastChat Config - Config version.";
				return;
			}
			$sid = $par->get("sid");
			if (!$sid || empty($sid)) {
				echo "Missing BlastChat Config - Website ID.";
				return;
			}
			$sid = intval($sid);
			$pk = $par->get("pk");
			if (empty($pk)) {
				echo "Missing BlastChat Config - Private key.";
				return;
			}
			$guestprefix = $par->get("guestprefix");
			if (empty($guestprefix)) {
				echo "Missing BlastChat Config - Guest prefix.";
				return;
			}
		} else {
			echo "Missing BlastChat Config extension.";
			return;
		}
		
		$bcData->configver = trim($cver);
		$bcData->sid = $sid;
		$bcData->pk = trim($pk);
		$bcData->guestprefix = trim($guestprefix);
		
	
		$document = JFactory::getDocument();
		if (!$called) {
			$user = self::bc_getUser();
	
			$bcData->theme = self::bc_getTheme($par);
			
			$bcData->userid = $user->id ? $user->id : 0;
			$bcData->name = $bcData->userid != 0 ? $user->username : uniqid($bcData->guestprefix, false);
			
			$guestnames = self::bc_getGuestNames();
			if (count($guestnames) > 0) {
				$bcData->fullname = $bcData->userid != 0 ? $user->name : $bcData->guestprefix.$guestnames[rand(0, count($guestnames)-1)];
			} else {
				$bcData->fullname = $bcData->userid != 0 ? $user->name : $bcData->name;
			}
			
			$bcData->gids = self::bc_getUserGroups($user);
			$bcData->gender = self::bc_getUserGender($user);
			$bcData->friends = self::bc_getUserFriends($user);
			$bcData->lang = self::bc_getLanguageFile($user, $par);
			
			$bcData->avtPath = "";
			$bcData->avt = "";
			$bcData->avtShow = false;
			if ($par->get("avtint") != "0") {
				$avatar = self::bc_getUserAvatar($user, $par->get("avtint"));
				$bcData->avtPath = $avatar->commonpath;
				$bcData->avt = $avatar->file;
				$bcData->avtShow = true;
			}
	
			$jversion = self::bc_getVersion();
			$bcData->prod = "'".$jversion->PRODUCT."','".$jversion->RELEASE."','".$jversion->DEV_LEVEL."'";
			
			$bcData->protocol = 0; //0 http, 1 - https (not used)
			$bcData->time = time();
			$bcData->code = hash('sha256', $bcData->time.$bcData->pk.$bcData->userid.$bcData->name.$bcData->gids );
			
			$bcDataJavascript = ""
				."if (typeof bcData === 'undefined') {"
					."var bcData = {"
						."'sid':".$bcData->sid.","
						."'auth':['".$bcData->time."','".$bcData->code."'],"
						."'user': ".json_encode(array(
							'sid' => $bcData->sid,
							'id' => $bcData->userid,
							'name' => $bcData->name,
							'fullname' => $bcData->fullname,
							'gids' => $bcData->gids,
							'gender' => $bcData->gender,
							'avt' => $bcData->avt
							)).","
						."'avtPath':'".$bcData->avtPath."',"
						."'avtShow':".($bcData->avtShow ? 'true' : 'false').","
						."'friends':[".$bcData->friends."],"
						."'bw':".(isset($bcData->barWidth) && $bcData->barWidth > 0 ? $bcData->barWidth : '0').","
						."'bh':".(isset($bcData->barHeight) && $bcData->barHeight > 0 ? $bcData->barHeight : '0').","
						."'detached':".$bcData->detached.","
						."'protocol':".$bcData->protocol.","
						."'product':[".$bcData->prod."],"
						."'theme':{'name':'".$bcData->theme->name."','cloc':'".$bcData->theme->cloc."','over':'".$bcData->theme->over."'},"
						."'bcc':[]"
					."};"
				."}"
				;
		}
		
		if ($bcData->detached || $bcData->interface == 'mob') {
			echo "<link rel=\"stylesheet\" href=\"".$webcloc."/css/main.css?v=".$bcData->configver."\" type=\"text/css\" />";
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'main.css')) {
				echo "<link rel=\"stylesheet\" href=\"".$webcloccustom."/css/main.css?v=".$bcData->configver."\" type=\"text/css\" />";
			}
			
			echo "\n<link rel=\"stylesheet\" href=\"".$webcloc."/css/icons.css?v=".$bcData->configver."\" type=\"text/css\" />";
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'icons.css')) {
				echo "\n<link rel=\"stylesheet\" href=\"".$webcloccustom."/css/icons.css?v=".$bcData->configver."\" type=\"text/css\" />";
			}
			
			echo "\n<link rel=\"stylesheet\" href=\"".$webcloc."/css/emoticons.css?v=".$bcData->configver."\" type=\"text/css\" />";
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'emoticons.css')) {
				echo "\n<link rel=\"stylesheet\" href=\"".$webcloccustom."/css/emoticons.css?v=".$bcData->configver."\" type=\"text/css\" />";
			}
			
			echo "\n<link rel=\"stylesheet\" href=\"".$webcloc."/css/sounds.css?v=".$bcData->configver."\" type=\"text/css\" />";
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'sounds.css')) {
				echo "\n<link rel=\"stylesheet\" href=\"".$webcloccustom."/css/sounds.css?v=".$bcData->configver."\" type=\"text/css\" />";
			}
			
			if ($bcData->detached) {
				echo "\n<style type=\"text/css\">\nhtml, body, #blastchatchat {top:0; left:0; height: 100%; width: 100%; padding: 0; margin: 0; border: 0; overflow: hidden; position: absolute;}\n#header {margin: 0px;}</style>";
			}
			
			echo "\n<script type=\"text/javascript\" src=\"components/com_blastchatconfig/js/loader.js?v=".$bcData->configver."\"></script>";
			
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'parseuri.js')) {
				echo "\n<script type=\"text/javascript\" src=\"".$webclocustom."/js/parseuri.js?v=".$bcData->configver."\"></script>";
			} else {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloc."/js/parseuri.js?v=".$bcData->configver."\"></script>";
			}
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $bcData->lang . '.js')) {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloccustom."/languages/".$bcData->lang.".js?v=".$bcData->configver."\"></script>";
			} else {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloc."/languages/".$bcData->lang.".js?v=".$bcData->configver."\"></script>";
			}
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'system.js')) {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloccustom."/system.js?v=".$bcData->configver."\"></script>";
			} else {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloc."/system.js?v=".$bcData->configver."\"></script>";
			}
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'rooms.js')) {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloccustom."/rooms.js?v=".$bcData->configver."\"></script>";
			} else {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloc."/rooms.js?v=".$bcData->configver."\"></script>";
			}
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'groups.js')) {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloccustom."/groups.js?v=".$bcData->configver."\"></script>";
			} else {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloc."/groups.js?v=".$bcData->configver."\"></script>";
			}
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'roomsgroups.js')) {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloccustom."/roomsgroups.js?v=".$bcData->configver."\"></script>";
			} else {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloc."/roomsgroups.js?v=".$bcData->configver."\"></script>";
			}
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'emoticons.js')) {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloccustom."/emoticons.js?v=".$bcData->configver."\"></script>";
			} else {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloc."/emoticons.js?v=".$bcData->configver."\"></script>";
			}
			if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'sounds.js')) {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloccustom."/sounds.js?v=".$bcData->configver."\"></script>";
			} else {
				echo "\n<script type=\"text/javascript\" src=\"".$webcloc."/sounds.js?v=".$bcData->configver."\"></script>";
			}
			echo "\n<script type=\"text/javascript\">";
			echo $bcDataJavascript;
			echo "\nbcData.bcc.push(['".$bcData->id."','".$bcData->client."','".$bcData->interface."',[".$bcData->roomids."], '".$bcData->version."']);";
			echo "\nbcLoader(\"bcJSmain\", \"script\", \"".$bcData->request."\", null, null);";
			echo "\n</script>";
		} else {
			if (!$called) {
				$document->addScriptDeclaration($bcDataJavascript);
				$document->addScript("components/com_blastchatconfig/js/loader.js?v=".$bcData->configver);
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'parseuri.js')) {
					$document->addScript($webcloccustom."/js/parseuri.js?v=".$bcData->configver);
				} else {
					$document->addScript($webcloc."/js/parseuri.js?v=".$bcData->configver);
				}
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $bcData->lang . '.js')) {
					$document->addScript($webcloccustom."/languages/".$bcData->lang.".js?v=".$bcData->configver);
				} else {
					$document->addScript($webcloc."/languages/".$bcData->lang.".js?v=".$bcData->configver);
				}
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'system.js')) {
					$document->addScript($webcloccustom."/system.js?v=".$bcData->configver);
				} else {
					$document->addScript($webcloc."/system.js?v=".$bcData->configver);
				}
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'rooms.js')) {
					$document->addScript($webcloccustom."/rooms.js?v=".$bcData->configver);
				} else {
					$document->addScript($webcloc."/rooms.js?v=".$bcData->configver);
				}
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'groups.js')) {
					$document->addScript($webcloccustom."/groups.js?v=".$bcData->configver);
				} else {
					$document->addScript($webcloc."/groups.js?v=".$bcData->configver);
				}
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'roomsgroups.js')) {
					$document->addScript($webcloccustom."/roomsgroups.js?v=".$bcData->configver);
				} else {
					$document->addScript($webcloc."/roomsgroups.js?v=".$bcData->configver);
				}
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'emoticons.js')) {
					$document->addScript($webcloccustom."/emoticons.js?v=".$bcData->configver);
				} else {
					$document->addScript($webcloc."/emoticons.js?v=".$bcData->configver);
				}
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'sounds.js')) {
					$document->addScript($webcloccustom."/sounds.js?v=".$bcData->configver);
				} else {
					$document->addScript($webcloc."/sounds.js?v=".$bcData->configver);
				}
				
				$document->addStyleSheet($webcloc."/css/main.css?v=".$bcData->configver);
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'main.css')) {
					$document->addStyleSheet($webcloccustom."/css/main.css?v=".$bcData->configver);
				}
				
				$document->addStyleSheet($webcloc."/css/icons.css?v=".$bcData->configver);
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'icons.css')) {
					$document->addStyleSheet($webcloccustom."/css/icons.css?v=".$bcData->configver);
				}
				
				$document->addStyleSheet($webcloc."/css/emoticons.css?v=".$bcData->configver);
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'emoticons.css')) {
					$document->addStyleSheet($webcloccustom."/css/emoticons.css?v=".$bcData->configver);
				}
				
				$document->addStyleSheet($webcloc."/css/sounds.css?v=".$bcData->configver);
				if (is_file(JPATH_ROOT . DIRECTORY_SEPARATOR . trim($cloccustom) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'sounds.css')) {
					$document->addStyleSheet($webcloccustom."/css/sounds.css?v=".$bcData->configver);
				}

				$document->addScriptDeclaration("if (typeof bcData.loaded === 'undefined') {bcLoader('bcJSmain', 'script', '".$bcData->request."', null, null);bcData.loaded = [];}");
			}
			$document->addScriptDeclaration("var bcDataObj = ['".$bcData->id."','".$bcData->client."','".$bcData->interface."',[".$bcData->roomids."], '".$bcData->version."'];if (bcData.loaded.indexOf('".$bcData->id."') == -1) {bcData.bcc.push(bcDataObj);bcData.loaded.push('".$bcData->id."');}");
		}
			
		$called = true;
	}
	*/
	
	/*
	protected function bc_getTheme($par) {
		$theme = new stdClass();
		$theme->name = $par->get("theme");
		$theme->cloc = "";
		$theme->over = "";
		if ($par->get("themecname") != "" && $par->get("themecloc") != "") {
			$theme->name = $par->get("themecname");
			$theme->cloc = $par->get("themecloc");
		}
		$theme->over = $par->get("themeover");
		return $theme;
	}
	/*
	
	/*
	return language file name in the "languages" subdirectory, we will prepend .js extension to it
	*/
	/*
	protected function bc_getLanguageFile($user, $par) {
		$lang = "en";
		if ($par->get("bclang")) {
			$lang = $par->get("bclang");
		}
		return $lang;
	}
	*/
	
	/*
	return predefined guest names, if empty generated guest name will be used
	*/
	/*
	protected function bc_getGuestNames() {
		//return array("John", "Peter", "Mark", "Jim", "Bill");
		return array();
	}
	*/
	
	/*
	return user object (containing at least id, username, name)
	$user->id
	$user->username
	$user->name
	*/
	/*
	protected function bc_getUser() {
		$user = JFactory::getUser();
		return $user;
	}
	*/
	
	/*
	return comma separated string of user group ids
	*/
	/*
	protected function bc_getUserGroups($user) {
		//find gids
		$gids = 0;
	
		if(version_compare(JVERSION,'1.6.0','ge')) {
			// Joomla! 1.6 code here
			$gids = JAccess::getGroupsByUser($user->id);
			$gids = implode(",", $gids);
		} else {
			// Joomla! 1.5 code here
			$gids = $user->gid;
		}
		return $gids;
	}
	*/
	
	/*
	returns int
	0 - unknown, 1 - male, 2 - female
	*/
	/*
	protected function bc_getUserGender($user) {
		//$user->gender
		$gender = 0;
		return $gender;
	}
	*/
	
	/*
	return comma separated string of user friends IDs
	*/
	/*
	protected function bc_getUserFriends($user) {
		//$friends = implode(',', array('1','2','3'));
		$friends = "";
		return $friends;
	}
	*/
	
	/*
	protected function bc_getUserAvatar($user, $type) {
		$db = JFactory::getDBO();
		$avt_file = "";
		$avt_commonpath = "";
		$avt_path = "";
		$row = null;
		$avatar = new stdClass();
	
		//Import JomSocial libraries, if it is installed.
		if ($type == "1") {
			if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_community' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'core.php') ) {
				require_once( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_community' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'core.php');
				if (class_exists('CFactory')) {
				  $jsUser =& CFactory::getUser();
					$avt_file = $jsUser->getAvatar();
					if ($avt_file) {
						$avt_file = "/".str_replace(JURI::root(), '', $avt_file);
					}
				}
			}
		}
		//end of JomSocial integration
			
		//Community Builder integration
		if ($type == "2") {
			if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_comprofiler' . DIRECTORY_SEPARATOR . 'comprofiler.class.php') ) {
				if ($user->id) {
					$query = "SELECT avatar FROM #__comprofiler WHERE user_id=".$user->id." AND avatarapproved=1";
					$db->setQuery($query);
					$row = $db->loadResult();
					if ($row) {
						$avt_path = "/images/comprofiler/";
					} else {
						//provide default avatar as we did not find avatar defined for user
						if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'comprofiler' . DIRECTORY_SEPARATOR . 'nophoto_n.png') ) {
							$avt_path = "/images/comprofiler/nophoto_n.png";
						} else if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_comprofiler' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'dark' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . 'nophoto_n.png') ) {
							$avt_path = "/components/com_comprofiler/plugin/templates/dark/images/avatar/nophoto_n.png";
						} else if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_comprofiler' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'light' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . 'nophoto_n.png') ) {
							$avt_path = "/components/com_comprofiler/plugin/templates/light/images/avatar/nophoto_n.png";
						}
						$row = "";
					}
				} else {
					//need better code for guest
					if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'comprofiler' . DIRECTORY_SEPARATOR . 'nophoto_n.png') ) {
						$avt_path = "/images/comprofiler/nophoto_n.png";
					} else if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_comprofiler' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'dark' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . 'nophoto_n.png') ) {
						$avt_path = "/components/com_comprofiler/plugin/templates/dark/images/avatar/nophoto_n.png";
					} else if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_comprofiler' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'light' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . 'nophoto_n.png') ) {
						$avt_path = "/components/com_comprofiler/plugin/templates/light/images/avatar/nophoto_n.png";
					}
					$row = "";
				}
				$avt_file = $avt_path.$row;
			}
		}
		//end of Community Builder integration
		
		//Kunena integration
		if ($type == "3") {
			if( file_exists(JPATH_ROOT . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_kunena' . DIRECTORY_SEPARATOR . 'admin.kunena.php') ) {
				$avt_commonpath = "/media/kunena/avatars";
				if ($user->id) {
					$query = "SELECT avatar FROM #__kunena_users WHERE userid=".$user->id;
					$db->setQuery($query);
					$row = $db->loadResult();
					if ($row) {
						if ( file_exists(JPATH_ROOT . $avt_commonpath . '/resized/size36/users/' . $row) ) {
							$avt_path = "/resized/size36/users/";
						} else if( file_exists(JPATH_ROOT . $avt_commonpath . '/resized/size36/' . $row) ) {
							$avt_path = "/resized/size36/";
						} else if( file_exists(JPATH_ROOT . $avt_commonpath . '/resized/size144/users/' . $row) ) {
							$avt_path = "/resized/size144/users/";
						} else if( file_exists(JPATH_ROOT . $avt_commonpath . '/resized/size144/' . $row) ) {
							$avt_path = "/resized/size144/";
						} else if( file_exists(JPATH_ROOT . $avt_commonpath . '/resized/size200/users/' . $row) ) {
							$avt_path = "/resized/size200/users/";
						} else if( file_exists(JPATH_ROOT . $avt_commonpath . '/resized/size200/' . $row) ) {
							$avt_path = "/resized/size200/";
						} else {
							$avt_path = "/";
							$row = "nophoto.jpg";
						}
					} else {
						//provide default avatar as we did not find avatar defined for user
						$avt_path = "/";
						$row = "nophoto.jpg";
					}
				} else {
					//need code for guest
					$avt_path = "/";
					$row = "nophoto.jpg";
				}
				$avt_file = $avt_path.$row;
			}
		}
		//end of Kunena integration
		
		//OTHER integration
		if ($type == "4") {
			//provide integration code with OTHER system here
		}
		//end of OTHER integration
	
		$avatar->commonpath = $avt_commonpath;
		$avatar->file = $avt_file;
		return $avatar;
	}
	*/
	
	/*
	protected function bc_getVersion() {
		//prepare variables dependent on system used
		// $_VERSION - variable holding CMS information
		// $_VERSION->PRODUCT - product used
		// $_VERSION->RELEASE - release number of product used
		// $_VERSION->DEV_LEVEL  - development number of product used
		$bc_version = new JVersion();
		return $bc_version;
	}
	*/
}
?>

<?php
/**
 * @package iFlyChat
 * @copyright Copyright (C) 2014 iFlyChat. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @author iFlyChat Team
 * @link https://iflychat.com
 */
defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Iflychat');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();

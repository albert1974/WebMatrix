<?php
/**
 * @version		$Id: controller.php 2012-01-30 15:24:18Z $
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
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of HelloWorld component
 */
class BlastChatConfigController extends JControllerLegacy
{
        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = false)
        {
                // set default view if not set
                JRequest::setVar('view', JRequest::getCmd('view', 'blastchatconfig'));
 
                // call parent behavior
                parent::display($cachable);
                
                //BlastChat_ConfigHelper::addSubmenu(JRequest::getVar('view'));
        }
}
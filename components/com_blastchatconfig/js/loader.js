/**
 * @version		$Id: loader.js 2011-08-26 15:24:18Z $
 * @package		BlastChat Chat
 * @author 		BlastChat
 * @copyright	Copyright (C) 2004-2010 BlastChat. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @HomePage 	<http://www.blastchat.com>

 * This file is part of BlastChat Chat module.

 * BlastChat Chat module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * BlastChat Chat module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with BlastChat Chat module.  If not, see <http://www.gnu.org/licenses/>.
 */

if (!Array.prototype.indexOf) { 
	Array.prototype.indexOf = function(obj, start) {
		for (var i = (start || 0), j = this.length; i < j; i++) {
			if (this[i] === obj) { return i; }
   	}
		return -1;
	}
}

function bcLoader(id, type, url, callback) {
	var objHead, scriptTag = null;
	if (!document.getElementById(id)) {
		objHead = document.getElementsByTagName('head');
		if (objHead[0]) {
			if (document.createElementNS && objHead[0].tagName === 'head') {
				scriptTag = document.createElementNS(type);
			} else {
				scriptTag = document.createElement(type);
			}
			scriptTag.id = id;

			if (callback) {
				// check for IE
				if (scriptTag.readyState) {
					scriptTag.onreadystatechange = function () {
						if (scriptTag.readyState === "loaded"  || scriptTag.readyState === "complete") {
							scriptTag.onreadystatechange = null;
							callback();
						}
					};
				} else {
					scriptTag.onload = function () {
						callback();
					};
				}
			}
			if (type === "script") {
				scriptTag.src = url;
				scriptTag.type = "text/javascript";
				scriptTag.charset = "UTF-8";
			} else {
				scriptTag.href = url;
				scriptTag.type = "text/css";
				scriptTag.rel = "stylesheet";
			}
			objHead[0].appendChild(scriptTag);
		}
	}
}
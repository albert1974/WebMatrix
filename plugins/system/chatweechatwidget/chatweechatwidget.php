<?php

/*
 * @version;   						2.1
 * @category;						widget
 * @copyright;   					Copyright (C) 2014 Chatwee Team. All rights reserved.
 * @license;   						GNU GPLv3 http://www.gnu.org/licenses/gpl.html
 * @link ;   						http://www.chatwee.com/
 */

defined( '_JEXEC' ) or die( 'Direct Access Denied' );

jimport( 'joomla.plugin.plugin');

jimport( 'joomla.html.parameter');

class plgSystemChatweechatwidget extends JPlugin
{
	function plgSystemChatweechatwidget(&$subject, $config)
	{ 
		parent::__construct($subject, $config);
		
		$this->_plugin = JPluginHelper::getPlugin( 'system', 'chatweechatwidget' );
		
		$this->_params = new JRegistry( $this->_plugin->params );
	}
	
	public function get_the_user_ip()	
	{
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}
	
	public function check_user_agent ( $type = NULL )
	{	
        $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
        if ( $type == 'bot' ) {
                if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                        return true;
                }
        } else if ( $type == 'browser' ) {
                if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                        return true;
                }
        } else if ( $type == 'mobile' ) {
            
                if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                        return true;
                } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                        return true;
                }
        }
        return false;
	}

	function onAfterRender()
	{
		$panel_admin = JFactory::getApplication();
		
		$widget_code = $this->params->get('chatwee_code');
		
		if($widget_code == '' || $panel_admin->isAdmin() || strpos($_SERVER["PHP_SELF"], "index.php") === false)
		{
			return;
		}

		$document = JFactory::getDocument();
			
		$block = JResponse::getBody();
		
		$block = str_replace("</body>", $widget_code."</body>", $block);
		
		JResponse::setBody($block);
		
		return true;
	}

	function onUserAfterLogin()
	{
		$ssoStatus = $this->params->get('chatwee_sso_status');

		if($ssoStatus !=0){
		
			$chatId = $this->params->get('chatwee_chatid');
			
			$clientKey = $this->params->get('chatwee_apikey');
			
			$user =JFactory::getUser();
			
			$isAdmin = intval($user->get('isRoot'));

			$user_login = ($this->params->get('chatwee_username_or_fullname') == 1) ? $user->username : $user->name;
			
			$ismobile = ($this->check_user_agent('mobile')==true) ? 1 : 0;
			
			$ip = $this->get_the_user_ip();
			
			if(isSet($_COOKIE["chch-SI"]))
				$this->onUserLogout();
				
			$previousSessionId = isSet($_COOKIE["chch-PSI"]) ? $_COOKIE["chch-PSI"] : null;
			
			$url = "http://chatwee-api.com/api/remotelogin?chatId=".$chatId."&clientKey=".$clientKey."&login=".$user_login."&isAdmin=".$isAdmin."&ipAddress=".$ip."&isMobile=".$ismobile."&previousSessionId=".$previousSessionId;
			
			$url = str_replace(' ', '%20', $url);
			
			$response = file_get_contents($url);
			
			$sessionArray = json_decode($response);
			
			$sessionId = $sessionArray->sessionId;
			
			$hostChunks = explode(".", $_SERVER["HTTP_HOST"]);

			$hostChunks = array_slice($hostChunks, -2);

			$domain = "." . implode(".", $hostChunks);

			setcookie("chch-SI", $sessionId, time() + 2592000, "/", $domain);
		}
	}
	function onUserLogout()
	{
		$ssoStatus = $this->params->get('chatwee_sso_status');

		if($ssoStatus !=0){
		
			$chatId = $this->params->get('chatwee_chatid');
			
			$clientKey = $this->params->get('chatwee_apikey');
			
			$sessionId = $_COOKIE['chch-SI'];
			
			$url = "http://chatwee-api.com/api/remotelogout?chatId=".$chatId."&clientKey=".$clientKey."&sessionId=".$sessionId;
			
			$execute = file_get_contents($url);

			$hostChunks = explode(".", $_SERVER["HTTP_HOST"]);

			$hostChunks = array_slice($hostChunks, -2);

			$domain = "." . implode(".", $hostChunks); 

			setcookie("chch-SI", "", time() - 1, "/", $domain);
		}
	}
}

?>
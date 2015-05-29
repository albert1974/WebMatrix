<?php
/*
* @name mod_social_chat 1.0
* Created By Guarneri Iacopo
* http://www.the-html-tool.com/
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

function getOnlineUserNames($user_del, $search_user=-1) {
	
	if($user_del->get('id')==0){return "-1";}
	
	$db = JFactory::getDbo();
	
	$search_user_sql=""; $search_user_limit="";
	if($search_user!=-1){
		$search_user_sql="AND a.userid=".$search_user;
		$search_user_limit=" LIMIT 0,1";
	}

	$query='SELECT a.username, a.time, a.userid, a.client_id, b.status FROM #__session AS a LEFT JOIN #__social_chat_user AS b ON a.userid = b.user WHERE a.userid != 0 AND a.client_id = 0 AND b.status != 2 '.$search_user_sql.' GROUP BY a.userid'.$search_user_limit;
	$db->setQuery($query); //echo($query."***");
	
	$user_connect = $db->loadObjectList();

	$user_list="[";
	foreach($user_connect as $uc){
		if($user_del->get('id')==$uc->userid && $search_user==-1){continue;}
		$user_list.="{userid:".$uc->userid.", username:'".$uc->username."', stato:".$uc->status."},";
	}
	return $user_list."]";
}
function refresh(){
	$database = JFactory::getDBO();
	$user_me = JFactory::getUser();
	
	if($user_me->get('id')!=0){
		$database->setQuery("SELECT * FROM #__social_chat as c, #__users as u, #__social_chat_user as s WHERE c.a=".$user_me->get('id')." AND c.read=0 AND u.id=c.da AND s.user = u.id ORDER BY send");
		$results = $database->loadAssocList();
		
		$nuovi_mex="[";
		foreach($results as $result){	
			$stato=$result['status'];
			$stato1=getOnlineUserNames($user_me,$result['da']);
			if($stato1=="[]"){$stato=2;}
			
			$nuovi_mex=$nuovi_mex."{user:".$result['da'].", username:'".$result['username']."', txt:'".addslashes($result['txt'])."', data:".$result['send'].", stato:".$stato."},";
		}

		$nuovi_mex=$nuovi_mex."]";
		echo("[".$nuovi_mex.",".getOnlineUserNames($user_me).",".getOnlineUserNames($user_me, $user_me->get('id'))."]");
	}
	JFactory::getApplication()->close();
}

function insert_mex($user,$mex){
	$database = JFactory::getDBO();
	$user_me = JFactory::getUser();
	$mex=str_replace("\n","",nl2br(htmlentities($mex,ENT_QUOTES)));

	if($user_me->get('id')!=0){
		$database->setQuery("INSERT INTO #__social_chat (da, a, txt, send, `read`) VALUES (".$user_me->get('id').", ".$user.", '".$mex."', ".time().",'0')");
		$database->query();
	}
	JFactory::getApplication()->close();
}

function cambia_stato($stato){
	$database = JFactory::getDBO();
	$user_me = JFactory::getUser();

	if($user_me->get('id')!=0){
		$database->setQuery('SELECT COUNT(*) FROM #__social_chat_user WHERE user='.$user_me->get('id'));
		$results = $database->loadAssocList();
		if($results[0]['COUNT(*)']==0){
			//inserisce
			$database->setQuery("INSERT INTO #__social_chat_user (user,status) VALUES (".$user_me->get('id').",".$stato.")");
			$database->query();
		}else{
			//aggiorna
			$database->setQuery("UPDATE #__social_chat_user SET status=".$stato." WHERE user=".$user_me->get('id'));
			$database->query();
		}
	}
	JFactory::getApplication()->close();
}

function leggi($user){
	$database = JFactory::getDBO();
	$user_me = JFactory::getUser();
	
	if($user_me->get('id')!=0){
		$database->setQuery("UPDATE #__social_chat SET `read`='1' WHERE da=".$user." AND a=".$user_me->get('id')." AND `read`=0");
		$database->query();
	}
	JFactory::getApplication()->close();
}

function storico_utenti(){
	$database = JFactory::getDBO();
	$user_me = JFactory::getUser();
	
	$database->setQuery('SELECT s.da as elenco, u.username FROM #__social_chat as s, #__users as u WHERE s.a='.$user_me->get('id').' AND u.id=s.da GROUP BY s.da ORDER BY u.username');
	$results = $database->loadAssocList();
	
	foreach($results as $result){
		echo "<span class='filtrastorico' id='filtrastorico_".$result['elenco']."'>".$result['username']."</span><br />";
	}
	JFactory::getApplication()->close();
}

function storico_utente($id_user, $da, $a){
	$database = JFactory::getDBO();
	$user_me = JFactory::getUser();
	
	$database->setQuery('SELECT da, a, txt FROM #__social_chat WHERE (a='.$user_me->get('id').' AND da='.$id_user.') OR (da='.$user_me->get('id').' AND a='.$id_user.') ORDER BY send ASC');
	$results = $database->loadAssocList();
	
	foreach($results as $result){
		$user_da = JFactory::getUser($result['da']);
		$user_a = JFactory::getUser($result['a']);
		echo $da.": ".$user_da->get('username').", ".$a.": ".$user_a->get('username')."<br />".$result['txt']."<div class='social_chat_separatore'></div>";
	}
	JFactory::getApplication()->close();
}

function install(){
	$database = &JFactory::getDBO();
	$database->setQuery("DELETE FROM #__menu WHERE alias = 'social-chat' OR alias = 'social-chat-core'");
	$database->query();

	header("location: ".JURI::base()."administrator/index.php?option=com_modules");
	JFactory::getApplication()->close();
}

$aggiorna = JRequest::getVar('aggiorna', '', 'post');
$user = JRequest::getVar('user', '', 'post');
$mex = JRequest::getVar('mex', '', 'post');
$stato = JRequest::getVar('stato', '', 'post');
$letto = JRequest::getVar('letto', '', 'post');
$storico_utenti = JRequest::getVar('storico_utenti', '', 'post');
$storico_utente = JRequest::getVar('storico_utente', '', 'post');
$da = JRequest::getVar('da', '', 'post');
$a = JRequest::getVar('a', '', 'post');

if(JRequest::getVar('install', '', 'get')==1){install();}
if($aggiorna==1){refresh();}
if($user!="" && $mex!=""){insert_mex($user,$mex);}
if($stato!=""){cambia_stato($stato);}
if($letto!=""){leggi($letto);}
if($storico_utenti==1){storico_utenti();}
if($storico_utente!="" && $da!="" && $a!=""){storico_utente($storico_utente,$da,$a);}
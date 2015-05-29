<?php
/*
* @name mod_social_chat 1.0
* Created By Guarneri Iacopo
* http://www.the-html-tool.com/
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

/*
gli utenti offline non riescono a scriversi? :(
*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$loggati_txt=JText::_('MOD_SOCIAL_CHAT_LOGGATI');
$chat_txt=JText::_('MOD_SOCIAL_CHAT_CHAT');
$invia_txt=JText::_('MOD_SOCIAL_CHAT_INVIA');
$disponibile=JText::_('MOD_SOCIAL_CHAT_DISPONIBILE');
$occupato=JText::_('MOD_SOCIAL_CHAT_OCCUPATO');
$invisibile=JText::_('MOD_SOCIAL_CHAT_INVISIBILE');
$storico_txt=JText::_('MOD_SOCIAL_CHAT_STORICO');
$entrata_txt=JText::_('MOD_SOCIAL_CHAT_ENTRATA');
$uscita_txt=JText::_('MOD_SOCIAL_CHAT_USCITA');
$da_txt=JText::_('MOD_SOCIAL_CHAT_DA');
$a_txt=JText::_('MOD_SOCIAL_CHAT_A');
$sei_offline=JText::_('MOD_SOCIAL_CHAT_SEI_OFFLINE');

$position = $params->get('position', 'fixed');
if($position=="relative"){
	$position='class="relative_style"';
}else{
	$position='';
}
$WCSS=$params->get('width', '200');
$HCSS=$params->get('height', '152');
$H1CSS='17';

//error_reporting(E_ALL);
//ini_set('display_errors','On');

$database = JFactory::getDBO();
$user_me = JFactory::getUser();

function install($database) {
	$database = &JFactory::getDBO();
	$database->setQuery("DELETE FROM #__menu WHERE alias = 'social-chat' OR alias = 'social-chat-core'");
	$database->query();
	
	$query = "CREATE TABLE `#__social_chat` (
	`id_chat` int(11) NOT NULL AUTO_INCREMENT,
	`da` int(11) NOT NULL,
	`a` int(11) NOT NULL,
	`txt` text NOT NULL,
	`send` int(11) NOT NULL,
	`read` int(1) NOT NULL,
	PRIMARY KEY  (`id_chat`)
	) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
	$database->setQuery($query);
	$result = $database->query(); 

	$query = "CREATE TABLE `#__social_chat_user` (
	`id_chat_user` int(11) NOT NULL AUTO_INCREMENT,
	`user` int(11) NOT NULL,
	`status` int(11) NOT NULL,
	PRIMARY KEY  (`id_chat_user`)
	) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
	$database->setQuery($query);
	$result = $database->query(); 
}

//controllo: se non ci sono le tabelle le creo
$database->setQuery("SHOW TABLES LIKE '%social_chat%'");
$elenco_delle_tabelle = $database->loadAssocList();
if(count($elenco_delle_tabelle)==0){install($database);}
?>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>modules/mod_social_chat/mod_social_chat.css" type="text/css" />

<div id="social_chat_container" <?php echo $position; ?> style="right:<?php echo $WCSS+11; ?>px;"></div>
<div id="social_chat_panel" <?php echo $position; ?> style="width:<?php echo $WCSS; ?>px; height:<?php echo $HCSS; ?>px;"></div>
<div id="social_chat_start" <?php echo $position; ?> style="width:<?php echo $WCSS; ?>px; height:<?php echo $H1CSS; ?>px;"></div>
<div id="social_chat_status" <?php echo $position; ?>>
	<img src="<?php echo JURI::base(); ?>modules/mod_social_chat/gear.png">
</div>
<div id="social_chat_status_panel" <?php echo $position; ?>>
<?php
	echo "<span class='cerchio colore_online'></span><span class='social_chat_stato' id='status_0'>".$disponibile."</span><br />";
	echo "<span class='cerchio colore_occupato'></span><span class='social_chat_stato' id='status_1'>".$occupato."</span><br />";
	echo "<span class='cerchio colore_offline'></span><span class='social_chat_stato' id='status_2'>".$invisibile."</span><br />";
	echo "<span id='storico_but'>".$storico_txt."</span><br />";
?>
</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
( function($) {
jQuery.noConflict();
jQuery(document).ready(function($){

function rimuovi_px(str){
	if(str==undefined){return("");}
	return parseInt(str.substr(0,str.length-2));
}
function width(elemento){
	w=0;
	w=w+rimuovi_px($(elemento).css("width"));
	w=w+rimuovi_px($(elemento).css("border-left-width"));
	w=w+rimuovi_px($(elemento).css("border-right-width"));
	w=w+rimuovi_px($(elemento).css("padding-left"));
	w=w+rimuovi_px($(elemento).css("padding-right"));
	return w;
}

n_box=0;
function paginator(){
	//allarga il contenitore
	$("#social_chat_container").width(n_box*width("#social_chat_container div"));
	
	//quanti box ci possono stare in questa larghezza?
	box_line=Math.floor(($(window).width()-rimuovi_px($("#social_chat_container").css("right")))/$(".social_chat_box").width());
	
	//se son troppi utenti li deve mettere su più righe
	tot_w=width("#social_chat_container")+rimuovi_px($("#social_chat_container").css("right"));
	if(tot_w>$(window).width()){
		$("#social_chat_container").width($(window).width()-rimuovi_px($("#social_chat_container").css("right")));
		numero_righe=n_box/box_line;
		if(numero_righe%1!=0){numero_righe=numero_righe+1;}
		numero_righe=Math.floor(numero_righe);

		$("#social_chat_container").height($(".social_chat_box").height()*numero_righe);
	}else{
		$("#social_chat_container").height($(".social_chat_box").height());
	}
}

panel_open=0;
$("#social_chat_start").click(function(){
	if(panel_open==0){
		$("#social_chat_panel").css("display","block"); panel_open=1;}
	else if(panel_open==1){
		$("#social_chat_panel").css("display","none"); panel_open=0;}
});

panel_open_status=0;
$("#social_chat_status").click(function(){
	if(panel_open_status==0){
		$("#social_chat_status_panel").css("display","block"); panel_open_status=1;}
	else if(panel_open_status==1){
		$("#social_chat_status_panel").css("display","none"); panel_open_status=0;}
});

function colore_stato(sel_stat, id_stat){
	if(id_stat==0){sel_stat.css("background","#3ec124");}
	if(id_stat==1){sel_stat.css("background","#d9cb29");}
	if(id_stat==2){sel_stat.css("background","#aeaeae");}
}

stat=2; //offline d default
$(".social_chat_stato").click(function(){
	stato=$(this).attr("id").split("_");
	stat=stato[1];
	colore_stato($("#user_status"), stat);
	
	$.ajax({
		type: "POST",
		url: "<?php echo JURI::current(); ?>?option=com_socialchatcore",
		data: {stato: stat}
	});
});

function aggiungi_chat(user){
	$("#social_chat_container").append(""
		+"<div class='social_chat_box' id='box_"+user[1]+"' style='width:<?php echo $WCSS; ?>px; height:<?php echo $H1CSS; ?>px;'>"
			+"<div class='social_chat_story' id='story_"+user[1]+"' style='width:<?php echo $WCSS; ?>px; height:<?php echo $HCSS; ?>px; margin-top:-<?php echo $HCSS+($H1CSS)-6; ?>px;'>"
				+"<div class='social_chat_mex' id='mex_"+user[1]+"' alt='0' style='height:<?php echo $HCSS-60; ?>px;'></div>"
				+"<div class='social_chat_form' id='form_"+user[1]+"'>"
					+"<textarea id='socialchattxt_"+user[1]+"'></textarea>"
					+"<button class='socialchatsend' id='socialchatsend_"+user[1]+"'><?php echo $invia_txt; ?></button>"
				+"</div>"
			+"</div>"
			+"<span class='close_box' id='closebox_"+user[1]+"'>x</span> "
			+"<span class='status_box cerchio'></span> "
			+user[2]
		+"</div>"); n_box++;
	paginator();
}

//aggiunge utenti con cui chattare
$(document).delegate(".start_chat","click",function(){
	user=$(this).attr("id").split("_");
	if($("#box_"+user[1]).length==0){
		aggiungi_chat(user);
	}
});
$(document).delegate(".close_box","click",function(event){
	event.stopPropagation();
	box=$(this).attr("id").split("_"); box=box[1];
	$("#box_"+box).remove();
	n_box--;
	
	//segnalalo come letto
	$.ajax({
		type: "POST",
		url: "<?php echo JURI::current(); ?>?option=com_socialchatcore",
		data: {letto: parseInt(box)}
	});
	
	paginator();
});

$(document).delegate(".social_chat_story","click",function(event){event.stopPropagation();});

//mostra la finestra di chat
precedente_box=-1;
$(document).delegate(".social_chat_box","click",function(){
	id=$(this).attr("id").split("_"); id=id[1];
	$('.social_chat_story').css("display","none");
	if(id!=precedente_box){
		$("#story_"+id).css("display","block");
		precedente_box=id;
	}else{precedente_box=-1;}
	
	//rimuovo la notifica
	$(".social_chat_notify#notify_"+id).remove();
	
	$.ajax({
		type: "POST",
		url: "<?php echo JURI::current(); ?>?option=com_socialchatcore",
		data: {letto: id}
	});
});

$(document).delegate(".social_chat_form","click",function(){
	id=$(this).attr("id").split("_"); id=id[1];
	//rimuovo la notifica
	$(".social_chat_notify#notify_"+id).remove();
});

$(document).delegate(".socialchatsend","click",function(){
	user_selec=$(this).attr("id").split("_");
	user_selec=user_selec[1];
	text_selec=$("#socialchattxt_"+user_selec).val();
	$("#socialchattxt_"+user_selec).val("");
	
	$(".social_chat_mex#mex_"+user_selec).append("<div class='personal_post'>"+text_selec+"</div><div class='social_chat_separatore'></div>");
	$(".social_chat_mex#mex_"+user_selec).scrollTop(9999999);
	
	$.ajax({
		type: "POST",
		url: "<?php echo JURI::current(); ?>?option=com_socialchatcore",
		data: { mex: text_selec, user: user_selec}
	});
});

function init_userlist(elenco_utenti){
	if(elenco_utenti!=-1){
		$("#social_chat_panel").html("");
		colore_stato($(".social_chat_box .status_box"), 2);
		
		if(stat==2){$("#social_chat_panel").append("<div id='youoffline'><?php echo $sei_offline; ?></div>");}
		for(i=0;i<elenco_utenti.length;i++){
			$("#social_chat_panel").append("<span class='start_chat' id='user_"+elenco_utenti[i].userid+"_"+elenco_utenti[i].username+"'><div class='cerchio'></div> "+elenco_utenti[i].username+"</span><br />");
			colore_stato($("#user_"+elenco_utenti[i].userid+"_"+elenco_utenti[i].username+" div"),elenco_utenti[i].stato);
			colore_stato($(".social_chat_box#box_"+elenco_utenti[i].userid+" .status_box"), elenco_utenti[i].stato);
		}
		
		$("#social_chat_start").html("<span id='user_status' class='cerchio'></span> <?php echo $chat_txt; ?> ("+elenco_utenti.length+")");
		colore_stato($("#user_status"), stat);
	}else{
		$("#social_chat_start").html("<?php echo $loggati_txt; ?>");
	}
}

function mostra_storico_utenti(){
	$.ajax({
		type: "POST",
		url: "<?php echo JURI::current(); ?>?option=com_socialchatcore",
		data: { storico_utenti: 1},
		success: function(e){
			$("#storico_cont").html(e);
		}
	});
}

$("#storico_but").click(function(){
	$("body").append("<div id='storico_panel'>"
	+"<span id='storico_back' style='display:none;'><<<</span>"
	+"<span id='chiudi_storico'>x</span>"
	+"<div id='storico_cont'>Loading...</div></div>");
	
	mostra_storico_utenti();
});

$(document).delegate(".filtrastorico", "click", function(){
	$("#storico_back").css("display","");
	id_storico=$(this).attr("id").split("_");
	
	$.ajax({
		type: "POST",
		url: "<?php echo JURI::current(); ?>?option=com_socialchatcore",
		data: { storico_utente: id_storico[1], da:'<?php echo $da_txt; ?>', a:'<?php echo $a_txt; ?>'},
		success: function(e){
			$("#storico_cont").html(e);
		}
	});
});

$(document).delegate("#storico_back","click",function(){
	$(this).css("display","none");
	mostra_storico_utenti();
});

$(document).delegate("#chiudi_storico","click",function(){
	$("#storico_panel").remove();
});

function aggiorna_chat(){
	$.ajax({
		type: "POST",
		url: "<?php echo JURI::current(); ?>?option=com_socialchatcore",
		data: {aggiorna:1},
		success: function(e){
			richiama_init=1;
			try{
				//{user, send, txt}";
				if(e==""){e="[[],[-1]]";}
				eval("aggiornamento="+e+";");
				nuovi_mex=aggiornamento[0];
				init_userlist(aggiornamento[1]);
				richiama_init=0;
				
				stat=aggiornamento[2][0].stato;
				colore_stato($("#user_status"), stat);
				for(i=0;i<nuovi_mex.length;i++){
					if($(".social_chat_mex#mex_"+nuovi_mex[i].user).length==0){
						aggiungi_chat(['',nuovi_mex[i].user,nuovi_mex[i].username]);
					}
					if($(".social_chat_mex#mex_"+nuovi_mex[i].user).attr("alt")<nuovi_mex[i].data){
						$(".social_chat_mex#mex_"+nuovi_mex[i].user).append(nuovi_mex[i].txt+"<div class='social_chat_separatore'></div>");
						$(".social_chat_mex#mex_"+nuovi_mex[i].user).attr("alt",nuovi_mex[i].data);
						
						//notifiche
						$(".social_chat_notify#notify_"+nuovi_mex[i].user).remove();
						$(".social_chat_box#box_"+nuovi_mex[i].user).append("<div id='notify_"+nuovi_mex[i].user+"' class='social_chat_notify'>1</div>");
					}
					$(".social_chat_mex#mex_"+nuovi_mex[i].user).scrollTop(9999999);
				}
			}catch(err){
				if(richiama_init==1){
					init_userlist([]);
				}
			}
		}
	});
}

var ciclo_chat=setInterval(function(){
	aggiorna_chat();
},1000*5);

//inizializza l'elenco utenti
aggiorna_chat();

$(window).resize(function(){
	paginator();
});

});
} ) ( jQuery );
</script>

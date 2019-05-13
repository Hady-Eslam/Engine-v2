<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){

	$_SESSION['Page Name'] = 'Inbox Messages';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Inbox Messages');

	$Hashing = new HashingEngine();
	$Result = (new ModelExcutionEngine())->FetchAllRows(
			'SELECT * FROM messages WHERE message_email = ? AND deleted = ? ORDER BY id DESC',
			array(
				(new HashingEngine())->Hash_Messages($_SESSION['Email']),
				'0'
			));
	
	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Inbox Messages');

	else if ( $Result->Result == 0 )
		$GLOBALS['Messages'] = [];
	else
		$GLOBALS['Messages'] = $Result->Data;

	return (new SiteRenderEngine())->Messages_Render('Sent Messages');
}
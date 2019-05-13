<?php

use CoreModels\ModelExcutionEngine;
use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'Notifications';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Notifications');

	$MySql = new ModelExcutionEngine();
	$Hashing = new HashingEngine();

	$Result = $MySql->FetchAllRows(
		'SELECT * FROM notifications WHERE to_user = ? ORDER BY id DESC',
		array(
			$Hashing->Hash_Notifications($_SESSION['Email'])
		));

	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Notifications');
	
	else if ( $Result->Result == 0 )
		$GLOBALS['Result'] = [];
	
	else
		$GLOBALS['Result'] = $Result->Data;

	return (new SiteRenderEngine())->Notifications_Render();
}
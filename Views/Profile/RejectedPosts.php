<?php

use CoreModels\ModelExcutionEngine;

use SiteEngines\HashingEngine;
use SiteEngines\SiteRenderEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){

	$_SESSION['Page Name'] = 'Rejected Posts';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Rejected Posts');

	$Result = (new ModelExcutionEngine())->FetchAllRows('SELECT * FROM posts WHERE user_email = ? AND deleted = ? AND status = ? ORDER BY id DESC',
		array( (new HashingEngine())->Hash_POSTS($_SESSION['Email']), '0', '-1'));

	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page("My Profile");

	else if ( $Result->Result == 0 )
		$GLOBALS['Result'] = [];
	
	else
		$GLOBALS['Result'] = $Result->Data;

	return (new SiteRenderEngine())->MyProfile_Render();
}
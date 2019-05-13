<?php

use CoreModels\ModelExcutionEngine;
use SiteEngines\SiteRenderEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'Pedding Posts';

	if ( !SESSION() || $_SESSION['Status'] != '0' )
		return (new SiteRenderEngine())->Not_Authurithed_User('Pedding Posts');

	$Result = (new ModelExcutionEngine())->FetchAllRows(
		'SELECT * FROM posts WHERE status = ? AND deleted = ? LIMIT 0, 20',
		array(
			'0',
			'0'
		));
	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Pedding Posts');

	else if ( $Result->Result == 0 )
		$GLOBALS['Result'] = [];
	else
		$GLOBALS['Result'] = $Result->Data;

	return (new SiteRenderEngine())->PeddingPosts_Render();
}
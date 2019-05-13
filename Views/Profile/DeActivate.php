<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'DeActivate';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('DeActivate Settings');

	else if ( $Request->isPOST() && $Request->CHECK_REFERER(Settings.'/DeActivate') )
		return Settings_POST_DeActivate($Request);

	return Settings_GET_DeActivate($Request);
}

function Settings_GET_DeActivate($Request){
	$GLOBALS['Result'] = '';
	$GLOBALS['Section'] = 'DeActivate';

	return (new SiteRenderEngine())->Settings_Render('Address');
}

function Settings_POST_DeActivate($Request){

	if ( $Request->IN_POST('DeactivateSubmit') ){
		$MySql = new ModelExcutionEngine();
		$Hashing = new HashingEngine();
		if ( ($Result = $MySql->excute('UPDATE users SET activate = ? WHERE email = ?',
						array(
							'0',
							$Hashing->Hash_Users( $_SESSION['Email'] )
						)))->Result == -1 )
			return (new SiteRenderEngine())->Error_Page('DeActivate Settings');
		Redirect(LogOut);
	}
	else if ( $Request->IN_POST('DeleteSubmit') ){
		$MySql = new ModelExcutionEngine();
		$Hashing = new HashingEngine();
		if ( ($Result = $MySql->excute('UPDATE users SET deleted = ? WHERE email = ?',
						array(
							'1',
							$Hashing->Hash_Users( $_SESSION['Email'] )
						)))->Result == -1 )
			return (new SiteRenderEngine())->Error_Page('DeActivate Settings');
		Redirect(LogOut);
	}

	return Settings_GET_DeActivate($Request);
}
<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use Forms\ProfileForms\NameForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'Name';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Name Settings');

	else if ( $Request->isPOST() && $Request->CHECK_REFERER(Settings.'/Name') )
		return Settings_POST_Name($Request);

	return Settings_GET_Name($Request);
}

function Settings_GET_Name($Request){
	if ( $Request->IN_GET('NameDone') )
		$GLOBALS['Result'] = 'NameDone';
	else
		$GLOBALS['Result'] = '';

	$GLOBALS['Section'] = 'Name';

	return (new SiteRenderEngine())->Settings_Render('Name');
}

function Settings_POST_Name($Request){
	
	$Form = new NameForm($Request->POST);
	if ( !$Form->isValid() )
		return Settings_GET_Name($Request);

    // Save in DataBase
    $Hashing = new HashingEngine();
    if ((new ModelExcutionEngine())->
    		excute('UPDATE users SET name = ? WHERE email = ?',
			array(
				$Hashing->Hash_Users( $Form->GetName() ),
				$Hashing->Hash_Users( $_SESSION['Email'] )
			))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Name Settings');

    $_SESSION['Name'] = $Form->GetName();
    Redirect(Settings.'/Name?NameDone');
}
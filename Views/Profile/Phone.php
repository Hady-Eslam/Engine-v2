<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use Forms\ProfileForms\PhoneForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'Phone';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Phone Settings');

	else if ( $Request->isPOST() && $Request->CHECK_REFERER(Settings.'/Phone') )
		return Settings_POST_Phone($Request);

	return Settings_GET_Phone($Request);
}

function Settings_GET_Phone($Request){
	if ( $Request->IN_GET('ReservedPhone') )
		$GLOBALS['Result'] = 'ReservedPhone';

	else if ( $Request->IN_GET('PhoneDone') )
		$GLOBALS['Result'] = 'PhoneDone';
	
	else
		$GLOBALS['Result'] = '';

	$GLOBALS['Section'] = 'Phone';

	return (new SiteRenderEngine())->Settings_Render('Phone');
}

function Settings_POST_Phone($Request){

	$Form = new PhoneForm($Request->POST);
	if ( !$Form->isValid() )
		return Settings_GET_Phone($Request);

    // Check Phone
    if ( ($Result = CheckUserPhone( $Form->GetPhone() ))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Phone Settings');

    else if ( $Result->Data != 'phone Not Found')
    	Redirect(Settings.'/Phone?ReservedPhone');

    // Save in DataBase
    if ((new ModelExcutionEngine())
    		->excute('UPDATE users SET phone = ? WHERE email = ?',
			array(
				$Hashing->Hash_Users( $Form->GetPhone() ),
				$Hashing->Hash_Users( $_SESSION['Email'] )
			))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Phone Settings');

    $_SESSION['Phone'] = $Form->GetPhone();
    Redirect(Settings.'/Phone?PhoneDone');
}
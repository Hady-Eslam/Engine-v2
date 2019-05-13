<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use Forms\ProfileForms\AddressForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'Address';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Address Settings');

	else if ( $Request->isPOST() && $Request->CHECK_REFERER(Settings.'/Address') )
		return Settings_POST_Address($Request);

	return Settings_GET_Address($Request);
}

function Settings_GET_Address($Request){
	if ( $Request->IN_GET('AddressDone') )
		$GLOBALS['Result'] = 'AddressDone';
	else
		$GLOBALS['Result'] = '';

	$GLOBALS['Section'] = 'Address';

	return (new SiteRenderEngine())->Settings_Render('Address');
}

function Settings_POST_Address($Request){

	$Form = new AddressForm($Request->POST);
	if ( !$Form->isValid() )
		Settings_GET_Address($Request);

    // Save in DataBase
    $Hashing = new HashingEngine();
    if ((new ModelExcutionEngine())->
    		excute('UPDATE users SET address = ? WHERE email = ?',
			array(
				$Hashing->Hash_Users( $Form->GetAddress() ),
				$Hashing->Hash_Users( $_SESSION['Email'] )
			))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Address Settings');

    $_SESSION['Address'] = $Form->GetAddress();
    Redirect(Settings.'/Address?AddressDone');
}
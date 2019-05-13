<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\JsonEngine;

use Forms\BackEndForms\CheckUserNameForm;
use Forms\BackEndForms\CheckUserPhoneForm;
use Forms\BackEndForms\CheckUserEmailForm;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	if ( $Request->isPOST() && (
			$Request->CHECK_REFERER(SignUP) || $Request->CHECK_REFERER(Settings.'/Phone') ) && ( 
				isset($Request->POST['Name']) || isset($Request->POST['Email']) ||
				isset($Request->POST['Phone'])) )
		return CheckPage_Check($Request->POST);

	return (new SiteRenderEngine())->Not_Authurithed_User('Check User');
}

function CheckPage_Check($POST){
	include_once CheckUser;

	if ( isset($POST['Name']) ){
		$Form = new CheckUserNameForm($POST);
		if ( $Form->isValid() )
			return (new JsonEngine)->MakeJson(CheckUserName( $Form->FILTERED_DATA['Name'] ));
	}

	else if ( isset($POST['Phone']) ){
		$Form = new CheckUserPhoneForm($POST);
		if ( $Form->isValid() )
			return (new JsonEngine)->MakeJson(CheckUserPhone( $Form->FILTERED_DATA['Phone'] ));
	}

	else{
		$Form = new CheckUserEmailForm($POST);
		if ( $Form->isValid() )
			return (new JsonEngine)->MakeJson(CheckUserEmail( $Form->FILTERED_DATA['Email'] ));
	}
	return (new SiteRenderEngine())->Not_Authurithed_User('Check User');
}
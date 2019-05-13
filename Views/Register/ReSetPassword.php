<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use Forms\RegisterForms\ReSetPassword_GetForm;
use Forms\RegisterForms\ReSetPassword_PostForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;
include_once CheckToken;

function Begin($Request){
	if ( $Request->isPOST() && $Request->IN_POST('Email', 'Token', 'Password') &&
		$Request->CHECK_REFERER(ReSetPassword) )
		return ReSetPassword_POST($Request);
	
	else if ( $Request->isGET() && $Request->IN_GET('E', 'T') )
		return ReSetPassword_GET($Request);

	return (new SiteRenderEngine())->Not_Authurithed_User('ReSet Password');
}

function ReSetPassword_GET($Request){

	$Data = (new HashingEngine())->Get_Data_From_Hash([
		['Type' => 'Login_Token', 'Data' => $Request->GET['E'], 'Key' => 'Email' ],
		['Type' => 'Login_Token', 'Data' => $Request->GET['T'], 'Key' => 'Token' ],
	]);

	if ( $Data->Result != 1 )
		return (new SiteRenderEngine())->Error_Page('ReSet Password');

	$Form = new ReSetPassword_GetForm($Data->Data);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->Not_Authurithed_User('ReSet Password');

	$Result = Check_Login_Token( $Form->GetEmail(), $Form->GetToken() );
	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('ReSet Password');

	else if ( $Result->Result == 'Found' )
		return (new SiteRenderEngine())->ReSetPassword_Render('', $Form->GetEmail(),
					$Form->GetToken());

	return (new SiteRenderEngine())->Not_Authurithed_User('ReSet Password');
}

function ReSetPassword_POST($Request){
	
	$Form = new ReSetPassword_PostForm($Request->POST);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->Not_Authurithed_User('ReSet Password');

	$Result = Check_Login_Token( $Form->GetEmail(), $Form->GetToken() );
	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('ReSet Password');

	else if ( $Result->Result != 'Found' )
		return (new SiteRenderEngine())->Not_Authurithed_User('ReSet Password');

	$Token_ID = $Result->Data['token_id'];
	
	include_once ChangePassword;
	$Result = ChangePassword( $Form->GetEmail(), $Form->GetPassword() );
	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('ReSet Password');

	// Delete Token From DataBase
	$Result = (new ModelExcutionEngine())->excute(
				'DELETE FROM log_in_token WHERE token_id = ?', array( $Token_ID ));

	return (new SiteRenderEngine())->ReSetPassword_Render('Done');
}
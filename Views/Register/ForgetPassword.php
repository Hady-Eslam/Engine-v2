<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;
use SiteEngines\MailEngine;

use CoreModels\ModelExcutionEngine;
use Forms\RegisterForms\ForgetPasswordForm;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
    if ( $Request->isPOST() && $Request->IN_POST('Email') &&
    	$Request->CHECK_REFERER(ForgetPassword) )
		return ForgetPassword_POST($Request->POST);
	
	return (new SiteRenderEngine())->ForgetPassword_Render();
}

function ForgetPassword_POST($POST){

	$Form = new ForgetPasswordForm($POST);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->ForgetPassword_Render();

    $MySql = new ModelExcutionEngine();
    $Hashing = new HashingEngine();

    // Check Email in DataBase
    include_once CheckUser;
    if ( ($Result = CheckUserEmail( $Form->GetEmail() ))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Forget Password');

    else if ( $Result->Data == 'Found email in Waiting_Users')
        Redirect(SuccessSignUP);
    
    else if ( $Result->Data != 'Found email in Users' )
    	return (new SiteRenderEngine())->ForgetPassword_Render('Email Not Found', $Form);

    // Make Log in Token
    $RowCount = $MySql->GetRowCount('SELECT COUNT(*) FROM log_in_token');
    if ( $RowCount->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Forget Password');

    // Save Token into DataBase
    if ( ($Result = $MySql->excute("INSERT INTO log_in_token (token_email, token,"
            ." token_date) VALUES (?, ?, ?)",
        array(
            $Hashing->Hash_Login_Token($Form->GetEmail()),
            $Hashing->Hash_Login_Token($RowCount->Data),
            date('D d-m-Y H:i:s')
        )))->Result == -1 )
        return (new SiteRenderEngine())->Error_Page('Forget Password');

    // Send Forget Password Email
    if ( ($Result = (new MailEngine())->
            SendForgetPasswordMail( $Form->GetEmail(), $RowCount->Data )) ->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Forget Password');

    else if ( $Result->Result == 0 )
    	return (new SiteRenderEngine())->Error_Page('Forget Password');

    return (new SiteRenderEngine())->ForgetPassword_Render('Done', $Form);
}
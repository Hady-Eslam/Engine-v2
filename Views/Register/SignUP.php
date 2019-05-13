<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;
use SiteEngines\MailEngine;

use Forms\RegisterForms\SignUPForm;
use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function SignUP_Begin($Request){
	$_SESSION['Page Name'] = 'Sign UP';
	if ( SESSION() )
		return (new SiteRenderEngine())->Log_Out_Page('Sign UP');

	else if ( $Request->isPOST() && $Request->IN_POST('Name', 'Email', 'Phone', 'Password') &&
			$Request->CHECK_REFERER(SignUP) )
		return SignUP_POST($Request->POST);

	return (new SiteRenderEngine())->SignUP_Render();
}

function SignUP_POST($POST){
	$Form = new SignUPForm($POST);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->SignUP_Render();

	return SignUP_CheckUser($Form);
}

function SignUP_CheckUser($Form){
	include_once CheckUser;

    // Check Email
    $Result = CheckUserEmail( $Form->FILTERED_DATA['Email'] );
    if ( $Result->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Sign UP');

    else if ( $Result->Data != 'email Not Found' )
    	return (new SiteRenderEngine())->SignUP_Render('Email Found', $Form);


    // Check Name
    /*if ( ($Result = CheckUserName($GLOBALS['N']))->Result == -1 )
        StatusPages_Error_Page('in Checking User Name');
    else if ( $Result->Data != 'name Not Found' )
        SignUP_GET('Name Found');*/

    // Check Phone
    $Result = CheckUserPhone( $Form->FILTERED_DATA['Phone'] );
    if ( $Result->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Sign UP');

    else if ( $Result->Data != 'phone Not Found' )
    	return (new SiteRenderEngine())->SignUP_Render('Phone Found', $Form);

    return SignUP_SaveData($Form);
}

function SignUP_SaveData($Form){
    $MySql = new ModelExcutionEngine();
    $Hashing = new HashingEngine();
    
    // insert Data
    if ( $MySql->excute("INSERT INTO waiting_users (email, name, phone, "
                ."password, sign_date) VALUES (?, ?, ?, ?, ?)", 
        array(
            $Hashing->Hash_WaitingUsers( $Form->FILTERED_DATA['Email'] ),
            $Hashing->Hash_WaitingUsers( $Form->FILTERED_DATA['Name'] ),
            $Hashing->Hash_WaitingUsers( $Form->FILTERED_DATA['Phone'] ),
            $Hashing->Hash_WaitingUsers( $Form->FILTERED_DATA['Password'] ), 
            date('D d-m-Y H:i:s')
        ) )->Result == -1 )
        return (new SiteRenderEngine())->Error_Page('Sign UP');
    
    // Get Token
    $RowCount = $MySql->GetRowCount('SELECT COUNT(*) FROM sign_up_token');
    if ( $RowCount->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Sign UP');
    
    // insert Token
    if ( $MySql->excute("INSERT INTO sign_up_token (token_email, token,"
            ." token_date) VALUES (?, ?, ?)",
        array(
            $Hashing->Hash_SignUP_Token( $Form->FILTERED_DATA['Email'] ),
            $Hashing->Hash_SignUP_Token($RowCount->Data),
            date('D d-m-Y H:i:s')
        ))->Result == -1 )
        return (new SiteRenderEngine())->Error_Page('Sign UP');
    
    // Send Email
    if ( ($Result = (new MailEngine())
            ->SendMailToConfirm( $Form->FILTERED_DATA['Email'], $RowCount->Data ))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Sign UP');

    else if ( $Result->Result == 0 )
        return (new SiteRenderEngine())->Error_Page('Sign UP');

    Redirect(SuccessSignUP);
}
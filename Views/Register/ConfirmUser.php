<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use CoreModels\ModelExcutionEngine;
use Forms\RegisterForms\ConfirmUserForm;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function ConfirmUser_Begin($Request){
	$_SESSION['Page Name'] = 'Confirm User';
	if ( SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Confirm User');

	else if ( $Request->isGET() && $Request->IN_GET('E', 'T') )
		return ConfirmUser_CheckData($Request);
	
	return (new SiteRenderEngine())->Not_Authurithed_User('Confirm User');
}

function ConfirmUser_CheckData($Request){
	include_once CheckToken;
	$Data = (new HashingEngine())->Get_Data_From_Hash([
		['Type' => 'SignUP_Token', 'Data' => $Request->GET['E'], 'Key' => 'E' ],
		['Type' => 'SignUP_Token', 'Data' => $Request->GET['T'], 'Key' => 'T' ],
	]);

	if ( $Data->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Confirm User');

	$Form = new ConfirmUserForm($Data->Data);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Confirm User');

	$Result = Check_SignUP_Token( $Form->GetEmail(), $Form->GetToken() );
	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Confirm User');
	
	else if ( $Result->Data != 'Found' )
		return (new SiteRenderEngine())->Not_Authurithed_User('Confirm User');
	
	return ConfirmUser_SaveData($Form);
}

function ConfirmUser_SaveData($Form){
	$MySql = new ModelExcutionEngine();
    $Hashing = new HashingEngine();
	
	// Fetch Data
	$Result = $MySql->FetchOneRow('SELECT * FROM waiting_users WHERE email = ?',
				array( $Hashing->Hash_WaitingUsers( $Form->GetEmail() ) ));

    if ( $Result->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Confirm User');
    else if ( $Result->Result == 0 )
    	return (new SiteRenderEngine())->Not_Authurithed_User('Confirm User');

    $Data = $Hashing->Get_Data_From_Hash([
		['Type' => 'Waiting_User', 'Data' => $Result->Data['email'], 'Key' => 'Email' ],
		['Type' => 'Waiting_User', 'Data' => $Result->Data['name'], 'Key' => 'Name' ],
		['Type' => 'Waiting_User', 'Data' => $Result->Data['phone'], 'Key' => 'Phone' ],
		['Type' => 'Waiting_User', 'Data' => $Result->Data['password'], 'Key' => 'Password' ],
	]);

	if ( $Data->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Confirm User');

	// insert into Users Table
	if ( ($Result = $MySql->excute('INSERT INTO users(picture, name, email, password, '
			.'phone, sign_in_date) VALUES (?, ?, ?, ?, ?, ?)',
				array(
					$Hashing->Hash_Users(OnLineUser),
					$Hashing->Hash_Users($Data->Data['Name']),
					$Hashing->Hash_Users($Data->Data['Email']),
					$Hashing->Hash_Users($Data->Data['Password']),
					$Hashing->Hash_Users($Data->Data['Phone']),
					date('D d-m-Y H:i:s')
				)))->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Confirm User');

	// Delete Data From waiting User
	if ( $MySql->excute('DELETE FROM waiting_users WHERE email = ?',
				array( $Hashing->Hash_WaitingUsers($Data->Data['Email']) ))->Result == -1 )
		return (new SiteRenderEngine())->ConfirmUser_Render();

	// Delete Token From DataBase
	$MySql->excute('DELETE FROM sign_up_token WHERE token_email = ?',
				array( $Hashing->Hash_SignUP_Token($Data->Data['Email']) ));
	return (new SiteRenderEngine())->ConfirmUser_Render();
}
<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use Forms\ProfileForms\PasswordForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'Password';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Password Settings');

	else if ( $Request->isPOST() && $Request->CHECK_REFERER(Settings.'/Password') )
		return Settings_POST_Password($Request);

	return Settings_GET_Password($Request);
}

function Settings_GET_Password($Request){
	if ( $Request->IN_GET('WrongPassword') )
		$GLOBALS['Result'] = 'WrongPassword';

	else if ( $Request->IN_GET('PasswordDone') )
		$GLOBALS['Result'] = 'PasswordDone';

	else
		$GLOBALS['Result'] = '';

	$GLOBALS['Section'] = 'Password';

	return (new SiteRenderEngine())->Settings_Render('Password');
}

function Settings_POST_Password($Request){

	$Form = new PasswordForm($Request->POST);
	if ( !$Form->isValid() )
		return Settings_GET_Password($Request);

    // Check Old Password
    $MySql = new ModelExcutionEngine();
    $Hashing = new HashingEngine();
    if ( ($Result = $MySql->isFound('SELECT password FROM users WHERE password = ?'
    		.' AND email = ?',
					array(
						$Hashing->Hash_Users( $Form->GetOldPassword() ),
						$Hashing->Hash_Users( $_SESSION['Email'] )
					)))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Password Settings');

    else if ( $Result->Result == 0 )
    	Redirect(Settings.'/Password?WrongPassword');

    // Save in DataBase
    if ( ($Result = $MySql->excute('UPDATE users SET password = ? WHERE email = ?',
			array(
				$Hashing->Hash_Users( $Form->GetPassword() ),
				$Hashing->Hash_Users( $_SESSION['Email'] )
			)))->Result == -1 )
    	return (new SiteRenderEngine())->Error_Page('Password Settings');
    Redirect(Settings.'/Password?PasswordDone');
}
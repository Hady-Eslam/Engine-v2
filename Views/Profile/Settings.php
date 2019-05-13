<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use Forms\ProfileForms\SettingsForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'Settings';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Profile Picture');

	else if ( $Request->isPOST() && $Request->CHECK_REFERER(Settings) )
		return Settings_POST_Picture($Request);

	return Settings_GET_Picture($Request);
}

function Settings_GET_Picture($Request){
	if ( $Request->IN_GET('PictureDone') )
		$GLOBALS['Result'] = 'PictureDone';
	else
		$GLOBALS['Result'] = '';

	$GLOBALS['Section'] = 'Settings';

	return (new SiteRenderEngine())->Settings_Render('Profile Picture');
}

function Settings_POST_Picture($Request){

	$Form = new SettingsForm($Request->FILES);
	if ( !$Form->isValid() )
		return Settings_GET($Request);

    // Process Image
    if ( $Form->GetFile1()['error'] != -1 ){

    	$Ext = pathinfo( $Form->GetFile1()['name'], PATHINFO_EXTENSION );
    	$NewName = UserPictures.'User'.$_SESSION['ID'].'/ProfilePicture.'.$Ext;
		if ( file_exists( $NewName ) == True )
			unlink( $NewName );
		$Result = rename( $Form->GetFile1()['tmp_name'], $NewName);
		
		if ( $Result == True ){
			$Pic = UserPictures_HTTP.'User'.$_SESSION['ID'].'/ProfilePicture.'.$Ext;
			
		    // Save in DataBase
			$Hashing = new HashingEngine();
		    if ((new ModelExcutionEngine())
		    		->excute('UPDATE users SET picture = ? WHERE'
		    		.' email = ?',
						array(
							$Hashing->Hash_Users( $Pic ),
							$Hashing->Hash_Users( $_SESSION['Email'] )
						))->Result == -1 )
		    	return (new SiteRenderEngine())->Error_Page('Settings');
		    $_SESSION['Picture'] = $Pic;
		}
    }
    Redirect(Settings.'?PictureDone');
}
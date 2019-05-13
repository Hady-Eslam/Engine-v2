<?php

use CoreModels\ModelExcutionEngine;

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request, $User_ID){
	$MySql = new ModelExcutionEngine();
	$Hashing = new HashingEngine();
	$GLOBALS['Page Name'] = 'Deleting Account '.$User_ID;

	$Result = $MySql->FetchOneRow('SELECT * FROM users WHERE id = ? AND deleted = ?',
		array(
			$User_ID,
			'0'
		));
	
	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page("Deleting User Account $User_ID");

	else if ( $Result->Result == 0 )
		$GLOBALS['Result'] = 'User Not Found';
	
	else{
		//var_dump($Result->Data['email']);
		$Email = $Hashing->Get_Hashed_Users($Result->Data['email']);
		if ( $Email->Result != 1 )
			return (new SiteRenderEngine())->Error_Page("Deleting User Account $User_ID");
		//var_dump($Email);
		$Result = $MySql->excute('UPDATE posts SET deleted = ? WHERE user_email = ?',
				array(
					'1',
					$Hashing->Hash_POSTS($Email->Data)
				));
		
		if ( $Result->Result == -1 )
			return (new SiteRenderEngine())->Error_Page("Deleting User Account $User_ID");

		$Result = $MySql->excute('UPDATE users SET deleted = ? WHERE email = ?',
				array(
					'1',
					$Hashing->Hash_Users($Email->Data)
				));
		
		if ( $Result->Result == -1 )
			return (new SiteRenderEngine())->Error_Page("Deleting User Account $User_ID");

		$GLOBALS['Result'] = 'Account Deleted';
	}

	return (new SiteRenderEngine())->DeleteUserAccount_Render();
}
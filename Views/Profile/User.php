<?php

use CoreModels\ModelExcutionEngine;

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request, $User_ID){

	$_SESSION['Page Name'] = "User $User_ID";
	$User_Data = (new ModelExcutionEngine())->FetchOneRow(
			'SELECT * FROM users WHERE id = ? AND deleted = ? AND activate = ?',
		array(
			$User_ID,
			'0',
			'1'
		));
	if ( $User_Data->Result == -1 )
		return (new SiteRenderEngine())->User_Render();

	else if ( $User_Data->Result == 0 )
		return (new SiteRenderEngine())->Not_Found_Page();

	$Hashing = new HashingEngine();
	$MySql = new ModelExcutionEngine();

	$Data = $Hashing->Get_Data_From_Hash([
		['Type' => 'User', 'Data' => $User_Data->Data['picture'], 'Key' => 'User_Picture',
			'Default' => OnLineUser ],
		['Type' => 'User', 'Data' => $User_Data->Data['name'], 'Key' => 'Base_User_Name' ],
		['Type' => 'User', 'Data' => $User_Data->Data['email'], 'Key' => 'Base_User_Email' ]
	]);

	if ( $Data->Result != 1 )
		return (new SiteRenderEngine())->Error_Page("User $User_ID");

	$Result = $MySql->FetchAllRows(
			'SELECT * FROM posts WHERE user_email = ? AND deleted = ? AND status = ? ORDER BY id DESC',
			array( $Hashing->Hash_POSTS($Data->Data['Base_User_Email']), '0' , '1'));

	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page("User ".$Data->Data['Base_User_Name']);

	else if ( $Result->Result == 0 ){
		$Posts = [];
		$Posts_Number = 0;
	}
	else{
		$Posts = $Result->Data;
		$Posts_Number = $MySql->GetAffectedRowsNumber();
	}

	return (new SiteRenderEngine())->User_Render( $Data->Data, $User_ID, $Posts_Number, $Posts );
}

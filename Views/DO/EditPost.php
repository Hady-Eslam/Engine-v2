<?php

use CoreModels\ModelExcutionEngine;

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use Forms\DOForms\EditPostForm;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;
include_once Files;

function Begin($Request, $Post_id){
	$_SESSION['Page Name'] = "Edit Post $Post_id";
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Edit Post');

	else if ( $Request->isPOST() && preg_match(
		'/^http:\/\/lookandsee\.com\/DO\/EditPost\/(\d+)$/', $Request->GET_REFERER() ) )
		return EditPost_POST($Request, $Post_id);
	
	return EditPost_GET($Post_id);
}

function EditPost_GET($Post_id){
	$Result = (new ModelExcutionEngine())->FetchOneRow(
		'SELECT * FROM posts WHERE id = ? AND user_email = ? AND deleted = ?',
		array(
			$Post_id,
			(new HashingEngine())->Hash_POSTS( $_SESSION['Email'] ),
			'0'
		));

	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page("Edit Post $Post_id");

	else if ( $Result->Result == 0 )
		return (new SiteRenderEngine())->Not_Found_Page();
	
	return EditPost_Get_Data_From_Hashing($Result->Data);
}

function EditPost_Get_Data_From_Hashing($Data){
	$Data = (new HashingEngine())->Get_Data_From_Hash([

		['Type' => 'POSTS', 'Data' => $Data['addname'], 'Key' => 'Add_Name' ],
		['Type' => 'POSTS', 'Data' => $Data['bigtype'], 'Key' => 'BigType' ],
		['Type' => 'POSTS', 'Data' => $Data['smalltype'], 'Key' => 'SmallType' ],
		['Type' => '', 'Data' => $Data['money'], 'Key' => 'Money' ],
		['Type' => '', 'Data' => $Data['rooms'], 'Key' => 'Rooms' ],
		['Type' => '', 'Data' => $Data['pathrooms'], 'Key' => 'PathRooms' ],
		['Type' => '', 'Data' => $Data['area'], 'Key' => 'Area' ],
		['Type' => 'POSTS', 'Data' => $Data['furnished'], 'Key' => 'Furnished' ],
		['Type' => 'POSTS', 'Data' => $Data['discreption'], 'Key' => 'Discreption' ],

		['Type' => 'POSTS', 'Data' => $Data['f_pic'], 'Key' => 'Picture1',
			'Default' => Housing ],
		['Type' => 'POSTS', 'Data' => $Data['s_pic'], 'Key' => 'Picture2',
			'Default' => Housing ],
		['Type' => 'POSTS', 'Data' => $Data['t_pic'], 'Key' => 'Picture3',
			'Default' => Housing ],
		['Type' => 'POSTS', 'Data' => $Data['fo_pic'], 'Key' => 'Picture4',
			'Default' => Housing ],

		['Type' => 'POSTS', 'Data' => $Data['address'], 'Key' => 'Address' ],
		['Type' => 'POSTS', 'Data' => $Data['user_name'], 'Key' => 'User_Name' ],
		['Type' => 'POSTS', 'Data' => $Data['phone'], 'Key' => 'Phone' ],
		['Type' => '', 'Data' => $Data['contact_status'], 'Key' => 'ContactMe']
	]);

	if ( $Data->Result != 1 )
		return (new SiteRenderEngine())->Error_Page("Edit Post $Post_id");

	return (new SiteRenderEngine())->EditPost_Render($Data->Data);
}

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

function EditPost_POST($Request, $Post_id){

	$Form = new EditPostForm($Request->POST);
	$Form->isValid();

	if ( !$Form->isValid() )
		return EditPost_GET($Post_id);

	$Hashing = new HashingEngine();
	$MySql = new ModelExcutionEngine();

	if ( ($Result = $MySql->excute('UPDATE posts SET address = ?, addname = ?, bigtype = ?, furnished = ?, area = ?, rooms = ?, pathrooms = ?, discreption = ?, smalltype = ?, user_name = ?, money = ?, phone = ?, status = ?, contact_status = ? WHERE id = ?',
		array(
			$Hashing->Hash_POSTS( $Form->GetCity() ),
			$Hashing->Hash_POSTS( $Form->GetAddName() ),
			$Hashing->Hash_POSTS( $Form->GetBigType() ),
			$Hashing->Hash_POSTS( $Form->GetFurnished() ),
			$Form->GetArea(),
			$Form->GetRooms(),
			$Form->GetPathRooms(),
			$Hashing->Hash_POSTS( $Form->GetDiscreption() ),
			$Hashing->Hash_POSTS( $Form->GetSmallType() ),
			$Hashing->Hash_POSTS( $Form->GetUserName() ),
			$Form->GetMoney(),
			$Hashing->Hash_POSTS( $Form->GetPhone() ),
			( $_SESSION['Status'] != '0' ) ? '0' : '1',
			$Form->GetContactMe(),
			$Post_id
		)))->Result == -1 )
		return (new SiteRenderEngine())->Error_Page("Edit Post ".$Form->GetAddName());

	Redirect(Post.$Post_id);
}
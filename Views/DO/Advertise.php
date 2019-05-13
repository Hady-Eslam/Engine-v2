<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

use Forms\DOForms\AdvertiseForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;
include_once Files;

function Begin($Request){
	$_SESSION['Page Name'] = 'Advertise';
	if ( !SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Advertise');

	else if ( $Request->isPOST() && $Request->CHECK_REFERER(Advertise) &&
		$Request->IN_POST('AddName', 'BigType', 'SmallType', 'Rooms', 'PathRooms', 'Area',
			'Furnished', 'Discreption', 'City', 'UserName', 'Money', 'Phone') && 
		$Request->IN_FILES('File1', 'File2', 'File3', 'File4') )

		return Advertise_POST($Request);

	return (new SiteRenderEngine())->Advertise_Render();
}

function Advertise_POST($Request){

	$Form = new AdvertiseForm($Request->POST, $Request->FILES);

	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->Advertise_Render();

	$MySql = new ModelExcutionEngine();
	$Result = $MySql->FetchOneRow('SELECT MAX(id) FROM posts;', array());
	if ( $Result->Result != 1 )
		return (new SiteRenderEngine())->Error_Page('Advertise');
	$ID = $Result->Data['MAX(id)'] + 1;

	MakePostFile( $_SESSION['ID'], $ID );
	$Pic1 = ReNamePicture( $Form->GetFile1(), $_SESSION['ID'], $ID, '1' );
	$Pic2 = ReNamePicture( $Form->GetFile2(), $_SESSION['ID'], $ID, '2' );
	$Pic3 = ReNamePicture( $Form->GetFile3(), $_SESSION['ID'], $ID, '3' );
	$Pic4 = ReNamePicture( $Form->GetFile4(), $_SESSION['ID'], $ID, '4' );
	
	$Hashing = new HashingEngine();

	if ( ($Result = $MySql->excute('INSERT INTO posts (deleted, user_email, address, addname,'
			.' bigtype, furnished, area, rooms, pathrooms, discreption, f_pic, s_pic, post_date'
			.', smalltype, user_name, t_pic, fo_pic, money, phone, status, contact_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			array(
				'0',
				$Hashing->Hash_POSTS( $_SESSION['Email'] ),
				$Hashing->Hash_POSTS( $Form->GetCity() ),
				$Hashing->Hash_POSTS( $Form->GetAddName() ),
				$Hashing->Hash_POSTS( $Form->GetBigType() ),
				$Hashing->Hash_POSTS( $Form->GetFurnished() ),
				$Form->GetArea(),
				$Form->GetRooms(),
				$Form->GetPathRooms(),
				$Hashing->Hash_POSTS( $Form->GetDiscreption() ),
				$Hashing->Hash_POSTS( $Pic1 ),
				$Hashing->Hash_POSTS( $Pic2 ),
				date('D d-m-Y H:i:s'),
				$Hashing->Hash_POSTS( $Form->GetSmallType() ),
				$Hashing->Hash_POSTS( $Form->GetUserName() ),
				$Hashing->Hash_POSTS( $Pic3 ),
				$Hashing->Hash_POSTS( $Pic4 ),
				$Form->GetMoney(),
				$Hashing->Hash_POSTS( $Form->GetPhone() ),
				( $_SESSION['Status'] != '0' ) ? '0' : '1',
				$Form->GetContactMe(),
			)))->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Advertise');

	$Post_id = $MySql->GetInsertedID();

	if ( $_SESSION['Status'] != '0' ){

		$MySql->excute('INSERT INTO notifications (from_user, to_user, notification_type, message, notification_date) VALUES (?, ?, ?, ?, ?)',
			array(
				$Hashing->Hash_Notifications( $_SESSION['Email'] ),
				$Hashing->Hash_Notifications('Admin'),
				'7',
				$Hashing->Hash_Notifications('I Want To Approve This Post '.$Post_id),
				date('D d-m-Y H:i:s')
			));
	}

	$_SESSION['Posts']++;
	Redirect(Post.$Post_id);
}

function ReNamePicture($File, $User_ID, $Post_ID, $ID){

	if ( $File['size'] != -1 ){
		$Ext = '.'.pathinfo( $File['name'], PATHINFO_EXTENSION );
		$NewName = UserPictures.'User'.$User_ID.'/Post'.$Post_ID.'/'.$ID.$Ext;
		$Result = rename( $File['tmp_name'], $NewName );
		if ( $Result == False )
			return Housing;
		else
			return UserPictures_HTTP.'User'.$User_ID.'/Post'.$Post_ID.'/'.$ID.$Ext;
	}
	return Housing;
}

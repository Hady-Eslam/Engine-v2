<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\JsonEngine;

use Forms\BackEndForms\CheckUserNameForm;
use Forms\BackEndForms\CheckUserPhoneForm;
use Forms\BackEndForms\CheckUserEmailForm;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	if ( $Request->isPOST() && $Request->CHECK_REFERER(Find) && $Request->IN_POST('Count') )
		return ShowMorePosts($Request->POST);

	return (new SiteRenderEngine())->Not_Authurithed_User('Get Find Posts');
}

function CheckPage_Check($POST){

	$Form = new GetFindPostsForm($POST);
	if ( !$Form->isValid() )
		return (new JsonEngine())->MakeJson(Returns(0));

	$Status = $Form->GetStatus(
		$Hashing->Hash_POSTS('Buy'),
		$Hashing->Hash_POSTS('Rent')
	);

	$Type = $Form->GetType(
		$Hashing->Hash_POSTS('Students'),
		$Hashing->Hash_POSTS('Families'),
		$Hashing->Hash_POSTS('Offices'),
		$Status
	);

	$Furnished = $Form->GetFurnished(
		$Hashing->Hash_POSTS('No'),
		$Hashing->Hash_POSTS('Yes'),
		$Type
	);

	$Views = $Form->GetViews(
		$Furnished
	);

	$GLOBALS['Form'] = $Form;
	$GLOBALS['Query'] = 'SELECT * FROM posts WHERE status = ? AND area >= ? AND area <= ? AND rooms >= ? AND rooms <= ? AND pathrooms >= ? AND pathrooms <= ? AND money >= ? AND money <= ? AND deleted = ? '
		.$Views.' LIMIT '.( $Form->GetPage() * 12 ).' , '.( ( $Form->GetPage() *12 ) + 12 );

	$Result = (new ModelExcutionEngine())->FetchAllRows(
		'SELECT * FROM posts WHERE status = ? AND area >= ? AND area <= ? AND rooms >= ? AND rooms <= ? AND pathrooms >= ? AND pathrooms <= ? AND money >= ? AND money <= ? AND deleted = ? '
		.$Views.' LIMIT '.( $Form->GetPage() * 12 ).' , '.( ( $Form->GetPage() *12 ) + 12 ),
			array(
				'1',

				$Form->GetMinArea(),
				$Form->GetMaxArea(),

				$Form->GetMinRooms(),
				$Form->GetMaxRooms(),

				$Form->GetMinPathRooms(),
				$Form->GetMaxPathRooms(),

				$Form->GetMinMoney(),
				$Form->GetMaxMoney(),
				'0'
			));


	include_once CheckUser;

	if ( isset($POST['Name']) ){
		$Form = new CheckUserNameForm($POST);
		if ( $Form->isValid() )
			return (new JsonEngine)->MakeJson(CheckUserName( $Form->FILTERED_DATA['Name'] ));
	}

	else if ( isset($POST['Phone']) ){
		$Form = new CheckUserPhoneForm($POST);
		if ( $Form->isValid() )
			return (new JsonEngine)->MakeJson(CheckUserPhone( $Form->FILTERED_DATA['Phone'] ));
	}

	else{
		$Form = new CheckUserEmailForm($POST);
		if ( $Form->isValid() )
			return (new JsonEngine)->MakeJson(CheckUserEmail( $Form->FILTERED_DATA['Email'] ));
	}
	return (new SiteRenderEngine())->Not_Authurithed_User('Check User');
}
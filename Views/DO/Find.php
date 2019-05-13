<?php

use SiteEngines\HashingEngine;
use SiteEngines\SiteRenderEngine;

use CoreModels\ModelExcutionEngine;

use Forms\DOForms\FindForm;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	$_SESSION['Page Name'] = 'Find';

	$Hashing = new HashingEngine();
	$Form = new FindForm($Request->GET);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->Error_Page('Find');

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

	$GLOBALS['Query'] = 'SELECT * FROM posts WHERE status = ? AND area >= ? AND area <= ? AND rooms >= ? AND rooms <= ? AND pathrooms >= ? AND pathrooms <= ? AND money >= ? AND money <= ? AND deleted = ? '.$Views;

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

	if ( $Result->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Find');

	else if ( $Result->Result == 1 )
		return (new SiteRenderEngine())->Find_Render($Result->Data);
	
	else
		return (new SiteRenderEngine())->Find_Render([]);
}
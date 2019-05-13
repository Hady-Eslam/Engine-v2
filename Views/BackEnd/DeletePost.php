<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\JSONEngine;
use SiteEngines\HashingEngine;

use Forms\BackEndForms\DeletePostForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){
	
	if ( !SESSION() || !$Request->isPOST() || !$Request->CHECK_REFERER(MyProfile) &&
		!$Request->CHECK_REFERER(MyProfile.'/PeddingPosts') &&
		!$Request->CHECK_REFERER(MyProfile.'/ApprovedPosts') &&
		!$Request->CHECK_REFERER(MyProfile.'/RejectedPosts')
	)
		return (new SiteRenderEngine())->Not_Authurithed_User('Delete Post');

	$MySql = new ModelExcutionEngine();

	$Form = new DeletePostForm($Request->POST);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->Not_Authurithed_User("Delete Post");

	if ( ($Result = $MySql->isFound(
			'SELECT * FROM posts WHERE id = ? AND user_email = ? AND deleted = ?',
			array(
				$Form->GetID(),
				(new HashingEngine())->Hash_POSTS($_SESSION['Email']),
				'0'
			)))->Result == -1 )
		return (new JSONEngine())->MakeJson(Returns(-1, 'Searching For Post', $Result->Error));

	else if ( $Result->Result == 0 )
		return (new JSONEngine())->MakeJson(Returns(0, 'Not Found'));

	if ( ($Result = $MySql->excute('UPDATE posts SET deleted = ? WHERE id = ?',
				array('1', $Form->GetID()) ))->Result == -1 )
		return (new JSONEngine())->MakeJson(Returns(-1, 'Deleting Post', $Result->Error));

	if ( $_SESSION['Posts'] != 0 )
		$_SESSION['Posts'] -= 1;
	return (new JSONEngine())->MakeJson(Returns(1, 'Done'));
}
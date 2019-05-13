<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\JSONEngine;
use SiteEngines\HashingEngine;

use Forms\BackEndForms\DeleteMessageForm;

use CoreModels\ModelExcutionEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin($Request){

	if ( !$Request->isPOST() || !$Request->CHECK_REFERER(Messages_Inbox) && 
		 !$Request->CHECK_REFERER(Messages_Sent) )
		return (new SiteRenderEngine())->Not_Authurithed_User('Delete Message');

	$Form = new DeleteMessageForm($Request->POST);
	if ( !$Form->isValid() )
		return (new SiteRenderEngine())->Not_Authurithed_User("Delete Message");

	$GLOBALS['Email'] = 'user_email';
	if ( $Request->CHECK_REFERER(Messages_Sent) )
		$GLOBALS['Email'] = 'message_email';

	
	$MySql = new ModelExcutionEngine();

	if ( ($Result = $MySql->isFound(
			'SELECT * FROM messages WHERE id = ? AND '.$GLOBALS['Email'].' = ?',
			array(
				$Form->GetMessageID(),
				(new HashingEngine())->Hash_Messages($_SESSION['Email']),
			)))->Result == -1 )
		return  (new JSONEngine())->MakeJson(
				Returns(-1, 'Searching For Message', $Result->Error));
	else if ( $Result->Result == 0 )
		return  (new JSONEngine())->MakeJson(Returns(0, 'Not Found'));

	if ( ($Result = $MySql->excute('UPDATE messages SET deleted = ? WHERE id = ?',
				array('1', $Form->GetMessageID() )))->Result == -1 )
		return  (new JSONEngine())->MakeJson(Returns(-1, 'Deleting Message', $Result->Error));

	return  (new JSONEngine())->MakeJson(Returns(1, 'Done'));
}
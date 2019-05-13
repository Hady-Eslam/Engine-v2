<?php

use SiteEngines\HashingEngine;
use CoreModels\ModelExcutionEngine;

function ShowMessages(){
	$String = '';
	foreach ($GLOBALS['Messages'] as $Value)
		$String .= Messages_Print_Messages($Value);
	
	if ( $String == '' )
		return '<p>No Message Found</p>';
	return $String;
}

function Messages_Print_Messages($Message){

	$GLOBALS['Error'] = False;
	Messages_Get_Data_From_Hashing($Message);
	if ( $GLOBALS['Error'] )
		return '';

	$GLOBALS['Error'] = False;
	$Result = Messages_Get_Add_Name_From_Hashing($Message['post_id']);
	if ( $Result != '1' || $GLOBALS['Error'] )
		return '';

	return '<div style="border-bottom-width: 1px;border-bottom-color: #454545;
				border-bottom-style: solid;" id="'.$GLOBALS['MESSAGE_ID'].'">
	       	
	       	<div>

	   			<input type="image" src="'.DeleteImage.'"
	   				onclick="DeleteMessage('.$GLOBALS['MESSAGE_ID'].');" 
	   				style="width: 50px;width: 35px;height: 35px;display: inline-block;">

	   			<div style="display: inline-block;width: 90%">
	   				
		   			<p style="vertical-align: top; padding-left: 2%;padding-right: 2%;text-overflow: ellipsis;overflow: hidden;font-size: 17px;white-space: nowrap;width: 100%;">
		   				<strong>To : </strong>'.$GLOBALS['User_Email'].'</p>

		   			<p style="vertical-align: top; padding-left: 2%;padding-right: 2%;text-overflow: ellipsis;overflow: hidden;font-size: 17px;white-space: nowrap;width: 100%;">
		   				<strong>Add Name : </strong>'.$GLOBALS['Add_Name'].'</p>

		   			<a href="'.Post.$Message['post_id'].'">Add Link</a>
	   			</div>
	       		
	       	</div>

   			<p style="display: inline-block;text-overflow: ellipsis;overflow: hidden;
					white-space: nowrap;width: 60%;vertical-align: top;font-size: 17px;">
						'.$GLOBALS['Message_Body'].'</p>

			<p style="font-size: 15px;">'.$GLOBALS['Message_Date'].'</p>

			<a href="'.Message.$GLOBALS['MESSAGE_ID'].'">Full Message</a>
   		</div>';
}

function Messages_Get_Data_From_Hashing($Message){
	(new HashingEngine())->Get_Data_From_Hashing([
		['Type' => '', 'Data' => $Message['id'], 'Key' => 'MESSAGE_ID' ],
		['Type' => 'Messages', 'Data' => $Message['user_email'], 'Key' => 'User_Email'],
		['Type' => 'Messages', 'Data' => $Message['message_body'], 'Key' => 'Message_Body'],
		['Type' => '', 'Data' => $Message['message_date'], 'Key' => 'Message_Date']
	], 'Status_Error');
}

function Messages_Get_Add_Name_From_Hashing($Post_id){

	$Result = (new ModelExcutionEngine())->FetchOneRow(
			'SELECT addname FROM posts WHERE id = ?', array( $Post_id ));

	if ($Result->Result == -1 )
		return '';

	else if ( $Result->Result == 0 )
		return '0';

	(new HashingEngine())->Get_Data_From_Hashing([
		['Type' => 'POSTS', 'Data' => $Result->Data['addname'], 'Key' => 'Add_Name']
	], 'Status_Error');

	return '1';
}

function Status_Error(){
	$GLOBALS['Error'] = True;
}
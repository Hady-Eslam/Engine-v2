<?php

use CoreModels\ModelExcutionEngine;
use SiteEngines\HashingEngine;

function GetNotifications(){
	$String = '';

    foreach ($GLOBALS['Result'] as $Value)
        $String .= Notifications_Get_Notification($Value);

    if ( $String == '' )
    	return '<div style="text-align: center;">
                	<p>You Have No Notifications</p>
            	</div>';
    
    return $String;
}

function Notifications_Get_Notification($Notification){

	$GLOBALS['Error'] = False;
	Notifications_Get_Data_From_Hashing($Notification);
	if ( $GLOBALS['Error'] )
		return '';

	Notifications_GetPicture();
	if ( $GLOBALS['Error'] )
		return '';

	Notifications_Get_Message();

	return '
	<div>
        <div>
            <a href="" style="display: inline-block;">
                <input type="image" src="'.$GLOBALS['User_Picture'].'"
                	style="width: 80px;height: 80px;">
            </a>

            <div style="display: inline-block;font-size: 15px;">
                <p><strong>Date : </strong>'.$GLOBALS['Date'].'</p>
                <p><strong>By : </strong>'.$GLOBALS['User_Name'].'</p>
                '.Notifications_Get_Status().'
            </div>
        </div>

        <div> <p>'.$GLOBALS['Message'].'</p> </div>

    </div>';
}

function Notifications_Get_Data_From_Hashing($Notification){
	(new HashingEngine())->Get_Data_From_Hashing([
		['Type' => 'Notifications', 'Data' => $Notification['from_user'], 'Key' => 'From_User'],
		['Type' => 'Notifications', 'Data' => $Notification['to_user'], 'Key' => 'To_User'],

		['Type' => '','Data' => $Notification['notification_type'],'Key' => 'Notification_Type'],
		['Type' => 'Notifications', 'Data' => $Notification['message'], 'Key' => 'Message'],

		['Type' => '', 'Data' => $Notification['see'], 'Key' => 'See'],
		['Type' => '', 'Data' => $Notification['notification_date'], 'Key' => 'Date']
	], 'Notifications_Set_Error');
}

function Notifications_Set_Error(){
	$GLOBALS['Error'] = True;
}

function Notifications_GetPicture(){
	if ( $GLOBALS['From_User'] == 'Admin' ){
		$GLOBALS['User_Picture'] = Admin;
		$GLOBALS['User_Name'] = 'Admin';
	}

	else{
		$Hashing = new HashingEngine();
		$Result = (new ModelExcutionEngine())->FetchOneRow(
			'SELECT * FROM users WHERE email = ? AND deleted = ? AND activate = ?',
			array(
				$Hashing->Hash_Users($GLOBALS['From_User']),
				'0',
				'1'
			));

		if ( $Result->Result == -1 )
			return -1;
		
		else if ( $Result->Result == 0 ){
			$GLOBALS['User_Picture'] = OfflineUsers;
			$GLOBALS['User_Name'] = $GLOBALS['From_User'];
		}
		
		else{
			$Hashing->Get_Data_From_Hashing([
				['Type' => 'User', 'Data' => $Result->Data['picture'], 'Key' => 'User_Picture'],
				['Type' => 'User', 'Data' => $Result->Data['name'], 'Key' => 'User_Name']
			], 'Notifications_Set_Error');
		}
	}
}

function Notifications_Get_Message(){
	if ( $GLOBALS['User_Name'] == 'Admin' ){
		if ( preg_match('/(\d+)/', $GLOBALS['Message'], $Result) ){
			Notifications_CheckPost($Result[1]);
		}
	}
}

function Notifications_CheckPost($Post_id){
	$Result = (new ModelExcutionEngine())->FetchOneRow('SELECT addname FROM posts WHERE id = ?', array( $Post_id ));
	if ( $Result->Result == 1 ){
		$Re = (new HashingEngine())->Get_Hashed_POSTS($Result->Data['addname']);
		if ( $Re->Result == 1 )
			$GLOBALS['Message'] = preg_replace('/(\d+)/',
				'<span style = "color : green;">'.$Re->Data.'</span>', $GLOBALS['Message']);
	}
}

function Notifications_Get_Status(){
	if ( $GLOBALS['From_User'] == 'Admin' )
		return '<p style="color: green;"><strong>Status : </strong>Authorized Admin</p>';
	else
		return '<p><strong>Status : </strong>User</p>';
}
<?php

function Show_Picture($ISSET){
	return ( $ISSET ) ? '<< OnLineUser >>' : '<< OffLineUser >>';
}

function include_User_Header($ISSET){
	return file_get_contents( _DIR_.'/Templates/Header/'.( ($ISSET) ? 'User.html' :
					'UserNotLogged.html' ) );
}

function Show_Notifications($ISSET){
	if ( !$ISSET )
		return '';
	return '<div>
				<input type="image" src="<< NoNotification >>" 
					width="30" height="30" onclick="ShowNotificationsMenu();">

				<< include : Header/Notifications_Header.html >>
			</div>';
}

function IsAdmin($User_Status){
	if ( $User_Status != '0' )
		return '';
	return '<div class="Profile_Item"><a href="<< PeddingPosts >>">Pedding Posts</a></div>';
}
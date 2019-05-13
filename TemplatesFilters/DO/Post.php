<?php

use CoreModels\ModelExcutionEngine;
use SiteEngines\HashingEngine;

function GetFirstPicture($Data){
	for ( $i=1; $i <5 ; $i++ )
		if ( $Data['Picture'.$i] != Housing ){
			$GLOBALS['ValidPicture'] = $i;
			return '
				<div class="Pictures">
                    	<img src="'.$Data['Picture'.$i].'"style="vertical-align: top;">
                </div>';
		}

	$GLOBALS['ValidPicture'] = 5;
	return '
		<div class="Pictures">
            	<img src="'.$Data['Picture1'].'"style="vertical-align: top;">
        </div>';
}

function GetAllPictures($Data){
	if ( $GLOBALS['ValidPicture'] == 5 )
		return '';

	$String = '';

	for ( $i = $GLOBALS['ValidPicture']+1; $i <5; $i++ ) { 
		if ( $Data['Picture'.$i] != Housing ){
			$String .= '<div class="Pictures">
                    	<img src="'.$Data['Picture'.$i].'" style="vertical-align: top;">
                </div>';
		}
	}
	return $String;
}

function CheckContactInfo($Contact_Status){
	if ( $Contact_Status != '2' ){
        return '
            <div style="background-color: green;border-color: green;border-style: solid;border-width: 1px;border-radius: 5px;height: 30px;">
                <p style="margin: 0px;"><< Phone >></p>
            </div>';
    }
    return '';
}

function GetStatusColor($Status){
	if ( $Status == 0 )
		return 'background-color: #c6c608;border-color: #c6c608;';
	else if ( $Status == -1 )
		return 'background-color: red;border-color: red;';
	else
		return 'background-color: green;border-color: green;';
}

function GetStatusText($Status){
	if ( $Status == 0 )
		return 'Still Pedding';
	else if ( $Status == -1 )
		return 'Rejected';
	else
		return 'Available';
}

function GetAdminSettings($Status){

	if ( SESSION() && $_SESSION['Status'] == '0' && $Status == '0' )
        return '<script type="text/javascript">
                    function ApprovePost(){
                        location.href = "<< AdminAcceptPost >>";
                    }

                    function RejectPost(){
                        location.href = "<< AdminRejectPost >>";
                    }
                </script>

                <div style="height: 30px;">
                    <input type="button" value="Approve" style="background-color: green;
                            width: 35%;border-color: green;"
                            onclick="ApprovePost()">
                    <input type="button" value="Reject" style="background-color: red;
                            width: 35%;border-color: red;"
                            onclick="RejectPost()">
                </div>';

    else if ( SESSION() && $_SESSION['Status'] == '0' && $Status == '1' )
        return '<script type="text/javascript">
                    function DeletePost(){
                        if ( confirm("Are You Sure Want To Delete This Post ?") == false )
                            return ;

                        location.href = "<< AdminDeletePost >>";
                    }
                </script>

                <div style="height: 30px;">
                    <input type="button" value="Delete Advertise" 
                        style="background-color: red;width: 70%;border-color: red;"
                        onclick="DeletePost()">
                </div>';

    return '';
}

function Check_Email(){
	return ( !SESSION() )? '
	<input type="text" name="MessageEmail" id="MessageEmail" placeholder="Your Email" style="display: block;margin: 10px;" oninput="CheckinputLen(this.id, Email_Len);">'
	: '';
}

function GetMessage($Contact_Status){

	if ( $Contact_Status != '1' )
        return '<div id="MakeMessage" style="text-align: left;">
                    <p>Make Message</p>

                    <div id="Message_Div">
                        << Filter : Check_Email >>

                        <textarea cols="10" rows="10" style="display: block;margin: 10px;"
                            placeholder="Enter Your Message Here" id="Message"
                            name="Message" style="display: inline-block;"></textarea>

                    <!-- First Message -->
                        <input type="image" src="<< AddPicture >>" width="80"
                            height="80" alt="AddPicture" id="image1" name = "image1"
                            onclick="GetPicture(\'#File1\');" style="display: inline-block;">
                        
                        <input type="file" id="File1" name="File1"
                        	onchange="Read(this,\'#image1\');">

                    <!-- Second Message -->
                        <input type="image" src="<< AddPicture >>" width="80"
                            height="80" alt="AddPicture" id="image2" name = "image2"
                            onclick="GetPicture(\'#File2\');" style="display: inline-block;">
                        
                        <input type="file" id="File2" name="File2"
                                onchange="Read(this,\'#image2\');">

                    <!-- Third Message -->
                        <input type="image" src="<< AddPicture >>" width="80"
                            height="80" alt="AddPicture" id="image3" name = "image3"
                            onclick="GetPicture(\'#File3\');" style="display: inline-block;">
                        
                        <input type="file" id="File3" name="File3"
                                onchange="Read(this,\'#image3\');">

                    <!-- Forth Message -->
                        <input type="image" src="<< AddPicture >>" width="80"
                            height="80" alt="AddPicture" id="image4" name = "image4"
                            onclick="GetPicture(\'#File4\');" style="display: inline-block;">
                        
                        <input type="file" id="File4" name="File4"
                                onchange="Read(this,\'#image4\');">

                    <!-- Fifth Message -->
                        <input type="image" src="<< AddPicture >>" width="80"
                            height="80" alt="AddPicture" id="image5" name = "image5"
                            onclick="GetPicture(\'#File5\');" style="display: inline-block;">
                        
                        <input type="file" id=\'File5\' name=\'File5\'
                                onchange="Read(this,\'#image5\');">

                    </div>

                    <input type="submit" value="Send" id="SendMessage">

                </div>';
    
    return '';
}

function GetUserPosts($Email, $User_Profile, $User_Picture, $User_Name){

	$Result = (new ModelExcutionEngine())->FetchAllRows(
		'SELECT * FROM posts WHERE user_email = ? AND deleted = ? AND status = ? ORDER BY id DESC LIMIT 3',
	array(
		(new HashingEngine())->Hash_POSTS($Email),
		'0',
		'1'
	));

	if ( $Result->Result != 1 )
		$GLOBALS['User_Posts'] = [];
	else
		$GLOBALS['User_Posts'] = $Result->Data;

	$String = '';
	$GLOBALS['User_Profile'] = $User_Profile;
	$GLOBALS['User_Picture'] = $User_Picture;
	$GLOBALS['User_Name'] = $User_Name;

	foreach ($GLOBALS['User_Posts'] as $Value)
		$String .= Show_User_Post($Value);

	return $String;
}

function Show_User_Post($Post){

	$GLOBALS['Error'] = False;
	Post_Get_User_Post_From_Hashing($Post);
	if ( $GLOBALS['Error'] )
		return '';

	return '<div style="border-bottom-width: 1px;border-bottom-color: #454545;
					border-bottom-style: solid;">
			<div>
				<div style="display: inline-block;margin: 0px;padding: 0px;">
					'.Post_GetPicture().'
				</div>

				<div style="display: inline-block;margin: 0px;padding: 0px;">
					<a href="'.$GLOBALS['User_Profile'].'">
						<input type="image" src="'.$GLOBALS['User_Picture'].'"
						style="width: 80px;height: 80px;">
					</a>
				</div>

				<div style="display: inline-block;margin: 0px;padding: 0px;font-size: 15px;">
					<p><strong>By : </strong>'.$GLOBALS['User_Name'].'</p>
					<p><strong>Date : </strong>'.$GLOBALS['Date'].'</p>
				</div>
			</div>
			<p style="padding: 0px;margin: 0px;"><strong>Title : </strong>
				'.$GLOBALS['Add_Name'].'</p>
			<div style="font-size: 15px;">
				<p>'.$GLOBALS['Discreption'].'</p>
			</div>
			<div style="padding: 0px;">
				<a href="'.Post.$GLOBALS['POST_ID'].'">See Full Advertise</a>
			</div>
		</div>';
}

function Post_Get_User_Post_From_Hashing($Data){
	(new HashingEngine())->Get_Data_From_Hashing([
		['Type' => '', 'Data' => $Data['id'], 'Key' => 'POST_ID' ],
		
		['Type' => '', 'Data' => $Data['status'], 'Key' => 'Status' ],

		['Type' => 'POSTS', 'Data' => $Data['phone'], 'Key' => 'Phone' ],
		['Type' => 'POSTS', 'Data' => $Data['address'], 'Key' => 'Address' ],
		['Type' => 'POSTS', 'Data' => $Data['bigtype'], 'Key' => 'BigType' ],
		['Type' => 'POSTS', 'Data' => $Data['furnished'], 'Key' => 'Furnished' ],
		['Type' => '', 'Data' => $Data['area'], 'Key' => 'Area' ],
		['Type' => '', 'Data' => $Data['rooms'], 'Key' => 'Rooms' ],
		['Type' => '', 'Data' => $Data['pathrooms'], 'Key' => 'PathRooms' ],
		['Type' => 'POSTS', 'Data' => $Data['discreption'], 'Key' => 'Discreption' ],
		['Type' => 'POSTS', 'Data' => $Data['f_pic'], 'Key' => 'Picture1',
			'Default' => Housing ],
		['Type' => 'POSTS', 'Data' => $Data['s_pic'], 'Key' => 'Picture2',
			'Default' => Housing ],
		['Type' => '', 'Data' => $Data['post_date'], 'Key' => 'Date', 'Default' => '' ],
		['Type' => 'POSTS', 'Data' => $Data['smalltype'], 'Key' => 'SmallType' ],
		['Type' => 'POSTS', 'Data' => $Data['user_name'], 'Key' => 'User_Name' ],
		
		['Type' => 'POSTS', 'Data' => $Data['t_pic'], 'Key' => 'Picture3',
			'Default' => Housing ],
		['Type' => 'POSTS', 'Data' => $Data['fo_pic'], 'Key' => 'Picture4',
			'Default' => Housing ],
		['Type' => '', 'Data' => $Data['money'], 'Key' => 'Money' ],

		['Type' => 'POSTS', 'Data' => $Data['addname'], 'Key' => 'Add_Name' ]

	], 'Post_Status_Error');
}

function Post_Status_Error(){
	$GLOBALS['Error'] = True;
}

function Post_GetPicture(){

	for ($i=1; $i < 5; $i++)
		if ( $GLOBALS['Picture'.$i] != Housing )
			return ' <input type="image" src="'.$GLOBALS['Picture'.$i].'"
							style="width: 80px;height: 80px;">';

	return ' <input type="image" src="'.Housing.'" style="width: 80px;height: 80px;">';
}
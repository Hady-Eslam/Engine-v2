<?php

use SiteEngines\HashingEngine;

function DeleteAccount(){
	if ( SESSION() && $_SESSION['Status'] == '0' )
		return '<script type="text/javascript">
                    function DeleteAccount(){
                        location.href = \'<< AdminDeleteAccount >>\';
                    }
                </script>

                <input type="button" value="Delete Account" style="height: 40px;width: 50%;
                    background-color: red;border-color: red;" onclick="DeleteAccount();">';

    return '';
}

function GetUserPosts($Posts){
	$String = '';
	foreach ( $Posts as $Value)
        $String .= User_Get_Post($Value);

    if ( $String == '' )
        return '<p>No Pedding Posts Found</p>';
    return $String;
}

function User_Get_Post($Post){

	$GLOBALS['Error'] = False;
	User_Get_Post_From_Hashing($Post);
	if ( $GLOBALS['Error'] )
		return '';
	return '
		<div style="border-bottom-width: 1px;border-bottom-color: #454545;border-bottom-style: solid;">
			<div>
				<div style="display: inline-block;margin: 0px;padding: 0px;">
					<a href="">
						<input type="image" src="<< User_Picture >>"
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

function User_Get_Post_From_Hashing($Data){
	(new HashingEngine())->Get_Data_From_Hashing([
		['Type' => '', 'Data' => $Data['id'], 'Key' => 'POST_ID' ],
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

	], 'User_Post_Error');
}

function User_Post_Error(){
	$GLOBALS['Error'] = True;
}
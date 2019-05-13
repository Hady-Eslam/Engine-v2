<?php

function GetScripts(){

	if ( $GLOBALS['Section'] == 'Settings' )
	    return '<script src="<< AddPictureScript >>"></script>
	    	<script src="<< PagesScripts >>Settings_PictureScript.js"></script>';

	else if ( $GLOBALS['Section'] == 'Name' )
	    return '<script src="<< CheckLenScript >>"></script>
		    <script src="<< CheckinputLenScript >>"></script>

		    <script src="<< PagesScripts >>Settings_NameScript.js"></script>';

	else if ( $GLOBALS['Section'] == 'Address' )
		return '<script src="<< CheckLenScript >>"></script>
		    <script src="<< CheckinputLenScript >>"></script>

		    <script src="<< PagesScripts >>Settings_AddressScript.js"></script>';

	else if ( $GLOBALS['Section'] == 'Phone' )
		return '<script src="<< CheckLenScript >>"></script>
		    <script src="<< CheckPhoneScript >>"></script>

		    <script src="<< PagesScripts >>Settings_PhoneScript.js"></script>';

	else if ( $GLOBALS['Section'] == 'Password' )
	    return '<script src="<< CheckLenScript >>"></script>
		    <script src="<< CheckinputLenScript >>"></script>

		    <script src="<< CheckPasswordScript >>"></script>
		    <script src="<< PagesScripts >>Settings_PasswordScript.js"></script>';

	else if ( $GLOBALS['Section'] == 'DeActivate' )
	    return '<script src="<< PagesScripts >>Settings_DeActivateScript.js"></script>';

	return '';
}

function GetTemplate(){
    if ( $GLOBALS['Section'] == 'Settings' )
    	return '<< include : Profile/Picture.html >>';

    else if ( $GLOBALS['Section'] == 'Name' )
    	return '<< include : Profile/Name.html >>';

    else if ( $GLOBALS['Section'] == 'Address' )
    	return '<< include : Profile/Address.html >>';
    
    else if ( $GLOBALS['Section'] == 'Phone' )
    	return '<< include : Profile/Phone.html >>';
    
    else if ( $GLOBALS['Section'] == 'Password' )
    	return '<< include : Profile/Password.html >>';
    
    else if ( $GLOBALS['Section'] == 'DeActivate' )
    	return '<< include : Profile/DeActivate.html >>';

    return '';
}

function ShowResults(){

	if ( $GLOBALS['Result'] == 'NameDone' )
        return 'TriggerMessage(3000, \'#53A01A\', \'<p>Name Changed</p>\');';

    else if ( $GLOBALS['Result'] == 'ReservedName' )
        return '$(\'#Name\').css(\'border-color\', \'red\')';
    
    else if ( $GLOBALS['Result'] == 'PhoneDone' )
        return 'TriggerMessage(3000, \'#53A01A\', \'<p>Phone Changed</p>\');';

    else if ( $GLOBALS['Result'] == 'ReservedPhone' )
        return '$(\'#Phone\').css(\'border-color\', \'red\');';
    
    else if ( $GLOBALS['Result'] == 'PictureDone' )
        return 'TriggerMessage(3000, \'#53A01A\', \'<p>Picture Changed</p>\');';
    
    else if ( $GLOBALS['Result'] == 'PasswordDone' )
        return 'TriggerMessage(3000, \'#53A01A\', \'<p>Password Changed</p>\');';

    else if ( $GLOBALS['Result'] == 'AddressDone' )
        return 'TriggerMessage(3000, \'#53A01A\', \'<p>Address Changed</p>\');';
    
    else if ( $GLOBALS['Result'] == 'WrongPassword' )
        return '$(\'#OldPassword\').css(\'border-color\', \'red\');';

    return '';
}
<?php

define('ROOT', _DIR_);
define('HTTP_ROOT', 'http://enginenote.com');

	define('Models', ROOT.'/Models/');


	define('Public_ROOT', ROOT.'/Public/');
	define('Public_HTTP', HTTP_ROOT.'/Public/');

	define('Resources', ROOT.'/Resources/');
		
		define('Library', Resources.'Library/');

		define('Templates', Resources.'Templates/');

	define('Views', ROOT.'/Views/');

	define('Uploads_ROOT', ROOT.'/Uploads/');
	define('Uploads_HTTP', HTTP_ROOT.'/Uploads/');

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

// PHP Library Folder

	// Pages Functions
	define('PagesPHP', Library.'PagesPHP/');

	// Classes
	define('Classes', Library.'Classes/');

		define('MongoDB', Classes.'/DataBases/MongoDB.php');
		define('MongoDBAutoload', Classes.'/DataBases/MongoDBFile/vendor/autoload.php');

		define('DATE', Classes.'DATE.php');
		define('Session', _DIR_.'/SiteEngines/Session.php');
		define('CSRF', Classes.'CSRF.php');
	

	// Global Functions
		define('CheckUser', _DIR_.'/SiteEngines/CheckUser.php');
		define('CheckToken', _DIR_.'/SiteEngines/CheckToken.php');
		define('OpenSession', _DIR_.'/SiteEngines/OpenSession.php');
		define('ChangePassword', _DIR_.'/SiteEngines/ChangePassword.php');
		define('Files', _DIR_.'/SiteEngines/Files.php');
		define('CheckAcount', _DIR_.'/SiteEngines/CheckAcount.php');
	

/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// Pages HTTP Requestes
	// Register
	define('Register_HTTP', HTTP_ROOT.'/Register/');
		define('SignUP', Register_HTTP.'SignUP');
		define('SuccessSignUP', Register_HTTP.'SuccessSignUP');
		define('Login', Register_HTTP.'Login');
		define('LogOut', Register_HTTP.'LogOut');


	// DO
	define('DO_HTTP', HTTP_ROOT.'/DO/');
		define('ShowNotes', DO_HTTP.'ShowNotes');
		define('MakeNote', DO_HTTP.'MakeNote');
		define('Note', DO_HTTP.'Note/');
		
		

	// Services
	define('Services_HTTP', HTTP_ROOT.'/Services/');
		define('Help', Services_HTTP.'Help');
		define('Policy', Services_HTTP.'Policy');
		define('AboutMe', Services_HTTP.'AboutMe');


	// Profile
	define('Profile_HTTP', HTTP_ROOT.'/Profile/');
		define('Settings', Profile_HTTP.'Settings');
		define('MyProfile', Profile_HTTP.'MyProfile');
		

/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// CSS Folder 
define('CSS', Public_HTTP.'CSS/');
	
	define('MainCSS', CSS.'MainCSS/');

		define('AllPagesCSS', MainCSS.'AllPagesCSS.CSS');
		define('BootStrapCSS', MainCSS.'MainBootstrap');


	define('PagesCSS', CSS.'PagesCSS/');

/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// Picture Folder
define('Pictures', Public_HTTP.'Pictures/');

	define('UserPictures', Uploads_ROOT.'UserPictures/');
	define('UserPictures_HTTP', Uploads_HTTP.'UserPictures/');

	define('MessagesPictures', Uploads_ROOT.'MessagesPictures/');
	define('MessagesPictures_HTTP', Uploads_HTTP.'MessagesPictures/');
	
	// Main Pictures
	define('LOGO', Pictures.'LOGO.JPG');
	define('Housing', Pictures.'Housing.PNG');
	define('OffLineUser', Pictures.'OffLineUser.PNG');
	define('OnLineUser', Pictures.'OnLineUser.PNG');
	define('AddPicture', Pictures.'AddPicture.PNG');
	define('NoNotification', Pictures.'NoNotification.PNG');
	define('Notification', Pictures.'Notification.PNG');
	define('Send', Pictures.'Send.PNG');
	define('DeleteImage', Pictures.'Delete.png');
	define('Admin', Pictures.'Admin.png');
	define('DropDown', Pictures.'DropDown.png');


/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// JavaScript Folder
define('JavaScript', Public_HTTP.'JavaScript/');
	
	// Main Scripts
	define('MainScripts', JavaScript.'MainScripts/');
		
		define('JQueryScript', MainScripts.'jquery-3.3.1.js');
		define('JQueryCookieScript', MainScripts.'js.cookie.js');
		define('DropBoxScript', MainScripts.'BodyLoadScript.js');
		define('SetCookieScript', MainScripts.'SetCookie.js');


	// Global Functions
	define('Global_Fun_Scripts', JavaScript.'GlobalFunctions/');

		define('CheckLenScript', Global_Fun_Scripts.'CheckLen.js');
		define('CheckinputLenScript', Global_Fun_Scripts.'CheckinputLen.js');

		define('CheckMinMaxScript', Global_Fun_Scripts.'CheckMinMax.js');
		define('CheckDataLenAndNumberScript',
				Global_Fun_Scripts.'CheckDataLenAndNumber.js');

		define('CheckPatternScript', Global_Fun_Scripts.'CheckPattern.js');

		define('CheckPasswordScript', Global_Fun_Scripts.'CheckPassword.js');

		define('isNumberScript', Global_Fun_Scripts.'isNumber.js');
		define('CheckinputLenAndNumberScript',
				Global_Fun_Scripts.'CheckinputLenAndNumber.js');

		define('AddPictureScript', Global_Fun_Scripts.'AddPicture.js');

		define('CheckNameScript', Global_Fun_Scripts.'CheckName.js');
		define('CheckPhoneScript', Global_Fun_Scripts.'CheckPhone.js');

		define('TriggerFormScript', Global_Fun_Scripts.'TriggerForm.js');
		
		define('TriggerMessageScript', Global_Fun_Scripts.'TriggerMessage.js');
		define('SetError_FunctionScript',
				Global_Fun_Scripts.'SetError_Function.js');
		
	
	// Pages Scripts
	define('PagesScripts', JavaScript.'PagesScripts/');


/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// Length
define('User_Name_Len', 100);
define('User_Email_Len', 100);
define('User_Password_Len', 100);


define('Note_Title_Len', 100);
define('Note_Body_Len', 500);




// Picture Size in Bytes 	1 * 1000 * 1000		=>	1 MegaByte
define('Picture_Len', 2 * 1000 * 1000);


/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// DataBase info

define('DBLanguage', 'mysql');

define('Host', 'localhost');

define('DBName', 'findhouse');

define('UserName', 'root');
//define('UserName', 'Session')
//define('UserName', 'BackEnd');
//define('UserName', 'Register');
//define('UserName', 'Token');
//define('UserName', 'DO');
//define('UserName', 'Settings');
//define('UserName', 'Profile');
define('Passwords', '');


/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// DataBase Models

define('SessionModel', Models.'SessionModel.php');



/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// SuperGlobal Functions

// Error Function
function Error($ErrorType, $ErrorCode, $ErrorMessage){
	return (object)[
		'Error Type' => $ErrorType,
		'Error Code' => $ErrorCode,
		'Error Message' => $ErrorMessage
	]; 
}

// Returns Function
function Returns($Result, $Data = '', $Error = ''){
	return (object)[
		'Result' => $Result,
		'Data' => $Data,
		'Error' => $Error
	];
}

// Debug Function
function Debug($DoExit = false, $Object = ''){
	var_dump($Object);
	echo '__________________________________________________________________________';
	var_dump( debug_backtrace() );
	if ( $DoExit == true )
		exit();
}

// Redirect Function
function Redirect($URL){
	header("Location:".$URL);
	exit();
}
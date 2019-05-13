<?php

define('ROOT', _DIR_);
define('HTTP_ROOT', 'http://lookandsee.com');

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


/////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////


// Templates

	//Headers
	define('Headers', Templates.'Headers/');
		// Small Headers
		define('BasicHeaders', Headers.'BasicHeaders/');

		define('NavBar', BasicHeaders.'NavBar.php');
		define('Notifications_Header', BasicHeaders.'Notifications_Header.php');
		
		define('UserHeader', BasicHeaders.'User.php');
		define('UserNotLoggedHeader', BasicHeaders.'UserNotLogged.php');

		// Big Headers
		define('NotLoggedHeaders', Headers.'NotLoggedHeaders.php');
		define('LoggedHeaders', Headers.'LoggedHeaders.php');
		define('AllHeaders', Headers.'AllHeaders.php');
		
	// Footer
	define('Footer', Templates.'Footer.php');

	// Message Boxs
	define('MessageBox', Templates.'MessageBoxs/MessageBox.php');

	// Page Status
	define('StatusPages', Templates.'StatusPages/');
		define('ClosedPage', StatusPages.'ClosedPage.php');
		define('CanNotAccessNowPage', StatusPages.'CanNotAccessNowPage.php');
		
		define('UnAuthurithedUserPage', StatusPages.'UnAuthurithedUserPage.php');
		
		define('LogOutPage', StatusPages.'LogOutPage.php');

		define('ErrorPage', StatusPages.'ErrorPage.php');

		define('NotFoundPage', StatusPages.'404.php');

		define('MaximumAdvertisingLimitPage', StatusPages.'MaximumAdvertisingLimitPage.php');
		


	// Pages
		// Register
		define('Register_Templates', Templates.'Register/');
			define('SignUP_Template', Register_Templates.'SignUP_Template.php');
			define('SuccessSignUP_Template', Register_Templates.'SuccessSignUP_Template.php');
			define('ConfirmUser_Template', Register_Templates.'ConfirmUser_Template.php');

			define('Login_Template', Register_Templates.'Login_Template.php');
			define('ForgetPassword_Template', Register_Templates.'ForgetPassword_Template.php');
			define('ReSetPassword_Template', Register_Templates.'ReSetPassword_Template.php');


		// DO
		define('DO_Templates', Templates.'DO/');
			define('Find_Template', DO_Templates.'Find_Template.php');
			define('Advertise_Template', DO_Templates.'Advertise.php');
			define('EditPost_Template', DO_Templates.'EditPost_Template.php');
			define('PostStatus_Template', DO_Templates.'PostStatus_Template.php');
			define('Predict_Template', DO_Templates.'Predict_Template.php');
			define('interested_Template', DO_Templates.'interested_Template.php');
			define('Post_Template', DO_Templates.'Post_Template.php');
			define('PostMessage_Template', DO_Templates.'PostMessage_Template.php');


		// Services
		define('Services_Templates', Templates.'Services/');
			define('Help_Template', Services_Templates.'Help_Template.php');
			define('Privacy_Template', Services_Templates.'Privacy_Template.php');


		// Profile
		define('Profile_Templates', Templates.'Profile/');
			define('Settings_Template', Profile_Templates.'Settings_Template.php');
			define('User_Template', Profile_Templates.'User_Template.php');
			define('MyProfile_Template', Profile_Templates.'MyProfile_Template.php');
			define('Notifications_Template', Profile_Templates.'Notifications_Template.php');
			define('Messages_Template', Profile_Templates.'Messages_Template.php');
			define('Message_Template', Profile_Templates.'Message_Template.php');
		

		// Admin
		define('Admin_Template', Templates.'Admin/');
			define('AdminOperations_Template', Admin_Template.'AdminOperations_Template.php');
			define('PeddingPosts_Template', Admin_Template.'PeddingPosts_Template.php');


/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// Back End Pages
	define('BackEnd', Resources.'BackEndPages/');
		
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// Views
	// Register
	define('Register_View', Views.'Register/');
		define('SignUP_View', Register_View.'SignUP_View.php');
		define('SuccessSignUP_View', Register_View.'SuccessSignUP_View.php');
		define('ConfirmUser_View', Register_View.'ConfirmUser_View.php');

		define('Login_View', Register_View.'Login_View.php');
		define('ForgetPassword_View', Register_View.'ForgetPassword_View.php');
		define('ReSetPassword_View', Register_View.'ReSetPassword_View.php');


	// DO
	define('DO_View', Views.'DO/');
		define('Find_View', DO_View.'Find_View.php');
		define('Advertise_View', DO_View.'Advertise_View.php');
		define('PostStatus_View', DO_View.'PostStatus_View.php');
		define('Predict_View', DO_View.'Predict_View.php');
		define('interested_View', DO_View.'interested_View.php');
		define('Post_View', DO_View.'Post_View.php');
		define('EditPost_View', DO_View.'EditPost_View.php');
		


	// Services
	define('Services_View', Views.'Services_View.php');


	// Profile
	define('Profile_View', Views.'Profile/');
		define('Settings_View', Profile_View.'Settings_View.php');
		define('User_View', Profile_View.'User_View.php');
		define('MyProfile_View', Profile_View.'MyProfile_View.php');
		define('Notifications_View', Profile_View.'Notifications_View.php');
		define('Messages_Inbox_View', Profile_View.'Messages_Inbox_View.php');
		define('Messages_Sent_View', Profile_View.'Messages_Sent_View.php');
		define('Message_View', Profile_View.'Message_View.php');


	// Admin
	define('Admin_View', Views.'Admin/');
		define('AdminDeletePost_View', Admin_View.'AdminDeletePost_View.php');
		define('AdminAcceptPost_View', Admin_View.'AdminAcceptPost_View.php');
		define('AdminRejectPost_View', Admin_View.'AdminRejectPost_View.php');
		define('AdminDeleteAccount_View', Admin_View.'AdminDeleteAccount_View.php');
		define('PeddingPosts_View', Admin_View.'PeddingPosts_View.php');


	// Back End Pages
	define('BackEnd_View', Views.'BackEnd_View.php');
	

/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

// Pages HTTP Requestes
	// Register
	define('Register_HTTP', HTTP_ROOT.'/Register/');
		define('SignUP', Register_HTTP.'SignUP');
		define('SuccessSignUP', Register_HTTP.'SuccessSignUP');
		define('ConfirmUser', Register_HTTP.'ConfirmUser');

		define('Login', Register_HTTP.'Login');
		define('ForgetPassword', Register_HTTP.'ForgetPassword');
		define('ReSetPassword', Register_HTTP.'ReSetPassword');

		define('LogOut', Register_HTTP.'LogOut');


	// DO
	define('DO_HTTP', HTTP_ROOT.'/DO/');
		define('Find', DO_HTTP.'Find');
		define('Advertise', DO_HTTP.'Advertise');
		define('PostStatus', DO_HTTP.'PostStatus/');
		define('Predict', DO_HTTP.'Predict');
		define('interested', DO_HTTP.'interested');
		define('Post', DO_HTTP.'Post/');
		define('EditPost', DO_HTTP.'EditPost/');


	// Services
	define('Services_HTTP', HTTP_ROOT.'/Services/');
		define('Help', Services_HTTP.'Help');
		define('Policy', Services_HTTP.'Policy');
		define('AboutMe', Services_HTTP.'AboutMe');


	// Profile
	define('Profile_HTTP', HTTP_ROOT.'/Profile/');
		define('Settings', Profile_HTTP.'Settings');
		define('User', Profile_HTTP.'User/');
		define('MyProfile', Profile_HTTP.'MyProfile');
		define('Notifications', Profile_HTTP.'Notifications');
		define('Messages', Profile_HTTP.'Messages');
		define('Messages_Inbox', Profile_HTTP.'Messages/Inbox');
		define('Messages_Sent', Profile_HTTP.'Messages/Sent');
		define('Message', Profile_HTTP.'Message/');

	// Admin
	define('Admin_HTTP', HTTP_ROOT.'/Admin/');
		define('AdminDeletePost', Admin_HTTP.'DeletePost/');
		define('AdminAcceptPost', Admin_HTTP.'ApprovePost/');
		define('AdminRejectPost', Admin_HTTP.'RejectPost/');
		define('AdminDeleteAccount', Admin_HTTP.'DeleteAccount/');
		define('PeddingPosts', Admin_HTTP.'PeddingPosts');


	// Back End Page
	define('BackEnd_HTTP', HTTP_ROOT.'/BackEnd/');
		define('CheckPage', BackEnd_HTTP.'CheckPage');
		define('DeletePostPage', BackEnd_HTTP.'DeletePost');
		define('MakeCommentPage', BackEnd_HTTP.'MakeComment');
		define('MakeLike_DisLikePage', BackEnd_HTTP.'MakeLike-DisLike');
		define('MakeMessage', BackEnd_HTTP.'MakeMessage');
		define('DeleteMessage', BackEnd_HTTP.'DeleteMessage');
		

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

// Register
define('Email_Len', 100);	// 200 character 
define('Password_Len', 40); // 100
define('Name_Len', 40);		// 100
define('Phone_Len', 20);	// 20
define('Token_Len', 20);	// 100

// DO
define('Advertise_Name_Len', 150); // 200
define('BigType_Len', 20); // 200
define('SmallType_Len', 20); // 200
define('Rooms_Len', 1);		// 5
define('Area_Len', 5);		// 20
define('Furnished_Len',10);	// 10

define('Address_Len', 70); // 200


define('Status_Len', 10);	// 20
define('Type_Len', 10);		// 30

define('Storey_Len', 2);	// 5

define('Money_Len', 9);	// 20

define('Discreption_Len', 500);	// 600

// Picture Size in Bytes 	1 * 1000 * 1000		=>	1 MegaByte
define('Picture_Len', 2 * 1000 * 1000);

define('Page_Len', 3);

// My Profile
define('ID_Len', 7);

// Post
define('Comment_Len', 500);
define('Message_Len', 500);


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

// Check Session is Set OR NOT
function SESSION(){
	return ( isset($_SESSION['Posts']) ) ? True : False ;
}

function RESET_GLOBAL_Variables(){
	$_POST = array();
	$_GET = array();
	$_FILES = array();
}

function RESET_SESSION($PageName = ''){
	$_SESSION = array();
	$_SESSION['Page Name'] = $PageName;
}
?>
<?php

return [
	'ROOT' => _DIR_,
	'HTTP_ROOT' => 'http://lookandsee.com',

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	// PHP Library Folder
	// Pages Functions
	'SiteEngines' => _DIR_.'/SiteEngines/',

	// DataBase
		'MySqlEngine' => _DIR_.'/Models/MySqlEngine.php',
		'MongoDBEngine' => _DIR_.'/Models/MongoDBEngine.php',

		'PHPMailerEngine' => _DIR_.'/SiteEngines/PHPMailer/MailerEngine.php',
		'HashingEngine' => _DIR_.'/SiteEngines/HashingEngine.php',
		'DateEngine' => _DIR_.'/SiteEngines/DateEngine.php',
		'JsonEngine' => _DIR_.'/SiteEngines/JsonEngine.php',
		'URLEngine' => _DIR_.'/SiteEngines/URLEngine.php',
		'SessionEngine' => _DIR_.'/SiteEngines/SessionEngine.php',
		'CSRFEngine' => _DIR_.'/SiteEngines/CSRFEngine.php',
	
	// Global Functions
	'Global_Fun_PHP' => _DIR_.'/Functions/',

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	// Templates

	//Headers
	'Headers' => _DIR_.'/Templates/Headers/',
		
	// Footer
	'Footer' => _DIR_.'/Templates/Footer.php',

	// Message Boxs
	'MessageBox' => _DIR_.'/Templates/MessageBox.php',

	// Status Pages
	'StatusPages' => _DIR_.'/Templates/StatusPages/',

	// Pages
		// Register
		'Register_Templates' => _DIR_.'/Templates/Register/',

		// DO
		'DO_Templates' => _DIR_.'/Templates/DO/',

		// Services
		'Services_Templates' => _DIR_.'/Templates/Services/',

		// Profile
		'Profile_Templates' => _DIR_.'/Templates/Profile/',

		// Admin
		'Admin_Template' => _DIR_.'/Templates/Admin/',

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	// Views

	// Register
	'Register_View' => _DIR_.'/Views/Register/',
	
	// DO
	'DO_View' => _DIR_.'/Views/DO/',

	// Services
	'Services_View' => _DIR_.'/Views/Services/',

	// Profile
	'Profile_View' => _DIR_.'/Views/Profile/',

	// Admin
	'Admin_View' => _DIR_.'/Views/Admin/',

	// Back End
	'BackEnd_View' => _DIR_.'/Views/BackEnd/',

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	// Pages HTTP Requestes
	// Register
	'Register_HTTP' => 'http://lookandsee.com/Register/',

	// DO
	'DO_HTTP' => 'http://lookandsee.com/DO/',

	// Services
	'Services_HTTP' => 'http://lookandsee.com/Services/',

	// Profile
	'Profile_HTTP' => 'http://lookandsee.com/Profile/',

	// Admin
	'Admin_HTTP' => 'http://lookandsee.com/Admin/',

	// Back End
	'BackEnd_HTTP' => 'http://lookandsee.com/BackEnd/',

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	// CSS Folder

	'CSS' => 'http://lookandsee.com/Public/CSS',

		'MainCSS' => 'http://lookandsee.com/Public/CSS/MainCSS/',

			'AllPagesCSS' => 'http://lookandsee.com/Public/CSS/MainCSS/AllPagesCSS.CSS',

		'PagesCSS' => 'http://lookandsee.com/Public/CSS/PagesCSS/',

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	// Picture Folder
	'Pictures' => 'http://lookandsee.com/Public/Pictures/',

		'UserPictures' => _DIR_.'/Uploads/UserPictures/',
		'UserPictures_HTTP' => 'http://lookandsee.com/Uploads/UserPictures/',

		'MessagesPictures' => _DIR_.'/Uploads/MessagesPictures/',
		'MessagesPictures_HTTP' => 'http://lookandsee.com/Uploads/MessagesPictures/',

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	// JavaScript Folder

	'JavaScript' => 'http://lookandsee.com/Public/JavaScript/',

		// Main Scripts
		'MainScripts' => 'http://lookandsee.com/Public/JavaScript/MainScripts/',

		// Global Functions
		'Global_Fun_Scripts' => 'http://lookandsee.com/Public/JavaScript/GlobalFunctions/',

		//Pages Scripts
		'PagesScripts' => 'http://lookandsee.com/Public/JavaScript/PagesScripts/',		


	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	// Length

	'Email_Len' => 100,
	'Password_Len' => 40,
	'Name_Len' => 40,
	'Phone_Len' => 20,
	'Token_Len' => 20,

	'Advertise_Name_Len' => 150,
	'BigType_Len' => 20,
	'SmallType_Len' => 20,
	'Rooms_Len' => 1,
	'Area_Len' => 5,
	'Furnished_Len' => 10,

	'Address_Len' => 70,

	'Status_Len' => 10,
	'Type_Len' => 10,

	'Storey_Len' => 2,

	'Money_Len' => 11,

	'Discreption_Len' => 500,

	'Picture_Len' => 2097152,

	'Page_Len' => 3,

	'ID_Len' => 7,

	'Comment_Len' => 500,

	'Message_Len' => 500
];
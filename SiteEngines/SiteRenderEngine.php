<?php

namespace SiteEngines;
use Core\RenderEngine;

class SiteRenderEngine extends RenderEngine{
	
	private static function Register_Static_Site_Data($Request){
		self::Register_Static_Data([
			'Head' => [
				'LOGO' => LOGO
			],

			'Header' => [
				'SignUP' => SignUP,
				'Login' => Login,

				'ShowNotes' => ShowNotes,
				'MakeNote' => MakeNote,
				'MyProfile' => MyProfile,
				'Settings' => Settings,
				'LogOut' => LogOut,


				'MakeNote' => MakeNote
			],

			'SESSION' => ( isset($Request->SESSION['Updated_At']) ) ? True : False
		]);
	}

	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////

	static function SignUP_Render($Request, $Errors = NULL, $POST = NULL){
		self::Register_Static_Site_Data($Request);

		return self::Render($Request, 'Register/SignUP.html', [

			'Errors' => [
				'Name' => ( isset($Errors['Name']) ) ? $Errors['Name'] : '',
				'Email' => ( isset($Errors['Email']) ) ? $Errors['Email'] : '',
				'Password' => ( isset($Errors['Password']) ) ? $Errors['Password'] : '',
			],

			'POST' => [
				'Name' => ( isset($POST['Name']) ) ? $POST['Name'] : '',
				'Email' => ( isset($POST['Email']) ) ? $POST['Email'] : '',
				'Password' => ( isset($POST['Password']) ) ? $POST['Password'] : '',
			],
		]);
	}

	static function SuccessSignUP_Render($Request){
		self::Register_Static_Site_Data($Request);
		return self::Render($Request, 'Register/SuccessSignUP.html', []);
	}

	static function Login_Render($Request, $Errors = NULL, $POST = NULL){
		self::Register_Static_Site_Data($Request);
		return self::Render($Request, 'Register/Login.html', [

			'Errors' => [
				'Email' => ( isset($Errors['Email']) ) ? $Errors['Email'] : '',
				'Password' => ( isset($Errors['Password']) ) ? $Errors['Password'] : '',
			],

			'POST' => [
				'Email' => ( isset($POST['Email']) ) ? $POST['Email'] : '',
				'Password' => ( isset($POST['Password']) ) ? $POST['Password'] : '',
			],
		]);
	}

	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////

	static function MakeNote_Render($Request, $Errors = NULL, $POST = NULL){
		self::Register_Static_Site_Data($Request);
		return self::Render($Request, 'DO/MakeNote.html', [

			'Errors' => [
				'Title' => ( isset($Errors['Title']) ) ? $Errors['Title'] : '',
				'Note' => ( isset($Errors['Note']) ) ? $Errors['Note'] : '',
			],

			'POST' => [
				'Title' => ( isset($POST['Title']) ) ? $POST['Title'] : '',
				'Note' => ( isset($POST['Note']) ) ? $POST['Note'] : '',
			],
		]);
	}

	static function Note_Render($Request, $Note){
		self::Register_Static_Site_Data($Request);
		return self::Render($Request, 'DO/Note.html', [
			
			'Note' => [
				'Title' => $Note['Title'],
				'Body' => $Note['Body'],
				'Created_At' => $Note['Created_At'],
				'Updated_At' => $Note['Updated_At']
			]
		]);
	}

	static function ShowNotes_Render($Request, $Notes){
		self::Register_Static_Site_Data($Request);
		return self::Render($Request, 'DO/ShowNotes.html', ['Notes' => $Notes ]);
	}

	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////


	static function Not_Found_Render($Request){
		self::Register_Static_Site_Data($Request);
		return self::Render($Request, 'StatusPages/404.html', []);
	}

	static function UnAuthorized_Render($Request){
		self::Register_Static_Site_Data($Request);
		return self::Render($Request, 'StatusPages/UnAuthorized.html', []);
	}
}
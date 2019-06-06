<?php

use SiteEngines\SiteRenderEngine;
use Forms\RegisterForms\LoginForm;
use Models\UserModel;
use Core\RedirectEngine;

class Login{
	
	function POST($Request){
		$Login = new LoginForm($Request->POST);
		if ( !$Login->isValid() )
			return SiteRenderEngine::Login_Render($Request, $Login->GetErrors(), $Request->POST);

		$User = (new UserModel())->Select()->Where('Email='.$Login->GetEmail())->Limit(1)->Get();

		if ( $User === [] )
			return SiteRenderEngine::Login_Render($Request, [
				'Email' => 'Email Not Found'
			], $Request->POST);

		else if ( $User[0]['Password'] !== $Login->GetPassword() )
			return SiteRenderEngine::Login_Render($Request, [
				'Password' => 'Wrong Password'
			], $Request->POST);

		$Request->SESSION['Name'] = $User[0]['Name'];
		$Request->SESSION['Email'] = $User[0]['Email'];
		$Request->SESSION['Created_At'] = $User[0]['Created_At'];
		$Request->SESSION['Updated_At'] = $User[0]['Updated_At'];

		RedirectEngine::To(ShowNotes, $Request);
	}

	function GET($Request){
		return SiteRenderEngine::Login_Render($Request);
	}

	function ALL($Request){
		return SiteRenderEngine::UnAuthorized_Render($Request);
	}
}
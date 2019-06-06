<?php

use SiteEngines\SiteRenderEngine;
use Forms\RegisterForms\SignUPForm;
use Models\UserModel;
use Core\RedirectEngine;

class SignUP{
	
	function POST($Request){
		$SignUP = new SignUPForm($Request->POST);
		if ( !$SignUP->isValid() )
			return SiteRenderEngine::SignUP_Render($Request, $SignUP->GetErrors(),
					$Request->POST);

		$User = new UserModel();
		if ( $User->Select('ID')->Where('Email='.$SignUP->GetEmail())->Limit(1)->Get() !== [] )
			return SiteRenderEngine::SignUP_Render($Request, [
				'Email' => 'This Email is Already Reserved'
			], $Request->POST);

		$User->Insert([
			'Name' => $SignUP->GetName(),
			'Email' => $SignUP->GetEmail(),
			'Password' => $SignUP->GetPassword()
		]);

		RedirectEngine::To(SuccessSignUP);
	}

	function GET($Request){
		return SiteRenderEngine::SignUP_Render($Request);
	}

	function ALL($Request){
		return SiteRenderEngine::UnAuthorized_Render($Request);
	}
}
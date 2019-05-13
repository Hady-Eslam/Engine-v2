<?php

use SiteEngines\SiteRenderEngine;
use SiteEngines\HashingEngine;

function Login_Begin($Request){
	//var_dump($Request->SESSION);
	//$Request->SESSION['Name'] = 'Hady';
	//var_dump($Request->SESSION['Name']);
	$Request->SESSION['Name'] = 'Hello Hady';
	//return '<strong>Hello World</strong>';
	//return [$Request, '<strong>Hello World</strong>'];
	return SiteRenderEngine::Login_Render($Request);
}
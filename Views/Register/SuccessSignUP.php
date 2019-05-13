<?php

use SiteEngines\SiteRenderEngine;
include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function SuccessSignUP_Begin($Request){
	$_SESSION['Page Name'] = 'Success Sign UP';
	if ( SESSION() )
		return (new SiteRenderEngine())->Not_Authurithed_User('Success Sign UP');
	return (new SiteRenderEngine())->SuccessSignUP_Render();
}
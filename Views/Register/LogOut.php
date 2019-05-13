<?php

use SiteEngines\SiteRenderEngine;

include_once _DIR_.'/Configs/Configs.php';
include_once Session;

function Begin(){
	$Page = ( isset($_SESSION['Page Name']) ) ? $_SESSION['Page Name'] : 'Find';

	if ( (new SessionEngine())->DestroySession()->Result == -1 )
		return (new SiteRenderEngine())->Error_Page('Log Out');

	// Register Pages

	if ( $Page == 'Sign UP' || $Page == 'Success Sign UP' ||
			  $Page == 'Confirm User')
		Redirect(SignUP);

	else if ( $Page == 'Log in' || $Page == 'Forget Password' ||
			  $Page == 'ReSet Password' )
		Redirect(Login);

	// DO Pages

	else if ( preg_match('/Post (.*)/', $Page) ){
		preg_match('/Post (.*)/', $Page, $Result);
		$Post_id = $Result[1];
		Redirect(Post.$Post_id);
	}

	else if ( preg_match('/User (.*)/', $Page) ){
		preg_match('/User (.*)/', $Page, $Result);
		$Post_id = $Result[1];
		Redirect(User.$Post_id);
	}

	// Services Pages

	else if ( $Page == 'Help' )
		Redirect(Help);

	else if ( $Page == 'Policy' )
		Redirect(Policy);

	Redirect(Find);
}
<?php

namespace SiteEngines;
use Core\RenderEngine;

class SiteRenderEngine extends RenderEngine{
	
	private static function Register_Static_Site_Data(){

		self::Register_Static_Data([
			'Data' => 'Hello From Static',
			'Type' => 'Static'
		]);

		self::Register_Group_Data('Register', [
			'Login' => 'SO'
		]);
	}

	static function Hello($Request){
		self::Register_Static_Site_Data();
		return self::Render($Request, 'Footer.html', [
			'Me' => 'Hello From Here',
			'Footer' => [
				'Find' => 'Find',
				'Help' => 'Help',
				'Privacy' => 'Privacy'
			],
			'Find' => 'Find',
			'Help' => 'Help',
			'Privacy' => 'Privacy'
		], 'Register');
	}

	static function Login_Render($Request, $Result = '', $Form = ''){
		
		self::Register_Static_Site_Data();
		return self::Render($Request, 'Footer.html', [
			'CheckLenScript' => 'CheckLenScript',
			'CheckPatternScript' => 'CheckPatternScript',
			'Find' => '',
			'Help'	=> '',
			'Privacy' => '',
		]);
	}
}
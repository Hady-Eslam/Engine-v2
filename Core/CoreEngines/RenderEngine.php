<?php

namespace Core;

class RenderEngine{

	protected static $Data = [];
	protected static $GroupData = [];
	
	static function Register_Static_Data(array $Array = []){
		self::$Data = $Array;
	}

	static function Register_Group_Data(String $GroupName, array $Array = []){
		self::$GroupData[$GroupName] = $Array;
	}

	static function Render(Request $Request, String $TemplatePath, array $Array = [],
		$GroupName = -1 ){

		self::$Data += $Array;
		if ( $GroupName != -1 )
			self::$Data += self::$GroupData[$GroupName];

		return [ $Request, $TemplatePath, self::$Data ];
	}

	static function StaticRender($TemplatePath, array $Array = []){
		return '<static:'.json_encode($Array).'>'.$TemplatePath;
	}
}
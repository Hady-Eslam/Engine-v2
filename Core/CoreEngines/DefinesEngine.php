<?php

namespace Core;

class DefinesEngine{
	
	function __construct($Value){
		$this->TurnEngineOn($Value);
	}

	private function TurnEngineOn($Value){
		define('_ROOT_ENGINE_', $Value);
		define('True', true);
		define('False', false);
		define('_SetErrorHandler_', false);	
		define('Second', 1000 * 1000);
		define('MilliSecond', 1000);
		define('EndLine', "\n");
		define('NULL', null);
	}
}
<?php

namespace Core;

class OutPutEngine{
	
	function __construct(){
		$this->TurnEngineOn();
	}

	private function TurnEngineOn(){
		ob_start(array($this, 'CloseOutPut') );
	}

	function CloseOutPut($Value){
		return '';
	}

	function OpenOutPut(){
		ob_end_clean();
	}
}
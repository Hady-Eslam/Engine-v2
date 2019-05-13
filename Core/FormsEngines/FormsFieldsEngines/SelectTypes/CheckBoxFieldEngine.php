<?php

/**
	The Value is True Or ( NULL For False )

*/

namespace FormsFields\SelectTypes;
use FormsFields\FieldEngine;

class CheckBoxFieldEngine extends FieldEngine{

	
	public $FieldName = 'Check Box Field';
	public $ClassType = 'SelectTypes';
	public $Type = 'CheckBox';
	public $Constraints = [];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;
	}

	function NotSetReturn(){
		$this->Value = False;
		return True;
	}

	function SetReturn($Value){
		$this->Value = True;
		return True;
	}
}
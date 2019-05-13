<?php

namespace FormsFields\IntegerTypes;
use FormsFields\FieldEngine;
use Exceptions\FormsExceptionsEngine;

class BooleanFieldEngine extends FieldEngine{

	
	public $FieldName = 'Boolean Field';
	public $ClassType = 'IntegerTypes';
	public $Type = 'Boolean';
	public $Constraints = [
		'Require' => True,
		'Default' => ''
	];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;

		if ( $this->Constraints['Default'] != 0 && $this->Constraints['Default'] != 1 )
			throw new FormsExceptionsEngine('Default Value For Boolean Field Must Be 0 Or 1');
	}
	
	function SetReturn($Value){
		$Value = filter_var($Value, FILTER_SANITIZE_STRING);
		
		if ( $Value == 0 || $Value == 1 ){
			$this->Value = $Value;
			return True;
		}

		else if ( $this->Constraints['Default'] !== '' ){
			$this->Value = $this->Constraints['Default'];
			return True;
		}

		$this->Error = ' : Boolean Field Not Boolean Value';
		return False;
	}
}
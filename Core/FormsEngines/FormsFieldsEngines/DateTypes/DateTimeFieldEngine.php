<?php

namespace FormsFields\DateTypes;
use FormsFields\FieldEngine;

class DateTimeFieldEngine extends FieldEngine{

	
	public $FieldName = 'DateTime Field';
	public $ClassType = 'DateTypes';
	public $Type = 'DateTime';
	public $Constraints = [
		'Require' => True,
		'Default' => 0
	];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function SetReturn($Value){
		$Value = filter_var( $Value, FILTER_SANITIZE_STRING );
		
		if ( !empty($Value) && 
				preg_match('/^(\d{2})-(\d{2})-(\d{4}) (\d{2}):(\d{2}):(\d{2})/', $Value) ){
			$this->Value = $Value;
			return True;
		}
		else if ( $this->Constraints['Default'] === 0 ){

			if ( empty($Value) )
				$this->Error = ' : DateTime Field is Empty';

			else
				$this->Error = ' : DateTime Field Not in DateTime Formate';
			
			return False;
		}
		else{
			$this->Value = $this->Constraints['Default'];
			return True;
		}
	}
}
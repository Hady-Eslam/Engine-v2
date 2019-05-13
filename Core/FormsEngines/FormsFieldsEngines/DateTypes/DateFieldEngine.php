<?php

namespace FormsFields\DateTypes;
use FormsFields\FieldEngine;

class DateFieldEngine extends FieldEngine{

	
	public $FieldName = 'Date Field';
	public $ClassType = 'DateTypes';
	public $Type = 'Date';
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
		
		if ( !empty($Value) && preg_match('/^(\d{2})-(\d{2})-(\d{4})/', $Value) ){
			$this->Value = $Value;
			return True;
		}
		else if ( $this->Constraints['Default'] === 0 ){

			if ( empty($Value) )
				$this->Error = ' : Date Field is Empty';

			else
				$this->Error = ' : Date Field Not in Date Formate';
			
			return False;
		}
		else{
			$this->Value = $this->Constraints['Default'];
			return True;
		}
	}
}
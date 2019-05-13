<?php

namespace FormsFields\StringTypes;
use FormsFields\FieldEngine;

class TextFieldEngine extends FieldEngine{

	
	public $FieldName = 'Text Field';
	public $ClassType = 'StringTypes';
	public $Type = 'Text';
	public $Constraints = [
		'Require' => True,
		'Default' => 0,
		'Min_Length' => 0,
		'Max_Length' => 2147483647
	];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function SetReturn($Value){
		$Value = filter_var( $Value, FILTER_SANITIZE_STRING );
		
		if ( !empty($Value) && strlen($Value) >= $this->Constraints['Min_Length'] && 
								strlen($Value) <= $this->Constraints['Max_Length'] ){
			$this->Value = $Value;
			return True;
		}
		else if ( $this->Constraints['Default'] === 0 ){

			if ( empty($Value) )
				$this->Error = ' : Text Field is Empty';

			else if ( strlen($Value) < $this->Constraints['Min_Length'] )
				$this->Error = ' : Text Field Size is Smaller Than '.
						$this->Constraints['Min_Length'];
			
			else if ( strlen($Value) > $this->Constraints['Max_Length'] )
				$this->Error = ' : Text Field Size is Longger Than '.
						$this->Constraints['Max_Length'];

			return False;
		}
		else{
			$this->Value = $this->Constraints['Default'];
			return True;
		}
	}
}
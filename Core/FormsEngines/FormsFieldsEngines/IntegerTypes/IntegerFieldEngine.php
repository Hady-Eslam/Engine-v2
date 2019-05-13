<?php

namespace FormsFields\IntegerTypes;
use FormsFields\FieldEngine;

class IntegerFieldEngine extends FieldEngine{

	
	public $FieldName = 'Integer Field';
	public $ClassType = 'IntegerTypes';
	public $Type = 'Integer';
	public $Constraints = [
		'Require' => True,
		'Default' => '',
		'Min_Value' => '',
		'Max_Value' => '',
		'Min_Length' => 0,
		'Max_Length' => 9
	];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function SetReturn($Value){
		
		$Value = filter_var( $Value, FILTER_VALIDATE_INT );
		
		if ( $Value != False && strlen($Value) >= $this->Constraints['Min_Length'] && 
								strlen($Value) <= $this->Constraints['Max_Length'] ){

			if ( $this->Constraints['Min_Value'] !== '' &&
				$Value < $this->Constraints['Min_Value'] ){
				$this->Error = ' : Integer Field Value is Smaller Than '.
							$this->Constraints['Min_Value'];
				return False;
			}
			
			else if ( $this->Constraints['Max_Value'] !== '' &&
				$Value > $this->Constraints['Max_Value'] ){
				$this->Error = ' : Integer Field Value is Longger Than '.
							$this->Constraints['Max_Value'];
				return False;
			}
			
			$this->Value = $Value;
			return True;
		}
		else if ( $this->Constraints['Default'] === '' ){

			if ( $Value == False )
				$this->Error = ' : Integer Field is Empty';

			else if ( strlen($Value) < $this->Constraints['Min_Length'] )
				$this->Error = ' : Integer Field Size is Smaller Than '.
						$this->Constraints['Min_Length'];
			
			else if ( strlen($Value) > $this->Constraints['Max_Length'] )
				$this->Error = ' : Integer Field Size is Longger Than '.
						$this->Constraints['Max_Length'];

			return False;
		}
		else{
			$this->Value = $this->Constraints['Default'];
			return True;
		}
	}
}
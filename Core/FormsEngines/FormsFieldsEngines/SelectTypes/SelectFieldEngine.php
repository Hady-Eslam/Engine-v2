<?php

namespace FormsFields\SelectTypes;
use FormsFields\FieldEngine;

class SelectFieldEngine extends FieldEngine{

	
	public $FieldName = 'Select Field';
	public $ClassType = 'SelectTypes';
	public $Type = 'Select';
	public $Constraints = [
		'Require' => True,
		'Default' => 0,
		'Options' => [],
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
			if ( $this->Constraints['Options'] !== [] ){
				if ( in_array($Value, $this->Constraints['Options']) ){
					$this->Value = $Value;
					return True;
				}
				else if ( $this->Constraints['Default'] === 0 ){

					if ( empty($Value) )
						$this->Error = ' : Select Field is Empty';

					else if ( strlen($Value) < $this->Constraints['Min_Length'] )
						$this->Error = ' : Select Field Size is Smaller Than '.
									$this->Constraints['Min_Length'];

					else if ( strlen($Value) > $this->Constraints['Max_Length'] )
						$this->Error = ' : Select Field Size is Longger Than '.
									$this->Constraints['Max_Length'];

					return False;

				}
				else{
					$this->Value = $this->Constraints['Default'];
					return True;
				}
			}
			else{
				$this->Value = $Value;
				return True;
			}
		}
		else if ( $this->Constraints['Default'] === 0 ){

			if ( empty($Value) )
				$this->Error = ' : Select Field is Empty';

			else if ( strlen($Value) < $this->Constraints['Min_Length'] )
				$this->Error = ' : Select Field Size is Smaller Than '.
						$this->Constraints['Min_Length'];

			else if ( strlen($Value) > $this->Constraints['Max_Length'] )
				$this->Error = ' : Select Field Size is Longger Than '.
						$this->Constraints['Max_Length'];

			return False;
		}
		else{
			$this->Value = $this->Constraints['Default'];
			return True;
		}
	}
}
<?php

namespace FormsFields\FilesTypes;
use FormsFields\FieldEngine;

class FileFieldEngine extends FieldEngine{

	
	public $FieldName = 'File Field';
	public $ClassType = 'FilesTypes';
	public $Type = 'File';
	public $Constraints = [
		'Require' => True,
		'Max_Length' => 1 * 1000 * 1000 * 1000,
		'Min_Length' => 0,
		'File_Extensions' => [],
		'Default' => 0
	];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function SetReturn($File){

		if ( $File['size'] > $this->Constraints['Max_Length'] || $File['error'] !== 0 ||
			 $File['size'] < $this->Constraints['Min_Length'] || $File['tmp_name'] === '' ||
			 $File['name'] === '' ){


			if ( $this->Constraints['Default'] === 0 ){

				if ( $File['error'] !== 0 )
					$this->Error = ' : Error in Uploading File';

				else if ( $File['tmp_name'] === '' )
					$this->Error = ' : File Temprory Location Not Found';

				else if ( $File['name'] === '' )
					$this->Error = ' : File Not Found';

				else if ( $File['size'] < $this->Constraints['Min_Length'] )
					$this->Error = ' : File Size is Smaller Than '.
								$this->Constraints['Min_Length'];

				else if ( $File['size'] > $this->Constraints['Max_Length'] )
					$this->Error = ' : File Size is Longger Than '.
								$this->Constraints['Max_Length'];

				return False;
			}
			
			else{
				$this->Value = [
					'name' => $this->Constraints['Default'],
					'type' => '',
					'tmp_name' => $this->Constraints['Default'],
					'error' => -1,
					'size' => -1,
				];
				return True;
			}
		}
		else{
			if ( sizeof($this->Constraints['File_Extensions']) !== 0 && !in_array(
					strtolower ( pathinfo( $File['name'], PATHINFO_EXTENSION ) ),
					$this->Constraints['File_Extensions']) ){
				
				if ( $this->Constraints['Default'] === 0 ){
					$this->Error = ' : Not Supported File Extension';
					return False;
				}

				else{
					$this->Value = [
						'name' => $this->Constraints['Default'],
						'type' => '',
						'tmp_name' => $this->Constraints['Default'],
						'error' => -1,
						'size' => -1,
					];
					return True;
				}
			}
		}
		$this->Value = $File;
		return True;
	}
}
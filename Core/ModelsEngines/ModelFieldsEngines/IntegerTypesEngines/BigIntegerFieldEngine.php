<?php

namespace ModelFields\IntegerTypes;
use ModelFields\FieldEngine;

class BigIntegerFieldEngine extends FieldEngine{
	

	public $Class = 'Big integer Field';
	public $ClassType = 'IntegerTypes';
	public $Type = 'BIGINT';
	public $Constraints = [
		'Max_Length' => 19,
		'Field_Type' => 'BIG INTEGER',
		'Null' => False,
		'Default' => '',
		'Help_Text' => -1,
		'Primary_Key' => False,
		'Unique' => False,
		'Auto_Increment' => False,
		'Signed' => True
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function BuildNewFieldQuery($Field_Name){

		return " `$Field_Name` BIGINT ( ".$this->Constraints['Max_Length'] .' ) '
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Unique']) ? ' UNIQUE ' : '')
			.( (!$this->Constraints['Signed']) ? ' UNSIGNED ' : '')
			.( ($this->Constraints['Auto_Increment']) ? ' AUTO_INCREMENT ' : '')
			.( ( $this->Constraints['Default'] !== '' ) ? 
					' DEFAULT '.$this->Constraints['Default'] : '' )
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){
		if ( is_numeric($Value) )
			return True;
		return False;
	}
}
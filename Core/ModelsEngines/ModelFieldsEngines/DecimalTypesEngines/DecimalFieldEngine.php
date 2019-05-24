<?php

namespace ModelFields\DecimalTypes;
use ModelFields\FieldEngine;

class DecimalFieldEngine extends FieldEngine{
	

	public $Class = 'Decimal Field';
	public $ClassType = 'DecimalTypes';
	public $Type = 'DECIMAL';
	public $Constraints = [
		'Field_Type' => 'DECIMAL',
		'Max_Length' => 65,
		'Help_Text' => -1,
		'Default' => '',
		'Unique' => False,
		'Primary_Key' => False,
		'Auto_Increment' => False,
		'Null' => True,
		'Signed' => True,
		'Max_Precision_Length' => 3
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function BuildNewFieldQuery($Field_Name){

		return " `$Field_Name` DECIMAL ( ".$this->Constraints['Max_Length'] 
				.','.$this->Constraints['Max_Precision_Length'].' ) '
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
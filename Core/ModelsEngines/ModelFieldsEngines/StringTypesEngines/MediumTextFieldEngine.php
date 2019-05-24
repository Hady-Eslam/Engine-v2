<?php

namespace ModelFields\StringTypes;
use ModelFields\FieldEngine;

class MediumTextFieldEngine extends FieldEngine{
	

	public $Class = 'Medium Text Field';
	public $ClassType = 'StringTypes';
	public $Type = 'MEDIUMTEXT';
	public $Constraints = [
		'Field_Type' => 'MEDIUMTEXT',
		'Max_Length' => 16777215,
		'Help_Text' => -1,
		'Unique' => False,
		'Primary_Key' => False,
		'Null' => False
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function BuildNewFieldQuery($Field_Name){

		return " `$Field_Name` MEDIUMTEXT "
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Unique']) ? ' UNIQUE ' : '')
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){
		if ( !is_object($Value) && !is_array($Value) )
			return True;
		return False;
	}
}
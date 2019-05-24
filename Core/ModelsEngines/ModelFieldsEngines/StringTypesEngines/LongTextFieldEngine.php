<?php

namespace ModelFields\StringTypes;
use ModelFields\FieldEngine;

class LongTextFieldEngine extends FieldEngine{
	

	public $Class = 'Long Text Field';
	public $ClassType = 'StringTypes';
	public $Type = 'LONGTEXT';
	public $Constraints = [
		'Field_Type' => 'LONGTEXT',
		'Max_Length' => 2147483647,
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

		return " `$Field_Name` LONGTEXT "
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
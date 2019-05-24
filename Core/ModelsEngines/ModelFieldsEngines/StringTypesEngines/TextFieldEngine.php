<?php

namespace ModelFields\StringTypes;
use ModelFields\FieldEngine;

class TextFieldEngine extends FieldEngine{
	

	public $Class = 'Text Field';
	public $ClassType = 'StringTypes';
	public $Type = 'TEXT';
	public $Constraints = [
		'Field_Type' => 'TEXT',
		'Max_Length' => 65535,
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

		return " `$Field_Name` TEXT "
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
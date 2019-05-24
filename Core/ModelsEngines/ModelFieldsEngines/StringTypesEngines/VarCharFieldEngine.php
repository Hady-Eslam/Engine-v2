<?php

namespace ModelFields\StringTypes;
use ModelFields\FieldEngine;

class VarCharFieldEngine extends FieldEngine{
	

	public $Class = 'Var Char Field';
	public $ClassType = 'StringTypes';
	public $Type = 'VARCHAR';
	public $Constraints = [
		'Field_Type' => 'VARCHAR',
		'Max_Length' => 255,
		'Help_Text' => -1,
		'Default' => -1,
		'Unique' => False,
		'Primary_Key' => False,
		'Null' => False,
		'Dynamic' => True
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		$this->Check();
	}

	function BuildNewFieldQuery($Field_Name){

		return " `$Field_Name` VARCHAR(".$this->Constraints['Max_Length'].") "
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Unique']) ? ' UNIQUE ' : '')
			.( ( $this->Constraints['Default'] !== -1 ) ? 
				' DEFAULT \''.$this->Constraints['Default'].'\'' : '' )
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){
		if ( !is_object($Value) && !is_array($Value) )
			return True;
		return False;
	}
}
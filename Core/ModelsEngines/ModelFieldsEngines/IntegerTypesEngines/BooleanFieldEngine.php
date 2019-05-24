<?php

namespace ModelFields\IntegerTypes;
use ModelFields\FieldEngine;

class BooleanFieldEngine extends FieldEngine{
	

	public $Class = 'Boolean Field';
	public $ClassType = 'IntegerTypes';
	public $Type = 'BOOLEAN';
	public $Constraints = [
		'Null' => False,
		'Field_Type' => 'BOOLEAN',
		'Default' => '',
		'Help_Text' => ''
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;
	}

	function BuildNewFieldQuery($Field_Name){

		if ( $this->Constraints['Default'] === True )
			$Default = ' DEFAULT 1 ';
		else if ( $this->Constraints['Default'] === False )
			$Default = ' DEFAULT 0 ';
		else
			$Default = '';

		return " `$Field_Name` TINYINT(1) "
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.$Default.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){
		if ( preg_match('/^(0|1)$/', $Value) )
			return True;
		return False;
	}
}
<?php

namespace ModelFields\RelationsTypes;
use ModelFields\FieldEngine;

class DecimalPrimaryKeyFieldEngine extends FieldEngine{
	
	public $Class = 'Primary Key Field';
	public $ClassType = 'RelationsTypes';
	public $Type = 'DECIMAL';
	public $Constraints = [
		'Type' => 'DECIMAL',
		'Field_Type' => 'DECIMAL PRIMARY KEY',
		'Help_Text' => 'This is DECIMAL Field, The Primary Key For The Model',
		'Primary_Key' => True
	];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;
	}

	function BuildNewFieldQuery($Field_Name){
		return " `$Field_Name` DOUBLE NOT NULL AUTO_INCREMENT UNIQUE COMMENT '"
				.$this->Constraints['Help_Text']."',";
	}

	function isValid($Value){
		if ( is_numeric($Value) )
			return True;
		return False;
	}
}
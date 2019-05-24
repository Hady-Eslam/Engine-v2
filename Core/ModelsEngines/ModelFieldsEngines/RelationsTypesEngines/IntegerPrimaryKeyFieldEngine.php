<?php

namespace ModelFields\RelationsTypes;
use ModelFields\FieldEngine;

class IntegerPrimaryKeyFieldEngine extends FieldEngine{
	
	public $Class = 'Primary Key Field';
	public $ClassType = 'RelationsTypes';
	public $Type = 'INT';
	public $Constraints = [
		'Type' => 'INT',
		'Field_Type' => 'INTEGER PRIMARY KEY',
		'Help_Text' => 'This is INT Field, The Primary Key For The Model',
		'Primary_Key' => True
	];

	function __construct($Constraints){
		foreach ($Constraints as $Key => $Value)
			$this->Constraints[$Key] = $Value;
	}

	function BuildNewFieldQuery($Field_Name){
		return " `$Field_Name` INT NOT NULL AUTO_INCREMENT UNIQUE COMMENT '"
				.$this->Constraints['Help_Text']."',";
	}

	function isValid($Value){
		if ( is_numeric($Value) )
			return True;
		return False;
	}
}
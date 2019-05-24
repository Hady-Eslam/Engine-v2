<?php

namespace ModelFields\DateTypes;
use ModelFields\FieldEngine;
use Exceptions\ModelExceptionsEngine;

class TimeFieldEngine extends FieldEngine{
	

	public $Class = 'Time Field';
	public $ClassType = 'DateTypes';
	public $Type = 'TIME';
	public $Constraints = [
		'Field_Type' => 'TIME',
		'Help_Text' => -1,
		'Default' => -1,
		'Unique' => False,
		'Primary_Key' => False,
		'Null' => True
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;

		$this->Check();
		if ( $this->Constraints['Default'] !== -1 ){
			if ( !preg_match('/([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])/',
					$this->Constraints['Default']) )
				throw new ModelExceptionsEngine('Default Date Formate ( ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]) ) ( HH-MM-SS )');
		}
	}

	function BuildNewFieldQuery($Field_Name){

		return " `$Field_Name` TIME "
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Unique']) ? ' UNIQUE ' : '')
			.( ( $this->Constraints['Default'] !== -1 ) ? 
				' DEFAULT \''.$this->Constraints['Default'].'\'' : '' )
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){
		if ( preg_match('/([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])/', $Value) )
			return True;
		return False;
	}
}
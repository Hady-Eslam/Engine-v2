<?php

namespace ModelFields\DateTypes;
use ModelFields\FieldEngine;
use Exceptions\ModelExceptionsEngine;

class DateTimeFieldEngine extends FieldEngine{
	

	public $Class = 'Date Time Field';
	public $ClassType = 'DateTypes';
	public $Type = 'TIMESTAMP';
	public $Constraints = [
		'Field_Type' => 'DATETIME',
		'Help_Text' => -1,
		'Default' => -1,
		'Unique' => False,
		'Primary_Key' => False,
		'Null' => True,
		'Auto_Fill' => False
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;

		$this->Check();
		if ( $this->Constraints['Default'] !== -1 ){
			if ( !preg_match('/\d{4}-(0[0-9]|1[0-2])-([0-2][0-9]|3[01]) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])/',
					$this->Constraints['Default']) )
				throw new ModelExceptionsEngine('Default Date Formate ( \d{4}-(0[0-9]|1[0-2])-([0-2][0-9]|3[01]) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9]) ) ( YYYY-MM-DD HH:MM:SS )');
		}
	}

	function BuildNewFieldQuery($Field_Name){

		if ( $this->Constraints['Default'] !== -1 )
			$Default = ' DEFAULT \''.$this->Constraints['Default'].'\'';
		else if ( $this->Constraints['Auto_Fill'] )
			$Default = ' DEFAULT NOW() ';
		else
			$Default = '';

		return " `$Field_Name` TIMESTAMP(6) "
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Unique']) ? ' UNIQUE ' : '')
			.$Default
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){
		if ( preg_match('/\d{4}-(0[0-9]|1[0-2])-([0-2][0-9]|3[01]) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])/', $Value) )
			return True;
		return False;
	}
}
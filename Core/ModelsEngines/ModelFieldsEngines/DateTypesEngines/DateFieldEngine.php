<?php

namespace ModelFields\DateTypes;
use ModelFields\FieldEngine;
use Exceptions\ModelExceptionsEngine;

class DateFieldEngine extends FieldEngine{
	

	public $Class = 'Date Field';
	public $ClassType = 'DateTypes';
	public $Type = 'DATE';
	public $Constraints = [
		'Field_Type' => 'DATE',
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
			if ( !preg_match('/\d{4}-(0[0-9]|1[0-2])-([0-2][0-9]|3[01])/',
					$this->Constraints['Default']) )
				throw new ModelExceptionsEngine('Default Date Formate ( \d{4}-(0[0-9]|1[0-2])-([0-2][0-9]|3[01]) ) ( YYYY-MM-DD )');
		}
	}

	function BuildNewFieldQuery($Field_Name){
		return " `$Field_Name` DATE "
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Unique']) ? ' UNIQUE ' : '')
			.( ( $this->Constraints['Default'] !== -1 ) ? 
				' DEFAULT \''.$this->Constraints['Default'].'\'' : '' )
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){
		if ( preg_match('/\d{4}-(0[0-9]|1[0-2])-([0-2][0-9]|3[01])/', $Value) )
			return True;
		return False;
	}
}
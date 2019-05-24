<?php

namespace ModelFields\DateTypes;
use ModelFields\FieldEngine;
use Exceptions\ModelExceptionsEngine;

class YearFieldEngine extends FieldEngine{
	

	public $Class = 'Year Field';
	public $ClassType = 'DateTypes';
	public $Type = 'YEAR';
	public $Constraints = [
		'Field_Type' => 'YEAR',
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
			if ( !preg_match('/\d{4}/', $this->Constraints['Default']) )
				throw new ModelExceptionsEngine('Default Date Formate ( \d{4} ) ( YYYY )');
		}
	}

	function BuildNewFieldQuery($Field_Name){
		
		return " `$Field_Name` YEAR(4) "
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Unique']) ? ' UNIQUE ' : '')
			.( ( $this->Constraints['Default'] !== -1 ) ? 
				' DEFAULT \''.$this->Constraints['Default'].'\'' : '' )
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){
		if ( preg_match('/\d{4}/', $Value) )
			return True;
		return False;
	}
}
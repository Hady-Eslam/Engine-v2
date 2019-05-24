<?php

namespace ModelFields\SelectTypes;
use ModelFields\FieldEngine;
use Exceptions\ModelExceptionsEngine;

class EnumFieldEngine extends FieldEngine{
	

	public $Class = 'Enum Field';
	public $ClassType = 'SelectTypes';
	public $Type = 'ENUM';
	public $Constraints = [
		'Field_Type' => 'ENUM',
		'MultiSelect' => False,
		'Help_Text' => -1,
		'Default' => -1,
		'Null' => False,
		'Options' => []
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;

		if ( $this->Constraints['Default'] !== -1 ){

			if ( gettype($this->Constraints['Default']) !== 'string' )
				throw new ModelExceptionsEngine('Defult Value For Enum Field Must Be String');

			else if ( !in_array($this->Constraints['Default'], $this->Constraints['Options']) )
				throw new ModelExceptionsEngine('Defult Value Must Be in The Options Set');
		}
	}

	function BuildNewFieldQuery($Field_Name){
		$Query = " `$Field_Name` ENUM (";

		foreach ($this->Constraints['Options'] as $Value)
			$Query .= " '$Value',";

		return substr($Query, 0, strlen($Query)-1 ).' ) '
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Default']) ?
				' DEFAULT \''.$this->Constraints['Default'].'\'' : '')
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){

		if ( is_object($Value) || is_array($Value) ||
			in_array($this->Constraints['Default'], $this->Constraints['Options']) )
			return False;

		return True;
	}
}
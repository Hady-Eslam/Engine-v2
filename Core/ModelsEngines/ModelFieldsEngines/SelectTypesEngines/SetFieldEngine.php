<?php

namespace ModelFields\SelectTypes;
use ModelFields\FieldEngine;
use Exceptions\ModelExceptionsEngine;

class SetFieldEngine extends FieldEngine{
	

	public $Class = 'Set Field';
	public $ClassType = 'SelectTypes';
	public $Type = 'SET';
	public $Constraints = [
		'Field_Type' => 'SET',
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

			if ( gettype($this->Constraints['Default']) !== 'array' )
				throw new ModelExceptionsEngine('Defult Value For Set Field Must Be Array');

			else if ( array_intersect($this->Constraints['Default'],
					$this->Constraints['Options']) !== $this->Constraints['Default'] )
				throw new ModelExceptionsEngine('Defult Values Must Be in The Options Set');
		}
	}

	function BuildNewFieldQuery($Field_Name){
		$Query = " `$Field_Name` SET (";
		$Default = ' DEFAULT \'';

		foreach ($this->Constraints['Options'] as $Value)
			$Query .= " '$Value',";

		if ( $this->Constraints['Default'] !== -1 ){
			foreach ($this->Constraints['Default'] as $Value)
				$Default .= "$Value,";
			$Default = substr($Default, 0, strlen($Default)-1).'\'';
		}
		else
			$Default = '';

		return substr($Query, 0, strlen($Query)-1 ).' ) '
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.$Default
			.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){

		if ( !is_array($Value) || array_intersect($this->Constraints['Default'],
					$this->Constraints['Options']) !== $this->Constraints['Default'] )
			return False;
		return True;
	}
}
<?php

namespace ModelFields\IntegerTypes;
use ModelFields\FieldEngine;
use Exceptions\ModelExceptionsEngine;

class BitFieldEngine extends FieldEngine{
	

	public $Class = 'Big Field';
	public $ClassType = 'IntegerTypes';
	public $Type = 'BIT';
	public $Constraints = [
		'Max_Length' => 30,
		'Field_Type' => 'BIT',
		'Help_Text' => -1,
		'Default' => '',
		'Unique' => False,
		'Primary_Key' => False,
		'Null' => True
	];

	function __construct($Array){
		foreach ($Array as $Key => $Value)
			$this->Constraints[$Key] = $Value;
		
		$this->Check();

		if ( $this->Constraints['Max_Length'] > 64 )
			throw new ModelExceptionsEngine('Max Length For Bit Field is 64');
	}

	function BuildNewFieldQuery($Field_Name){

		if ( $this->Constraints['Default'] === True )
			$Default = ' DEFAULT 1 ';
		else if ( $this->Constraints['Default'] === False )
			$Default = ' DEFAULT 0 ';
		else
			$Default = '';

		return " `$Field_Name` BIT ( ".$this->Constraints['Max_Length'] .' ) '
			.( ($this->Constraints['Null']) ? '' : ' NOT NULL ')
			.( ($this->Constraints['Unique']) ? ' UNIQUE ' : '')
			.$Default.( ($this->Constraints['Help_Text'] !== -1 ) ? 
				' COMMENT \''.$this->Constraints['Help_Text'].'\',' : ',');
	}

	function isValid($Value){

		if ( preg_match('/^([01]+)$/', $Value) )
			return True;
		return False;
	}
}
<?php

namespace CoreForms;

use FormsFields\IntegerTypes\BooleanFieldEngine;
use FormsFields\IntegerTypes\IntegerFieldEngine;
use FormsFields\IntegerTypes\DecimalFieldEngine;

use FormsFields\DateTypes\DateFieldEngine;
use FormsFields\DateTypes\TimeFieldEngine;
use FormsFields\DateTypes\DateTimeFieldEngine;

use FormsFields\StringTypes\TextFieldEngine;

use FormsFields\SelectTypes\RadioButtonFieldEngine;
use FormsFields\SelectTypes\CheckBoxFieldEngine;
use FormsFields\SelectTypes\SelectFieldEngine;
use FormsFields\SelectTypes\MultiSelectFieldEngine;

use FormsFields\EmailTypes\EmailFieldEngine;

use FormsFields\FilesTypes\FileFieldEngine;
use FormsFields\FilesTypes\ImageFieldEngine;

use Exceptions\FormsExceptionsEngine;

class FormsFieldsEngine{

	// Make Put Default Value if Require is False
	private static $BooleanConstraintsArray = [
		'Require' => True,
		'Default' => False
	];

	private static $IntegerConstraintsArray = [
		'Require' => True,
		'Default' => 0,
		'Min_Value' => 0,
		'Max_Value' => 0,
		'Min_Length' => 0,
		'Max_Length' => 9
	];

	private static $DecimalConstraintsArray = [
		'Require' => True,
		'Default' => 10.5,
		'Min_Value' => 0.0,
		'Max_Value' => 0.0,
		'Min_Length' => 0,
		'Max_Length' => 20
	];

	///////////////////////////////////////////////////////////////////////////////

	private static $DateConstraintsArray = [
		'Require' => True,
		'Default' => ''
	];

	///////////////////////////////////////////////////////////////////////////////

	private static $StringConstraintsArray = [
		'Require' => True,
		'Default' => '',
		'Min_Length' => 0,
		'Max_Length' => 2147483647
	];

	///////////////////////////////////////////////////////////////////////////////

	private static $EmailConstraintsArray = [
		'Require' => True,
		'Default' => '',
		'Min_Length' => 0,
		'Max_Length' => 300
	];

	///////////////////////////////////////////////////////////////////////////////

	private static $RadioButtonConstraintsArray = [
		'Require' => True,
		'Default' => '',
		'Options' => [],
		'Min_Length' => 0,
		'Max_Length' => 2147483647
	];

	private static $CheckBoxConstraintsArray = [];

	private static $MultiSelectConstraintsArray = [
		'Require' => True,
		'Default' => [],
		'Options' => [],
		'Min_Length' => 0,
		'Max_Length' => 2147483647
	];

	///////////////////////////////////////////////////////////////////////////////

	private static $FileConstraintsArray = [
		'Require' => True,
		'Max_Length' => 1 * 1000 * 1000,
		'Min_Length' => 0,
		'File_Extensions' => [
			'jpeg',
			'jpg',
			'png',
			'gif'
		],
		'Default' => 'Image_Path'
	];

	/////////////////////////////////////////////////////////////////////////////////

	private static function GetConstraints($Constraints){
		$Attributes = [];
		foreach ($Constraints as $Constraint){

			if ( !is_array($Constraint) )
				throw new FormsExceptionsEngine(
					'Attribute Should Be Array With Key => Value Pair');

			foreach ($Constraint as $AttributeName => $Attribute)
				$Attributes[$AttributeName] = $Attribute;
		}
		return $Attributes;
	}

	private static function CheckConstraints($Constraints, $ConstraintArray){
		$Constraints = self::GetConstraints($Constraints);
		foreach ($Constraints as $Key => $Value) {
			
			if ( !array_key_exists($Key, $ConstraintArray) )
				throw new FormsExceptionsEngine("Field Have No Sush Attribute ( $Key )");

			else if ( gettype($Value) != gettype($ConstraintArray[$Key]) )
				throw new FormsExceptionsEngine("This Attribute ( $Key ) Should Be ("
					.gettype($ConstraintArray[$Key]).") Type .. Type Found ("
					.gettype($Value).")");
		}
		return $Constraints;
	}

	private static function CheckFilesConstraints($Constraints, $ConstraintArray){
		$Constraints = self::CheckConstraints($Constraints, $ConstraintArray);
		if ( isset($Constraints['File_Extensions']) )
			foreach ($Constraints['File_Extensions'] as $Value)
				if ( gettype($Value) != 'string' )
					throw new FormsExceptionsEngine("( File_Extensions ) Must Be String");
		return $Constraints;
	}
	
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	
	static function BooleanField(...$Constraints){
		return new BooleanFieldEngine(
			self::CheckConstraints($Constraints, self::$BooleanConstraintsArray)
		);
	}

	static function IntegerField(...$Constraints){
		return new IntegerFieldEngine(
			self::CheckConstraints($Constraints, self::$IntegerConstraintsArray)
		);
	}

	static function DecimalField(...$Constraints){
		return new DecimalFieldEngine(
			self::CheckConstraints($Constraints, self::$DecimalConstraintsArray)
		);
	}


	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	static function DateField(...$Constraints){
		return new DateFieldEngine(
			self::CheckConstraints($Constraints, self::$DateConstraintsArray)
		);
	}

	static function TimeField(...$Constraints){
		return new TimeFieldEngine(
			self::CheckConstraints($Constraints, self::$DateConstraintsArray)
		);
	}

	static function DateTimeField(...$Constraints){
		return new DateTimeFieldEngine(
			self::CheckConstraints($Constraints, self::$DateConstraintsArray)
		);
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	static function TextField(...$Constraints){
		return new TextFieldEngine(
			self::CheckConstraints($Constraints, self::$StringConstraintsArray)
		);
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	static function RadioButtonField(...$Constraints){
		return new RadioButtonFieldEngine(
			self::CheckConstraints($Constraints, self::$RadioButtonConstraintsArray)
		);
	}

	static function CheckBoxField(...$Constraints){
		return new CheckBoxFieldEngine(
			self::CheckConstraints($Constraints, self::$CheckBoxConstraintsArray)
		);
	}

	static function SelectField(...$Constraints){
		return new SelectFieldEngine(
			self::CheckConstraints($Constraints, self::$RadioButtonConstraintsArray)
		);
	}

	static function MultiSelectField(...$Constraints){
		return new MultiSelectFieldEngine(
			self::CheckConstraints($Constraints, self::$MultiSelectConstraintsArray)
		);
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	static function EmailField(...$Constraints){
		return new EmailFieldEngine(
			self::CheckConstraints($Constraints, self::$EmailConstraintsArray)
		);
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	static function FileField(...$Constraints){
		return new FileFieldEngine(
			self::CheckFilesConstraints($Constraints, self::$FileConstraintsArray)
		);
	}

	static function ImageField(...$Constraints){
		return new ImageFieldEngine(
			self::CheckFilesConstraints($Constraints, self::$FileConstraintsArray)
		);
	}
}
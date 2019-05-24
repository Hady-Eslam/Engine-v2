<?php

namespace CoreModels;
use Exceptions\ModelExceptionsEngine;

use ModelFields\RelationsTypes\IntegerPrimaryKeyFieldEngine;
use ModelFields\RelationsTypes\DecimalPrimaryKeyFieldEngine;

use ModelFields\IntegerTypes\BitFieldEngine;
use ModelFields\IntegerTypes\BooleanFieldEngine;
use ModelFields\IntegerTypes\SmallIntegerFieldEngine;
use ModelFields\IntegerTypes\MediumIntegerFieldEngine;
use ModelFields\IntegerTypes\IntegerFieldEngine;
use ModelFields\IntegerTypes\BigIntegerFieldEngine;

use ModelFields\DecimalTypes\FloatFieldEngine;
use ModelFields\DecimalTypes\DoubleFieldEngine;
use ModelFields\DecimalTypes\DecimalFieldEngine;

use ModelFields\DateTypes\DateFieldEngine;
use ModelFields\DateTypes\TimeFieldEngine;
use ModelFields\DateTypes\YearFieldEngine;
use ModelFields\DateTypes\DateTimeFieldEngine;

use ModelFields\StringTypes\CharFieldEngine;
use ModelFields\StringTypes\VarCharFieldEngine;
use ModelFields\StringTypes\TextFieldEngine;
use ModelFields\StringTypes\MediumTextFieldEngine;
use ModelFields\StringTypes\LongTextFieldEngine;

use ModelFields\SelectTypes\SetFieldEngine;
use ModelFields\SelectTypes\EnumFieldEngine;


class ModelFieldsEngine{

	private static $PrimaryKeysConstraintsArray = [
		'Type' => '',
		'Help_Text' => ''
	];

	/////////////////////////////////////////////////////////

	private static $BitConstraintsArray = [
		'Max_Length' => 5,
		'Help_Text' => '',
		'Default' => True,
		'Unique' => True,
		'Primary_Key' => True,
		'Null' => False
	];

	private static $BooleanConstraintsArray = [
		'Null' => False,
		'Default' => False,
		'Help_Text' => ''
	];

	private static $IntegerConstraintsArray = [
		'Max_Length' => 11,
		'Help_Text' => '',
		'Default' => 0,
		'Unique' => True,
		'Primary_Key' => True,
		'Auto_Increment' => True,
		'Null' => False,
		'Signed' => True
	];

	private static $DecimalConstraintsArray = [
		'Max_Length' => 11,
		'Help_Text' => '',
		'Default' => 0,
		'Unique' => True,
		'Primary_Key' => True,
		'Auto_Increment' => True,
		'Null' => False,
		'Signed' => True,
		'Max_Precision_Length' => 3
	];

	/////////////////////////////////////////////////////////

	private static $DateConstraintsArray = [
		'Help_Text' => '',
		'Default' => '',
		'Unique' => True,
		'Primary_Key' => True,
		'Null' => False,
		'Auto_Fill' => True
	];

	/////////////////////////////////////////////////////////

	private static $CharConstraintsArray = [
		'Max_Length' => 255,
		'Help_Text' => '',
		'Default' => '',
		'Unique' => False,
		'Primary_Key' => False,
		'Null' => False,
		'Dynamic' => True
	];

	private static $TextConstraintsArray = [
		'Max_Length' => 21474836,
		'Help_Text' => '',
		'Unique' => False,
		'Primary_Key' => False,
		'Null' => False
	];

	/////////////////////////////////////////////////////////

	private static $SetConstraintsArray = [
		'MultiSelect' => False,
		'Help_Text' => '',
		'Default' => '',
		'Null' => False,
		'Options' => []
	];

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////

	private static function GetConstraints($Constraints){
		$Attributes = [];
		foreach ($Constraints as $Value){

			if ( !is_array($Value) )
				throw new ModelExceptionsEngine(
					'Attribute Should Be Array With Key => Value Pair');

			foreach ($Value as $AttributeName => $Attribute)
				$Attributes[$AttributeName] = $Attribute;
		}
		return $Attributes;
	}

	private static function CheckConstraints($Constraints, $ConstraintArray){
		$Constraints = self::GetConstraints($Constraints);
		foreach ($Constraints as $Key => $Value) {
			
			if ( !array_key_exists($Key, $ConstraintArray) )
				throw new ModelExceptionsEngine("Field Have No Sush Attribute ( $Key )");

			else if ( gettype($Value) != gettype($ConstraintArray[$Key]) )
				throw new ModelExceptionsEngine("This Attribute ( $Key ) Should Be ("
					.gettype($ConstraintArray[$Key]).") Type .. Type Found ("
					.gettype($Value).")");
		}
		return $Constraints;
	}

	private static function CheckSetConstraints($Constraints, $ConstraintArray){
		$Constraints = self::GetConstraints($Constraints);
		foreach ($Constraints as $Key => $Value) {
			if ( !array_key_exists($Key, $ConstraintArray) )
				throw new ModelExceptionsEngine("Field Have No Sush Attribute ( $Key )");
		}

		if ( !isset($Constraints['Options']) || gettype($Constraints['Options']) !== 'array' )
			throw new ModelExceptionsEngine('Must Put Options For The Set To Select From Them');

		return $Constraints;
	}

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////

	/**
		Relations Types
	*/

	static function PrimaryKeyField(...$Constraints){
		$Constraints = self::CheckConstraints($Constraints, self::$PrimaryKeysConstraintsArray);
		
		if ( !isset( $Constraints['Type'] ) || $Constraints['Type'] == 'INT' )
			return new IntegerPrimaryKeyFieldEngine($Constraints);
		else if ( $Constraints['Type'] == 'DECIMAL' )
			return new DecimalPrimaryKeyFieldEngine($Constraints);

		throw new ModelExceptionsEngine('Uknown Primary Key Type For Primary Key ( '
			.$Constraints['Type'] .' )');
	}

	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////

	/**
		Integer Types
	*/

	static function BitField(...$Constraints){
		return new BitFieldEngine(
			self::CheckConstraints($Constraints, self::$BitConstraintsArray )
		);
	}

	static function BooleanField(...$Constraints){
		return new BooleanFieldEngine(
			self::CheckConstraints($Constraints, self::$BooleanConstraintsArray)
		);
	}

	static function IntegerField(...$Constraints){

		$Constraints = self::CheckConstraints($Constraints, self::$IntegerConstraintsArray);

		if ( !isset($Constraints['Max_Length']) )
			return new IntegerFieldEngine($Constraints);
		else if ( $Constraints['Max_Length'] < 5 )
			return new SmallIntegerFieldEngine($Constraints);
		else if ( $Constraints['Max_Length'] < 7 )
			return new MediumIntegerFieldEngine($Constraints);
		else if ( $Constraints['Max_Length'] < 11 )
			return new IntegerFieldEngine($Constraints);
		else if ( $Constraints['Max_Length'] < 20 )
			return new BigIntegerFieldEngine($Constraints);

		throw new ModelExceptionsEngine('Integer Length Should be no Longer Than 19 Digit');
	}

	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////
	/**
		Decimal Types
	*/

	static function DecimalField(...$Constraints){
		$Constraints = self::CheckConstraints(
			$Constraints,
			self::$DecimalConstraintsArray
		);

		if ( !isset($Constraints['Max_Precision_Length']) ){	// Defult is 3

			if ( !isset($Constraints['Max_Length']) )
				return new FloatFieldEngine($Constraints);

			else if ( $Constraints['Max_Length'] < 8 )
				return new FloatFieldEngine($Constraints);
			
			else if ( $Constraints['Max_Length'] < 16 )
				return new DoubleFieldEngine($Constraints);
			
			else if ( $Constraints['Max_Length'] < 66 )
				return new DecimalFieldEngine($Constraints);

			throw new ModelExceptionsEngine('Decimal Field Should Be Less Than 66 Digit');
		}
		else{
			if ( !isset($Constraints['Max_Length']) ){

				if ( $Constraints['Max_Precision_Length'] < 7 )
					return new FloatFieldEngine($Constraints);
				
				else if ( $Constraints['Max_Precision_Length'] < 15 )
					return new DoubleFieldEngine($Constraints);
				
				else if ( $Constraints['Max_Precision_Length'] < 30 )
					return new DecimalFieldEngine($Constraints);

				throw new ModelExceptionsEngine('Decimal Precision  Should Be Less Than 31');
			}
			else{

				if ( $Constraints['Max_Precision_Length'] + $Constraints['Max_Length'] < 8 )
					return new FloatFieldEngine($Constraints);
				
				else if ( $Constraints['Max_Precision_Length'] +
					$Constraints['Max_Length'] < 16 )
					return new DoubleFieldEngine($Constraints);
				
				else if ( $Constraints['Max_Precision_Length'] +
					$Constraints['Max_Length'] < 66 )
					return new DecimalFieldEngine($Constraints);

				throw new ModelExceptionsEngine(
					'Decimal Field AND Precision Their Sum Should Be 66 Digit');
			}
		}
	}

	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////
	/**
		Date Types
	*/

	static function DateField(...$Constraints){
		return new DateFieldEngine(
			self::CheckConstraints($Constraints, self::$DateConstraintsArray)
		);
	}

	static function DateTimeField(...$Constraints){
		return new DateTimeFieldEngine(
			self::CheckConstraints($Constraints, self::$DateConstraintsArray)
		);
	}

	static function TimeField(...$Constraints){
		return new TimeFieldEngine(
			self::CheckConstraints($Constraints, self::$DateConstraintsArray)
		);
	}

	static function YearField(...$Constraints){
		return new YearFieldEngine(
			self::CheckConstraints($Constraints, self::$DateConstraintsArray)
		);
	}

	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////
	/**
		String Types
	*/

	static function CharField(...$Constraints){
		$Constraints = self::CheckConstraints($Constraints, self::$CharConstraintsArray);

		if ( isset($Constraints['Max_Length']) && $Constraints['Max_Length'] > 255 )
			throw new ModelExceptionsEngine('Char Field Should Be 255 Character Only');

		if ( !isset($Constraints['Dynamic']) || $Constraints['Dynamic'] == True )
			return new VarCharFieldEngine($Constraints);

		return new CharFieldEngine($Constraints);
	}

	static function TextField(...$Constraints){
		$Constraints = self::CheckConstraints($Constraints, self::$TextConstraintsArray);

		if ( !isset($Constraints['Max_Length']) || $Constraints['Max_Length'] < 65535 )
			return new TextFieldEngine($Constraints);
		else if ( $Constraints['Max_Length'] < 16777215 )
			return new MediumTextFieldEngine($Constraints);
		else if ( $Constraints['Max_Length'] < 2147483647 )
			return new LongTextFieldEngine($Constraints);

		throw new ModelExceptionsEngine('Max Length Should Be 2147483646 Character Only');
	}

	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////

	static function SetField(...$Constraints){
		$Constraints = self::CheckSetConstraints($Constraints, self::$SetConstraintsArray);
		if ( !isset($Constraints['MultiSelect']) || !$Constraints['MultiSelect'] )
			return new EnumFieldEngine($Constraints);
		return new SetFieldEngine($Constraints);
	}
}
<?php

namespace Models;
use CoreModels\ModelEngine;

class Post3Model extends ModelEngine{
	
	function __construct(){

		//$this->ID = ModelEngine::PrimaryKeyField(['Type' => 'INT']);
		/*
			Primary Key Constraints
			
			1. Type => INT/DECIMAL/STRING/TIMESTAMP/BIT
			3. CAN'T HAVE DEFAULT VALUE OR INSERT VALUES INTO IT
			4. Help_Text
		*/
		
		//$this->Bit = ModelEngine::BitField(['Null' => False, 'Primary_Key' => True,
			//'Default' => False, 'Help_Text' => 'Bit Field']);
		/*
			Bit Constraints

			1. Max_Length
			2. Help_Text
			3. Default
			4. UNIQUE
			5. PRIMARY KEY
			8. NULL
		*/
		//$this->Boolean = ModelEngine::BooleanField(['Null' => False, 'Default' => False, 'Help_Text' => 'Boolean Field']);
		/*
			Boolean Constraints

			1. Help_Text
			2. Default
			3. NULL
		*/
		//$this->Integer = ModelEngine::IntegerField(['Max_Length' => 16, 'Primary_Key' => True]);
		/*
			Integer Constraints

			1. Max_Length 	< 19 Digit
			2. Help_Text
			3. Default
			4. UNIQUE
			5. PRIMARY KEY
			6. Min_Length 	> 0 Digit
			7. Auto_Increament
			8. NULL
			9. SIGNED
		*/

		$this->Decimal = ModelEngine::DecimalField(['Max_Length' => 5]);
		$this->Integer = ModelEngine::DateField();
		/*
			Decimal Constraints

			1. Max_Length
			2. Help_Text
			3. Default
			4. UNIQUE
			5. PRIMARY KEY
			7. Auto_Increament
			8. Max_Precision_Length
			9. NULL
			10. SIGNED
		*/

		//$this->Date = ModelEngine::DateField(['Default' => '4444-12-31']);
		/*
			Date Constraints

			1. Help_Text
			2. Default 		=> in Format YYYY-mm-dd
			3. UNIQUE
			4. PRIMARY KEY
			6. NULL
		*/
		//$this->Time = ModelEngine::TimeField();
		/*
			Time Constraints

			2. Help_Text
			3. Default 		=> in Format HH:MM:SS
			4. UNIQUE
			5. PRIMARY KEY
			7. Auto_Fill
			8. NULL
		*/
		//$this->Year = ModelEngine::YearField();
		/*
			Year Constraints

			2. Help_Text
			3. Default 		=> in Format YYYY
			4. UNIQUE
			5. PRIMARY KEY
			7. Auto_Fill
			8. NULL
		*/
		//$this->DateTime = ModelEngine::DateTimeField(['Auto_Fill' => True]);
		/*
			DateTime Constraints

			2. Help_Text
			3. Default 		=> in Format YYYY-mm-dd HH:MM:SS
			4. UNIQUE
			5. PRIMARY KEY
			7. Auto_Fill
			8. NULL
		*/


		//$this->VarChar = ModelEngine::CharField();
		//$this->Char = ModelEngine::CharField(['Dynamic' => False, 'Max_Length' => 50]);
		/*
			Char Constraints

			1. Max_Length
			2. Help_Text
			3. Default
			4. UNIQUE
			5. PRIMARY KEY
			7. Dynamic
			8. NULL
		*/

		//$this->Text = ModelEngine::TextField(['Max_Length' => 214748364]);
		/*
			Text Constraints

			1. Max_Length
			2. Help_Text
			4. UNIQUE
			5. PRIMARY KEY
			7. NULL
		*/
		/*$this->Set = ModelEngine::SetField(['MultiSelect' => True, 'Default' => ['Hello', 'From'],
				'Options' => [
				'Hello',
				'From',
				'Here'
			]
		]);

		$this->Enum = ModelEngine::SetField(['Default' => 'Hello',
			'Options' => [
				'Hello',
				'From',
				'Here'
			]
		]);*/
		/*
			Set Constraints
			
			1. MultiSelect
			2. Help_Text
			3. Default 		=> Depends On The MultiSelect
			4. Options 		=> Must Be Put And is List Of Strings
			5. NULL
		*/
	}
}
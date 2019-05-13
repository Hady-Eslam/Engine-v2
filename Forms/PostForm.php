<?php

namespace Forms;
use CoreForms\FormsEngine;

class PostForm extends FormsEngine{
	

	function __construct(...$Data){


		$this->Boolean = FormsEngine::BooleanField(['Require' => True]);
		$this->Integer = FormsEngine::IntegerField(['Max_Length' => 7,
					'Require' => True]);
/*		$this->Decimal = FormsEngine::DecimalField(['Require' => False, 'Max_Length' => 2,
							'Default' => 50.5]);

		$this->Date = FormsEngine::DateField(['Require' => True, 'Default' => '02-02-2019']);
		$this->Time = FormsEngine::TimeField(['Require' => True, 'Default' => '12:12:25']);
		$this->DateTime = FormsEngine::DateTimeField(['Require' => False,
				'Default' => '02-02-2019 12:12:25']);

		$this->Text = FormsEngine::TextField(['Require' => True, 'Default' => 'Hello']);
		
		$this->RadioButton = FormsEngine::RadioButtonField(['Require' => True,
			'Default' => 'Hady', 'Options' => [
				'Ahmed',
				'Mohamed',
				'Sadiq'
			]
		]);
		$this->CheckBox = FormsEngine::CheckBoxField();
		$this->JJ = FormsEngine::MultiSelectField(['Require' => True,
			'Default' => [
				'Hello',
				'I AM HERE'
			],
			'Options' => [
				'H',
				'HOK'
			]
		]);
		$this->Select = FormsEngine::SelectField(['Require' => True, 'Default' => 'HelloSelect',
			'Options' => [
				'MMM',
				'LLL',
				'sfds'
			]
		]);

		$this->Email = FormsEngine::EmailField(['Require' => True,
			'Default' => 'Hady@gmail.com']);
		$this->File = FormsEngine::FileField(['Require' => True, 
			'Default' => 'Hello World',
			'File_Extensions' => [
				'PP'
			]
		]);
		/*$this->Image = FormsEngine::ImageField(['Require' => False,
			//'Default' => _DIR_.'/OnlineUser.png' ,
			'File_Extensions' => [
				'PNG'
			]
		]);*/

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
		$this->CAN_CONTINUE = True;

		/*
			Data Types
				Input

				Select
					
				TextArea
					Big Text
						{
							'Require' =>
							'Default' => 0,
							'Max_Length_Default'
							'Rows' => '',
								'Rows_Max_Length' =>
								'Rows_Min_Length' =>
							'Columns' => '',
								'Columns_Max_Length' =>
								'Columns_Min_Length' =>
								'Max_Column_Char_Length' => 
							'Max_Char_Length'
						}





				Boolean
				int
				Decimal

				Date
				Time
				DateTime

				Password

				FILTER_VALIDATE_DOMAIN
				FILTER_VALIDATE_IP
				FILTER_VALIDATE_MAC
				FILTER_VALIDATE_REGEXP
				FILTER_VALIDATE_URL

			SELECT
			MULTISELECT
		*/
	}
}
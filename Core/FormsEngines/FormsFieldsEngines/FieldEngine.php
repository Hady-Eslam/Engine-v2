<?php

namespace FormsFields;
use Exceptions\FormsExceptionsEngine;

class FieldEngine{
	
	protected function Check(){

		if ( $this->ClassType == 'IntegerTypes' )
			if ( $this->Type == 'Integer' )
				$this->Check_Integer_Values();
			else
				$this->Check_Decimal_Values();

		else if ( $this->ClassType == 'StringTypes' )
			if ( $this->Type == 'Char' )
				$this->Check_MinMaxLength('Char', 255);
			else
				$this->Check_MinMaxLength('Text', 2147483647);
		
		else if ( $this->ClassType == 'DateTypes' )
			$this->Check_DateTypes();

		else if ( $this->ClassType == 'EmailTypes' )
			$this->Check_EmailTypes();

		else if ( $this->ClassType == 'FilesTypes' )
			$this->Check_FilesTypes();

		else if ( $this->ClassType == 'SelectTypes' )
			$this->Check_MinMaxLength('Select', 2147483647);
	}

	private function Check_MinMaxLength($Type = "Integer", $Max_Length = 9){
		
		if ( $this->Constraints['Min_Length'] < 0 )
			throw new FormsExceptionsEngine("Min Length For $Type Types Should Be 0");

		else if ( $this->Constraints['Max_Length'] < 0 )
			throw new FormsExceptionsEngine(
				"Max Length For $Type Types Should Be Longer Than 0");

		else if ( $this->Constraints['Max_Length'] > $Max_Length )
			throw new FormsExceptionsEngine("Max Length For $Type Types Should Be $Max_Length");
	}

	private function Check_Integer_Values(){
		$this->Check_MinMaxLength();

		if ( $this->Constraints['Min_Value'] != '' &&
			strlen($this->Constraints['Min_Value']) > $this->Constraints['Min_Length'] )
			throw new FormsExceptionsEngine('Min Value ( '.$this->Constraints['Min_Value']
				.' ) Length Should Be Less Than Or Equal To Min Length ( '.
				$this->Constraints['Min_Length'].' )');

		if ( $this->Constraints['Max_Value'] != '' &&
			strlen($this->Constraints['Max_Value']) > $this->Constraints['Max_Length'] )
			throw new FormsExceptionsEngine('Max Value ( '.$this->Constraints['Max_Value']
				.' ) Length Should Be Less Than Or Equal To Max Length ( '.
				$this->Constraints['Max_Length'].' )');
	}

	private function Check_Decimal_Values(){
		$this->Check_MinMaxLength('Decimal', 20);
		
		if ( $this->Constraints['Min_Value'] != '' &&
			strlen(explode('.', $this->Constraints['Min_Value'])[0]) >
				$this->Constraints['Min_Length'] )
			throw new FormsExceptionsEngine('Min Value ( '.$this->Constraints['Min_Value']
				.' ) Length Should Be Less Than Or Equal To Min Length ( '.
				$this->Constraints['Min_Length'].' )');

		if ( $this->Constraints['Max_Value'] != '' &&
			strlen(explode('.', $this->Constraints['Max_Value'])[0]) >
				$this->Constraints['Max_Length'] )

			throw new FormsExceptionsEngine('Max Value ( '.$this->Constraints['Max_Value']
				.' ) Length Should Be Less Than Or Equal To Max Length ( '.
				$this->Constraints['Max_Length'].' )');
	}

	private function Check_DateTypes(){
		if ( $this->Constraints['Default'] === 0 )
			return ;

		if ( $this->Type == 'Date' && 
			!preg_match('/^(\d{2})-(\d{2})-(\d{4})/', $this->Constraints['Default'] ) )
			throw new FormsExceptionsEngine("Date Should Be in The Format Of  { dd-mm-YYYY }");
		
		else if ( $this->Type == 'Time' &&
			!preg_match('/^(\d{2}):(\d{2}):(\d{2})/', $this->Constraints['Default'] ) )
			throw new FormsExceptionsEngine("Date Should Be in The Format Of { HH:ii:ss }");

		else if ( $this->Type == 'DateTime' &&
			!preg_match('/^(\d{2})-(\d{2})-(\d{4}) (\d{2}):(\d{2}):(\d{2})/',
				$this->Constraints['Default'] ) )
			throw new FormsExceptionsEngine(
				"Date Should Be in The Format Of { dd-mm-YYYY HH:ii:ss }");
	}

	private function Check_EmailTypes(){
		
		$this->Check_MinMaxLength("Email", 500);

		if ( $this->Constraints['Default'] === 0 )
			return ;

		if ( !preg_match('/^(.*)@(.*)\.(.*)/', $this->Constraints['Default']) )
			throw new FormsExceptionsEngine("Email Format Should Be String@string.string");
	}

	private function Check_FilesTypes(){
		if ( $this->Type == 'File' )
			$this->Check_MinMaxLength('File', 1 * 1000 * 1000 * 1000 );
		else{
			$this->Check_MinMaxLength('Image', 2 * 1000 * 1000 );

			foreach ($this->Constraints['File_Extensions'] as $Key => $Extension){
				$Extension = strtolower($Extension);
				if ( !in_array($Extension, ['jpeg', 'jpg', 'png', 'gif']) )
					throw new FormsExceptionsEngine(
						"$Extension is Not Supported Image Extensions"
						." ( 'jpeg', 'jpg', 'png', 'gif' )");
				$this->Constraints['File_Extensions'][$Key] = $Extension;
			}
		}
	}

	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////

	function NotSetReturn(){
		if ( $this->ClassType == 'IntegerTypes' )
			return $this->NotSetReturn_Integer();
		else
			return $this->NotSetReturn_All();
	}

	private function NotSetReturn_Integer(){

		if ( $this->Constraints['Require'] == True ){
			$this->Error = ' : This Field is Required';
			return False;
		}
		else if ( $this->Constraints['Default'] !== '' )
			$this->Value = $this->Constraints['Default'];
		else
			$this->Value = NULL;
		return True;
	}

	private function NotSetReturn_All(){
		
		if ( $this->Constraints['Require'] == True ){
			$this->Error = ' : This Field is Required';
			return False;
		}
		else if ( $this->Constraints['Default'] !== 0 )
			$this->Value = $this->Constraints['Default'];
		else
			$this->Value = NULL;
		return True;
	}
}
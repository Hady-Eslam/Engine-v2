<?php

namespace Core;
use Exceptions\TemplateExceptionsEngine;

class TemplateEngine{

	function __construct($Render, $CSRF_Token){

		$this->Render = $Render;
		$this->CSRF_Token = $CSRF_Token;
		$this->CSRF_FOUND = False;
		
		if ( $Render[0] === 'Static' )
			$this->MakeStaticTemplate();
		
		else if ( $Render[0] === 'Static_Render' )
			$this->MakeStaticRenderTemplate();

		else{
			if ( sizeof($Render[1]) == 1 ){
				$this->Status = 'Static';
				if ( is_string($Render[1]) )
					$this->File = $Render[1];
				else
					$this->File = $Render[1][0];
			}
			else if ( sizeof($Render[1]) == 2 ){
				$this->Status = 'Static';
				$this->File = $Render[1][1];
			}
			else if ( sizeof($Render[1]) == 3 ){
				$this->Status = 'Render';
				$this->TemplatePath = $Render[1][1];
				$this->TemplateValues = $Render[1][2];
				$this->TemplateValues['CSRF'] = 
					"<input type='hidden' name='ENGINE_CSRF_Token' value='$CSRF_Token'>";
				$this->CheckArgs();
			}
			else
				throw new TemplateExceptionsEngine('Render Should return Only Two Parameters');
		}
	}

	private function MakeStaticTemplate(){
		if ( file_exists(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->Render[1] ) ){
			$this->Status = 'Static';
			$this->File = file_get_contents(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->Render[1]);
		}
		else if ( file_exists( $this->Render[1] ) ){
			$this->Status = 'Static';
			$this->File = file_get_contents($this->Render[1]);
		}
		else
			throw new TemplateExceptionsEngine('Template Not Found Check if Path ('.
					$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->Render[1]
					.') is Correct');
	}

	private function MakeStaticRenderTemplate(){
		$this->Status = 'Render';
		$this->TemplatePath = $this->Render[2];
		$this->TemplateValues = json_decode($this->Render[1], True);
		$this->CheckArgs();
	}

	private function CheckArgs(){
		if ( !is_string($this->TemplatePath) )
			throw new TemplateExceptionsEngine('Path Argument Should Be String');

		else if ( !is_array($this->TemplateValues) )
			throw new TemplateExceptionsEngine('Template Args Should Be Array');
		
		if ( file_exists(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->TemplatePath ) )
			$this->File = file_get_contents(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->TemplatePath);
		else
			throw new TemplateExceptionsEngine('Template Not Found Check if Path ('.
					$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$this->TemplatePath
					.') is Correct');
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	function BeginParsing(){
		if ( $this->Status !== 'Render' )
			return $this->File;

		return $this->Parse_Template_String( $this->File );
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	private $INSIDE_IF = False;
	private $MATCHED_IF = False;
	private $DO_NOT_STORE = False;
	private $STORE = '';

	private function Parse_Template_String($String){

		$Template = '';
		foreach (preg_split('/(<< .* >>)|(<# .* #>)/', $String, -1,
					PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE)
				as $Value) {

			if ( $this->INSIDE_IF )
				$Template .= $this->Check_IF($Value);
			else{
				if ( preg_match('/<# .* #>/', $Value) );	// Comment Section
				else if ( preg_match('/<< +Load *: *([^ ]*) +>>/', $Value, $Result) )
					$Template .= $this->LoadFilter($Result[1]);
				else if ( preg_match('/<< +include *: *([^ ]*) +>>/', $Value, $Result) )
					$Template .= $this->include($Result[1]);
				else if ( preg_match('/<< +Filter *: *([^ ]*) +>>/', $Value, $Result) )
					$Template .= $this->EmptyArgumentedFilter($Result[1]);
				else if ( preg_match('/<< +Filter *: *([^ ]*) *: *(.*[^ ]) +>>/',
						$Value, $Result ) )
					$Template .= $this->ArgumentedFilter($Result);
				else if ( preg_match('/<< +if +(.*[^ ]) *(==|>=|<=|>|<) *(.*[^ ]) +>>/',
						$Value, $Result) )
					$Template .= $this->IF_Command($Result);
				else if ( preg_match('/<< +elseif +(.*[^ ]) *(==|>=|<=|>|<) *(.*[^ ]) +>>/',
						$Value, $Result) )
					throw new TemplateExceptionsEngine(
						"Excepeted ( << if Variable Operator Value >> ) Found ( $Value )");
				else if ( preg_match('/<< +(.*[^ ]) +>>/', $Value, $Result) )
					$Template .= $this->PrintVariableValue($Result[1]);
				else
					$Template .= $Value;
			}
		}
		return $Template;
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	private function LoadFilter($Filter_Name){
		if ( !file_exists(
			$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES_FILTERS'].$Filter_Name.'.php' ) )

			throw new TemplateExceptionsEngine("Failed To Load Filter ( $Filter_Name )");

		include_once $GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES_FILTERS']
							.$Filter_Name.'.php';
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	private function include($include_Path){
		if ( !file_exists(
			$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].$include_Path.'.html') )
			throw new TemplateExceptionsEngine(
				"Template ( $include_Path ) Not Found in Templates Folder");

		return $this->Parse_Template_String(
					file_get_contents(
						$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].
						$include_Path.'.html'));
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	private function EmptyArgumentedFilter($Filter_Name){

		if ( !function_exists($Filter_Name) )
			throw new TemplateExceptionsEngine("Filter ( $Filter_Name ) Not Found");

		$ReturnValue = call_user_func($Filter_Name);
		if ( is_object($ReturnValue) || is_array($ReturnValue) )
			throw new TemplateExceptionsEngine(
				"Filters Functions ( $Filter_Name ) Must't Return Objects Or Arrays Values");

		return $this->Parse_Template_String( strval($ReturnValue) );
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	private function ArgumentedFilter($Argumented_Filter_Command){

		if ( !function_exists($Argumented_Filter_Command[1]) )
			throw new TemplateExceptionsEngine(
				"Filter ( $Argumented_Filter_Command[1] ) Not Found");

		$Filter_Arguments = explode('-', $Argumented_Filter_Command[2]);
		
		$Args = [];
		foreach ($Filter_Arguments as $Argument) {

			$Value = ltrim(rtrim($Argument));

			if ( $Value[0] == '"' && $Value[strlen($Value)-1] == '"' )
				array_push($Args, substr($Value, 1, strlen($Value)-2));
			else{
				$Var = explode('.', $Value);
				if ( sizeof($Var) == 1 ){
					if ( isset($this->TemplateValues[$Value]) )
						array_push($Args, $this->TemplateValues[$Value]);
					else
						throw new TemplateExceptionsEngine("Args ( $Value ) Not Found");
				}
				else if ( sizeof($Var) == 2 ){
					if ( isset($this->TemplateValues[$Var[0]][$Var[1]]) )
						array_push($Args, $this->TemplateValues[$Var[0]][$Var[1]]);
					else
						throw new TemplateExceptionsEngine("Args ( $Value ) Not Found");
				}
				else
					throw new TemplateExceptionsEngine("Wrong Variable ( $Value ) Syntax");
			}
		}

		$ReturnValue = call_user_func_array($Argumented_Filter_Command[1], $Args);
		if ( is_object($ReturnValue) || is_array($ReturnValue) )
			throw new TemplateExceptionsEngine(
				"Filters Functions ( $Filter_Name ) Must't Return Objects Or Arrays Values");

		return $this->Parse_Template_String( strval($ReturnValue) );
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	private function IF_Command($Tokens){

		$Var = explode('.', $Tokens[1]);
		
		if ( sizeof($Var) == 1 ){

			if ( !isset($this->TemplateValues[$Var[0]]) )
				throw new TemplateExceptionsEngine("Variable ( $Tokens[1] ) Not Found");
			$Value = $this->TemplateValues[$Var[0]];
		}
		else if ( sizeof($Var) == 2 ){

			if ( !isset($this->TemplateValues[$Var[0]][$Var[1]]) )
				throw new TemplateExceptionsEngine("Variable ( $Tokens[1] ) Not Found");
			$Value = $this->TemplateValues[$Var[0]][$Var[1]];
		}
		else
			throw new TemplateExceptionsEngine(
				"Error in Template Variable ( $Tokens[1] ) Syntax");

		if ( $Tokens[3][0] == '"' && $Tokens[3][strlen($Tokens[3])-1] == '"' )
			$this->IF_Compare_String($Value, $Tokens[2],
				substr($Tokens[3], 1, strlen($Tokens[3])-2) );

		else if ( substr($Tokens[3], strlen($Tokens[3])-2) == '()' )
			$this->IF_Compare_Filter($Value, $Tokens[2],
				substr($Tokens[3], 0, strlen($Tokens[3])-2) );

		else
			return $this->IF_Compare_Variable($Value, $Tokens[2], $Tokens[3]);
	}

	private function IF_Compare_String($Value, $Operator, $String){
		if ( $Operator === '==' && $Value != $String ||
			 $Operator === '>=' && $Value < $String ||
			 $Operator === '<=' && $Value > $String ||
			 $Operator === '>' && $Value < $String ||
			 $Operator === '<' && $Value < $String ){

			$this->INSIDE_IF = true;
			$this->MATCHED_IF = false;
		}
		else{
			$this->INSIDE_IF = true;
			$this->MATCHED_IF = true;
		}
	}

	private function IF_Compare_Filter($Value, $Operator, $Filter_Name){
		if ( !function_exists($Filter_Name) )
			throw new TemplateExceptionsEngine("Filter ( $Filter_Name ) Not Found");

		$ReturnValue = call_user_func($Filter_Name);
		$this->IF_Compare_String($Value, $Operator, $ReturnValue);
	}

	private function IF_Compare_Variable($Value, $Operator, $Variable){
		$Var = explode('.', $Variable);

		if ( sizeof($Var) == 1 ){

			if ( !isset($this->TemplateValues[$Variable]) )
				throw new TemplateExceptionsEngine("Variable ( $Variable ) Not Found");
			$Val = $this->TemplateValues[$Variable];
		}
		else if ( sizeof($Var) == 2 ){

			if ( !isset($this->TemplateValues[$Var[0]][$Var[1]]) )
				throw new TemplateExceptionsEngine("Variable ( $Variable ) Not Found");
			$Val = $this->TemplateValues[$Var[0]][$Var[1]];
		}
		else
			throw new TemplateExceptionsEngine(
				"Error in Template Variable ( $Variable ) Syntax");

		$this->IF_Compare_String($Value, $Operator, $Val);
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	private function PrintVariableValue($Variable){
		if ( $Variable == 'CSRF' ){
			$this->CSRF_FOUND = True;
			return $this->TemplateValues['CSRF'];
		}

		$Var = explode('.', $Variable);

		if ( sizeof($Var) == 1 ){

			if ( !isset($this->TemplateValues[$Variable]) )
				throw new TemplateExceptionsEngine("Variable ( $Variable ) Not Found");

			else if ( is_object( $this->TemplateValues[$Variable] ) ||
						is_array( $this->TemplateValues[$Variable]) )
				throw new TemplateExceptionsEngine(
					"Variable ( $Variable ) is Object Or Array So Can't Print The Value Of it");

			return $this->TemplateValues[$Variable];
		}
		else if ( sizeof($Var) == 2 ){

			if ( !isset($this->TemplateValues[$Var[0]][$Var[1]]) )
				throw new TemplateExceptionsEngine("Variable ( $Variable ) Not Found");

			else if ( is_object( $this->TemplateValues[$Var[0]][$Var[1]] ) ||
						is_array( $this->TemplateValues[$Var[0]][$Var[1]] ) )
				throw new TemplateExceptionsEngine(
					"Variable ( $Variable ) is Object Or Array So Can't Print The Value Of it");

			return $this->TemplateValues[$Var[0]][$Var[1]];
		}
		else
			throw new TemplateExceptionsEngine(
				"Error in Template Variable ( $Variable ) Syntax");
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////

	private function Check_IF($String){

		if ( !$this->MATCHED_IF ){

			if ( preg_match('/<< +endif +>>/', $String) ){
				$this->INSIDE_IF = false;
				$this->MATCHED_IF = false;
				$this->STORE = '';
				$this->DO_NOT_STORE = false;
				return ;
			}
			else if ( preg_match('/<< +else +>>/', $String) ){
				$this->MATCHED_IF = true;
				return ;
			}
			else if ( preg_match('/<< +elseif +(.*[^ ]) *(==|>=|<=|>|<) *(.*[^ ]) +>>/',
					$String, $Result) )
				return $this->IF_Command($Result);
		}
		else
			return $this->MATCHED_IF($String);
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////


	private function MATCHED_IF($Value){

		if ( !$this->DO_NOT_STORE ){

			if ( preg_match('/<< +endif +>>/', $Value) ){
				$this->INSIDE_IF = false;
				$this->MATCHED_IF = false;
				$this->DO_NOT_STORE = false;
				$Template = $this->Parse_Template_String( $this->STORE );
				$this->STORE = '';
				return $Template;
			}
			else if ( preg_match('/<< +elseif +(.*[^ ]) *(==|>=|<=|>|<) *(.*[^ ]) +>>/',
				$Value) )
				$this->DO_NOT_STORE = true;
			else if ( preg_match('/<< +else +>>/', $Value) )
				$this->DO_NOT_STORE = true;
			else
				$this->STORE .= $Value;
		}
		else
			if ( preg_match('/<< +endif +>>/', $Value) ){
				$this->INSIDE_IF = false;
				$this->MATCHED_IF = false;
				$this->DO_NOT_STORE = false;
				$Template = $this->Parse_Template_String( $this->STORE );
				$this->STORE = '';
				return $Template;
			}
	}

	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////

	function FlushTemplate($Template){
		//print_r($Template);
		echo $Template;
		//var_dump($Template);
	}

	function GET_CSRF(){
		return ( !$this->CSRF_FOUND ) ? NULL : $this->CSRF_Token;
	}
}

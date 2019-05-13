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

		return preg_replace_callback('/<< (.*) >>|<# (.*) #>/', function ($Text){
			//var_dump($Text);
			if ( $Text[0][1] == '#' )
				return '';

			return $this->Filter_Data($Text[1]);
		}, $this->File);
	}

	private function Filter_Data($TextBefore){
		//var_dump($TextBefore);
		$Text = explode(':', $TextBefore);


		if ( $Text[0] == 'include ' )
			return $this->include($Text);

		else if ( $Text[0] == 'Filter ' )
			return $this->TemplateFilter($Text);

		else if ( $Text[0] == 'Load ')
			return $this->LoadFilter($Text);

		else if ( !empty( ltrim($TextBefore) ) )
			return $this->PrintValue($Text[0]);
		
		else
			throw new TemplateExceptionsEngine("UnDefined Template Command");
	}

	private function PrintValue($Variable){
		if ( $Variable == 'CSRF' ){
			$this->CSRF_FOUND = True;
			return $this->TemplateValues['CSRF'];
		}

		$Var = explode('.', $Variable);

		if ( sizeof($Var) == 1 ){

			if ( !isset($this->TemplateValues[$Variable]) )
				throw new TemplateExceptionsEngine("Variable ( $Variable ) Not Found");
			return $this->TemplateValues[$Variable];
		}
		else if ( sizeof($Var) == 2 ){

			if ( !isset($this->TemplateValues[$Var[0]][$Var[1]]) )
				throw new TemplateExceptionsEngine("Variable ( $Variable ) Not Found");
			return $this->TemplateValues[$Var[0]][$Var[1]];
		}
		else
			throw new TemplateExceptionsEngine(
				"Error in Template Variable ( $Variable ) Syntax ");
	}

	private function LoadFilter($Text){
		if ( sizeof($Text) != 2 )
			throw new TemplateExceptionsEngine(
				"NOT Valid Template Load Filter Syntax << Load : Filter_Module_Path >>");

		else if ( !file_exists(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES_FILTERS'].
							ltrim($Text[1]).'.php'))
			throw new TemplateExceptionsEngine(
				"Filter ( $Text[1] ) Not Found in TemplatesFilters Folder");

		include_once $GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES_FILTERS']
					.ltrim($Text[1]).'.php';
	}

	private function TemplateFilter($Text){
		if ( sizeof($Text) != 3 )
			return $this->TemplateFilter_2($Text);
		
		$Text[1] = ltrim(rtrim($Text[1]));

		$Text[2] = explode('-', $Text[2]);
		$Args = [];
		foreach ($Text[2] as $Value) {
			$Value = ltrim(rtrim($Value));
			if ( substr($Value, 0, 1) == '"' && substr($Value, strlen($Value)-1, 1) == '"' )
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

		$Values = call_user_func_array($Text[1], $Args);
		if ( is_object($Values) || is_array($Values) )
			throw new TemplateExceptionsEngine(
				"Filters Functions ( $Text[1] ) Must't Return Objects Or Arrays Values");

		$Values = strval($Values);
		return preg_replace_callback('/<< (.*) >>|<# (.*) #>/', function ($Text){

			if ( $Text[0][1] == '#' )
				return '';

			return $this->Filter_Data($Text[1]);
		},	$Values );
	}

	private function TemplateFilter_2($Text){
		if ( sizeof($Text) != 2 )
			throw new TemplateExceptionsEngine(
				"NOT Valid Template Filter Syntax << Filter : Filter_Name : "
				."FilterArgs , ... >> <br><br> OR << Filter : Filter_Name >> ");
		
		$Values = call_user_func(ltrim(rtrim($Text[1])));
		if ( !is_string($Values) )
			throw new TemplateExceptionsEngine(
				"Filters Functions ($Text[1]) Must Return Only String Values");

		return preg_replace_callback('/<< (.*) >>|<# (.*) #>/', function ($Text){
			
			if ( $Text[0][1] == '#' )
				return '';

			return $this->Filter_Data($Text[1]);
		},	$Values );	

	}

	private function include($Text){
		if ( sizeof($Text) != 2 )
			throw new Exception(
				"NOT Valid Template include Syntax << include : Template_Name >>");

		else if ( 
			!file_exists($GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].ltrim($Text[1])) )
			throw new TemplateExceptionsEngine(
					"Template ( $Text[1] ) Not Found in Template Folder");

		return preg_replace_callback('/<< (.*) >>|<# (.*) #>/', function ($Text){

			if ( $Text[1][0] == '#' )
				return '';

			return $this->Filter_Data($Text[1]);
		},	file_get_contents(
				$GLOBALS['_Configs_']['_AppConfigs_']['TEMPLATES'].ltrim($Text[1]) ) );
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

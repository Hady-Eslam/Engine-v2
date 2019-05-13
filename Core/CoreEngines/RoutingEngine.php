<?php

namespace Core;
use Exceptions\RoutingExceptionsEngine;

class RoutingEngine{

	private $Schema;

	function __construct($SCHEMA, $Page_404, $Page_401, $URL){
		$this->URL = $URL;
		$this->Page_404 = [
			'Type' => 'Static',
			'Value' => '<static>'.$Page_404
		];
		$this->Page_401 = [
			'Type' => 'Static',
			'Value' => '<static>'.$Page_401
		];
		$this->Schema = include_once $SCHEMA;
		$this->Values = [];
		$this->Result = $this->BeginRouting();
	}

	private function BeginRouting(){
		if ( !is_array($this->Schema) )
			throw new RoutingExceptionsEngine(
				'Error in Schema Format : Schema Should Be Key => Value Pair Array');
		
		return $this->GetPath();
	}

	private function GetPath(){
		
		while (True) {

			$URLPart = explode('/', $this->URL, 2);
			$Matched = False;
			$Matched_Value = NULL;
			
			foreach ($this->Schema as $Key => $Value) {
				
				$Key = strval($Key);
			
				if ( $Key === '404' )
					$this->Put404Page($Value);

				else if ( $Key === '401' )
					$this->Put401Page($Value);

				// Check BOOLEAN
				else if ( $Key === '<boolean>' ){
					if ( $this->Handle_BOOLEAN($URLPart[0]) ){
						$Matched = True;
						$Matched_Value = $Value;
						break;
					}
				}

				// Check INT
				else if ( preg_match('/^<int>|<int\((\d+)\)>$/', $Key, $Result) ){
					if ( $this->Handle_INT($Result, $URLPart[0]) ){
						$Matched = True;
						$Matched_Value = $Value;
						break;
					}
				}

				// Check STRING
				else if ( preg_match('/^<string>|<string\((\d+)\)>$/', $Key, $Result) ){
					if ( $this->Handle_STRING($Result, $URLPart[0]) ){
						$Matched = True;
						$Matched_Value = $Value;
						break;
					}
				}

				// Check DOUBLE
				else if ( preg_match(
						'/^<double>|<double\((\d+)\)>|<double\((\d+)\,(\d+)\)>$/',
						$Key, $Result) 
				){
					if ( $this->Handle_DOUBLE($Result, $URLPart[0]) ){
						$Matched = True;
						$Matched_Value = $Value;
						break;
					}
				}
				
				else if ( $Key == $URLPart[0] ){
					$Matched = True;
					$Matched_Value = $Value;
					break;
				}
			}
			
			if ( !$Matched )
				//return $this->ErrorPage;
				return ['NotFound'];
			else{
				if ( sizeof($URLPart) == 1 ){
					if ( is_string($Matched_Value ) )
						//return $Matched_Value;
						return ['Found', $Matched_Value];
					
					else if ( array_key_exists('', $Matched_Value) )
						//return $Matched_Value[''];
						return ['Found', $Matched_Value['']];

					//return $this->ErrorPage;
					return ['NotFound'];
				}
				else
					if ( is_string($Matched_Value) )
						//return $this->ErrorPage;
						return ['NotFound'];
			}
			$this->Schema = $Matched_Value;
			$this->URL = $URLPart[1];
		}
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	private function Handle_INT($Result, $URL){
		
		if ( sizeof($Result) === 1 ){
			if ( preg_match('/^(\d+)$/', $URL) ){
				array_push($this->Values, $URL);
				return True;
			}
		}

		else if ( preg_match('/^(\d{'.$Result[1].'})$/', $URL, $Result) ){
			array_push($this->Values, $Result[0]);
			return True;
		}

		return False;
	}

	private function Handle_STRING($Result, $URL){
		
		if ( sizeof($Result) === 1 ){
			array_push($this->Values, $URL);
			return True;
		}

		else if ( preg_match('/^(.{'.$Result[1].'})$/', $URL, $Result) ){
			array_push($this->Values, $Result[0]);
			return True;
		}

		return False;
	}

	private function Handle_DOUBLE($MainResult, $URL){

		if ( sizeof($MainResult) === 1 ){
			if ( preg_match('/^(\d+)(\.(\d+))?$/', $URL) ){
				array_push($this->Values, $URL);
				return True;
			}
		}

		else if ( sizeof($MainResult) === 2 ){

			if ( preg_match('/^(\d{'.$MainResult[1].'})(\.(\d+))?$/', $URL, $Result) ){
				array_push($this->Values, $Result[0]);
				return True;
			}
		}

		else if ( preg_match('/^(\d{'.$MainResult[2].'})(\.(\d{'.$MainResult[3].'}))?$/',
				$URL, $Result) ){
			array_push($this->Values, $Result[0]);
			return True;
		}

		return False;
	}

	private function Handle_BOOLEAN($URL){
		if ( preg_match('/^([01]|[tT]rue|[fF]alse)$/', $URL) ){
			array_push($this->Values, $URL);
			return True;
		}
		return False;
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////


	private function Put404Page($Value){
		if ( strtolower( array_slice(explode('.', $Value), -1)[0] ) === 'html' )
			$this->Page_404 = [
				'Type' => 'Static',
				'Value' => $Value
			];
		else
			$this->Page_404 = [
				'Type' => 'Render',
				'Value' => $Value
			];
	}

	private function Put401Page($Value){
		if ( strtolower( array_slice(explode('.', $Value), -1)[0] ) === 'html' )
			$this->Page_401 = [
				'Type' => 'Static',
				'Value' => $Value
			];
		else
			$this->Page_401 = [
				'Type' => 'Render',
				'Value' => $Value
			];
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	function GetResult(){
		if ( $this->Result[0] == 'NotFound' )
			return [
				'Result' => 'NotFound',
				'404' => $this->Page_404,
				'401' => $this->Page_401,
				'Data' => [
					'Path' => '',
					'Values' => $this->Values
				]
			];
		return [
			'Result' => 'Found',
			'404' => $this->Page_404,
			'401' => $this->Page_401,
			'Data' => [
				'Path' => $this->Result[1],
				'Values' => $this->Values
			]
		];
	}
}
<?php

namespace Core;
use Exceptions\ViewsExceptionsEngine;

class ViewsEngine{
	
	function __construct($ViewsPath, $RoutingResult){
		
		$this->ViewsPath = $ViewsPath;
		$this->Values = $RoutingResult['Data']['Values'];
		$this->RoutingResult = $RoutingResult;
		
		if ( $RoutingResult['Result'] === 'Found' )
			$this->Check_Routing_Return($RoutingResult['Data']['Path']);

		else if ( $RoutingResult['Result'] === 'NotFound' )
			$this->Check_Routing_Return($RoutingResult['404']['Value']);
		
		else
			$this->Check_Routing_Return($RoutingResult['401']['Value']);
	}

	private function Check_Routing_Return($Path){

		if ( preg_match('/^<static>(.*)$/', $Path, $Result) )
			$this->ViewType = ['Static', $Result[1]];
		
		else if ( preg_match('/^<static:(.*)>(.*)$/', $Path, $Result) )
			$this->ViewType = ['Static_Render', $Result[1], $Result[2]];
		
		else
			$this->CheckView($Path);
	}

	private function CheckView($Path){

		$View = explode('.', $Path);

		if ( sizeof( $View ) != 2 )
			throw new ViewsExceptionsEngine('Error in SCHEMA View Syntax : '.$Path);

		if ( $this->ViewsPath == '' )
			$this->ViewsPath = _DIR_.'/Views/';

		if ( !file_exists($this->ViewsPath.$View[0].'.php') )
			throw new ViewsExceptionsEngine('View Not Found in Path ( '.
					$this->ViewsPath.$View[0].'.php )');
		else
			include_once $this->ViewsPath.$View[0].'.php';


		$this->ViewType = ['Done', $View[1]];
	}

	function TurnViewOn($Request){

		if ( $this->ViewType[0] !== 'Done' )
			return $this->ViewType;

		/*
			Check if View is class or not
		*/

		if ( function_exists($this->ViewType[1]) ){
			array_unshift($this->Values, $Request);
			include_once _DIR_.'/Configs/UserConfigs.php';
			$Render = call_user_func_array($this->ViewType[1], $this->Values);
		}
		else if ( class_exists($this->ViewType[1]) ){

			$ViewClass = new $this->ViewType[1];
			if ( !method_exists($ViewClass, 'POST') ||
				 !method_exists($ViewClass, 'GET') ||
				 !method_exists($ViewClass, 'ALL') )
				throw new ViewsExceptionsEngine(
					'Class View Must Have These Methods ( GET - POST - ALL )');

			include_once _DIR_.'/Configs/UserConfigs.php';
			if ( $Request->isPOST() && method_exists($ViewClass, 'POST') ){
				array_unshift($this->Values, $Request);
				$Render = call_user_func_array(array($ViewClass, 'POST'), $this->Values);
			}

			else if ( $Request->isGET() && method_exists($ViewClass, 'GET') ){
				array_unshift($this->Values, $Request);
				$Render = call_user_func_array(array($ViewClass, 'GET'), $this->Values);
			}

			else{
				array_unshift($this->Values, $Request);
				$Render = call_user_func_array(array($ViewClass, 'ALL'), $this->Values);
			}
		}
		else
			throw new ViewsExceptionsEngine('View Not Found in The Script');

		return ['Done', $Render];
	}
}
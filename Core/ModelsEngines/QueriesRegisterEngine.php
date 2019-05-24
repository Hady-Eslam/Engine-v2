<?php

namespace CoreModels;
use Exceptions\ModelExceptionsEngine;

class QueriesRegisterEngine{

	private $Queries = [];
	private $Queries_Result = [];
	private $Position = 0;
	private $QueriesNumber = 0;
	private $Query = [];
	private $PDO = NULL;
	private $PDO_NOT_NULL;

	function __construct($PDO = NULL){
		$this->PDO_NOT_NULL = ( $PDO !== NULL ) ? True : False;
		$this->PDO = $PDO;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	function RegisterQuery($QueryType, $Fields, $QueryNumber, $ModelObject = NULL){

		if ( !$this->PDO_NOT_NULL )
			throw new ModelExceptionsEngine('Error in Making DataBase Connection');


		if ( $QueryNumber == -1 )
				return $this->NewQuery($QueryType, $Fields, $ModelObject);

		$this->Queries[$QueryNumber]['Queries'][$QueryType] = [ 'QueryFields' => $Fields ];
		return $QueryNumber;
	}

	private function NewQuery($QueryType, $Fields, $Model_Object){
		$QueryNumber = $this->QueriesNumber;
		$this->QueriesNumber++;

		$this->Queries[$QueryNumber] = [
			'Model_Object' => $Model_Object,
			'Queries' => [ $QueryType =>[ 'QueryFields' => $Fields ] ] ];

		return $QueryNumber;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	function GetQueryResult($Query_Number){
		if ( isset($this->Queries_Result[$Query_Number]) )
			return $this->Queries_Result[$Query_Number];
		$this->InvokeQueries();
		//var_dump($this->Query);
		$this->ExcuteQueries();
		return $this->Queries_Result[$Query_Number];
	}

	private function InvokeQueries(){

		for ( $i = $this->Position ; $i < $this->QueriesNumber; $i++){

			if ( isset($this->Queries[$i]['Queries']['Insert']) )
				$this->InsertFields($i);

			else if ( isset($this->Queries[$i]['Queries']['Delete']) )
				$this->DeleteFields($i);

			else if ( isset($this->Queries[$i]['Queries']['Update']) )
				$this->UpdateFields($i);

			else if ( isset($this->Queries[$i]['Queries']['Select']) )
				$this->SelectFields($i);

			/////////////////////
			else if ( isset($this->Queries[$i]['Queries']['Where']) )
				$this->WhereFields($i);

			else if ( isset($this->Queries[$i]['Queries']['GroupBy']) )
				$this->GroupByFields($i);

			else if ( isset($this->Queries[$i]['Queries']['Having']) )
				$this->HavingFields($i);

			else if ( isset($this->Queries[$i]['Queries']['OrderBy']) )
				$this->OrderByFields($i);

			else if ( isset($this->Queries[$i]['Queries']['Limit']) )
				$this->LimitFields($i);
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function InsertFields($i){
		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = "INSERT INTO `$Model_Name` (";
		$ValueQuery = 'VALUES(';
		foreach ($this->Queries[$i]['Queries']['Insert']['QueryFields'][0]
				as $Field_Name => $Field_Value){

			if ( !isset($Model_Fields[$Field_Name]) )
				throw new ModelExceptionsEngine(
					"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

			else if ( !$Model_Fields[$Field_Name]->isValid($Field_Value) )
				throw new ModelExceptionsEngine(
					"Not Valid Value For Field ( $Field_Name ) in Model ( $Model_Name )");

			$Query .= " `$Field_Name`,";
			$ValueQuery .= ' ?,';
			$Values[] = $Field_Value;
		}

		if ( $Query === "INSERT INTO `$Model_Name` (" ){
			$this->Query[$i]['Type'] = 'INSERT';
			$this->Query[$i]['String'] = "INSERT INTO `Model_Name`() VALUES()";
			$this->Query[$i]['Values'] = [];
		}

		else{
			$this->Query[$i]['Type'] = 'INSERT';
			$this->Query[$i]['String'] = substr($Query, 0, strlen($Query)-1).' ) '
				.substr($ValueQuery, 0, strlen($ValueQuery)-1 ).' )';

			$this->Query[$i]['Values'] = $Values;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function DeleteFields($i){

		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = "DELETE FROM `$Model_Name` ";
		$Values = [];

		$Delete = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$DeleteQuery = ' WHERE ';
			foreach ($Value as $Statment) {
				if ( preg_match('/^ *(.*[^ ]) *(=|>|<|!=|<>|>=|<=) *(.*[^ ]) *$/', $Statment,
						$Result) ){

					if ( !isset($Model_Fields[$Result[1]]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Result[1] )");

					$DeleteQuery .= "`$Result[1]` $Result[2] ?  AND ";
					$Values[] = $Result[3];
				}
				else
					throw new ModelExceptionsEngine(
						"UnKnown Where Statment ( $Statment ) in Delete Statment");
			}

			if ( $DeleteQuery === ' WHERE ' )
				return '';

			return substr($DeleteQuery, 0, strlen($DeleteQuery)-4 );
		};

		$OrderBy = function ($Value, &$Model_Fields, &$Model_Name){

			$OrderQuery = ' ORDER BY ';
			foreach ($Value as $Statment) {

				if ( $Statment[0] === '-' ){
					$Field_Name = substr($Statment, 1);
					if ( !isset($Model_Fields[$Field_Name]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

					$OrderQuery .= " `$Field_Name` DESC,";
				}
				else{
					if ( !isset($Model_Fields[$Statment]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Statment )");

					$OrderQuery .= " `$Statment`,";
				}
			}

			if ( $OrderQuery === ' ORDER BY ' )
				return '';

			return substr($OrderQuery, 0, strlen($OrderQuery)-1 );
		};

		$Limit = function ($Value){
			return ' LIMIT '.$Value['Arg1'].(($Value['Arg2']!==NULL)?', '.$Value['Arg2'] : '');
		};

		foreach ($this->Queries[$i]['Queries'] as $Key => $Value){

			if ( $Key == 'Delete' )
				$Query .= $Delete($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'OrderBy' )
				$Query .= $OrderBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Limit' )
				$Query .= $Limit($Value['QueryFields']);
		}

		$this->Query[$i]['Type'] = 'DELETE';

		if ( $Query === "DELETE FROM `$Model_Name` " ){
			$this->Query[$i]['Values'] = [];
			$this->Query[$i]['String'] = "DELETE FROM `$Model_Name`";
		}

		else{
			$this->Query[$i]['Values'] = $Values;
			$this->Query[$i]['String'] = $Query;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function UpdateFields($i){

		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = "UPDATE `$Model_Name` ";
		$Values = [];

		$Update = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$UpdateQuery = ' SET ';
			foreach ($Value[0] as $Field_Name => $Field_Value){

				if ( !isset($Model_Fields[$Field_Name]) )
					throw new ModelExceptionsEngine(
						"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

				else if ( !$Model_Fields[$Field_Name]->isValid($Field_Value) )
					throw new ModelExceptionsEngine(
						"Not Valid Value For Field ( $Field_Name ) in Model ( $Model_Name )");

				$UpdateQuery .= "`$Field_Name` = ?,";
				$Values[] = $Field_Value;
			}

			if ( $UpdateQuery === ' SET ' )
				throw new ModelExceptionsEngine('UPDATE Statment Must Have Values To Change');

			return substr($UpdateQuery, 0, strlen($UpdateQuery)-1 );
		};

		$Where = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$WhereQuery = ' WHERE ';
			foreach ($Value as $Statment) {
				if ( preg_match('/^ *(.*[^ ]) *(=|>|<|!=|<>|>=|<=) *(.*[^ ]) *$/', $Statment,
						$Result) ){

					if ( !isset($Model_Fields[$Result[1]]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Result[1] )");

					$WhereQuery .= "`$Result[1]` $Result[2] ?  AND ";
					$Values[] = $Result[3];
				}
				else
					throw new ModelExceptionsEngine(
						"UnKnown Where Statment ( $Statment ) in Delete Statment");
			}

			if ( $WhereQuery === ' WHERE ' )
				return '';

			return substr($WhereQuery, 0, strlen($WhereQuery)-4 );
		};

		$OrderBy = function ($Value, &$Model_Fields, &$Model_Name){

			$OrderQuery = ' ORDER BY ';
			foreach ($Value as $Statment) {

				if ( $Statment[0] === '-' ){
					$Field_Name = substr($Statment, 1);
					if ( !isset($Model_Fields[$Field_Name]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

					$OrderQuery .= " `$Field_Name` DESC,";
				}
				else{
					if ( !isset($Model_Fields[$Statment]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Statment )");

					$OrderQuery .= " `$Statment`,";
				}
			}

			if ( $OrderQuery === ' ORDER BY ' )
				return '';

			return substr($OrderQuery, 0, strlen($OrderQuery)-1 );
		};

		$Limit = function ($Value){
			return ' LIMIT '.$Value['Arg1'].(($Value['Arg2']!==NULL)?', '.$Value['Arg2'] : '');
		};

		foreach ($this->Queries[$i]['Queries'] as $Key => $Value){

			if ( $Key == 'Update' )
				$Query .= $Update($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'Where' )
				$Query .= $Where($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'OrderBy' )
				$Query .= $OrderBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Limit' )
				$Query .= $Limit($Value['QueryFields']);
		}

		$this->Query[$i]['Type'] = 'UPDATE';
		$this->Query[$i]['Values'] = $Values;
		$this->Query[$i]['String'] = $Query;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function SelectFields($i){

		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = 'SELECT';
		$Values = [];

		$Select = function ($Value, &$Model_Fields, &$Model_Name){

			$SelectQuery = '';
			foreach ($Value as $Field_Name){

				if ( !isset($Model_Fields[$Field_Name]) )
					throw new ModelExceptionsEngine(
						"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

				$SelectQuery .= " `$Field_Name`,";
			}

			if ( $SelectQuery === '' )
				return " * FROM `$Model_Name` ";

			return substr($SelectQuery, 0, strlen($SelectQuery)-1 )." FROM `$Model_Name` ";
		};

		$Where = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$WhereQuery = ' WHERE ';
			foreach ($Value as $Statment) {
				if ( preg_match('/^ *(.*[^ ]) *(=|>|<|!=|<>|>=|<=) *(.*[^ ]) *$/', $Statment,
						$Result) ){

					if ( !isset($Model_Fields[$Result[1]]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Result[1] )");

					$WhereQuery .= "`$Result[1]` $Result[2] ?  AND ";
					$Values[] = $Result[3];
				}
				else
					throw new ModelExceptionsEngine(
						"UnKnown Where Statment ( $Statment ) in Select Statment");
			}

			if ( $WhereQuery === ' WHERE ' )
				return '';

			return substr($WhereQuery, 0, strlen($WhereQuery)-4 );
		};

		$GroupBy = function ($Value, &$Model_Fields, &$Model_Name){

			$GroupByQuery = ' GROUP BY ';
			foreach ($Value as $Field_Name){

				if ( !isset($Model_Fields[$Field_Name]) )
					throw new ModelExceptionsEngine(
						"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

				$GroupByQuery .= " `$Field_Name`,";
			}

			if ( $GroupByQuery === ' GROUP BY ' )
				return '';

			return substr($GroupByQuery, 0, strlen($GroupByQuery)-1 );
		};

		$Having = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$HavingQuery = ' HAVING ';
			foreach ($Value as $Statment) {
				if ( preg_match('/^ *(.*[^ ]) *(=|>|<|!=|<>|>=|<=) *(.*[^ ]) *$/', $Statment,
						$Result) ){

					if ( !isset($Model_Fields[$Result[1]]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Result[1] )");

					$HavingQuery .= "`$Result[1]` $Result[2] ?  AND ";
					$Values[] = $Result[3];
				}
				else
					throw new ModelExceptionsEngine(
						"UnKnown Where Statment ( $Statment ) in Having in Select Statment");
			}

			if ( $HavingQuery === ' HAVING ' )
				return '';

			return substr($HavingQuery, 0, strlen($HavingQuery)-4 );
		};

		$OrderBy = function ($Value, &$Model_Fields, &$Model_Name){

			$OrderQuery = ' ORDER BY ';
			foreach ($Value as $Statment) {

				if ( $Statment[0] === '-' ){
					$Field_Name = substr($Statment, 1);
					if ( !isset($Model_Fields[$Field_Name]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

					$OrderQuery .= " `$Field_Name` DESC,";
				}
				else{
					if ( !isset($Model_Fields[$Statment]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Statment )");

					$OrderQuery .= " `$Statment`,";
				}
			}

			if ( $OrderQuery === ' ORDER BY ' )
				return '';

			return substr($OrderQuery, 0, strlen($OrderQuery)-1 );
		};

		$Limit = function ($Value){
			return ' LIMIT '.$Value['Arg1'].(($Value['Arg2']!==NULL)?', '.$Value['Arg2'] : '');
		};

		foreach ($this->Queries[$i]['Queries'] as $Key => $Value){

			if ( $Key == 'Select' )
				$Query .= $Select($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Where' )
				$Query .= $Where($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'GroupBy' )
				$Query .= $GroupBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Having' )
				$Query .= $Having($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'OrderBy' )
				$Query .= $OrderBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Limit' )
				$Query .= $Limit($Value['QueryFields']);
		}

		$this->Query[$i]['Type'] = 'SELECT';
		$this->Query[$i]['Values'] = $Values;
		$this->Query[$i]['String'] = $Query;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function WhereFields($i){

		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = "SELECT * FROM `$Model_Name` ";
		$Values = [];

		$Where = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$WhereQuery = ' WHERE ';
			foreach ($Value as $Statment) {
				if ( preg_match('/^ *(.*[^ ]) *(=|>|<|!=|<>|>=|<=) *(.*[^ ]) *$/', $Statment,
						$Result) ){

					if ( !isset($Model_Fields[$Result[1]]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Result[1] )");

					$WhereQuery .= "`$Result[1]` $Result[2] ?  AND ";
					$Values[] = $Result[3];
				}
				else
					throw new ModelExceptionsEngine(
						"UnKnown Where Statment ( $Statment ) in Select Statment");
			}

			if ( $WhereQuery === ' WHERE ' )
				return '';

			return substr($WhereQuery, 0, strlen($WhereQuery)-4 );
		};

		$GroupBy = function ($Value, &$Model_Fields, &$Model_Name){

			$GroupByQuery = ' GROUP BY ';
			foreach ($Value as $Field_Name){

				if ( !isset($Model_Fields[$Field_Name]) )
					throw new ModelExceptionsEngine(
						"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

				$GroupByQuery .= " `$Field_Name`,";
			}

			if ( $GroupByQuery === ' GROUP BY ' )
				return '';

			return substr($GroupByQuery, 0, strlen($GroupByQuery)-1 );
		};

		$Having = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$HavingQuery = ' HAVING ';
			foreach ($Value as $Statment) {
				if ( preg_match('/^ *(.*[^ ]) *(=|>|<|!=|<>|>=|<=) *(.*[^ ]) *$/', $Statment,
						$Result) ){

					if ( !isset($Model_Fields[$Result[1]]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Result[1] )");

					$HavingQuery .= "`$Result[1]` $Result[2] ?  AND ";
					$Values[] = $Result[3];
				}
				else
					throw new ModelExceptionsEngine(
						"UnKnown Where Statment ( $Statment ) in Having in Select Statment");
			}

			if ( $HavingQuery === ' HAVING ' )
				return '';

			return substr($HavingQuery, 0, strlen($HavingQuery)-4 );
		};

		$OrderBy = function ($Value, &$Model_Fields, &$Model_Name){

			$OrderQuery = ' ORDER BY ';
			foreach ($Value as $Statment) {

				if ( $Statment[0] === '-' ){
					$Field_Name = substr($Statment, 1);
					if ( !isset($Model_Fields[$Field_Name]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

					$OrderQuery .= " `$Field_Name` DESC,";
				}
				else{
					if ( !isset($Model_Fields[$Statment]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Statment )");

					$OrderQuery .= " `$Statment`,";
				}
			}

			if ( $OrderQuery === ' ORDER BY ' )
				return '';

			return substr($OrderQuery, 0, strlen($OrderQuery)-1 );
		};

		$Limit = function ($Value){
			return ' LIMIT '.$Value['Arg1'].(($Value['Arg2']!==NULL)?', '.$Value['Arg2'] : '');
		};

		foreach ($this->Queries[$i]['Queries'] as $Key => $Value){

			if ( $Key == 'Where' )
				$Query .= $Where($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'GroupBy' )
				$Query .= $GroupBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Having' )
				$Query .= $Having($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'OrderBy' )
				$Query .= $OrderBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Limit' )
				$Query .= $Limit($Value['QueryFields']);
		}

		$this->Query[$i]['Type'] = 'SELECT';
		$this->Query[$i]['Values'] = $Values;
		$this->Query[$i]['String'] = $Query;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function GroupByFields($i){

		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = "SELECT * FROM `$Model_Name` ";
		$Values = [];

		$GroupBy = function ($Value, &$Model_Fields, &$Model_Name){

			$GroupByQuery = ' GROUP BY ';
			foreach ($Value as $Field_Name){

				if ( !isset($Model_Fields[$Field_Name]) )
					throw new ModelExceptionsEngine(
						"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

				$GroupByQuery .= " `$Field_Name`,";
			}

			if ( $GroupByQuery === ' GROUP BY ' )
				return '';

			return substr($GroupByQuery, 0, strlen($GroupByQuery)-1 );
		};

		$Having = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$HavingQuery = ' HAVING ';
			foreach ($Value as $Statment) {
				if ( preg_match('/^ *(.*[^ ]) *(=|>|<|!=|<>|>=|<=) *(.*[^ ]) *$/', $Statment,
						$Result) ){

					if ( !isset($Model_Fields[$Result[1]]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Result[1] )");

					$HavingQuery .= "`$Result[1]` $Result[2] ?  AND ";
					$Values[] = $Result[3];
				}
				else
					throw new ModelExceptionsEngine(
						"UnKnown Where Statment ( $Statment ) in Having in Select Statment");
			}

			if ( $HavingQuery === ' HAVING ' )
				return '';

			return substr($HavingQuery, 0, strlen($HavingQuery)-4 );
		};

		$OrderBy = function ($Value, &$Model_Fields, &$Model_Name){

			$OrderQuery = ' ORDER BY ';
			foreach ($Value as $Statment) {

				if ( $Statment[0] === '-' ){
					$Field_Name = substr($Statment, 1);
					if ( !isset($Model_Fields[$Field_Name]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

					$OrderQuery .= " `$Field_Name` DESC,";
				}
				else{
					if ( !isset($Model_Fields[$Statment]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Statment )");

					$OrderQuery .= " `$Statment`,";
				}
			}

			if ( $OrderQuery === ' ORDER BY ' )
				return '';

			return substr($OrderQuery, 0, strlen($OrderQuery)-1 );
		};

		$Limit = function ($Value){
			return ' LIMIT '.$Value['Arg1'].(($Value['Arg2']!==NULL)?', '.$Value['Arg2'] : '');
		};

		foreach ($this->Queries[$i]['Queries'] as $Key => $Value){

			if ( $Key == 'GroupBy' )
				$Query .= $GroupBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Having' )
				$Query .= $Having($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'OrderBy' )
				$Query .= $OrderBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Limit' )
				$Query .= $Limit($Value['QueryFields']);
		}

		$this->Query[$i]['Type'] = 'SELECT';
		$this->Query[$i]['Values'] = $Values;
		$this->Query[$i]['String'] = $Query;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function HavingFields($i){

		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = "SELECT * FROM `$Model_Name` ";
		$Values = [];

		$Having = function ($Value, &$Model_Fields, &$Model_Name, &$Values){

			$HavingQuery = ' HAVING ';
			foreach ($Value as $Statment) {
				if ( preg_match('/^ *(.*[^ ]) *(=|>|<|!=|<>|>=|<=) *(.*[^ ]) *$/', $Statment,
						$Result) ){

					if ( !isset($Model_Fields[$Result[1]]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Result[1] )");

					$HavingQuery .= "`$Result[1]` $Result[2] ?  AND ";
					$Values[] = $Result[3];
				}
				else
					throw new ModelExceptionsEngine(
						"UnKnown Where Statment ( $Statment ) in Having in Select Statment");
			}

			if ( $HavingQuery === ' HAVING ' )
				return '';

			return substr($HavingQuery, 0, strlen($HavingQuery)-4 );
		};

		$OrderBy = function ($Value, &$Model_Fields, &$Model_Name){

			$OrderQuery = ' ORDER BY ';
			foreach ($Value as $Statment) {

				if ( $Statment[0] === '-' ){
					$Field_Name = substr($Statment, 1);
					if ( !isset($Model_Fields[$Field_Name]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

					$OrderQuery .= " `$Field_Name` DESC,";
				}
				else{
					if ( !isset($Model_Fields[$Statment]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Statment )");

					$OrderQuery .= " `$Statment`,";
				}
			}

			if ( $OrderQuery === ' ORDER BY ' )
				return '';

			return substr($OrderQuery, 0, strlen($OrderQuery)-1 );
		};

		$Limit = function ($Value){
			return ' LIMIT '.$Value['Arg1'].(($Value['Arg2']!==NULL)?', '.$Value['Arg2'] : '');
		};

		foreach ($this->Queries[$i]['Queries'] as $Key => $Value){

			if ( $Key == 'Having' )
				$Query .= $Having($Value['QueryFields'], $Model_Fields, $Model_Name, $Values);

			else if ( $Key == 'OrderBy' )
				$Query .= $OrderBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Limit' )
				$Query .= $Limit($Value['QueryFields']);
		}

		$this->Query[$i]['Type'] = 'SELECT';
		$this->Query[$i]['Values'] = $Values;
		$this->Query[$i]['String'] = $Query;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function OrderByFields($i){

		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = "SELECT * FROM `$Model_Name` ";
		$Values = [];

		$OrderBy = function ($Value, &$Model_Fields, &$Model_Name){

			$OrderQuery = ' ORDER BY ';
			foreach ($Value as $Statment) {

				if ( $Statment[0] === '-' ){
					$Field_Name = substr($Statment, 1);
					if ( !isset($Model_Fields[$Field_Name]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Field_Name )");

					$OrderQuery .= " `$Field_Name` DESC,";
				}
				else{
					if ( !isset($Model_Fields[$Statment]) )
						throw new ModelExceptionsEngine(
							"Model ( $Model_Name ) Has No Field With Name ( $Statment )");

					$OrderQuery .= " `$Statment`,";
				}
			}

			if ( $OrderQuery === ' ORDER BY ' )
				return '';

			return substr($OrderQuery, 0, strlen($OrderQuery)-1 );
		};

		$Limit = function ($Value){
			return ' LIMIT '.$Value['Arg1'].(($Value['Arg2']!==NULL)?', '.$Value['Arg2'] : '');
		};

		foreach ($this->Queries[$i]['Queries'] as $Key => $Value){

			if ( $Key == 'OrderBy' )
				$Query .= $OrderBy($Value['QueryFields'], $Model_Fields, $Model_Name);

			else if ( $Key == 'Limit' )
				$Query .= $Limit($Value['QueryFields']);
		}

		$this->Query[$i]['Type'] = 'SELECT';
		$this->Query[$i]['Values'] = $Values;
		$this->Query[$i]['String'] = $Query;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function LimitFields($i){

		$Model_Name =
			array_slice( explode('\\', get_class( $this->Queries[$i]['Model_Object'] ) ), -1)[0];

		if ( !isset($GLOBALS['_Configs_']['_Models_'][$Model_Name]) )
			throw new ModelExceptionsEngine(
				"Model ( $Model_Name ) Not Found in The DataBase Schema");

		$Model_Fields = get_object_vars($this->Queries[$i]['Model_Object']);

		$Query = "SELECT * FROM `$Model_Name` ";
		$Values = [];

		$Limit = function ($Value){
			return ' LIMIT '.$Value['Arg1'].(($Value['Arg2']!==NULL)?', '.$Value['Arg2'] : '');
		};

		foreach ($this->Queries[$i]['Queries'] as $Key => $Value){

			if ( $Key == 'Limit' )
				$Query .= $Limit($Value['QueryFields']);
		}

		$this->Query[$i]['Type'] = 'SELECT';
		$this->Query[$i]['Values'] = $Values;
		$this->Query[$i]['String'] = $Query;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	private function ExcuteQueries(){

		for ( $i = $this->Position ; $i < $this->QueriesNumber; $i++){

			try{
				$SQL = $this->PDO->prepare($this->Query[$i]['String']);
				$SQL->execute($this->Query[$i]['Values']);

				if ( $this->Query[$i]['Type'] === 'INSERT' ||
					 $this->Query[$i]['Type'] === 'DELETE' ||
					 $this->Query[$i]['Type'] === 'UPDATE' ){

					$this->Queries_Result[$i] = [
						'RowCount' => $SQL->rowCount(),
						'LastInsertedID' => $this->PDO->lastInsertId()
					];
				}
				else{
					$this->Queries_Result[$i] = [
						'RowCount' => $SQL->rowCount(),
						'LastInsertedID' => $this->PDO->lastInsertId(),
						'Result' => $SQL->fetchAll(\PDO::FETCH_ASSOC)
					];
				}

				$this->Position++;
			}
			catch(\PDOException $e){
				echo 'Error in Making Query : '.$e->getMessage();
				exit();
			}
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////

	function ShowQueries(){
		//var_dump( $this->Queries[2]['Queries']['Update']['QueryFields'] );
		print_r($this->Queries);
	}
}
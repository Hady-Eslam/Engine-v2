<?php
namespace Core;
use Exceptions\LazyLoaderExceptionsEngine;

class LazyLoaderEngine{

	function __construct(){
		$this->TurnEngineOn();
	}

	private function TurnEngineOn(){
		spl_autoload_register('Core\LazyLoaderEngine::AutoLoader');
	}

	static function AutoLoader($Name){
		$Name = explode('\\', $Name);

		if ( $Name[0] == 'Server' )
			require_once _DIR_.'/Core/ServerEngines/'.$Name[1].'.php';

		else if ( $Name[0] == 'ModelQueriesOperations' )
			self::ModelQueriesOperations($Name);

		else if ( $Name[0] == 'Core' )
			require_once _DIR_.'/Core/CoreEngines/'.$Name[1].'.php';

		else if ( $Name[0] == 'Configs' )
			require_once _DIR_.'/Core/ConfigsEngines/'.$Name[1].'.php';

		else if ( $Name[0] == 'ErrorsHandlers' )
			require_once _DIR_.'/Core/ErrorsHandlersEngines/'.$Name[1].'.php';

		else if ( $Name[0] == 'Exceptions' )
			require_once _DIR_.'/Core/ExceptionsEngines/'.$Name[1].'.php';

		else if ( $Name[0] == 'CoreModels' )
			require_once _DIR_.'/Core/ModelsEngines/'.$Name[1].'.php';

		else if ( $Name[0] == 'ModelFields' )
			self::ModelFields($Name);

		else if ( $Name[0] == 'Models' )
			require_once _DIR_.'/'.implode('/', $Name).'.php';

		else if ( $Name[0] == 'WhereOperations' )
			require_once _DIR_.'/Core/ModelsEngines/ModelQueriesEngines/WhereOperationsEngines/'
					.$Name[1].'.php';

		else if ( $Name[0] == 'MainQueries')
			require_once _DIR_.'/Core/ModelsEngines/ModelQueriesEngines/MainQueriesEngines/'
					.$Name[1].'.php';

		else if ( $Name[0] == 'SubQueries')
			require_once _DIR_.'/Core/ModelsEngines/ModelQueriesEngines/SubQueriesEngines/'
					.$Name[1].'.php';

		else if ( $Name[0] == 'CoreForms' )
			require_once _DIR_.'/Core/FormsEngines/'.$Name[1].'.php';

		else if ( $Name[0] == 'FormsFields' )
			self::FormsFields($Name);

		else if ( $Name[0] == 'Forms' )
			require_once _DIR_.'/'.implode('/', $Name).'.php';

		else if ( $Name[0] == 'Manibulations' )
			require_once _DIR_.'/Core/ManibulationsEngines/'.$Name[1].'.php';

		else if ( $Name[0] == 'SessionEngines' )
			require_once _DIR_.'/Core/SessionEngines/'.$Name[1].'.php';

		else
			self::CheckRegistered($Name);
	}

	private static function ModelFields($Name){
		if ( $Name[1] == 'RelationsTypes' )
			require_once _DIR_.'/Core/ModelsEngines/ModelFieldsEngines/'
					.'RelationsTypesEngines/'.$Name[2].'.php';

		else if ( $Name[1] == 'IntegerTypes' )
			require_once _DIR_.'/Core/ModelsEngines/ModelFieldsEngines/'
					.'IntegerTypesEngines/'.$Name[2].'.php';

		else if ( $Name[1] == 'DecimalTypes' )
			require_once _DIR_.'/Core/ModelsEngines/ModelFieldsEngines/'
					.'DecimalTypesEngines/'.$Name[2].'.php';

		else if ( $Name[1] == 'DateTypes' )
			require_once _DIR_.'/Core/ModelsEngines/ModelFieldsEngines/'
					.'DateTypesEngines/'.$Name[2].'.php';

		else if ( $Name[1] == 'StringTypes' )
			require_once _DIR_.'/Core/ModelsEngines/ModelFieldsEngines/'
					.'StringTypesEngines/'.$Name[2].'.php';

		else if ( $Name[1] == 'SelectTypes' )
			require_once _DIR_.'/Core/ModelsEngines/ModelFieldsEngines/'
					.'SelectTypesEngines/'.$Name[2].'.php';

		else
			require_once _DIR_.'/Core/ModelsEngines/ModelFieldsEngines/'.$Name[1].'.php';
	}

	private static function FormsFields($Name){

		if ( $Name[1] == 'IntegerTypes' )
			require_once _DIR_.'/Core/FormsEngines/FormsFieldsEngines/IntegerTypes/'
					.$Name[2].'.php';

		else if ( $Name[1] == 'DateTypes' )
			require_once _DIR_.'/Core/FormsEngines/FormsFieldsEngines/DateTypes/'
					.$Name[2].'.php';

		else if ( $Name[1] == 'StringTypes' )
			require_once _DIR_.'/Core/FormsEngines/FormsFieldsEngines/StringTypes/'
					.$Name[2].'.php';

		else if ( $Name[1] == 'SelectTypes' )
			require_once _DIR_.'/Core/FormsEngines/FormsFieldsEngines/SelectTypes/'
					.$Name[2].'.php';

		else if ( $Name[1] == 'EmailTypes' )
			require_once _DIR_.'/Core/FormsEngines/FormsFieldsEngines/EmailTypes/'
					.$Name[2].'.php';

		else if ( $Name[1] == 'FilesTypes' )
			require_once _DIR_.'/Core/FormsEngines/FormsFieldsEngines/FilesTypes/'
					.$Name[2].'.php';

		else
			require_once _DIR_.'/Core/FormsEngines/FormsFieldsEngines/'.$Name[1].'.php';
	}

	private static function ModelQueriesOperations($Name){

		if ( $Name[1] == 'InsertOperations' )
			require_once _DIR_.'/Core/ModelsEngines/ModelQueriesOperationsEngines/InsertOperationsEngines/'.$Name[2].'.php';

		else if ( $Name[1] == 'DeleteOperations' )
			require_once _DIR_.'/Core/ModelsEngines/ModelQueriesOperationsEngines/DeleteOperationsEngines/'.$Name[2].'.php';

		else if ( $Name[1] == 'UpdateOperations' )
			require_once _DIR_.'/Core/ModelsEngines/ModelQueriesOperationsEngines/UpdateOperationsEngines/'.$Name[2].'.php';

		else if ( $Name[1] == 'SelectOperations' )
			require_once _DIR_.'/Core/ModelsEngines/ModelQueriesOperationsEngines/SelectOperationsEngines/'.$Name[2].'.php';
	}

	private static function CheckRegistered($Name){
		if ( isset($GLOBALS['_Configs_']['_LazyLoaderConfigs_']['Register'][$Name[0]]) )
			require_once $GLOBALS['_Configs_']['_LazyLoaderConfigs_']['Register']
					[$Name[0]].'/'.$Name[1].'.php';
		else
			throw new LazyLoaderExceptionsEngine("Name Space Not Found (".
				implode('/', $Name).") ");
	}
}

return new LazyLoaderEngine();
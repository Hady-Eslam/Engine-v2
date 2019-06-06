<?php

namespace Core;

use ErrorsHandlers\ErrorsHandlerEngine;

use Configs\AppConfigsEngine;
use Configs\RoutingConfigsEngine;
use Configs\ModelConfigsEngine;
use Configs\LazyLoaderConfigsEngine;
use Configs\SessionConfigsEngine;

use SessionEngines\SessionDataBaseTypeEngine;
use SessionEngines\SessionFileTypeEngine;

use Core\CSRFProtectionEngine;
use Core\RequestEngine;
use Core\ViewsEngine;
use Core\TemplateEngine;

use CoreModels\ModelExcutionEngine;
use CoreModels\QueriesRegisterEngine;

use Exceptions\CSRFExceptionsEngine;

class CoreEngine{

	function __construct(){
		new ErrorsHandlerEngine();
		new DefinesEngine('WebSiteEngine');
		$this->LoadConfigs();
	}

	private function LoadConfigs(){

		$GLOBALS['_Configs_']['_AppConfigs_'] =
				new AppConfigsEngine(_DIR_.'/Configs/AppConfigs.php');
		
		$GLOBALS['_Configs_']['_ModelConfigs_'] =
				new ModelConfigsEngine(_DIR_.'/Configs/ModelConfigs.php');

		$GLOBALS['_Configs_']['_LazyLoaderConfigs_'] =
				new LazyLoaderConfigsEngine(_DIR_.'/Configs/LazyLoaderConfigs.php');

		$GLOBALS['_Configs_']['_SessionConfigs_'] = 
				new SessionConfigsEngine(_DIR_.'/Configs/SessionConfigs.php');

		if ( file_exists(_DIR_.'/Storage/Models/RegisteredModels') ){
			$GLOBALS['_Configs_']['_Models_'] = json_decode(
				file_get_contents(_DIR_.'/Storage/Models/RegisteredModels'),
				True
			);
		}
		else
			$GLOBALS['_Configs_']['_Models_'] = [];
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	function BeginRouting(){

		$this->RoutingResult = (new RoutingEngine(

			$GLOBALS['_Configs_']['_AppConfigs_']['SCHEMA'],
			_DIR_.'/Core/CorePages/404.html',
			_DIR_.'/Core/CorePages/403.html',
			explode('/',    explode('?', $_SERVER['REQUEST_URI'], 2)[0],    2)[1]
		
		))->GetResult();
	}


	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////


	function MakeDataBaseConnection(){
		$GLOBALS['PDO'] = ModelExcutionEngine::Get_PDO($GLOBALS['_Configs_']['_ModelConfigs_']);

		if ( $GLOBALS['PDO'] !== NULL )
			$GLOBALS['_Configs_']['_Queries_'] = new QueriesRegisterEngine($GLOBALS['PDO']);
		else
			$GLOBALS['_Configs_']['_Queries_'] = new QueriesRegisterEngine();
	}


	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////


	function CheckMiddleWares(){
		$this->Check_Session_Middle_Ware();
		$this->Check_CSRF_Middle_Ware();
	}

	private function Check_Session_Middle_Ware(){

		if ( !in_array('SESSION', $GLOBALS['_Configs_']['_AppConfigs_']['MIDDLE_WARE']) )
			$GLOBALS['SESSION'] = NULL;

		else if ( $GLOBALS['_Configs_']['_SessionConfigs_']['TYPE'] == 'DATABASE' )
			$GLOBALS['SESSION'] = SessionDataBaseTypeEngine::GetSession();

		else
			$GLOBALS['SESSION'] = NULL;
	}

	private function Check_CSRF_Middle_Ware(){

		if ( !isset($GLOBALS['_Configs_']['_AppConfigs_']['MIDDLE_WARE']['CSRF']) )
			$GLOBALS['CSRF'] = NULL;

		else if ( !in_array('SESSION', $GLOBALS['_Configs_']['_AppConfigs_']['MIDDLE_WARE']) )
			throw new CSRFExceptionsEngine('CSRF Engine is Build On The Session Middle Ware SO You Must Activate Session Middle Ware');

		$GLOBALS['CSRF'] = new CSRFProtectionEngine(
			isset( $_POST['ENGINE_CSRF_Token'] ) ? $_POST['ENGINE_CSRF_Token'] : NULL,
			isset( $GLOBALS['SESSION']['CSRF'] ) ? $GLOBALS['SESSION']['CSRF'] : NULL
		);

		$this->RoutingResult['Result'] = $GLOBALS['CSRF']->isValid(
			$this->RoutingResult['Result']
		);

		$GLOBALS['SESSION'] = $GLOBALS['CSRF']->GetSessionTokens(
			$GLOBALS['SESSION']
		);
	}


	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////


	function GetRequest(){
		$this->Request = RequestEngine::GetRequest();
	}


	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////


	function BeginView(){
		$Views = new ViewsEngine(
			$GLOBALS['_Configs_']['_AppConfigs_']['VIEWS'],
			$this->RoutingResult
		);

		$this->Render = $Views->TurnViewOn($this->Request);
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	function InvokeQueries(){
		$GLOBALS['_Configs_']['_Queries_']->InvokeAllQueries();
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	function GenerateTemplate(){
		$this->Template = new TemplateEngine(
			$this->Render,
			$GLOBALS['CSRF']->GetCSRFToken()
		);
		$this->Generated_Template = $this->Template->BeginParsing();
		$this->GET_CSRF = $this->Template->GET_CSRF();
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	function SaveSession(){

		if ( !in_array('SESSION', $GLOBALS['_Configs_']['_AppConfigs_']['MIDDLE_WARE']) )
			return ;

		else if ( $GLOBALS['_Configs_']['_SessionConfigs_']['TYPE'] == 'DATABASE' )
			SessionDataBaseTypeEngine::SaveSession($this->Render, $this->GET_CSRF);

		else
			SessionFileTypeEngine::SaveSession($this->Render, $this->GET_CSRF);
	}

	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////

	function FlushOutPut(){
		$this->Template->FlushTemplate($this->Generated_Template);
	}
}

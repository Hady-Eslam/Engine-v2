<?php

namespace Core;
use SessionEngines\SessionFileTypeEngine;
use SessionEngines\SessionDataBaseTypeEngine;

class RedirectEngine{

	static function To($URL, Request $Request = NULL){
		$GLOBALS['_Configs_']['_Queries_']->InvokeAllQueries();
		if ( $Request !== NULL )
			self::SaveSession($Request);
		header('Location:'.$URL);
		exit();
	}

	private static function SaveSession($Request){

		if ( !in_array('SESSION', $GLOBALS['_Configs_']['_AppConfigs_']['MIDDLE_WARE']) )
			return ;

		else if ( $GLOBALS['_Configs_']['_SessionConfigs_']['TYPE'] == 'DATABASE' )
			SessionDataBaseTypeEngine::SaveRedirectSession($Request);

		else
			return ;
	}
}
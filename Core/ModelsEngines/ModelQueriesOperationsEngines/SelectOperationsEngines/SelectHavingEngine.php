<?php

namespace ModelQueriesOperations\SelectOperations;
use ModelQueriesOperations\SelectOperations\SelectOrderByEngine;
use ModelQueriesOperations\SelectOperations\SelectLimitEngine;
use ModelQueriesOperations\SelectOperations\SelectStatusEngine;

class SelectHavingEngine extends SelectStatusEngine{

	function __construct($QueryNumber){
		$this->QueryNumber = $QueryNumber;
	}

	function Having(...$Fields){
		return new SelectOrderByEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery(
				'Having', $Fields, $this->QueryNumber )
		);
	}

	function OrderBy(...$Fields){
		return new SelectLimitEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery(
				'OrderBy', $Fields, $this->QueryNumber )
		);
	}

	function Limit($Arg1, $Arg2 = NULL){
		return new SelectStatusEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Limit',
				['Arg1' => $Arg1, 'Arg2' => $Arg2], $this->QueryNumber)
		);
	}
}
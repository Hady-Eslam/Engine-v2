<?php

namespace ModelQueriesOperations\SelectOperations;
use ModelQueriesOperations\SelectOperations\SelectGroupByEngine;
use ModelQueriesOperations\SelectOperations\SelectHavingEngine;
use ModelQueriesOperations\SelectOperations\SelectOrderByEngine;
use ModelQueriesOperations\SelectOperations\SelectLimitEngine;
use ModelQueriesOperations\SelectOperations\SelectStatusEngine;

class SelectWhereEngine extends SelectStatusEngine{

	function __construct($QueryNumber){
		$this->QueryNumber = $QueryNumber;
	}

	function Where(...$Fields){
		return new SelectGroupByEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery(
				'Where', $Fields, $this->QueryNumber )
		);
	}

	function GroupBy(...$Fields){
		return new SelectHavingEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery(
				'GroupBy', $Fields, $this->QueryNumber )
		);
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
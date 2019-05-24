<?php

namespace ModelQueriesOperations\UpdateOperations;
use ModelQueriesOperations\InsertOperations\StatusEngine;
use ModelQueriesOperations\UpdateOperations\UpdateOrderByEngine;
use ModelQueriesOperations\UpdateOperations\UpdateLimitEngine;

class UpdateWhereEngine extends StatusEngine{

	function __construct($QueryNumber){
		$this->QueryNumber = $QueryNumber;
	}

	function Where(...$Fields){
		return new UpdateOrderByEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Where', $Fields,
				$this->QueryNumber)
		);
	}

	function OrderBy(...$Fields){
		return new UpdateLimitEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('OrderBy', $Fields,
				$this->QueryNumber)
		);
	}

	function Limit($Arg1, $Arg2 = NULL){
		return new StatusEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Limit',
				['Arg1' => $Arg1, 'Arg2' => $Arg2], $this->QueryNumber)
		);
	}
}
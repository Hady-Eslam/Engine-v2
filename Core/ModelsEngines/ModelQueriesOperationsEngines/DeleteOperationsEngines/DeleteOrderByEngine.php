<?php

namespace ModelQueriesOperations\DeleteOperations;
use ModelQueriesOperations\InsertOperations\StatusEngine;
use ModelQueriesOperations\DeleteOperations\DeleteLimitEngine;

class DeleteOrderByEngine extends StatusEngine{

	function __construct($QueryNumber){
		$this->QueryNumber = $QueryNumber;
	}

	function OrderBy(...$Fields){
		return new DeleteLimitEngine(
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
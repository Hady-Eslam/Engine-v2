<?php

namespace ModelQueriesOperations\UpdateOperations;
use ModelQueriesOperations\InsertOperations\StatusEngine;

class UpdateLimitEngine extends StatusEngine{

	function __construct($QueryNumber){
		$this->QueryNumber = $QueryNumber;
	}

	function Limit($Arg1, $Arg2 = NULL){
		return new StatusEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Limit',
				['Arg1' => $Arg1, 'Arg2' => $Arg2], $this->QueryNumber)
		);
	}
}
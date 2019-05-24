<?php

namespace ModelQueriesOperations\SelectOperations;
use ModelQueriesOperations\SelectOperations\SelectStatusEngine;

class SelectLimitEngine extends SelectStatusEngine{

	function __construct($QueryNumber){
		$this->QueryNumber = $QueryNumber;
	}

	function Limit($Arg1, $Arg2 = NULL){
		return new SelectStatusEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Limit',
				['Arg1' => $Arg1, 'Arg2' => $Arg2], $this->QueryNumber)
		);
	}
}
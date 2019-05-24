<?php

namespace CoreModels;
use CoreModels\ModelFieldsEngine;

use ModelQueriesOperations\InsertOperations\StatusEngine;
use ModelQueriesOperations\DeleteOperations\DeleteOrderByEngine;
use ModelQueriesOperations\UpdateOperations\UpdateWhereEngine;

use ModelQueriesOperations\SelectOperations\SelectWhereEngine;
use ModelQueriesOperations\SelectOperations\SelectGroupByEngine;
use ModelQueriesOperations\SelectOperations\SelectHavingEngine;
use ModelQueriesOperations\SelectOperations\SelectOrderByEngine;
use ModelQueriesOperations\SelectOperations\SelectLimitEngine;
use ModelQueriesOperations\SelectOperations\SelectStatusEngine;

class ModelEngine extends ModelFieldsEngine{

	function Insert(...$Fields){
		return new StatusEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Insert', $Fields, -1, $this)
		);
	}

	function Delete(...$Fields){
		return new DeleteOrderByEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Delete', $Fields, -1, $this)
		);
	}

	function Update(...$Fields){
		return new UpdateWhereEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Update', $Fields, -1, $this)
		);
	}

	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////

	function Select(...$Fields){
		return new SelectWhereEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Select', $Fields, -1, $this)
		);
	}

	function Where(...$Fields){
		return new SelectGroupByEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Where', $Fields, -1, $this)
		);
	}

	function GroupBy(...$Fields){
		return new SelectHavingEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('GroupBy', $Fields, -1, $this)
		);
	}

	function Having(...$Fields){
		return new SelectOrderByEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Having', $Fields, -1, $this)
		);
	}

	function OrderBy(...$Fields){
		return new SelectLimitEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('OrderBy', $Fields, -1, $this)
		);
	}

	function Limit($Arg1, $Arg2 = NULL){
		return new SelectStatusEngine(
			$GLOBALS['_Configs_']['_Queries_']->RegisterQuery('Limit',
				['Arg1' => $Arg1, 'Arg2' => $Arg2 ], -1, $this)
		);
	}

	function Exists(){

	}

	function Count(){

	}

	function Max(){

	}

	function Min(){

	}

	function Avg(){

	}

	function Sum(){

	}

	function Turncate(){

	}
}
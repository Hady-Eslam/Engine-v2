<?php

namespace ModelQueriesOperations\InsertOperations;

class StatusEngine{

	protected $QueryNumber = NULL;
	protected $Excuted = False;
	protected $Status = -1;
	protected $RowCount = -1;
	protected $LastInsertedID = -1;

	function __construct($QueryNumber){
		$this->QueryNumber = $QueryNumber;
	}

	private function Excute($Return){
		$Status = $GLOBALS['_Configs_']['_Queries_']->GetQueryResult($this->QueryNumber);
		$this->RowCount = $Status['RowCount'];
		$this->LastInsertedID = $Status['LastInsertedID'];
		$this->Excuted = True;
		return ( $Return == 'RowCount' ) ? $Status['RowCount'] : $Status['LastInsertedID'];
	}

	function RowCount(){
		return ( !$this->Excuted ) ? $this->Excute('RowCount') : $this->RowCount ;
	}

	function LastInsertedID(){
		return ( !$this->Excuted ) ? $this->Excute('LastInsertedID') : $this->LastInsertedID ;
	}
}

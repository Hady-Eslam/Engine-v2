<?php

namespace ModelQueriesOperations\SelectOperations;

class SelectStatusEngine{

	protected $QueryNumber = NULL;
	protected $Excuted = False;
	protected $Status = -1;
	protected $RowCount = -1;
	protected $LastInsertedID = -1;
	protected $QueryResult = -1;

	function __construct($QueryNumber){
		$this->QueryNumber = $QueryNumber;
	}

	private function Excute($Return){
		$Status = $GLOBALS['_Configs_']['_Queries_']->GetQueryResult($this->QueryNumber);
		$this->RowCount = $Status['RowCount'];
		$this->LastInsertedID = $Status['LastInsertedID'];
		$this->QueryResult = $Status['Result'];

		$this->Excuted = True;
		if ( $Return == 'RowCount' )
			return $Status['RowCount'];
		else if ( $Return == 'LastInsertedID' )
			return $Status['LastInsertedID'];
		return $Status['Result'];
	}

	function RowCount(){
		return ( !$this->Excuted ) ? $this->Excute('RowCount') : $this->RowCount ;
	}

	function LastInsertedID(){
		return ( !$this->Excuted ) ? $this->Excute('LastInsertedID') : $this->LastInsertedID ;
	}

	function Get(){
		return ( !$this->Excuted ) ? $this->Excute('Get') : $this->QueryResult ;
	}
}
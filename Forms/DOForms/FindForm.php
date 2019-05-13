<?php

namespace Forms\DOForms;
use CoreForms\FormsEngine;
use SiteEngines\HashingEngine;

class FindForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->MinA = FormsEngine::IntegerField(['Require' => False, 'Min_Value' => 0,
				'Max_Value' => 10000, 'Default' => 0]);
		$this->MaxA = FormsEngine::IntegerField(['Require' => False, 'Min_Value' => 0,
				'Max_Value' => 10000, 'Default' => 10000]);

		$this->MinR = FormsEngine::IntegerField(['Require' => False, 'Min_Value' => 0,
				'Max_Value' => 9, 'Default' => 0]);
		$this->MaxR = FormsEngine::IntegerField(['Require' => False, 'Min_Value' => 0,
				'Max_Value' => 9, 'Default' => 9]);

		$this->MinPR = FormsEngine::IntegerField(['Require' => False, 'Min_Value' => 0,
				'Max_Value' => 9, 'Default' => 0]);
		$this->MaxPR = FormsEngine::IntegerField(['Require' => False, 'Min_Value' => 0,
				'Max_Value' => 9, 'Default' => 9]);

		$this->MinM = FormsEngine::DecimalField(['Require' => False, 'Min_Value' => 0.0,
				'Max_Value' => 10000000000, 'Default' => 0.0]);
		$this->MaxM = FormsEngine::DecimalField(['Require' => False, 'Min_Value' => 0.0,
				'Max_Value' => 10000000000, 'Default' => 10000000000]);

		$this->Page = FormsEngine::IntegerField(['Require' => False, 'Min_Value' => 0,
				'Max_Value' => 1000, 'Default' => 0]);

		$this->Views = FormsEngine::RadioButtonField(['Require' => False,
				'Min_Length' => 3, 'Max_Length' => 4, 'Default' => 'BOTH',
				'Options' => [ 'ASC', 'DESC', 'BOTH' ]]);

		$this->StatusRent = FormsEngine::CheckBoxField();
		$this->StatusBuy = FormsEngine::CheckBoxField();

		$this->TypeStudents = FormsEngine::CheckBoxField();
		$this->TypeFamilies = FormsEngine::CheckBoxField();
		$this->TypeOffices = FormsEngine::CheckBoxField();

		$this->FurnishedYes = FormsEngine::CheckBoxField();
		$this->FurnishedNo = FormsEngine::CheckBoxField();

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetMinArea(){
		return $this->FILTERED_DATA['MinA'];
	}

	function GetMaxArea(){
		return $this->FILTERED_DATA['MaxA'];
	}

	function GetMinRooms(){
		return $this->FILTERED_DATA['MinR'];
	}

	function GetMaxRooms(){
		return $this->FILTERED_DATA['MaxR'];
	}

	function GetMinPathRooms(){
		return $this->FILTERED_DATA['MinPR'];
	}

	function GetMaxPathRooms(){
		return $this->FILTERED_DATA['MaxPR'];
	}

	function GetMinMoney(){
		return $this->FILTERED_DATA['MinM'];
	}

	function GetMaxMoney(){
		return $this->FILTERED_DATA['MaxM'];
	}

	function GetPage(){
		return $this->FILTERED_DATA['Page'];
	}

	function GetViews($Query){
		if ( $this->FILTERED_DATA['Views'] === 'BOTH' )
			return $Query;
		else if ( $this->FILTERED_DATA['Views'] === 'ASC' )
			return $Query.' ORDER BY views ASC ';
		return $Query.' ORDER BY views DESC ';
	}

	function GetStatus($BUY, $RENT){
		if ( $this->FILTERED_DATA['StatusBuy'] && !$this->FILTERED_DATA['StatusRent'] )
			return " AND bigtype = '$BUY' ";
		else if ( !$this->FILTERED_DATA['StatusBuy'] && $this->FILTERED_DATA['StatusRent'] )
			return " AND bigtype = '$RENT' ";
		return ' ';
	}

	function GetFurnished($NO, $YES, $Query){
		if ( $this->FILTERED_DATA['FurnishedYes'] && !$this->FILTERED_DATA['FurnishedNo'] )
			return ( $Query == ' ' ) ? " furnished = '$YES' " : " AND furnished = '$YES' " ;
		else if ( !$this->FILTERED_DATA['FurnishedYes'] && $this->FILTERED_DATA['FurnishedNo'] )
			return ( $Query == ' ' ) ? " furnished = '$NO' " : " AND furnished = '$NO' " ;
		return $Query;
	}

	function GetType($STUDENTS, $FAMILIES, $OFFICES, $Query){
		if ( $this->FILTERED_DATA['TypeStudents'] && !$this->FILTERED_DATA['TypeFamilies'] &&
			 !$this->FILTERED_DATA['TypeOffices'] )
			return ( $Query == ' ' ) ? " smalltype = '$STUDENTS' " :
						" AND smalltype = '$STUDENTS' ";

		else if ( !$this->FILTERED_DATA['TypeStudents'] && $this->FILTERED_DATA['TypeFamilies'] &&
			 !$this->FILTERED_DATA['TypeOffices'] )
			return ( $Query == ' ' ) ? " smalltype = '$FAMILIES' " :
						" AND smalltype = '$FAMILIES' ";

		else if ( !$this->FILTERED_DATA['TypeStudents'] && $this->FILTERED_DATA['TypeFamilies'] &&
			 $this->FILTERED_DATA['TypeOffices'] )
			return ( $Query == ' ' ) ? " smalltype = '$OFFICES' " :
						" AND smalltype = '$OFFICES' ";

		else if ( $this->FILTERED_DATA['TypeStudents'] && $this->FILTERED_DATA['TypeFamilies'] &&
			 !$this->FILTERED_DATA['TypeOffices'] )
			return ( $Query == ' ' ) ? " smalltype != '$OFFICES' " :
						" AND smalltype != '$OFFICES' ";

		else if ( $this->FILTERED_DATA['TypeStudents'] && !$this->FILTERED_DATA['TypeFamilies'] &&
			 $this->FILTERED_DATA['TypeOffices'] )
			return ( $Query == ' ' ) ? " smalltype != '$FAMILIES' ":
						" AND smalltype != '$FAMILIES' ";

		else if ( !$this->FILTERED_DATA['TypeStudents'] && $this->FILTERED_DATA['TypeFamilies'] &&
			 $this->FILTERED_DATA['TypeOffices'] )
			return ( $Query == ' ' ) ? " smalltype != '$STUDENTS' ":
						" AND smalltype != '$STUDENTS' ";
		return $Query;
	}
}
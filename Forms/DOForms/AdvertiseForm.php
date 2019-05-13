<?php

namespace Forms\DOForms;
use CoreForms\FormsEngine;

class AdvertiseForm extends FormsEngine{
	
	function __construct(...$Data){

		$this->AddName = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Advertise_Name_Len]);

		$this->BigType = FormsEngine::SelectField(['Require' => True, 'Min_Length' => 3,
				'Max_Length' => 4, 'Options' => [ 'Buy', 'Rent' ]]);
		$this->SmallType = FormsEngine::SelectField(['Require' => True, 'Min_Length' => 3,
				'Max_Length' => 8, 'Options' => [ 'Officess', 'Families', 'Students' ]]);

		$this->Rooms = FormsEngine::IntegerField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => 1, 'Min_Value' => 0, 'Max_Value' => 9]);
		$this->PathRooms = FormsEngine::IntegerField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => 1, 'Min_Value' => 0, 'Max_Value' => 9]);

		$this->Area = FormsEngine::IntegerField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Area_Len, 'Min_Value' => 0]);
		$this->Money = FormsEngine::IntegerField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Money_Len, 'Min_Value' => 0]);

		$this->Furnished = FormsEngine::SelectField(['Require' => True, 'Min_Length' => 2,
				'Max_Length' => 3, 'Options' => [ 'Yes', 'No' ]]);

		$this->Discreption = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Discreption_Len]);

		//////////////////////////////////////////////

		$this->City = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Address_Len]);
		$this->UserName = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Name_Len]);
		$this->Phone = FormsEngine::TextField(['Require' => True, 'Min_Length' => 1,
				'Max_Length' => Phone_Len]);

		//////////////////////////////////////////////

		$this->ContactMe = FormsEngine::RadioButtonField(['Require' => True,
				'Min_Length' => 4, 'Max_Length' => 8, 'Default' => 'Both',
				'Options' => [ 'Messages', 'Phone', 'Both' ]]);

		//////////////////////////////////////////////

		$this->File1 = FormsEngine::ImageField(['Require' => True, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->File2 = FormsEngine::ImageField(['Require' => True, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->File3 = FormsEngine::ImageField(['Require' => True, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->File4 = FormsEngine::ImageField(['Require' => True, 'Min_Length' => 0,
				'Max_Length' => Picture_Len, 'Default' => Housing]);

		$this->FORMDATA = $Data;
		$this->OBJECTS = get_object_vars($this);
	}

	function GetAddName(){
		return $this->FILTERED_DATA['AddName'];
	}

	function GetBigType(){
		return $this->FILTERED_DATA['BigType'];
	}

	function GetSmallType(){
		return $this->FILTERED_DATA['SmallType'];
	}

	function GetRooms(){
		return $this->FILTERED_DATA['Rooms'];
	}

	function GetPathRooms(){
		return $this->FILTERED_DATA['PathRooms'];
	}

	function GetArea(){
		return $this->FILTERED_DATA['Area'];
	}

	function GetMoney(){
		return $this->FILTERED_DATA['Money'];
	}

	function GetFurnished(){
		return $this->FILTERED_DATA['Furnished'];
	}

	function GetDiscreption(){
		return $this->FILTERED_DATA['Discreption'];
	}

	/////////////////////////////////////////////////////////

	function GetCity(){
		return $this->FILTERED_DATA['City'];
	}

	function GetUserName(){
		return $this->FILTERED_DATA['UserName'];
	}

	function GetPhone(){
		return $this->FILTERED_DATA['Phone'];
	}

	/////////////////////////////////////////////////////////

	function GetContactMe(){
		if ( $this->FILTERED_DATA['ContactMe'] == 'Both' )
			return 0;
		else if ( $this->FILTERED_DATA['ContactMe'] == 'Phone' )
			return 1;
		return 2;
	}

	/////////////////////////////////////////////////////////

	function GetFile1(){
		return $this->FILTERED_DATA['File1'];
	}

	function GetFile2(){
		return $this->FILTERED_DATA['File2'];
	}
	
	function GetFile3(){
		return $this->FILTERED_DATA['File3'];
	}

	function GetFile4(){
		return $this->FILTERED_DATA['File4'];
	}

}
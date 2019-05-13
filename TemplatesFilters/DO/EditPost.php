<?php

function GetBigType($BigType){
	if ( $BigType == 'Buy' )
		return '<option selected>Buy</option><option>Rent</option>';
	else
		return '<option>Buy</option><option selected>Rent</option>';
}

function GetSmallType($SmallType){
	if ( $SmallType == 'Officess' )
		return '<option value="Officess" selected>Flat For Officess</option><option value="Families">Flat For Families</option>
                    <option value="Students">Flat For Students</option>';
    else if ( $SmallType == 'Families' )
    	return '<option value="Officess">Flat For Officess</option><option value="Families" selected>Flat For Families</option>
                    <option value="Students">Flat For Students</option>';
    else
    	return '<option value="Officess">Flat For Officess</option><option value="Families">Flat For Families</option>
                    <option value="Students" selected>Flat For Students</option>';
}

function GetRooms($Rooms){
	$String = '';
	for ($i = 0; $i <10 ; $i++)
		if ( $i == $Rooms ) 
			$String .= "<option selected>$i</option>";
		else
			$String .= "<option>$i</option>";

	return $String;
}

function GetPathRooms($PathRooms){
	$String = '';
	for ($i = 0; $i <10 ; $i++){ 
		if ( $i == $PathRooms ) 
			$String .= "<option selected>$i</option>";
		else
			$String .= "<option>$i</option>";
	}

	return $String;
}

function GetFurnished($Furnished){
	if ( $Furnished == 'Yes' )
		return '<option selected>Yes</option><option>No</option>';
	else
		return '<option>Yes</option><option selected>No</option>';
}

function GetContactMe($ContactMe){
	if ( $ContactMe == '0' )
		return '<input type="radio" name="ContactMe" checked value="Both">Both
				<input type="radio" name="ContactMe" value="Phone">Phone
				<input type="radio" name="ContactMe" value="Messages">Messages';

	else if ( $ContactMe == '1' )
		return '<input type="radio" name="ContactMe" value="Both">Both
				<input type="radio" name="ContactMe" checked value="Phone">Phone
				<input type="radio" name="ContactMe" value="Messages">Messages';

	else
		return '<input type="radio" name="ContactMe" value="Both">Both
				<input type="radio" name="ContactMe" value="Phone">Phone
				<input type="radio" name="ContactMe" checked  value="Messages">Messages';
}
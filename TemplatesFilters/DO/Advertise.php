<?php

function CountRooms(){
	$String = '';
	for ($i=0; $i <10 ; $i++)
		$String .= "<option>$i</option>";
	return $String;
}
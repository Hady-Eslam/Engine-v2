<?php

use SiteEngines\HashingEngine;
use CoreModels\ModelExcutionEngine;

function GetViews(){
	if ( $GLOBALS['Form']->FILTERED_DATA['Views'] === 'BOTH' )
		return '<input type="radio" name="Views" value="ASC">ASC
                <br>
                <input type="radio" name="Views" value="DESC">DESC
                <br>
                <input type="radio" name="Views" value="BOTH" checked>BOTH';

    else if ( $GLOBALS['Form']->FILTERED_DATA['Views'] === 'ASC' )
		return '<input type="radio" name="Views" value="ASC" checked>ASC
                <br>
                <input type="radio" name="Views" value="DESC">DESC
                <br>
                <input type="radio" name="Views" value="BOTH">BOTH';

    else
		return '<input type="radio" name="Views" value="ASC">ASC
                <br>
                <input type="radio" name="Views" value="DESC" checked>DESC
                <br>
                <input type="radio" name="Views" value="BOTH">BOTH';
}

function GetStatus(){
	$String = '';
	if ( $GLOBALS['Form']->FILTERED_DATA['StatusRent'] == True )
		$String .= '<input type="checkbox" name="StatusRent" checked>Rent';
	else
		$String .= '<input type="checkbox" name="StatusRent">Rent';

	$String .= '<br>';

	if ( $GLOBALS['Form']->FILTERED_DATA['StatusBuy'] == True )
		$String .= '<input type="checkbox" name="StatusBuy" checked>Buy';
	else
		$String .= '<input type="checkbox" name="StatusBuy">Buy';

	return $String;
}

function GetStudents(){
	if ( $GLOBALS['Form']->FILTERED_DATA['TypeStudents'] == True )
		return 'checked';
	return '';
}

function GetFamilies(){
	if ( $GLOBALS['Form']->FILTERED_DATA['TypeFamilies'] == True )
		return 'checked';
	return '';
}

function GetOffices(){
	if ( $GLOBALS['Form']->FILTERED_DATA['TypeOffices'] == True )
		return 'checked';
	return '';
}

function GetFurnishedYes(){
	if ( $GLOBALS['Form']->FILTERED_DATA['FurnishedYes'] == True )
		return 'checked';
	return '';
}

function GetFurnishedNo(){
	if ( $GLOBALS['Form']->FILTERED_DATA['FurnishedNo'] == True )
		return 'checked';
	return '';
}


function GetMinArea(){
	return ( $GLOBALS['Form']->FILTERED_DATA['MinA'] == 0 ) ? '' :
		strval($GLOBALS['Form']->FILTERED_DATA['MinA']);
}

function GetMaxArea(){
	return ( $GLOBALS['Form']->FILTERED_DATA['MaxA'] == 10000 ) ? '' :
		strval($GLOBALS['Form']->FILTERED_DATA['MaxA']);
}

function GetMinRooms(){
	return ( $GLOBALS['Form']->FILTERED_DATA['MinR'] == 0 ) ? '' :
		strval($GLOBALS['Form']->FILTERED_DATA['MinR']);
}

function GetMaxRooms(){
	return ( $GLOBALS['Form']->FILTERED_DATA['MaxR'] == 9 ) ? '' :
		strval($GLOBALS['Form']->FILTERED_DATA['MaxR']);
}

function GetMinPathRooms(){
	return ( $GLOBALS['Form']->FILTERED_DATA['MinPR'] == 0 ) ? '' :
		strval($GLOBALS['Form']->FILTERED_DATA['MinPR']);
}

function GetMaxPathRooms(){
	return ( $GLOBALS['Form']->FILTERED_DATA['MaxPR'] == 9 ) ? '' :
		strval($GLOBALS['Form']->FILTERED_DATA['MaxPR']);
}

function GetMinMoney(){
	return ( $GLOBALS['Form']->FILTERED_DATA['MinM'] == 0 ) ? '' :
		strval($GLOBALS['Form']->FILTERED_DATA['MinM']);
}

function GetMaxMoney(){
	return ( $GLOBALS['Form']->FILTERED_DATA['MaxM'] == 10000000000 ) ? '' :
		strval($GLOBALS['Form']->FILTERED_DATA['MaxM']);
}

function Get_Posts($Posts){
	$Result = '';
	$GLOBALS['Count_Posts'] = 0;
	foreach ($Posts as $Value)
		$Result .= Get_Post($Value);

	if ( $Result == '' )
		return '<p>No Posts Found</p>';
	return $Result;
}

function Get_Post($Post){
    $Hashing = new HashingEngine();

	$Result = $Hashing->Get_Hashed_POSTS($Post['user_email']);
	if ( $Result->Result != 1 )
		return '';

	if ( ($Result = (new ModelExcutionEngine())
			->isFound('SELECT * FROM users WHERE email = ? AND activate = ?',
				array(
					$Hashing->Hash_Users($Result->Data),
					'1'
				)))->Result == -1 || $Result->Result == 0 )
		return '';

	$Link = Post.$Post['id'];

	$Picture = $Hashing->Get_Hashed_POSTS($Post['f_pic']);
	if ( $Picture->Result != 1 || $Picture->Data == Housing ){

		$Picture = $Hashing->Get_Hashed_POSTS($Post['s_pic']);
		if ( $Picture->Result != 1 )
			$Picture = Housing;
		else
			$Picture = $Picture->Data;
	}
	else
		$Picture = $Picture->Data;

	$Money = $Post['money'];
	$Address = $Hashing->Get_Hashed_POSTS($Post['address']);
	if ( $Address->Result != 1 )
		return '';
	else
		$Address = $Address->Data;

	$GLOBALS['Count_Posts']++;

	return '<a href="'.$Link.'">
		<div>
			<input type="image" width="200" height="200" src="'.$Picture.'">
			<p><strong>$ '.$Money.'</strong></p>
			<p><strong>in : '.$Address.'</strong></p>
		</div>
	</a>';
}

function GetPostsNumber(){
	return strval($GLOBALS['Count_Posts']);
}
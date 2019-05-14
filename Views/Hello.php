<?php

use Models\PostModel;
use WhereOperations\OrEngine as _Or;
use WhereOperations\AndEngine as _And;
use CoreModels\ModelExcutionEngine;
use Core\TimerEngine;
use Forms\PostForm;
use SiteEngines\SiteRenderEngine;
use Core\RedirectEngine;

function P($Request, $int, $Double){


	$Timer = new TimerEngine();
	$Timer->Start();
	$Request->POST['Integer'] = 'fjdhf';

	$Form = new PostForm($Request->GET, $Request->POST, $Request->FILES);
	//var_dump($Request->FILES);

	if ( $Form->isValid() ){
		echo 'Form is Valid';/*
		var_dump($Form->FILTERED_DATA['Boolean']);
		var_dump($Form->FILTERED_DATA['Integer']);
		var_dump($Form->FILTERED_DATA['Decimal']);
		var_dump($Form->FILTERED_DATA['Date']);
		var_dump($Form->FILTERED_DATA['Time']);
		var_dump($Form->FILTERED_DATA['DateTime']);
		var_dump($Form->FILTERED_DATA['Text']);
		var_dump($Form->FILTERED_DATA['Email']);
		var_dump($Form->FILTERED_DATA['RadioButton']);
		var_dump($Form->FILTERED_DATA['Select']);
		var_dump($Form->FILTERED_DATA['CheckBox']);
		var_dump($Form->FILTERED_DATA['JJ']); // MultiSelect*/
		//var_dump($Form->FILTERED_DATA['Image']);
		//var_dump($Form->FILTERED_DATA['File']);
	}
	else{
		var_dump($Form->GetErrors());
		var_dump($Form->FILTERED_DATA);
		echo 'Form Not Valid';
	}
	
	$Timer->End();
	$Timer->ShowTime();

	return SiteRenderEngine::Hello($Request);
	/*exit();

	exit();
	echo gettype(1 * 1000 * 1000 * 1000);
	exit();
	$The = new MRequest();
	new ClassName($The->Server, $The->Files);
	exit();
	$ExcutionEngine = new ModelExcutionEngine();
	$Timer = new TimerEngine($Request);
	$Timer->Start();

	$ExcutionEngine->excute(
		'SELECT * FROM `MakeModel`;', array());
		$Result = $ExcutionEngine->GetData();
		print_r($Result);

	$ExcutionEngine->excute(
		'SELECT a.*, b.* FROM `MakeModel` AS a FULL OUTER JOIN `PostsaaaModel` AS b', array());
		$Result = $ExcutionEngine->GetData();
		print_r('<br><br>');
		print_r($Result);
	
	$Timer->End();
	$Timer->ShowTime();
	//print_r($Result);

	$Timer->Start();
		/*$ExcutionEngine->excute(
		'INSERT INTO `MakeModel` ()VALUES();DELETE FROM `PostsaaaModel`;UPDATE `MakeModel` SET `Boolean` = ?;', array(True));
		//$Result = $ExcutionEngine->GetData();*/
	/*$Timer->End();
	$Timer->ShowTime();

	exit();
	$Post = new PostModel();
	//echo 'Hello';
	//$Post->Delete();
	//$Post->Insert(['Boolean' => True]);
	//$Post->Insert()->Update(['Boolean' => True])->Delete()->Insert()->Delete();
	//$Post->Insert()->Update(['Boolean' => True]);
	$Post->Update(['Boolean' => False])->Where(['Hello' => 'OK', 'Hell' => '5'])
			->OrderBy('-Boolean', 'd')->Limit(5);

	$Post->Delete();
	$Post->Delete()->Limit(5);
	$Post->Select()->Get();
	$Post->Select()->Having()->Limit(5)->Get();
	$Post->Insert()->Select()->Where()->GroupBy()->Having()->OrderBy()->Limit(9);

	print_r($GLOBALS['_Queries_']);*/

	return [ 'Footer.html', [
		'HELLO' => 'OO',
		'OK' => 'OKOK',
		'Jus((t ME' => 'OK',
		'Name' => 'Hady',
		'World' => 'Universe',
		'Hady' => 'This is My Name',
		'Eslam' => 'This is My Father Name'
	]];
}

class Hello{
	
	function GET($Request, $int, $Double){

		RedirectEngine::To('http://engine.com/Register/Login');
		return [$Request, '<p>Hello World</p>'];
		//var_dump($Request->SESSION);


		$Timer = new TimerEngine();
		$Timer->Start();
		$Request->POST['Integer'] = 'fjdhf';

		$Form = new PostForm($Request->GET, $Request->POST, $Request->FILES);
		//var_dump($Request->FILES);

		if ( $Form->isValid() ){
			echo 'Form is Valid';/*
			var_dump($Form->FILTERED_DATA['Boolean']);
			var_dump($Form->FILTERED_DATA['Integer']);
			var_dump($Form->FILTERED_DATA['Decimal']);
			var_dump($Form->FILTERED_DATA['Date']);
			var_dump($Form->FILTERED_DATA['Time']);
			var_dump($Form->FILTERED_DATA['DateTime']);
			var_dump($Form->FILTERED_DATA['Text']);
			var_dump($Form->FILTERED_DATA['Email']);
			var_dump($Form->FILTERED_DATA['RadioButton']);
			var_dump($Form->FILTERED_DATA['Select']);
			var_dump($Form->FILTERED_DATA['CheckBox']);
			var_dump($Form->FILTERED_DATA['JJ']); // MultiSelect*/
			//var_dump($Form->FILTERED_DATA['Image']);
			//var_dump($Form->FILTERED_DATA['File']);
		}
		else{
			var_dump($Form->GetErrors());
			var_dump($Form->FILTERED_DATA);
			echo 'Form Not Valid';
		}
		
		$Timer->End();
		$Timer->ShowTime();

		return SiteRenderEngine::Hello($Request);
	}

	function POST($Request){
		var_dump('Hello POST');
		exit();
	}

	function ALL($Request){
		var_dump('Hello Undefined');
		exit();
	}
}

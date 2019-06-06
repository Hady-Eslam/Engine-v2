<?php

return [

	404 => '404.Begin',
	
	'Register' => [

		'Login' => 'Register/Login.Login',

		'SignUP' => 'Register/SignUP.SignUP',
		'SuccessSignUP' => 'Register/SuccessSignUP.Begin',

		'LogOut' => 'Register/LogOut.Begin'
	],

	'DO' => [

		'MakeNote' => 'DO/MakeNote.MakeNote',
		'ShowNotes' => 'DO/ShowNotes.Begin',
		'Note' => [
			'<int>' => 'DO/Note.Begin'
		],

		'EditNote' => [
			'<int>' => ''
		]
	],

	'Profile' => [
		
		'Settings' => [
			'Password' => '',
			'Name' => '',
			'Delete' => '',
		]
	]
];
<?php

use Core\RedirectEngine;

function Begin($Request){
	$Request->SESSION->DeleteSession();
	RedirectEngine::To(ShowNotes, $Request);
}
<?php

use SiteEngines\SiteRenderEngine;
use Models\NotesModel;

function Begin($Request){

	if ( !isset($Request->SESSION['Updated_At']) )
		return SiteRenderEngine::UnAuthorized_Render($Request);

	$Notes = (new NotesModel())->Select('ID', 'Title', 'Created_At')
								->Where('Email='.$Request->SESSION['Email'] )->Get();

	return SiteRenderEngine::ShowNotes_Render($Request, $Notes);
}
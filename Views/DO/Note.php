<?php

use SiteEngines\SiteRenderEngine;
use Models\NotesModel;

function Begin($Request, $NoteID){

	if ( !isset($Request->SESSION['Updated_At']) )
		return SiteRenderEngine::UnAuthorized_Render($Request);

	$Note = (new NotesModel())->Select()->Where('ID='.$NoteID,
			'Email='.$Request->SESSION['Email'])->Get();

	if ( $Note === [] )
		return SiteRenderEngine::Not_Found_Render($Request);

	return SiteRenderEngine::Note_Render($Request, $Note[0]);
}
<?php

use SiteEngines\SiteRenderEngine;
use Forms\DOForms\MakeNoteForm;
use Models\NotesModel;
use Core\RedirectEngine;

class MakeNote{

	function POST($Request){
		$MakeNote = new MakeNoteForm($Request->POST);
		if ( !$MakeNote->isValid() )
			return SiteRenderEngine::MakeNote_Render($Request, $MakeNote->GetErrors(),
							$Request->POST);

		$Note = (new NotesModel())->Insert([
			'Title' => $MakeNote->GetTitle(),
			'Body' => $MakeNote->GetNote(),
			'Email' => $Request->SESSION['Email']
		]);

		RedirectEngine::To(Note.$Note->LastInsertedID());
	}

	function GET($Request){
		if ( !isset($Request->SESSION['Updated_At']) )
			return SiteRenderEngine::UnAuthorized_Render($Request);

		return SiteRenderEngine::MakeNote_Render($Request);
	}

	function ALL($Request){
		return SiteRenderEngine::UnAuthorized_Render($Request);
	}
}
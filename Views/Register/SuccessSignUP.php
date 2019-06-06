<?php

use SiteEngines\SiteRenderEngine;

function Begin($Request){
	return SiteRenderEngine::SuccessSignUP_Render($Request);
}
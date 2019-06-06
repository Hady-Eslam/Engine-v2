<?php

function ShowNotes($Notes){

	$String = '';

	foreach ($Notes as $Note)
		$String .= '<div style="display: block;border-bottom-color: #454545;border-bottom-style: solid;border-bottom-width: 0.5px;" class="col-lg-12">
						<p>Title : '.$Note['Title'].' </p>
						<p>Created At : '.$Note['Created_At'].' </p>
						<a href="'.Note.$Note['ID'].'">Link For Note</a>
					</div>';

	if ( $String === '' )
		return '<p>No Notes Found</p>';
	return $String;
}
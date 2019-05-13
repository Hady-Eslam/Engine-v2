<?php

function GetPictures(){
	$String = '';

	for ( $i=1; $i < 6; $i++ )
		if ( $GLOBALS['Message']['Picture'.$i] != Housing )
			$String = '<div>
				<img src="'.$GLOBALS['Message']['Picture'.$i].
				'" style="height: 300;width: 300;"></div>';

	return $String;
}
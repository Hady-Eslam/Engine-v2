<?php

function SignUP_Result($Result){
	
    if ( $Result == "Name Found" )
        return "$('#Name').css('border-color','red');";

    else if ( $Result == "Email Found" )
        return "$('#Email').css('border-color','red');";

    else if ( $Result == "Phone Found" )
        return "$('#Phone').css('border-color','red');";
    
    return '';
}
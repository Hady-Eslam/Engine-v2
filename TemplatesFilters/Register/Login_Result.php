<?php

function Login_Result($Result){

    if ( $Result == 'Email Not Found' )
        return "$('#Email').css('border-color','red');";

    else if ( $Result == 'Wrong Password' )
        return "$('#Password').css('border-color','red');";

    return '';
}
<?php

use SiteEngines\HashingEngine;
use CoreModels\ModelExcutionEngine;

function Check_SignUP_Token($Email, $Token){
    $Hashing = new HashingEngine();
    $Result = CheckToken(
        $Hashing->Hash_SignUP_Token($Email),
        $Hashing->Hash_SignUP_Token($Token),
        'sign_up_token'
    );
    if ( $Result->Result != -1 )
        return Returns(0, $Result->Result);
    else
        return $Result;
}

function Check_Login_Token($Email, $Token){
    $Hashing = new HashingEngine();
    return CheckToken(
        $Hashing->Hash_Login_Token($Email),
        $Hashing->Hash_Login_Token($Token),
        'log_in_token'
    );
}

/*
    - What is Doing?
        Check The Token For (log_token, sign_up_token)

    - Return :
        return array(-1, $MySql->Error, 'Fetching Token And Email', 'Check Token');
        return array(0, 'Not Found');
        return array(0, 'Found');
*/
function CheckToken($Email, $Token, $Table){
    // Check if Token And Email Found or Not
    if ( ($Result = (new ModelExcutionEngine())->FetchOneRow(
                "SELECT * FROM $Table WHERE token_email = ? AND token = ?",
                array( $Email, $Token )))->Result == -1 )
        return Returns(-1, "Check Token And Email Found Or Not in $Table",
                $Result->Error);
    else if ( $Result->Result == 0 )
        return Returns('Not Found');
    return Returns('Found', $Result->Data);
}
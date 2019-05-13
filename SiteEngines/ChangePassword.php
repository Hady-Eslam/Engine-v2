<?php

use SiteEngines\HashingEngine;
use CoreModels\ModelExcutionEngine;

function ChangePassword($Email, $Password){
    $Hashing = new HashingEngine();
    if ( ($Result = (new ModelExcutionEngine())->excute(
                "UPDATE users SET password = ? WHERE email = ?",
                    array(
                        $Hashing->Hash_Users($Password),
                        $Hashing->Hash_Users($Email)
                    )))->Result == -1 )
        return Returns(-1, 'Changing User Password', $Result->Error);
    return Returns(0, 'Done');
}
<?php 

use SiteEngines\HashingEngine;
use CoreModels\ModelExcutionEngine;

function OpenSession($Email){
    $Hashing = new HashingEngine();
    
    // Getting Data From DataBase
    $Result = (new ModelExcutionEngine())
                ->FetchOneRow("SELECT * FROM users WHERE email = ?",
                    array(  $Hashing->Hash_Users($Email) ));
    if ( $Result->Result == -1 )
        return Returns(-1, 'Getting User Data From DataBase To Session', $Result->Error);
    else if ( $Result->Result == 0 )
        return Returns(0, 'User Not Found');

    // Get Hashed Email
    $_SESSION['Email'] = $Hashing->Get_Hashed_Users($Result->Data['email']);
    if ( $_SESSION['Email']->Result == -1 )
        return Returns(-1, 'Getting Email Hashed To Session', $_SESSION['Email']->Error);
    $_SESSION['Email'] = $_SESSION['Email']->Data;

    // Get Hashed Name
    $_SESSION['Name'] = $Hashing->Get_Hashed_Users($Result->Data['name']);
    if ( $_SESSION['Name']->Result == -1 )
        return Returns(-1, 'Getting Name Hashed To Session', $_SESSION['Name']->Error);
    $_SESSION['Name'] = $_SESSION['Name']->Data;

    // Get Hashed Phone
    $_SESSION['Phone'] = $Hashing->Get_Hashed_Users($Result->Data['phone']);
    if ( $_SESSION['Phone']->Result == -1 )
        return Returns(-1, 'Getting Phone Hashed To Session', $_SESSION['Phone']->Error);
    $_SESSION['Phone'] = $_SESSION['Phone']->Data;

    // Get Hashed Address
    $_SESSION['Address'] = $Hashing->Get_Hashed_Users($Result->Data['address']);
    if ( $_SESSION['Address']->Result == -1 )
        return Returns(-1, 'Getting Address Hashed To Session', $_SESSION['Address']->Error);
    $_SESSION['Address'] = $_SESSION['Address']->Data;

    // Get Hashed Profile Picture
    $_SESSION['Picture'] = $Hashing->Get_Hashed_Users($Result->Data['picture']);
    if ( $_SESSION['Picture']->Result == -1 )
        return Returns(-1,'Getting Picture Hashed To Session', $_SESSION['Picture']->Error);
    $_SESSION['Picture'] = $_SESSION['Picture']->Data;

    $_SESSION['Sign_UP_Date'] = $Result->Data['sign_in_date'];

    $_SESSION['Status'] = $Result->Data['status'];

    $_SESSION['ID'] = $Result->Data['id'];

    return Get_Posts_Number();
}

function Get_Posts_Number(){
    $Result = (new ModelExcutionEngine())->GetRowCount(
            "SELECT COUNT(*) FROM posts WHERE deleted = '0' AND user_email = '"
            .(new HashingEngine())->Hash_POSTS($_SESSION['Email'])."'");
    if ( $Result->Result == -1 )
        return Returns(-1, 'Getting User Number Of Posts', $Result->Error);
    $_SESSION['Posts'] = $Result->Data;
    
    return Returns(0, 'Done');
}

/*
    - info :
        javascript page     =>  ConfirmPassword.js
        init name           =>  ConfirmPasswordScript

    -The Scripts it Depends On (init Name) :
        JQueryScript

    - Data Needed :
        id  => #Password
        id  => #ConPassword
*/

function CheckPassword(Result = true){
    if ( $('#Password').val() === $('#ConPassword').val() )
        return Result;
    $('#ConPassword').css('border-color','red');
    return false;
}
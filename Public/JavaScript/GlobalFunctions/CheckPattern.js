/*
    - info :
        javascript page     =>  CheckPattern.js
        init name           =>  CheckPatternScript

    -The Scripts it Depends On (init Name) :
        JQueryScript

    - Data Needed :
        id  => #Email
*/

function CheckEmailPattern(Result = true){
    reg = /\S+@\S+\.\S+/;
    if ( reg.test( $('#Email').val() ) == true )
        return Result;
    $('#Email').css('border-color','red');
    return false;
}
$(document).ready(function(){
    $("#ReSetPasswordForm").submit(function(event){
        Result = CheckLength('#Password', Password_Len);
        if ( CheckPassword(Result) == false )
            event.preventDefault();
    });
})
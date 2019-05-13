$(document).ready(function(){
    $("#ForgetForm").submit(function(event){
        Result = CheckLength('#Email', Email_Len, true);
        if ( CheckEmailPattern(Result) == false )
            event.preventDefault();
    });
})
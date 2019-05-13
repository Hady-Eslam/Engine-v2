$(document).ready(function(){

    $("#LogForm").submit(function(event){
        Result = CheckLength('#Email', Email_Len);
        if ( !CheckLength('#Password', Password_Len, Result) )
            event.preventDefault();
    });
})
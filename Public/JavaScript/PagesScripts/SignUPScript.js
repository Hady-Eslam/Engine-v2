$(document).ready(function(){
    $("#SignForm").submit(function(event){
        if ( CheckData() == false )
            event.preventDefault();
    });
})

function CheckData(){
    Result = CheckLength('#Name', Name_Len);
    Result = CheckLength('#Email', Email_Len, Result);
    Result = CheckLength('#Phone', Phone_Len, Result);
    Result = CheckLength('#Password', Password_Len, Result);
    Result = CheckEmailPattern(Result);
    Result = CheckPassword(Result);
    if ( !$('#TemsOfUse').prop('checked') ){
        alert('You Must Agree in Terms Of Use');
        return false;
    }
    return Result;
}

function CheckEmail(){
    
    if ( $('#Email').val().length == 0 || !CheckEmailPattern() )
        return ;

    else if ( $('#Email').val().length > Email_Len ){
        $("#Email").css('border-color', 'red');
        return;
    }

    $.ajax({
        type : "POST",
        url : CheckPage,
        data : 'Email='+$('#Email').val(),
        error: function (jqXHR, exception) {
            console.log(jqXHR);
        },
        
        success : function(Data){
            console.log(Data);
            try{
                Data = JSON.parse(Data);
                if ( Data['Result'] == 0 ){
                    
                    if ( Data['Data'] == 'email Not Found' )
                        $('#Email').css('border-color','green');
                    else
                        $('#Email').css('border-color','red');
                }
                else{
                    SetError_Function('in Searching For Email Reservied Or Not',
                        'in SignUPScript.js', 'in CheckEmail Function',
                        Data['Error']['Error Type'], Data['Error']['Error Code'],
                        Data['Error']['Error Message'], true);
                }
            }
            catch(e){
                SetError_Function('in Searching For Email Reservied Or Not',
                    'in SignUPScript.js', 'in CheckEmail Function', 'JSON Error',
                    '1', 'Failed To Covert JSON', false);
            }    
        }
    });
}
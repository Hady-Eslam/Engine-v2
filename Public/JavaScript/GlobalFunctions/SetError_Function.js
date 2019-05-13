/*
    - info :
        javascript page     =>  SetError_Function.js
        init name           =>  SetError_FunctionScript

    -The Scripts it Depends On (init Name) :
        JQueryScript
        SetMessage
*/
function SetError_Function(Proccess, Location_Script_info, Location, Type, Code, Message, CanShowMessage){
    console.log(
        "Proccess : " + Proccess + " \n"+
        'Error Script Location info : ' + Location_Script_info + " \n\n"+
        'Error Location = ' + Location + " \n"+
        'Error Type = ' + Type + " \n"+
        'Error Code = ' + Code + " \n"+
        'Error Message = ' + Message + " \n"
    );

    if ( CanShowMessage == true )
        TriggerMessage(5000, '#E30300',
            '<p>Error Message Code : ' + Code +
            '</p><p>Something Goes Wrong</p>');
}
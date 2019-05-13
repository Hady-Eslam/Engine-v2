/*
    - info :
        javascript page     =>  TriggerForm.js
        init name           =>  TriggerFormScript

    -The Scripts it Depends On (init Name) :
        JQueryScript
*/
function MakeForm(Method, id){
    $("<form id='TheSubmitForm' method='" + Method + "'"
            +"enctype='multipart/form-data'></form>").appendTo('body');
    $(id).appendTo('#TheSubmitForm');
    $('#TheSubmitForm').trigger('submit');
}
function GO(id){
	MakeForm('POST', id);
}
function GO_GET(id){
	MakeForm('GET', id);
}
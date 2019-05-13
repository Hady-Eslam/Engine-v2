/*
	- info :
		javascript page    	=>  AddPicture.js
        init name   		=>  AddPictureScript

	-The Scripts it Depends On (init Name) :
		JQueryScript
*/

function GetPicture(id){
    $(id).trigger('click');
}

function Read(input, id){
    if (input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function (e) {
            $(id).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
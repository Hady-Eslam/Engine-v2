/*
    - info :
        javascript page     =>  TriggerMessage.js
        init name           =>  TriggerMessageScript

    -The Scripts it Depends On (init Name) :
        JQueryScript

    - Data Needed :
        id  => #MessageBox
*/

function TriggerMessage(Timeout, BackgroundColor, Text){
    
    $('#MessageBox').empty();
    $(Text).appendTo('#MessageBox');
    left  = (screen.width)/2 - (document.getElementById("MessageBox").clientWidth)/2;

    $('#MessageBox').css('background-color', BackgroundColor)
              		.css('left', left)
              		.css('top', 180);

    $('#MessageBox').css('visibility','visible');

    setTimeout(function () {
        $('#MessageBox').css('visibility','hidden');
    }, Timeout);
}
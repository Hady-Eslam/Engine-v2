/*
	- info :
		javascript page    	=>  SetCokiee.js
        init name   		=>  SetCookieScript

	-The Scripts it Depends On (init Name) :
		JQueryCookieScript
*/

function SetCokiee() {
	if ( !Cookies.get('FindHouse') ){
		Cookies.set('FindHouse', "found", {
    		expires: 365 ,
    		path: '/',
    	});
	}
}
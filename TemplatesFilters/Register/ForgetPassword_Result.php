<?php

function ForgetPassword_Result($Result){
	if ( $Result == 'Email Not Found' )
		return "$('#Email').css('border-color', 'red');";
	return '';
}

function GetSection($Result){
	if ( $Result == 'Done' )
		return '<p>The Email is Succesfully Sended</p>
        <p><strong>Note : </strong>The Token Will Be Deleted After 3 Days</p>';

    return '<form id="ForgetForm" method="post" enctype="multipart/form-data"
            action="<< ForgetPassword >>">

			<p>Please Enter Your Email</p>
			<P>To Send You The Reset Link</P>
            <div>
				<input type="text" id="Email" required name="Email"
                    placeholder="Enter Your Email">
			</div>

			<div>
                <input type="submit" value="Send">
            </div>
        </form>';
}
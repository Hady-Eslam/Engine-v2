<?php

function GetSection($Result){
	if ( $Result == 'Done' )
		return '<p>Password Has Changed</p>
        <a href="<< Login >>">Enter To Go To Log in Page</a>';

    return '<form id="ReSetPasswordForm" method="post" enctype="multipart/form-data"
            action="<< ReSetPassword >>">

            <div>
            	<input type="hidden" name="Email" value="<< Email >>">
            </div>

            <div>
                <input type="hidden" name="Token" value="<< Token >>">
            </div>

            <div>
				<input id="Password" type="Password" name="Password" required
                    placeholder="Enter New Password">
			</div>

			<div>
				<input id="ConPassword" type="Password" name="ConPassword" required
                    placeholder="Re Enter Password">
			</div>

			<div>
                <input type="submit" value="ReSet Password">
            </div>
			
		</form>';
}
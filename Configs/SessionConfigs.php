<?php

return [

    'TYPE' => 'DATABASE',	// Supported: DATABASE"

    'LIFE_TIME' => 1 * 60 * 60,	// in Seconds

    'EXPIRE_ON_CLOSE' => False,	// Expire on Closing The Browser

    'ENCRYPT' => False,

    /*
	 *	It Means It Will Delete Expires Sessions Every 55 hit
     */

    'PROBABILITY' => 110
];
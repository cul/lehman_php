<?php
/* if remote address is not '^.columbia.edu' or '^.barnard.edu', then the IP is a RESTRICTED IP */

function isRestricted() {
	$result = 0;
	
	// if Barnard or Columbia, DO NOT RESTRICT
	if ( stristr(gethostbyaddr($_SERVER['REMOTE_ADDR']),"columbia.edu") || stristr(gethostbyaddr($_SERVER['REMOTE_ADDR']), "barnard.edu") )
		$result = 0; // "false";

	else // you are RESTRICTED!
		$result = 1; // "true";

	return $result;

} // end FUNCTION isRestricted
?>

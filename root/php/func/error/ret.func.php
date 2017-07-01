<?php

# ==== Error return function ====

# Return all errors if exists

function errorRet($retType = E_USER_ERROR)
{
	global $errorArr;

	# Errors exists?
	if(!empty($errorArr))
		if(DEBUG)
			# Details return
			user_error(json_encode($errorArr), $retType);
	
		else
			# Return error return array
			die(json_encode($errorArr));
}

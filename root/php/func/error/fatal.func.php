<?php

# ==== Fatal error function ====

# Program stop with error description

function errorFatal(array $errorArr, $type = E_USER_ERROR)
{
	# - Error -

	# Push
	error($errorArr);
	
	# Return
	errorRet($type);
}

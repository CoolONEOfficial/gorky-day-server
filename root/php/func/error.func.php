<?php

# ==== Error function ====

# Add error in $errorArr

function error(array $newErrorArr)
{
	if(DEBUG)
	{
		echo 'Error!';
		var_dump($newErrorArr);
		echo '  Trace:';
		var_dump(debug_backtrace());
	}

	if(DEBUG)
	{
		# Add error prefix
		global $errorPrefixArr;
		if( !empty($errorPrefixArr) )
			$newErrorArr = [ $errorPrefixArr, $newErrorArr ];
	}

	# Add error
	global $errorArr, $errorPrefixArr;
	$errorArr[] = [ $errorPrefixArr, $newErrorArr ];
}

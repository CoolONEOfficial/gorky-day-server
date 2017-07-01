<?php

# ==== Get value function ====

# Check with $needleType and return $needle from input $haystackArr

# --- Functions ---

# Check val
require_once getPathCodePhp('func/check', 'val');

# --- Code ---

function getValManual($needle, array $haystackArr, array $checkArr)
{
	global $errorArr;

	$ret = NULL;

	# Debug
	if(DEBUG)
	{
		echo '-- function getVal --';

		echo 'needleName:';
		var_dump($needle);

		echo PHP_EOL;
	}

	# -- Get --

	$val = NULL;

	# Find key in methods
	foreach($haystackArr as $mHaystack)
		
		# Founded?
		if(array_key_exists($needle, $mHaystack))
		{
			# -- Value --

			# Return
			$val = $mHaystack[$needle];

			# Check
			checkVal($val, $checkArr);
		}

	# Return val
	$ret = $val;

	return $ret;
}

function getVal($needle, array $haystackArr, array $checkArr)
{
	$ret = NULL;

	# -- Get --

	$val = NULL;

	# Get
	if(($val = getValManual($needle, $haystackArr, $checkArr)) === NULL)
		error( [ $needle => [ 'NULL' ] ] );

	# Return val
	$ret = $val;

	return $ret;
}

<?php

# ==== Check value function ====

# Check correct value with name

# --- Code ---

function checkValManual($val, array $checkArr)
{
	$ret = false;

	# -- Check and return --

	$valErrorArr = [];

	# Check arr struct:
	# [
	# 	'wds' // only words, numbers and spaces
	# 	[ 3, 5 ] // length only 3, 4, 5
	# 	[ $callableVal, [ 'arg1'. CHECK_VAL, 'arg3'... ] ] // exec callable check function (she returns true/1 of false/0/null)
	# ]

	foreach($checkArr as $mVal)

		# Check with map
		if(is_string($mVal))
		{
			# Check var 

			# -- Check symbols --

			# - Generate regular expression -

			$regExp = '/^[';
			
			foreach(str_split($checkArr) as $mChar)
				switch(strToLower($mChar))
				{
					case 'w':
					case 'd':
					case 's':
						$regExp .= '\\' . $mChar;
						break;
				}

			$regExp .= ']+$/';

			# Debug
			var_dump($regExp);

			# Check
			if(!preg_match($regExp, $val))
				$valErrorArr[] = 'uncorrect';
		}

		# Check callable or length
		else if(is_array($mVal))
		{
			# Callable defines
			define('CALLABLE_ID', 0);
			define('CALLABLE_ARG_ARR_ID');

			if(is_callable($mVal[CALLABLE_ID]))
			{
				# Push in argument array val with alias
				foreach($mVal[CALLABLE_ARG_ARR_ID] as &$mArg)
					if($mArg === CHECK_VAL)
						$mArg = $val;

				if(DEBUG)
				{
					echo 'Check function:';
					var_dump($mVal[CALLABLE_ID]);

					echo 'Args:';
					var_dump($mVal[CALLABLE_ARG_ARR_ID]);
				}

				# Exec callable
				if(!call_user_func_array($mVal['CALLABLE_ID'], $mVal['CALLABLE_ARG_ARR_ID']))
					$valErrorArr[] = 'bad';
			}
			else
			{
				# Check var length (if string), or val (if int)

				// Length
				
				# Defines
				define('MIN_LEN_ID', 0);
				define('MAX_LEN_ID', 1);

				# Get
				$len = NULL;
				if(is_int($val)) // int
					$len = $val;
				else if(is_string($val)) // str
					$len = strLen($val);

				# Check
				if($len < $mVal[MIN_LEN_ID])
					$valErrorArr[] = 'small';
				else if($len > $mVal[MAX_LEN_ID])
					$valErrorArr[] = 'big';
			}
		}

	if(empty($valErrorArr))

		# Return true
		$ret = true;
	else
		# Return error array
		$ret = $valErrorArr;

	return $ret;
}

function checkVal($val, array $checkArr)
{
	# -- Check and error --

	if(($errorArr = checkValManual($val, $checkArr)) !== true)
		error( [ $val => $errorArr ] );
}

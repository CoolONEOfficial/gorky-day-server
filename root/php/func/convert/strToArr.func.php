<?php

# ==== String to mas function ====

# Replace chars in string to massives with map

function strToArr($str, $charMap)
{
	$ret = [];

	# Convert
	for($mCharNum = 0; $mCharNum < strLen($str); $mCharNum++)
	{
		$mChar = $str[$mCharNum];
		if(array_key_exists($mChar, $charMap))
			$ret[] = $charMap[$mChar];
		else
			errorFatal( [ 'strToArr' => [ $mChar => [ 'bad' ] ] ] );
	}

	return $ret;
}

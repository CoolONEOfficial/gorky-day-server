<?php

# ==== Generate key function ====

# Generate random key.

function genKey(int $len = KEY_LEN, string $charMap = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890')
{
	$ret = '';

	# Generate
	for($mChar = 0; $mChar < $len; $mChar++)
		$ret .= $charMap[rand(0, strLen($charMap) - 1)];

	return $ret;
}

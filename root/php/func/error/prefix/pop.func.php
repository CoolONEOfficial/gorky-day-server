<?php

# ==== Pop error prefix function ====

# Pop prefix to errors

function errorPrefixPop()
{
	global $errorPrefixArr;

	# Pop prefix
	array_pop($errorPrefixArr);
}

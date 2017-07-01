<?php

# ==== Push error prefix function ====

# Push prefix to errors

function errorPrefixPush($prefix)
{
	global $errorPrefixArr;

	# Push prefix
	array_push($errorPrefixArr, $prefix);
}

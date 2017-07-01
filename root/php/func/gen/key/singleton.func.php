<?php

# ==== Generate singleton key ====

# Generate key not exists in $tableName where key = $keyName

function genKeySingleton(string $tableName, string $keyName, int $keyLength = 15)
{
	$ret = '';

	# --- Generate ---

	global $db;

	do
		# Generate
		$key = genKey($keyLength);
	
	# Duplicate?
	while(QB::table($tableName)->where(
				$keyName,
				'=',
				$key
			)->first() !== NULL);

	return $key;
}

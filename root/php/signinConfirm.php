<?php

# ==== Signin confirm ====

# Delete signin key

# Values:
# 	keySignin
# 	mail

# --- Code ---

$retJson = false;

# -- Confirm --

# Delete signin key
QB::table('userKeysSignin')->where(
		'id',
		'=',
		$signin->id
	)->delete();

errorRet();

# Return true
$retJson["result"] = true;

die(json_encode($retJson));

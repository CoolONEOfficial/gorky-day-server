<?php

# ==== Sign out ====

# Delete user

# Values:
# 	keySession

# --- Code ---

$retJson = false;

# -- Sign out --

# Find user id with session key
$userSession = QB::table('userKeysSession')->where(
		'keySession',
		'=',
		$keySession
	)->where(
		'keySessionActive',
		'=',
		1
	)->first();

# Get user id with 

# - Delete -

# User
QB::table('users')->where(
		'id',
		'=',
		$userSession->id
	)->delete();

errorRet();

# Return true 
$retJson["result"] = true;

die(json_encode($retJson));

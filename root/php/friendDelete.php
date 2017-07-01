<?php

# ==== Friend delete ====

# Delete friend request from user

# Vals:
# 	keySession
# 	friendId

# --- Code ---

$retJson = false;

# Request

# Find
$request = QB::table('friends')->where(
		'idFrom',
		'=',
		$session->id
	)->where(
		'idTo',
		'=',
		$friendId
	);

# Check
if( !empty($request->first()) )

	# Delete
	$request->delete();

errorRet();

# Return true
$retJson["result"] = true;

die($retJson);

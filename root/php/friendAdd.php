<?php

# ==== Add friend file ====

# Send friend request or confirm his

# Values:
# 	keySession
# 	friendId

# --- Code ---

$retJson = false;

# Check request from user to friend not created
if(QB::table('friends')->where(
			'idFrom',
			'=',
			$session->id
		)->where(
			'idTo',
			'=',
			$friendId
		)->first())
	errorFatal( [ 'request' => [ 'created' ] ] );

// Not confirmed request from friend to user

# Find
$request = QB::table('friends')->where(
		'idFrom',
		'=',
		$friendId
	)->where(
		'idTo',
		'=',
		$session->id
	)->where(
		'confirm',
		'=',
		0
	);

# Check
if( !empty($request->first()) )
{
	# Confirm request
	$request->update(
			[
				'confirm' => 1
			]
		);
}
else
	# Create (send) request
	QB::table('friends')->insert(
			[
				'idFrom' => $session->id,
				'idTo'   => $friendId
			]
		);

errorRet();

# Return true
$retJson["result"] = true;

die($retJson);

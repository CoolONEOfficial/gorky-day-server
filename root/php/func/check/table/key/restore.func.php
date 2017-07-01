<?php

# ==== Check key restore function ====

# Check restore user key from mail

function checkKeyRestore($keyRestore)
{
	global $user;
	if( empty($user) ) # varMap syntax error
		errorFatal( [ 'checkKeyRestore' => [ 'user' => [ 'null' ] ] ] );

	// Key

	# Get
	global $restore;
	$restore = QB::table('userKeysRestore')->where(
			'id',
			'=',
			$user->id
		)->where(
			'keyRestore',
			'=',
			$keyRestore
		)->where(
			QB::raw('NOW()'),
			'<',
			'timeEnd'
		)->first();

	# Check
	if( empty($restore) )
		error( [ 'bad' ] );
};

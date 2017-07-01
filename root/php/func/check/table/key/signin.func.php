<?php

# ==== Check signin key function ====

# Check user signin key from mail

function checkKeySignin($keySignin)
{
	global $user;
	if( empty($user) )
		errorFatal( [ 'checkKeySignin' => [ 'user' => [ 'null' ] ] ] );

	// Key
	
	# Get
	global $signin;
	$signin = QB::table('userKeysSignin')->where(
				'id',
				'=',
				$user->id
			)->where(
				'keySignin',
				'=',
				$keySignin
			)->first();

	# Check
	if( empty($signin) )
		error( [ 'bad' ] );
};

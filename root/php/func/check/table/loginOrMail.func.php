<?php

# ==== Check login function ====

# Check SIGNED login or mail

function checkLoginOrMail(string $loginOrMail)
{
	// User with login or mail

	# Get
	global $user;
	$user = QB::table('users')->where(
			'login',
			'=',
			$loginOrMail
		)->orWhere(
			'mail',
			'=',
			$loginOrMail
		)->first();

	# Check
	if( empty($user) )
		error( [ 'bad' ] );
}

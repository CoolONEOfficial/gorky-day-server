<?php

# ==== Check login function ====

# Check signed or not signed user login

function checkLogin(string $login, bool $signed)
{
	// Login

	# Get
	global $user;
	$user = QB::table('users')->where(
			'login',
			'=',
			$login
		)->first();

	// Check
	
	# Signed
	if( $signed )
	{
		if( empty($user) )
			error( [ 'not signed' ] );
	}

	# Not signed
	else
	{
		if( !empty($user) )
			error( [ 'signed' ] );
	}
}
